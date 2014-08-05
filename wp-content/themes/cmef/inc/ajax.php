<?php

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
    	$args = array(
			'post_type'   => 'program',
			'offset' => $_POST['offset'] + 1,
			'posts_per_page' => 3
		);
		$the_query = new WP_Query( $args );
			if ($the_query->have_posts()) :;
    		while ($the_query->have_posts()) : $the_query->the_post() ;
    			$goal = get_post_meta(get_the_ID(), '_fundraising-goal', true);
		    	$program = $post;
		    	$program->author = get_the_author();
		    	$program->post_thumbnail = get_the_post_thumbnail($post->ID, $size = 'post-thumbnail', $attr = '');
		    	$program->placement_holder_image = '<img src="'. get_template_directory_uri() .'/images/placeholder.png" alt="">';
		    	$program->percentage_raised = (47523/(int) $goal)*100;
                //Also append the same data to an array for JS
    			$programsDataObject[] = $program;
    			$program->amount_raised = money_format('%.0n', 15000) . "\n";
    			$program->fundraiser_goal = money_format('%.0n', $goal) . "\n";
    			$program->twitter_url = get_post_meta($post->ID, '_social-networks', true)['twitter'];
    			$program->linkedin_url = get_post_meta($post->ID, '_social-networks', true)['linkedin'];
    			$program->facebook_url = get_post_meta($post->ID, '_social-networks', true)['facebook'];
    			$program->googel_url = get_post_meta($post->ID, '_social-networks', true)['google'];
    	endwhile;

    	echo json_encode($programsDataObject);
    	endif;
    	die(); 
    }//ajax_fetch_programs

    //Save Author
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

    /**
     * Process Donation with Authorize.NET
     */
    add_action('wp_ajax_nopriv_process_donation', 'process_donation');
    add_action('wp_ajax_process_donation', 'process_donation');
    function process_donation(){
    	//Set the authorize.net variables
    	include ('sdk-php-master/autoload.php');
    	define("AUTHORIZENET_API_LOGIN_ID", "6KRWv8m7WtF");
		define("AUTHORIZENET_TRANSACTION_KEY", "45DnnA8Q659jxqFj");
		define("AUTHORIZENET_SANDBOX", true);
		
    	//Store the variables (again...).. There must be a better way of doing this........
		//print_r($_POST); 
		$amount = $_POST[''];
		$pay_for_transaction = $_POST['pay_for_transaction'];
		$donate_to_cmef = $_POST['donate_to_cmef'];
		$card_type = $_POST['card_type'];
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
        //$sale->email              = $email;
        //$sale->cust_id            = $customer_id = "55";
        //$sale->customer_ip        = "98.5.5.5";
        //$sale->invoice_num        = $invoice_number = "123";
        //$sale->ship_to_first_name = $ship_to_first_name = "John";
        //$sale->ship_to_last_name  = $ship_to_last_name = "Smith";
        //$sale->ship_to_company    = $ship_to_company = "Smith Enterprises Inc.";
        //$sale->ship_to_address    = $ship_to_address = "10 Main Street";
        //$sale->ship_to_city       = $ship_to_city = "San Francisco";
        //$sale->ship_to_state      = $ship_to_state = "CA";
        //$sale->ship_to_zip        = $ship_to_zip_code = "94110";
        //$sale->ship_to_country    = $ship_to_country = "US";
        //$sale->tax                = $tax = "0.00";
        //$sale->freight            = $freight = "Freight<|>ground overnight<|>12.95";
        //$sale->duty               = $duty = "Duty1<|>export<|>15.00";
        //$sale->tax_exempt         = $tax_exempt = "FALSE";
        //$sale->po_num             = $po_num = "12";

        print_r($sale);
        $response = $sale->authorizeAndCapture();
        if ($response->approved) {
		    $transaction_id = $response->transaction_id;
		}
		echo json_encode($response);
		die();
    }