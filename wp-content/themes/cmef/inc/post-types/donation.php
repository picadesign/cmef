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

	/* Pretty self explanatory but we are creating the donation post type. */
	$labels = array(
		'name'               => _x( 'Donations', 'post type general name' ),
		'singular_name'      => _x( 'Donation', 'post type singular name' ),
		'menu_name'          => _x( 'Donations', 'admin menu' ),
		'name_admin_bar'     => _x( 'Donation', 'add new on admin bar' ),
		'add_new'            => _x( 'Add New', 'Donation' ),
		'add_new_item'       => __( 'Add New Donation' ),
		'new_item'           => __( 'New Donation' ),
		'edit_item'          => __( 'Edit Donation' ),
		'view_item'          => __( 'View Donation' ),
		'all_items'          => __( 'All Donations' ),
		'search_items'       => __( 'Search Donations' ),
		'parent_item_colon'  => __( 'Parent Donations:' ),
		'not_found'          => __( 'No Donations found.' ),
		'not_found_in_trash' => __( 'No Donations found in Trash.' )
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
		'supports'           => array('editor'),
		'menu_icon'          => 'dashicons-color-bell'
	);
	register_post_type( 'donation', $args );

	/**
	* Below we need to add the meta-boxes for the fields listed below.
	*
	* • Contribution Amount
	* DONOR INFORMATION
	* • Email Address
	* • Organization Name
	* • First Name
	* • Middle Name
	* • Last Name
	* • Street Address
	* • City
	* • State
	* • Zip
	* • Country
	* • Anonymity Donation Checkbox.
	* • Payment Type (Check or Credit Card)
	* • Program ID
	*/

	add_action( 'add_meta_boxes', 'add_donation_meta_boxes' );
	function add_donation_meta_boxes(){

		/* Create contribution amount meta box */
		function contribution_amount_admin($post){
			/* Store the existing meta data in a variable so we can access it later and pre-fill the fields. */
			$contribution_amount = get_post_meta( $post->ID, '_contribution-amount', true);
			wp_nonce_field( 'meta_box', 'meta_box_nonce' );


			/* CMEF has a few prefilled donation amounts. I'm giving them one more. This part needs a bit more work once we get to the front end.  */
			?>
			<div class="container">
					<input type="radio" value="25" name="payment-amount" <?php checked( '25', $contribution_amount); ?>><label for="payment-amount">$25</label><br />
					<input type="radio" value="50" name="payment-amount" <?php checked( '50', $contribution_amount); ?>><label for="payment-amount">$50</label><br />
					<input type="radio" value="100" name="payment-amount" <?php checked( '100', $contribution_amount); ?>><label for="payment-amount">$100</label><br />
					<input type="radio" value="250" name="payment-amount" <?php checked( '250', $contribution_amount); ?>><label for="payment-amount">$250</label><br />
					<input type="radio" value="500" name="payment-amount" <?php checked( '500', $contribution_amount); ?>><label for="payment-amount">$500</label><br />
					<input type="radio" value="1000" name="payment-amount" <?php checked( '1000', $contribution_amount); ?>><label for="payment-amount">$1,000</label><br />
					<input type="number" name="other-payment-amount" placeholder="Other Amount" value="<?php echo $contribution_amount ?>">
			</div>

		<?php }
		add_meta_box('contribution-amount', __('Contribution Amount'), 'contribution_amount_admin', 'donation', 'side', 'core');

		/* Create program ID meta box */
		function program_id_admin(){
			global $post;
			/* Store the existing meta data in a variable so we can access it later and prefill the fields. */
			$program_id = get_post_meta( $post->ID, '_program-id', true);

			/**
			* Here we will give the admin user a dropdown to select the program.
			* The program will store it's ID as meta data in the donation so we
			* can track how much the program has for donations.
			*/

			$args = array(
				'post_type'   => 'program',
			);

			$the_query = new WP_Query( $args );

			/* Create the dropdown usgint he data we gathered above. We will store the program id so we can use if for later. */
			if ( $the_query->have_posts() ) {
				echo '<select name="program-id" id="">';
					echo '<option value="none">None</option>';
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					echo '<option value="' . $post->ID . '"' . selected( $post->ID, $program_id, true) . '>' . $post->post_title .'</option>';
				}
				echo '</select>';
			}
			/* Restore original Post Data */
			wp_reset_postdata();
		}
		add_meta_box('program-id', __('Program Donated To'), 'program_id_admin', 'donation', 'side', 'core');

		/* Create payment method meta box */
		function payment_method_admin($post){
			/* Store the existing meta data in a variable so we can access it later and prefill the fields. */
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

		/* Create donor information meta box */
		function donor_information_admin(){
			global $post_id;
			/* Store the existing meta data in a variables so we can access it later and prefill the fields. */
			$donation_address = get_post_meta( $post_id, '_donation-address', true);
			$donor_name = get_post_meta( $post_id, '_donor-name', true);

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
		add_meta_box('donor-information', __('Donor Information'), 'donor_information_admin', 'donation', 'normal', 'high');
	}

	/* This function will be used to save the post. */
	function save_donation_meta_boxes_data( $post_id ) {
		/* Make $post available */
		// global $post, $wpdb;
		/* Check if we have a nounce set. We use this for an authentication method to make sure we are on the right page. */
		if(isset($_POST['meta_box_nonce'])){
			/* Let's store the address in an array. We will save the array as one meta. */
			$address = array(
				'street_1' => $_POST['street-address-1'],
				'street_2' => $_POST['street-address-2'],
				'city'     => $_POST['city'],
				'state'    => $_POST['state'],
				'zip'      => $_POST['zip'],
				'country'  => $_POST['country']
			);
			/* Let's store the name in an array. We will save the array as one meta */
			$name = array(
				'first' => $_POST['first-name'],
				'middle' => $_POST['middle-name'],
				'last' => $_POST['last-name'],
			);

			/* Update each of the metadata from above. If we have to create another meta box DO NOT FORGET to add it here to be saved. */
			update_post_meta( $post_id, '_donation-address', $address );
			update_post_meta( $post_id, '_donor-name', $name );
			update_post_meta( $post_id, '_payment-method', $_POST['payment-method'] );
			update_post_meta( $post_id, '_program-id', $_POST['program-id'] );
			if(!isset($_POST['payment-amount'])){
				update_post_meta( $post_id, '_contribution-amount', $_POST['other-payment-amount'] );
			}
			else{
				update_post_meta( $post_id, '_contribution-amount', $_POST['payment-amount'] );
			}
		}
	}
	add_action( 'save_post', 'save_donation_meta_boxes_data' );

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

	/**
	* Below we show the donation post content in the column.
	* First Column is the ID with a link to the edit post page.
	* Second is the contribution amount.
	* Third is the program ID that it belong to.
	* Fourth is the payment method for quick reference.
	*/

	function custom_donations_columns( $column, $post_id ) {

	    switch ( $column ) {
	    case 'donation_ID' :
	    	echo '<a href="' . get_edit_post_link($post_id) . '">' . $post_id . '</a>';
	    	break;
		case 'contribution-amount' :
			echo '$' . get_post_meta( $post_id , '_contribution-amount' , true ) . '.00';
			break;
		case 'program' :
		    echo '<a href="' . get_edit_post_link(get_post_meta( $post_id, '_program-id', true)) . '">' . get_the_title(get_post_meta( $post_id, '_program-id', true)) .'</a>';
		    break;
		case 'payment-method':
			echo get_post_meta( $post_id , '_payment-method' , true );
		    break;
	    }
	}
	add_action( 'manage_donation_posts_custom_column' , 'custom_donations_columns', 10, 2 );