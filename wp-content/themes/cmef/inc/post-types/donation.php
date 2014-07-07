<?php
	/** 
	* If you need to create another meta box for this post type you will have to create
	* a add_meta_box() function inside the add_donation_meta_boxes() function, you can 
	* follow one below as a reference. 
	* After you create that, make sure you grab the input from the $_POST and save
	* is using update_post_meta() function inside the save_meta_boxes_data() function.
	* Again if you do not know how to do this see below for an example.
	*
	* DOCUMENT THE PDF AND COLUMNS
	* 
	*/

	// Pretty self explanitory but we are creating the donation post type.
	$labels = array(
		'name'               => _x( 'Donations', 'post type general name', 'your-plugin-textdomain' ),
		'singular_name'      => _x( 'Donation', 'post type singular name', 'your-plugin-textdomain' ),
		'menu_name'          => _x( 'Donations', 'admin menu', 'your-plugin-textdomain' ),
		'name_admin_bar'     => _x( 'Donation', 'add new on admin bar', 'your-plugin-textdomain' ),
		'add_new'            => _x( 'Add New', 'Donation', 'your-plugin-textdomain' ),
		'add_new_item'       => __( 'Add New Donation', 'your-plugin-textdomain' ),
		'new_item'           => __( 'New Donation', 'your-plugin-textdomain' ),
		'edit_item'          => __( 'Edit Donation', 'your-plugin-textdomain' ),
		'view_item'          => __( 'View Donation', 'your-plugin-textdomain' ),
		'all_items'          => __( 'All Donations', 'your-plugin-textdomain' ),
		'search_items'       => __( 'Search Donations', 'your-plugin-textdomain' ),
		'parent_item_colon'  => __( 'Parent Donations:', 'your-plugin-textdomain' ),
		'not_found'          => __( 'No Donations found.', 'your-plugin-textdomain' ),
		'not_found_in_trash' => __( 'No Donations found in Trash.', 'your-plugin-textdomain' )
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'donation' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array(''),
		'menu_icon'          => 'dashicons-color-bell'
	);
	register_post_type( 'donation', $args );

	/**
	* Below we need to add the metaboxes for the fields listed below. 
	*
	* • Contribution Amount
	* DONOR INFORMATION
	* • Email Address
	* • Organization Name
	* • First Name
	* • Middle Name
	* • Last Name
	* • Stree Address
	* • City
	* • State
	* • Zip
	* • Country
	* • Anonomize Donation Checkbox.
	* • Payment Type (Check or Credit Card)
	* • Program ID
	*/

	add_action( 'add_meta_boxes', 'add_donation_meta_boxes' );  
	function add_donation_meta_boxes(){

		// Create contribution amount meta box
		function contribution_amount_admin($post){
			// Store the existing meta data in a variable so we can access it later and prefill the fields.
			$contribution_amount = get_post_meta( $post->ID, '_contribution-amount', true);
			wp_nonce_field( 'meta_box', 'meta_box_nonce' );
			

			// CMEF has a few prefilled donation amounts. I'm giving them one more. This part needs a bit more work once we get to the front end. 
			?>
			<div class="container">
					<input type="radio" value="25" name="payment-amount" <?php checked( '25', $contribution_amount); ?>> $25 <br />
					<input type="radio" value="50" name="payment-amount" <?php checked( '50', $contribution_amount); ?>> $50 <br />
					<input type="radio" value="100" name="payment-amount" <?php checked( '100', $contribution_amount); ?>> $100 <br />
					<input type="radio" value="250" name="payment-amount" <?php checked( '250', $contribution_amount); ?>> $250 <br />
					<input type="radio" value="500" name="payment-amount" <?php checked( '500', $contribution_amount); ?>> $500 <br />
					<input type="radio" value="1000" name="payment-amount" <?php checked( '1000', $contribution_amount); ?>> $1,000 <br />
					<input type="radio" value="other" name="payment-amount"> Other Amount <br />
					<input type="number" name="other-payment-amount" placeholder="Other Amount" value="<?php echo $contribution_amount ?>">
			</div>

		<?php }
		add_meta_box('contribution-amount', __('Contribution Amount'), 'contribution_amount_admin', 'donation', 'side', 'core');

		// Create program ID meta box
		function program_id_admin($post){
			// Store the existing meta data in a variable so we can access it later and prefill the fields.
			$program_id = get_post_meta( $post->ID, '_program-id', true);

			/** 
			* Here we will give the admin user a dropdown to select the program. 
			* The program will store it's ID as meta data in the donation so we 
			* can track how much the program has for donations.
			*/

			?>
			<div class="container">
					<input type="text" value="<?php echo $program_id;  ?>" name="program-id" placeholder="Program ID">
			</div>

		<?php }
		add_meta_box('program-id', __('Program Donated To'), 'program_id_admin', 'donation', 'side', 'core');

		// Create payment method meta box
		function payment_method_admin($post){
			// Store the existing meta data in a variable so we can access it later and prefill the fields.
			$payment_method = get_post_meta( $post->ID, '_payment-method', true); 

			/**
			* Add a set of checkboxes so that the admin can check off whether the 
			* donation was a credit card or a check donation. 
			* Keep in mind that if we want to add in another payment method we would add it in here..ie. 'Cash'.
			*/ 

			?>
			<div class="container">
					<input type="radio" value="Credit Card" name="payment-method" <?php checked( 'Credit Card', $payment_method); ?>> Credit Card <br />
					<input type="radio" value="Check" name="payment-method" <?php checked( 'Check', $payment_method); ?>> Check
			</div>	
	<?php }
		add_meta_box('payment-method', __('Payment Method'), 'payment_method_admin', 'donation', 'side', 'core');

		// Create donor information meta box
		function donor_information_admin($post){
			// Store the existing meta data in a variables so we can access it later and prefill the fields.
			$donation_address = get_post_meta( $post->ID, '_donation-address', true);
			$donor_name = get_post_meta( $post->ID, '_donor-name', true);

			/**
			* We are going to store the donation address and donation name in an array. 
			* That way we can pull the information without querying the database nine time.
			*/

			 ?>
			<div class="container">
					<div class="half left">
						<table>
							<thead><h4>Name:</h4></thead>
							<tr><td> <label for="first-name">First Name: </label></td><td><input type="text" name="first-name" placeholder="First Name" value="<?php if(!empty($donor_name)){ echo $donor_name['first']; }?>"></td></tr>
							<tr><td> <label for="middle-name">Middle Name: </label></td><td><input type="text" name="middle-name" placeholder="Middle Name" value="<?php if(!empty($donor_name)){ echo $donor_name['middle']; }?>"></td></tr>
							<tr><td> <label for="last-name">Last Name: </label></td><td><input type="text" name="last-name" placeholder="Last Name" value="<?php if(!empty($donor_name)){ echo $donor_name['last']; }?>"></td></tr>
						</table>
					</div>
					<div class="half right">
						<table>
							<thead><h4>Address:</h4></thead>
							<tr><td> <label for="street-address-1">Street Address: </label></td><td><input type="text" name="street-address-1" placeholder="Street Address" value="<?php if(!empty($donation_address)){ echo $donation_address['street_1']; }?>"></td></tr>
							<tr><td> <label for="street-address-2">Street Address Cont.: </label></td><td><input type="text" name="street-address-2" placeholder="Street Address Cont." value="<?php if(!empty($donation_address)){ echo $donation_address['street_2']; }?>"></td></tr>
							<tr><td> <label for="city">City: </label></td><td><input type="text" name="city" placeholder="City" value="<?php if(!empty($donation_address)){ echo $donation_address['city']; }?>"></td></tr>
							<tr><td> <label for="state">State: </label></td><td><input type="text" name="state" placeholder="State" value="<?php if(!empty($donation_address)){ echo $donation_address['state']; }?>"></td></tr>
							<tr><td> <label for="zip">Zip: </label></td><td><input type="text" name="zip" placeholder="Zip" value="<?php if(!empty($donation_address)){ echo $donation_address['zip']; }?>"></td></tr>
							<tr><td> <label for="country">Country: </label></td><td><input type="text" name="country" placeholder="Country" value="<?php if(!empty($donation_address)){ echo $donation_address['country']; }?>"></td></tr>
						</table>
					</div>
			</div>
		<?php }
		add_meta_box('donor-information', __('Donor Information'), 'donor_information_admin', 'donation', 'normal', 'core');
	}

	// This function will be used to save the post.
	function save_meta_boxes_data( $post_id ) {
		// Make $post available
		global $post, $wpdb;
		// Check if we have a nounce set. We use this for an authentication method to make sure we are on the right page.
		if(isset($_POST['meta_box_nonce'])){
			// Let's store the address in an array. We will save the array as one meta.
			$address = array(
				'street_1' => $_POST['street-address-1'],
				'street_2' => $_POST['street-address-2'],
				'city'     => $_POST['city'],
				'state'    => $_POST['state'],
				'zip'      => $_POST['zip'],
				'country'  => $_POST['country']
			);
			// Let's store the name in an array. We will save the array as one meta
			$name = array(
				'first' => $_POST['first-name'],
				'middle' => $_POST['middle-name'],
				'last' => $_POST['last-name'],
			);

			// Update each of the metadata from above. If we have to create another meta box DO NOT FORGET to add it here to be saved.
			update_post_meta( $post_id, '_donation-address', $address );
			update_post_meta( $post_id, '_donor-name', $name );
			update_post_meta( $post_id, '_payment-method', $_POST['payment-method'] );
			update_post_meta( $post_id, '_program-id', $_POST['program-id'] );
			
			if($_POST['payment-amount'] != 'other'):;
				update_post_meta( $post_id, '_contribution-amount', $_POST['payment-amount'] );
			else:;
				update_post_meta( $post_id, '_contribution-amount', $_POST['other-payment-amount'] );
			endif;
		}
	}
	add_action( 'save_post', 'save_meta_boxes_data' );

	/**
	* Below we are going to update the columns on the edit donations page. (The page where you see the table of all donations).
	*/

	function donation_columns( $columns ){
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'donation_ID' => __('Donation ID'),
			'contribution-amount' => __( 'Amount' ),
			'program' => __('Program'),
			'payment-method' => __('Payment Method'),
			'date' => __( 'Date' ),
		);

		return $columns;
	}
	add_filter( 'manage_donation_posts_columns', 'donation_columns' ) ;

	// Show the donation post content in the column.
	add_action( 'manage_donation_posts_custom_column' , 'custom_donations_columns', 10, 2 );
	function custom_donations_columns( $column, $post_id ) {
		
	    switch ( $column ) {
	    case 'donation_ID' :
	    	echo '<a href="' . get_edit_post_link($post_id) . '">' . $post_id . '</a>';
	    	break;
		case 'contribution-amount' :
			echo '$' . get_post_meta( $post_id , '_contribution-amount' , true ) . '.00';
			break;
		case 'program' :
		    echo get_post_meta( $post_id , 'publisher' , true );
		    break;
		case 'payment-method':
			echo get_post_meta( $post_id , '_payment-method' , true );
		    break;
	    }
	}

	// Add a menu item under donations to create a pdf and csv of the donations
	add_action('admin_menu' , 'create_custom_donation_menu');
	function create_custom_donation_menu() {
		// We are creating a page to export our donations to a pdf or csv...Need to find the support for that.
		add_submenu_page('edit.php?post_type=donation', 'Export Donations to PDF or CSV', 'Export to PDF or CSV', 'edit_posts', basename(__FILE__), 'create_donation_spreadsheets');
		function create_donation_spreadsheets(){ global $post ?>
			<div class="container full margin-right">
				<form action="" method="post">
					<h1>Export to PDF or CSV</h1>
					<br />
					Starting Date: <input type="date" name="start-date" value="<?php echo date('Y-m-d') ?>">
					Ending Date: <input type="date" name="end-date" value="<?php echo date('Y-m-d') ?>">
					<br />
					<h2>PDF or CSV?</h2>
					<input type="checkbox" value="CSV" name="csv"> CSV <br />
					<input type="checkbox" value="PDF" name="pdf"> PDF <br />
					<br />
					<input class="submit button" type="submit">
				</form>
				<br><br>
<?php
				if($_POST){
					$start_date = explode('-', $_POST['start-date']);
					$end_date = explode('-', $_POST['end-date']);
					// Just in case we need it.
					// print_r($end_date); 
					$args = array(
						'post_type' => 'donation',
						'posts_per_page' => -1,
						'date_query' => array(
							'after' => array(
								'year' => $start_date[0],
								'month'=> $start_date[1],
								'day' => $start_date[2],
							),
							'before' => array(
								'year' => $end_date[0],
								'month'=> $end_date[1],
								'day' => $end_date[2],
							)
						)
					);
					$the_query = new WP_Query( $args );
					// The Loop
					if ( $the_query->have_posts() ) {
						echo '<table class="wp-list-table widefat fixed posts">';
						echo '<thead><tr><th scope="col" class="manage-column">Donation ID</th><th class="manage-column">Amount</th><th class="manage-column">Program ID</th><th class="manage-column">Date</th></tr></thead>';
						while ( $the_query->have_posts() ) {
							$the_query->the_post();
							//print_r($post);
							echo '<tbody id="the-list"><tr><td>' . $post->ID . '</td><td>' . '$' . get_post_meta( $post->ID, '_contribution-amount', true) . '</td><td>' . get_post_meta( $post->ID, '_program-id', true) . '</td><td>' . $post->post_date . '</td></tr></tbody>';
						};
						echo '</table>';
					}
					else{
						// no posts found
					}

					/* Restore original Post Data */
					wp_reset_postdata();

				} ?>
				<br />
		<?php	if($_POST['csv'] == 'CSV'){
					echo '<div class="button" id="download-csv">Download CSV</div>';
				}
				elseif($_POST['pdf'] == 'PDF'){
					echo '<div class="button" id="download-pdf">Download PDF</div>';
				}
				else{

				} ?>
			</div>
<?php
			}
	}
