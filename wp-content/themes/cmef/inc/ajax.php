<?php
global $post;

	add_action('wp_ajax_nopriv_delete_exported_csv', 'delete_exported_csv');
    add_action('wp_ajax_delete_exported_csv', 'delete_exported_csv');
    function delete_exported_csv(){
    	print_r($_POST);
    	unlink(ABSPATH . $_POST['file']);
    	die();
    }

    add_action('wp_ajax_nopriv_fetch_programs', 'ajax_fetch_programs');
    add_action('wp_ajax_fetch_programs', 'ajax_fetch_programs');
    function ajax_fetch_programs () {;
    	setlocale(LC_MONETARY, 'en_US');
    	global $post;
        $offset = (int) $_POST['offset'];

    	$args = array(
			'post_type'   => 'program',
            'post_status' => 'publish',
			'offset' => $offset,
			'posts_per_page' => 3,
            'post__not_in' => array(947),
            'meta_key' => '_thumbnail_id'
		);
        // Query For Program donations
        
		$the_query = new WP_Query( $args );
			if ($the_query->have_posts()) :;
    		while ($the_query->have_posts()) : $the_query->the_post() ;
    			$goal = get_post_meta(get_the_ID(), '_fundraising-goal', true);
                $donation_args = array(
                    'post_type' => 'donation',
                    'post_status' =>'publish',
                    'posts_per_page' => -1,
                    'meta_key'       => '_program-id',
                    'meta_value'     => $post->ID,
                );
                $donations = new WP_Query($donation_args);
            
                // The Loop
                if($donations->have_posts()):
                    $raised = 0;
                    foreach ($donations->posts as $donation) {
                        $raised += (int) get_post_meta($donation->ID, '_contribution-amount', true);
                    }
                else:
                    $raised = 0;
                endif;
		    	$program = $post;
		    	$program->author = get_the_author();
		    	$program->post_thumbnail = get_the_post_thumbnail($post->ID, $size = 'post-thumbnail', $attr = '');
		    	$program->placement_holder_image = '<img src="'. get_template_directory_uri() .'/images/placeholder.png" alt="">';
		    	$program->percentage_raised = ($raised/(int) $goal)*100;
                //Also append the same data to an array for JS
    			$programsDataObject[] = $program;
    			$program->amount_raised = money_format('%.0n', $raised) . "\n";
    			$program->fundraiser_goal = money_format('%.0n', $goal) . "\n";
    			$program->twitter_url = "http://www.twitter.com/share/?url=" . get_permalink($post->ID);
    			$program->linkedin_url = "https://www.linkedin.com/cws/share?url=" . get_permalink($post->ID);
    			$program->facebook_url = "http://www.facebook.com/sharer.php?u=" . get_permalink($post->ID);
    			$program->google_url = "http://plus.google.com/share?url=" . get_permalink($post->ID);
                $program->donation_url = add_query_arg( 'program_id', get_the_ID(), get_the_permalink( 252 ) );
    	endwhile;

    	echo json_encode($programsDataObject);
    	endif;
    	die(); 
    }//ajax_fetch_programs

    //Save Author (for some reason this was already here. It's been a few months and I don't remember what exactly this was for because I didnt find a view that used this... Delete this when we are positive that we are not using it.)
    add_action('wp_ajax_save_author', 'ajax_save_author');
    function ajax_save_author(){
        global $post;
        //Get the informatioan from the author.
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $description = $_POST['description'];
        $author_ID = $_POST['author_ID'];
        $phone_number = $_POST['phone_number'];
        $email_address = $_POST['email_address'];

        //Update the information.
        $user_id = wp_update_user(array(
            'ID' => $author_ID,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'description' => $description,
            'display_name' => $first_name . ' ' . $last_name,
            'user_email' => $email_address
        ));
        update_user_meta( $user_id, 'phone', $phone_number);
        die();
    }//end ajax_save_author

    add_action('wp_ajax_save_profile', 'save_profile');
    function save_profile(){
        global $post , $current_user;

        $user_id = wp_update_user(array(
            'ID' => $_POST['author_ID'],
            //'first_name' => $_POST['first_name'],
            //'last_name' => $_POST['last_name'],
            'description' => $_POST['description'],
            //'display_name' => $_POST['first_name'] . ' ' . $_POST['last_name'],
            'user_email' => $_POST['email_address'],
        ));
        // TODO: Finish the save_profile function.
        update_user_meta( $user_id, 'phone', $_POST['phone']);
        update_user_meta( $user_id, 'street-1', $_POST['street1']);
        update_user_meta( $user_id, 'street-2', $_POST['street2']);
        update_user_meta( $user_id, 'city', $_POST['city']);
        update_user_meta( $user_id, 'state', $_POST['state']);
        update_user_meta( $user_id, 'zip', $_POST['zip']);
        $response = array();
        if(wp_check_password($_POST['old_password'], $current_user->user_pass, $user_id)){
            if($_POST['new_password'] != $_POST['conf_new_password']){
                $response['status'] = 'error';
                $response['message'] = 'Please check and confirm that your new passwords match.';
            }
            elseif(strlen($_POST['new_password']) < 8 || strlen($_POST['conf_new_password']) < 8 ){
                $response['status'] = 'error';
                $response['message'] = 'Your new password must be longer than eight characters.';
            }
            elseif($_POST['new_password'] == $_POST['conf_new_password'] && strlen($_POST['new_password']) > 8 || strlen($_POST['conf_new_password']) > 8 ){
                //change password
                $response['status'] = 'success';
                wp_set_password( $_POST['new_password'], $user_id );
            }
        }
        elseif (strlen($_POST['old_password']) > 0 & !wp_check_password($_POST['old_password'], $current_user->user_pass, $user_id)) {
            $response['status'] = 'error';
            $response['message'] = "Your existing password doesn't seem to match what we have on file.";
        }
        else{
            $response['status'] = 'success';
        }

        echo json_encode($response);

        die();
    }


    /**
     * Process Donation with Authorize.NET
     */
    add_action('wp_ajax_nopriv_process_donation', 'process_donation');
    add_action('wp_ajax_process_donation', 'process_donation');
    function process_donation(){
        //Set the authorize.net variables
    	include ('sdk-php-master/autoload.php');
        if(get_option('sandbox_mode') == 'true'){
            $sandbox = true;
        }
        else{
            $sandbox = false;
        }
    	define("AUTHORIZENET_API_LOGIN_ID", get_option('api_login_id'));
		define("AUTHORIZENET_TRANSACTION_KEY", get_option('api_transaction_key'));
		define("AUTHORIZENET_SANDBOX", $sandbox );
		
    	//Store the variables (again...).. There must be a better way of doing this........
		//print_r($_POST); 
	    
        $amount = (int) $_POST['amount'];

		$pay_for_transaction = $_POST['pay_for_transaction'];
		$donate_to_cmef = $_POST['donate_to_cmef'];
		$card_number = $_POST['card_number'];
		$three_digit = $_POST['three_digit'];
		$month = $_POST['month'];
		$credit_card_expiry_year = $_POST['credit_card_expiry_year'];
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$street = $_POST['street'];
		$city = $_POST['city'];
		$zip = $_POST['zip'];
		$state = $_POST['state'];
        $program_id = $_POST['program_id'];
        $remain_anonymous = $_POST['remain_anonymous'];
        if($donate_to_cmef == 'true'){
            $amount = (float) $amount + 5;
        }
        if($pay_for_transaction == 'true'){
            $amount = (float) $amount + 0.29;
        }
		/**
		 * We need to do a few things here.
		 * 1. Process the Authorize.net Payment
		 * 2. Wait for the reply.
		 * 3. Create a post once we get the reply.
		 * 4. Send back to the front end the receipt etc.
		 */
		//Process the authorize.net payment.
		$sale = new AuthorizeNetAIM;
        $sale->card_num           = $card_number;
        $sale->exp_date           = $month . '/' . $credit_card_expiry_year;
        $sale->amount             = $amount;
        $sale->description        = $description = "";
        $sale->first_name         = $first_name;
        $sale->last_name          = $last_name;
        $sale->address            = $street;
        $sale->city               = $city;
        $sale->state              = $state;
        $sale->zip                = $zip;
        $sale->country            = $country = "US";
        $sale->email              = $_POST['email'];

        $response = $sale->authorizeAndCapture();
        if ($response->approved) {
		    $transaction_id = $response->transaction_id;
            //Set up the post data for a new post into the database to get a record of the donation.
            $post = array(
              'post_name'      => 'Donation ' . $transaction_id, 
              'post_title'     => 'Donation ' . $transaction_id, 
              'post_status'    => 'publish', 
              'post_type'      => 'donation', 
              'post_author'    => 1, 
            );  
            //Create a new donation post.
            $new_post_id = wp_insert_post($post);

            $address = array(
                'street_1' => $street,
                'street_2' => ' ',
                'city'     => $city,
                'state'    => $state,
                'zip'      => $zip,
                'country'  => 'US',
            );
            $name = array(
                'first' => $first_name,
                'middle' => ' ',
                'last' => $last_name,
            );
            //Update the various needed post data.
            
            update_post_meta($new_post_id, '_program-id', $program_id);
            update_post_meta($new_post_id, '_contribution-amount', ($amount - 5));    //this is because we do not store the transaction amount.
            update_post_meta($new_post_id, '_donation-address', $address);
            update_post_meta($new_post_id, '_donor-name', $name);
            update_post_meta( $new_post_id, '_payment-method', 'Credit Card' );
            update_post_meta( $new_post_id, '_email-address', $_POST['email']);
            update_post_meta( $new_post_id, '_remain-anonymous', $remain_anonymous);
            //update_balance($amount, $program_id);
            if($donate_to_cmef === 'true'){
                //Create a donation for cmef.
                $new_post = array(
                  'post_name'      => 'Donation To CMEF ' . $transaction_id, 
                  'post_title'     => 'Donation to CMEF' . $transaction_id, 
                  'post_status'    => 'publish', 
                  'post_type'      => 'donation', 
                  'post_author'    => 1, 
                );  
                //Create a new donation post.
                $cmef_new_post_id = wp_insert_post($new_post);

                $address = array(
                    'street_1' => $street,
                    'street_2' => ' ',
                    'city'     => $city,
                    'state'    => $state,
                    'zip'      => $zip,
                    'country'  => 'US',
                );
                $name = array(
                    'first' => $first_name,
                    'middle' => ' ',
                    'last' => $last_name,
                );
                //Update the various needed post data.
                update_post_meta($cmef_new_post_id, '_program-id', 947);
                update_post_meta($cmef_new_post_id, '_contribution-amount', 5);
                update_post_meta($cmef_new_post_id, '_donation-address', $address);
                update_post_meta($cmef_new_post_id, '_donor-name', $name);
                update_post_meta( $cmef_new_post_id, '_payment-method', 'Credit Card' );
                update_post_meta( $cmef_new_post_id, '_email-address', $_POST['email']);
                update_post_meta( $cmef_new_post_id, '_remain-anonymous', $remain_anonymous);
            }
		}
        // Send back the response.
		echo json_encode($response);
		die();
    }
    /**
     * Register (not logged in)
     */
    add_action('wp_ajax_nopriv_new_registration', 'new_registration');
    function new_registration(){
        /**
         * The user is being created here
         */
        $username = $_POST['username'];
        $email = $_POST['email'];
        $confirm_email = $_POST['confirm_email'];
        $corps_region = $_POST['corps_region'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $corps_year = $_POST['corps_year'];
        $phone = $_POST['phone'];
        $street_1 = $_POST['street_1'];
        $street_2 = $_POST['street_2'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $zip = $_POST['zip'];
        $author = $_POST['author'];
        
        if(strlen($username) === 0){
            $alerts = array(
                'alert' => "Please enter a username."
                );
        }
        elseif(username_exists($username) != null){
             $alerts = array(
                'alert' => "Sorry, this username already exists."
                );
        }
        elseif(email_exists($email) != false){
            $alerts = array(
                'alert' => "Sorry, this email is already registered to another user."
            );
        }
        elseif(strlen($email) ===0 && strlen($confirm) === 0){
            $alerts = array(
                'alert' => 'Please enter an email address.'
            );
        }
        elseif($email != $confirm_email){
            $alerts = array(
                'alert' => "Emails do not match."
                );
        }
        elseif(strlen($first_name) === 0){
            $alerts = array(
                'alert' => "Please enter your first name."
                );
        }
        elseif(strlen($last_name) === 0){
            $alerts = array(
                'alert' => "Please enter your last name"
                );
        }
        elseif(strlen($corps_region) === 0){
            $alerts = array(
                'alert' => "Please select a corps region"
                );
        }
        elseif(strlen($corps_year) === 0){
            $alerts = array(
                'alert' => "Please enter a valid corp year."
                );
        }
        elseif(strlen($phone) === 0){
            $alerts = array(
                'alert' => "Please enter you phone number."
                );
        }
        elseif(strlen($street_1) === 0 ){
            $alerts = array(
                'alert' => "Please enter your street address."
                );
        }
        elseif(strlen($city) === 0){
            $alerts = array(
                'alert' => "Please enter your city."
                );
        }
        elseif(strlen($state) === 0){
            $alerts = array(
                'alert' => "Please select your state."
                );
        }
        elseif(strlen($zip) === 0){
            $alerts = array(
                'alert' => "Please enter a valid zip code."
                );
        }
        else{
            
            $userdata = array(
                'user_pass' => wp_generate_password(),
                'user_login' => $username,
                'user_nicename' => $username,
                'display_name' => $first_name . ' ' . $last_name,
                'user_email' => $email,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'role' => 'corp_member'
            );
            $user_id = wp_insert_user( $userdata );
            update_user_meta( $user_id, 'corps-region', $corps_region );
            update_user_meta( $user_id, 'corps-year', $corps_year );
            update_user_meta( $user_id, 'phone', $phone );
            update_user_meta( $user_id, 'street-1', $street_1 );
            update_user_meta( $user_id, 'street-2', $street_2 );
            update_user_meta( $user_id, 'city', $city );
            update_user_meta( $user_id, 'state', $state );
            update_user_meta( $user_id, 'zip', $zip );

            $alerts = array(
                'alert' => 'success',
                'user_id' => $user_id
            );
        }
        // Get the alerts back to the dom
        echo json_encode($alerts);
        die();
    }

    /**
     * Add a New Program
     */
    add_action('wp_ajax_nopriv_new_program', 'new_program');
    add_action('wp_ajax_new_program', 'new_program');
    function new_program(){

        $program_name = $_POST['program_name'];
        $fundraising_goal = $_POST['fundraising_goal'];
        $number_students = $_POST['number_students'];
        $grade_level = $_POST['grade_level'];
        $tfa_region = $_POST['tfa_region'];
        $author = $_POST['author'];
        $description = $_POST['description'];
        $organization_name = $_POST['organization_name'];

        if(strlen($program_name) === 0){
            $alerts = array(
                'alert' => "Please enter a program name."
            );
            //echo strlen($program_name);
        }
        elseif(strlen($fundraising_goal) === 0){
            $alerts = array(
                'alert' => "Please enter a fundraising goal."
                );
        }
        elseif(strlen($number_students) === 0){
            $alerts = array(
                'alert' => "Please enter the number of students this program is for."
                );
        }
        elseif(strlen($grade_level) === 0){
            $alerts = array(
                'alert' => "Please select a grade level."
                );
        }
        elseif(strlen($tfa_region) === 0 ){
            $alerts = array(
                'alert' => "Please select a TFA Region."
                );
        }
        elseif(strlen($description) === 0 ){
            $alerts = array(
                'alert' => "Please enter a description about your program."
                );
        }
        elseif(strlen($organization_name) === 0 ){
            $alerts = array(
                'alert' => "Please enter an organization name."
            );
        }
        else{
            $post_status = (is_user_logged_in() == true ? 'publish' : 'draft');
            $new_program = array(
                'post_type' => 'program',
                'post_title' => $program_name,
                'post_content' => $description,
                'post_author' => $author,
                'post_status' => $post_status
            );
            //Create the new post
            $new_program_ID = wp_insert_post( $new_program );

            //Update the new post meta
            update_post_meta($new_program_ID, '_fundraising-goal', $fundraising_goal);
            update_post_meta($new_program_ID, '_organization-name', $organization_name);
            update_post_meta($new_program_ID, '_number-students', $number_students);
            update_post_meta($new_program_ID, '_program-balance', 0);
            update_post_meta($new_program_ID, '_program-status', 'open');
            //update_post_meta($new_program_ID, '_program-type', $program);
            
            //Update the new post taxonomies
            wp_set_post_terms( $new_program_ID, $grade_level, 'grade-level', true);
            wp_set_post_terms( $new_program_ID, $tfa_region, 'tfa-region', true);
            //wp_set_post_terms( $new_program_ID, $grade_level, 'grade-level', true)
            $href = (is_user_logged_in() == true ? get_the_permalink($new_program_ID) : get_the_permalink(342));

            $alerts = array(
                'alert' => 'success',
                'new_program' => $href,
                'new_program_id' => $new_program_ID,
                'updated-post-information' => $new_program,
                'goal' => $fundraising_goal,
                'grade_level' => $grade_level,
                'number_students' => $number_students,
                'tfa_region' => $tfa_region,
                'organization_name' => $organization_name
            );
        }

        //echo $alerts;
        echo json_encode($alerts);
        die();
    }

    /**
     * Upload an image to a program
     */
    add_action('wp_ajax_nopriv_upload_image', 'upload_image');
    add_action('wp_ajax_upload_image', 'upload_image');
    function upload_image(){

        //print_r($_FILES['image']);
        $attachment_id = media_handle_upload('image', $_POST['program_id']);
        set_post_thumbnail($_POST['program_id'], $attachment_id);
        $attachment = wp_get_attachment_image_src( $attachment_id );
        array_push($attachment, $attachment_id);
        echo json_encode($attachment);
        die();
    }

    /**
     * Upload an image to a program
     */
    add_action('wp_ajax_upload_expense_image', 'upload_expense_image');
    function upload_expense_image(){
        $post = array(
            'post_type' => 'expense',
            'post_content' => $_POST['memo'],
            'post_status' => 'draft'
        );
        if((int) $_POST['amount'] > 0){
            $new_expense = wp_insert_post($post);
            update_post_meta($new_expense, '_program-id', $_POST['program_id']);
            update_post_meta($new_expense, '_expense-amount', (int) $_POST['amount']);
            $expense_attachment_id = media_handle_upload('expense-image', $new_expense);
            set_post_thumbnail($new_expense, $expense_attachment_id);
        }
        if($new_expense != 0 && (int) $_POST['amount'] > 0){
            echo 'success';
        }else{
            echo 'Please enter a valid amount' . $_POST['amount'];
        }
        die();
    }

    /**
     * Make Image Featured
     */
    add_action('wp_ajax_nopriv_make_featured', 'make_featured');
    add_action('wp_ajax_make_featured', 'make_featured');
    function make_featured(){

        $program_id = $_POST['program_ID'];
        $image_id = $_POST['image_ID'];
        $return = set_post_thumbnail( $program_id, $image_id );
        echo json_encode($return);
        die();
    }

    /**
     * Delete Image From Media
     */
    add_action('wp_ajax_nopriv_delete_image', 'delete_image');
    add_action('wp_ajax_delete_image', 'delete_image');
    function delete_image(){
        $image_id = $_POST['image_ID'];
        $return = wp_delete_attachment( $image_id, true );
        echo json_encode($return);
        die();
    }

    /**
     * Update Program
     */
    add_action('wp_ajax_update_program', 'update_program');
    function update_program(){
        $program_id = $_POST['program_id'];
        $organization_name = $_POST['organization_name'];
        $number_students = $_POST['number_students'];
        $program_type = $_POST['program_type'];
        $tfa_region = $_POST['tfa_region'];
        $grade_level = $_POST['grade_level'];
        $goal = $_POST['goal'];

         // Update post content
          $program = array(
              'ID'           => $program_id,
              'post_content' => $_POST['description'],
              'post_title'   => $_POST['title']
          );

        // Update the post into the database
        wp_update_post( $program );

        update_post_meta($program_id, '_organization-name', $organization_name);
        update_post_meta($program_id, '_number-students', $number_students);
        update_post_meta($program_id, '_fundraising-goal', $goal);
        update_post_meta($program_id, '_program-status', $_POST['program_status']);
        $program_type_response = wp_set_post_terms( $program_id, $program_type, 'program-type', false);
        $tfa_region_response = wp_set_post_terms( $program_id, $tfa_region, 'tfa-region', false );
        $grade_level_response = wp_set_post_terms( $program_id, $grade_level, 'grade-level', false );
        die();
    }

    /**
     * Add a rating to the resource
     */
    add_action('wp_ajax_add_rating', 'add_rating');
    function add_rating(){
        $ratings = get_post_meta($_POST['resource_id'], 'resource_rating', true);
        if($_POST['rating'] == 1){
            echo $_POST['rating'];
            $ratings['one'] = (int) $ratings['one'] + 1;
        }
        elseif($_POST['rating'] == 2){
            echo $_POST['rating'];
            $ratings['two'] = (int) $ratings['two'] + 1;
        }
        elseif($_POST['rating'] == 3){
            echo $_POST['rating'];
            $ratings['three'] = (int) $ratings['three'] + 1;
        }
        elseif($_POST['rating'] == 4){
            echo $_POST['rating'];
            $ratings['four'] = (int) $ratings['four'] + 1;
        }
        elseif($_POST['rating'] == 5){
            echo $_POST['rating'];
            $ratings['five'] = (int) $ratings['five'] + 1;
        }
        update_post_meta($_POST['resource_id'], '_ratings', $ratings);
        die();
    }

    /**
     * Purpose: Submit the forgot password form and send a reset password link from wordpress.
     * Step one. Check to see if user exists.
     * Step two. if user does exist then check to see if they are approved
     * Step 3. If user is approved send reset link to the email they provided.
     * Step 4. If user is not approved then send notification back to the from end to inform them that they may need to contact the admin. (info@cmef.org)
     * Step 5. if the user doesnt exist then send notification back to them informing them that they do not exist.
     * Step 6. End.
     */
    
    add_action('wp_ajax_nopriv_forgot_password', 'forgot_password');
    add_action('wp_ajax_forgot_password', 'forgot_password');
    function forgot_password(){                                                 //PRE: no parameters
        if(email_exists($_POST['email'])):                                      //check if user exists by email
            $user  = get_user_by('email', $_POST['email']);                     // if they do get their information
            if(get_user_meta($user->ID, 'pw_user_status', true) == 'approved'): //check the status of a user (see if they have been approved);
                $new_password = wp_generate_password(8, true);
                $user = get_user_by('email', $_POST['email']);
                wp_set_password($new_password, $user->ID);

                $new_wp_mail = array(
                    'to' => $_POST['email'],
                    'subject' => 'Your new CMEF password.',
                    'message' => 'Here is your new CMEF password. Please log in and change it as soon as possible.' . $new_password,
                );

                $alerts = array(                                                //Success alert
                    'type' => 'success',
                    'message' => "You should receive a new password shortly at your email entered below.",
                );
            else:
                $alerts = array(
                    'type' => 'error',                                          //Error about user not being approved
                    'message' => 'This email does not belong to an approved user of the site, please contact us at <a href="mailto:' . antispambot("info@cmef.org") . '">' . antispambot("info@cmef.org") . '</a> for assistance.',
                );
            endif;
        else:
            $alerts = array(                                                    //Error about email not belonging to regsitered user.
                'type' => 'error',
                'message' => 'This email does not belong to a registered user.'
            );
        endif;


        echo json_encode($alerts);                                              //POST: return notifications etc.
        die();                                                                  //equiv to exit
    }