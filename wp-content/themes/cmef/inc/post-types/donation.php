<?php
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

			$contribution_amount = get_post_meta( $post->ID, '_contribution-amount', true);
			wp_nonce_field( 'meta_box', 'meta_box_nonce' );
			
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

			$program_id = get_post_meta( $post->ID, '_program-id', true);
			wp_nonce_field( 'meta_box', 'meta_box_nonce' );

			?>

			<div class="container">
					<input type="text" value="<?php echo $program_id;  ?>" name="program-id" placeholder="Program ID">
			</div>

		<?php }
		add_meta_box('program-id', __('Program Donated To'), 'program_id_admin', 'donation', 'side', 'core');

		// Create payment method meta box
		function payment_method_admin($post){ 

			$payment_method = get_post_meta( $post->ID, '_payment-method', true);
			wp_nonce_field( 'meta_box', 'meta_box_nonce' );

			?>

			<div class="container">
					<input type="radio" value="Credit Card" name="payment-method" <?php checked( 'Credit Card', $payment_method); ?>> Credit Card <br />
					<input type="radio" value="Check" name="payment-method" <?php checked( 'Check', $payment_method); ?>> Check
			</div>	

		<?php }
		add_meta_box('payment-method', __('Payment Method'), 'payment_method_admin', 'donation', 'side', 'core');

		// Create donor information meta box
		function donor_information_admin($post){

			$donation_address = get_post_meta( $post->ID, '_donation-address', true);
			$donor_name = get_post_meta( $post->ID, '_donor-name', true);
			wp_nonce_field( 'meta_box', 'meta_box_nonce' );

			?>

			<div class="container">
					<div class="half left">
						<table>
							<thead><h4>Name:</h4></thead>
							<tr><td> <label for="first-name">First Name: </label></td><td><input type="text" name="first-name" placeholder="First Name" value="<?php echo $donor_name['first'] ?>"></td></tr>
							<tr><td> <label for="middle-name">Middle Name: </label></td><td><input type="text" name="middle-name" placeholder="Middle Name" value="<?php echo $donor_name['middle'] ?>"></td></tr>
							<tr><td> <label for="last-name">Last Name: </label></td><td><input type="text" name="last-name" placeholder="Last Name" value="<?php echo $donor_name['last'] ?>"></td></tr>
						</table>
					</div>
					<div class="half right">
						<table>
							<thead><h4>Address:</h4></thead>
							<tr><td> <label for="street-address-1">Street Address: </label></td><td><input type="text" name="street-address-1" placeholder="Street Address" value="<?php echo $donation_address['street_1'] ?>"></td></tr>
							<tr><td> <label for="street-address-2">Street Address Cont.: </label></td><td><input type="text" name="street-address-2" placeholder="Street Address Cont." value="<?php echo $donation_address['street_2'] ?>"></td></tr>
							<tr><td> <label for="city">City: </label></td><td><input type="text" name="city" placeholder="City" value="<?php echo $donation_address['city'] ?>"></td></tr>
							<tr><td> <label for="state">State: </label></td><td><input type="text" name="state" placeholder="State" value="<?php echo $donation_address['state'] ?>"></td></tr>
							<tr><td> <label for="zip">Zip: </label></td><td><input type="text" name="zip" placeholder="Zip" value="<?php echo $donation_address['zip'] ?>"></td></tr>
							<tr><td> <label for="country">Country: </label></td><td><input type="text" name="country" placeholder="Country" value="<?php echo $donation_address['country'] ?>"></td></tr>
						</table>
					</div>
			</div>
		<?php }
		add_meta_box('donor-information', __('Donor Information'), 'donor_information_admin', 'donation', 'normal', 'core');
	}

	// Save the post data.
	function save_meta_boxes_data( $post_id ) {
		global $post, $wpdb;
		//print_r($_POST);
		if($_POST){
			$address = array(
				'street_1' => $_POST['street-address-1'],
				'street_2' => $_POST['street-address-2'],
				'city'     => $_POST['city'],
				'state'    => $_POST['state'],
				'zip'      => $_POST['zip'],
				'country'  => $_POST['country']
			);

			$name = array(
				'first' => $_POST['first-name'],
				'middle' => $_POST['middle-name'],
				'last' => $_POST['last-name'],
			);

			update_post_meta( $post_id, '_donation-address', $address );
			update_post_meta( $post_id, '_donor-name', $name );
			update_post_meta( $post_id, '_payment-method', $_POST['payment-method'] );
			update_post_meta( $post_id, '_program-id', $_POST['program-id'] );
			if($post->post_title != $post->ID):
				wp_update_post( 
					array(
						'post_title' => $post->ID
					)
				);
			endif;
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
			'title' => __('Donation ID'),
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
		function create_donation_spreadsheets(){ ?>
			<h1>Export to PDF or CSV</h1>
			<br />
			Starting Date: <input type="date">
			Ending Date: <input type="date">
			<br />
			<h2>PDF or CSV?</h2>
			<input type="checkbox" value="CSV" name="csv"> CSV <br />
			<input type="checkbox" value="PDF" name="pdf"> PDF

			<br><br>
		<?php }
	}
