<?php
	// Pretty self explanitory, but we are creating the program post type.
	$labels = array(
		'name'               => _x( 'Programs', 'post type general name', 'your-plugin-textdomain' ),
		'singular_name'      => _x( 'Program', 'post type singular name', 'your-plugin-textdomain' ),
		'menu_name'          => _x( 'Programs', 'admin menu', 'your-plugin-textdomain' ),
		'name_admin_bar'     => _x( 'Program', 'add new on admin bar', 'your-plugin-textdomain' ),
		'add_new'            => _x( 'Add New', 'Program', 'your-plugin-textdomain' ),
		'add_new_item'       => __( 'Add New Program', 'your-plugin-textdomain' ),
		'new_item'           => __( 'New Program', 'your-plugin-textdomain' ),
		'edit_item'          => __( 'Edit Program', 'your-plugin-textdomain' ),
		'view_item'          => __( 'View Program', 'your-plugin-textdomain' ),
		'all_items'          => __( 'All Programs', 'your-plugin-textdomain' ),
		'search_items'       => __( 'Search Programs', 'your-plugin-textdomain' ),
		'parent_item_colon'  => __( 'Parent Programs:', 'your-plugin-textdomain' ),
		'not_found'          => __( 'No Programs found.', 'your-plugin-textdomain' ),
		'not_found_in_trash' => __( 'No Programs found in Trash.', 'your-plugin-textdomain' )
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'program' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'thumbnail' ),
		'menu_icon'          => 'dashicons-universal-access'
	);

	register_post_type( 'program', $args );
	/**
	* META BOXES
	* If you need to add more please add them below in the function.
	*/ 
	add_action( 'add_meta_boxes', 'add_program_meta_boxes' );  
	function add_program_meta_boxes(){
		function fundraising_goal_admin($post){ ?>
			<input type="number" value="<?php echo get_post_meta( $post->ID, '_fundraising-goal', true );  ?>" name="fundraising-goal" placeholder="5000 for $5,000" required="required">

		<?php }
		add_meta_box('fundraising-goal', __('Fundraising Goal'), 'fundraising_goal_admin', 'program', 'side', 'core');

		function school_name_admin($post){ ?>
			<input type="text" value="<?php echo get_post_meta( $post->ID, '_school-name', true );  ?>" name="school-name" placeholder="Your School Name" required="required">
		<?php }
		add_meta_box( 'school-name', __('School Name'), 'school_name_admin', 'program', 'side', 'core' );

		function grade_level_admin($post){ ?>
			<select name="grade-level" id="grade-level" required="required">
				<option value="Kindergarten" <?php selected( 'Kindergarten', get_post_meta( $post->ID, '_grade-level', true ), true) ?>>Kindergarten</option>
				<option value="Elementary School" <?php selected( 'Elementary School', get_post_meta( $post->ID, '_grade-level', true ), true) ?>>Elementary School</option>
				<option value="Middle School" <?php selected( 'Middle School', get_post_meta( $post->ID, '_grade-level', true ), true) ?>>Middle School</option>
				<option value="High School" <?php selected( 'High School', get_post_meta( $post->ID, '_grade-level', true ), true) ?>>High School</option>
				<option value="All Grades" <?php selected( 'All Grades', get_post_meta( $post->ID, '_grade-level', true ), true) ?>>All Grades</option>
			</select>
		<?php }
		add_meta_box( 'grade-level', __('Grade Level'), 'grade_level_admin', 'program', 'side', 'core' );

		function number_students_admin($post){ ?>
			<input type="number" name="number-students" value="<?php echo get_post_meta( $post->ID, '_number-students', true );  ?>" required="required">
		<?php }
		add_meta_box( 'number-students', __('Number of Students'), 'number_students_admin', 'program', 'side', 'core' );

		function TFA_region_admin($post){ ?>
			<select name="tfa-region" require="required">
				<option value="All Regions" <?php selected( 'All Regions', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>All Regions</option>
				<option value="Alabama" <?php selected( 'Alabama', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>Alabama</option>
				<option value="Appalachia" <?php selected( 'Appalachia', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>Appalachia</option>
				<option value="Arkansas" <?php selected( 'Arkansas', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>Arkansas</option>
				<option value="Baltimore" <?php selected( 'Baltimore', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>Baltimore</option>
				<option value="Bay Area" <?php selected( 'Bay Area', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>Bay Area</option>
				<option value="Charlotte" <?php selected( 'Charlotte', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>Charlotte</option>
				<option value="Chicago" <?php selected( 'Chicago', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>Chicago</option>
				<option value="Colorado" <?php selected( 'Colorado', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>Colorado</option>
				<option value="Connecticut" <?php selected( 'Connecticut', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>Connecticut</option>
				<option value="D.C. Region" <?php selected( 'D.C. Region', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>D.C. Region</option>
				<option value="Dallas-Fort Worth" <?php selected( 'Dallas-Fort Worth', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>Dallas-Fort Worth</option>
				<option value="Delaware" <?php selected( 'Delaware', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>Delaware</option>
				<option value="Detroit" <?php selected( 'Detroit', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>Detroit</option>
				<option value="Eastern North Carolina" <?php selected( 'Eastern North Carolina', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>Eastern North Carolina</option>
				<option value="Greater Nashville" <?php selected( 'Greater Nashville', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>Greater Nashville</option>
				<option value="Greater New Orleans-Louisiana Delta" <?php selected( 'Greater New Orleans-Louisiana Delta', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>Greater New Orleans-Louisiana Delta</option>
				<option value="Greater Philadelphia" <?php selected( 'Greater Philadelphia', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>Greater Philadelphia</option>
				<option value="Hawai'i" <?php selected( 'Hawai\'i', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>Hawai'i</option>
				<option value="Houston" <?php selected( 'Houston', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>Houston</option>
				<option value="Indianapolis" <?php selected( 'Indianapolis', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>Indianapolis</option>
				<option value="Jacksonville" <?php selected( 'Jacksonville', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>Jacksonville</option>
				<option value="Kansas City" <?php selected( 'Kansas City', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>Kansas City</option>
				<option value="Las Vegas Valley" <?php selected( 'Las Vegas Valley', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>Las Vegas Valley</option>
				<option value="Los Angeles" <?php selected( 'Los Angeles', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>Los Angeles</option>
				<option value="Massachusetts" <?php selected( 'Massachusetts', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>Massachusetts</option>
				<option value="Memphis" <?php selected( 'Memphis', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>Memphis</option>
				<option value="Metro Atlanta" <?php selected( 'Metro Atlanta', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>Metro Atlanta</option>
				<option value="Miami-Dade" <?php selected( 'Miami-Dade', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>Miami-Dade</option>
				<option value="Milwaukee" <?php selected( 'Milwaukee', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>Milwaukee</option>
				<option value="Mississippi" <?php selected( 'Mississippi', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>Mississippi</option>
				<option value="New Jersey" <?php selected( 'New Jersey', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>New Jersey</option>
				<option value="New Mexico" <?php selected( 'New Mexico', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>New Mexico</option>
				<option value="New York" <?php selected( 'New York', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>New York</option>
				<option value="Northeast Ohio-Cleveland" <?php selected( 'Northeast Ohio-Cleveland', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>Northeast Ohio-Cleveland</option>
				<option value="Oklahoma" <?php selected( 'Oklahoma', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>Oklahoma</option>
				<option value="Phoenix" <?php selected( 'Phoenix', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>Phoenix</option>
				<option value="Rhode Island" <?php selected( 'Rhode Island', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>Rhode Island</option>
				<option value="Rio Grande Valley" <?php selected( 'Rio Grande Valley', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>Rio Grande Valley</option>
				<option value="Sacramento" <?php selected( 'Sacramento', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>Sacramento</option>
				<option value="San Antonio" <?php selected( 'San Antonio', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>San Antonio</option>
				<option value="San Diego" <?php selected( 'San Diego', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>San Diego</option>
				<option value="South Carolina" <?php selected( 'South Carolina', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>South Carolina</option>
				<option value="South Dakota" <?php selected( 'South Dakota', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>South Dakota</option>
				<option value="South Louisiana" <?php selected( 'South Louisiana', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>South Louisiana</option>
				<option value="Southwest Ohio" <?php selected( 'Southwest Ohio', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>Southwest Ohio</option>
				<option value="St. Louis" <?php selected( 'St. Louis', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>St. Louis</option>
				<option value="Twin Cities" <?php selected( 'Twin Cities', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>Twin Cities</option>
				<option value="Washington" <?php selected( 'Washington', get_post_meta( $post->ID, '_tfa-region', true ), true) ?>>Washington</option>
			</select>
		<?php }
		add_meta_box( 'TFA-region', __('TFA Region'), 'TFA_region_admin', 'program', 'side', 'core' );

		function program_type_admin($post){ ?>
			<select name="program-type">
				<option value="Field Trip" <?php selected( 'Field Trip', get_post_meta( $post->ID, '_program-type', true ), true) ?>>Field Trip</option>
				<option value="Scholarship Fund" <?php selected( 'Scholarship Fund', get_post_meta( $post->ID, '_program-type', true ), true) ?>>Scholarship Fund</option>
				<option value="Technology" <?php selected( 'Technology', get_post_meta( $post->ID, '_program-type', true ), true) ?>>Technology</option>
				<option value="Other" <?php selected( 'Other', get_post_meta( $post->ID, '_program-type', true ), true) ?>>Other</option>
			</select>
		<?php }
		add_meta_box( 'program-type', __('Program Type'), 'program_type_admin', 'program', 'side', 'core' );

		function social_networks_admin($post){ ?>
			<?php $social_meta = get_post_meta( $post->ID, '_social-networks', true ); ?>
			<h4>Google Plus</h4>
			<input type="url" name="google-plus" placeholder="http://plus.google.com/###" value="<?php echo $social_meta['google'] ?>" required="required">
			<h4>Twitter URL</h4>
			<input type="url" name="twitter" placeholder="http://www.twitter.com/" value="<?php echo $social_meta['twitter'] ?>" required="required">
			<h4>Facebook URL</h4>
			<input type="url" name="facebook" placeholder="http://www.facebook.com/" value="<?php echo $social_meta['facebook'] ?>" required="required">
		<?php }
		add_meta_box( 'social-networks-admin', __('Social Network URLs'), 'social_networks_admin', 'program', 'side', 'core' );

		/**
		* We only need the below meta box if the program has already been created.. 
		* So let's check the url to see if we are using wordpress's 'post-new.php' file.
		* We will pull in the donations and expenses to create a balance table.
		* 
		* We will add some more doc's a bit later.
		*/
		$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		if (false == strpos($url,'post-new.php')) {
			function balance_admin(){
				global $post_id, $post;

				$args = array(
					'post_type'      => array('donation', 'expense'),
					'meta_key'       => '_program-id',
					'meta_value'     => $post_id,
					'orderby'        => 'date',
					'posts_per_page' => -1
				);
				
				$the_query = new WP_Query( $args );

				if ( $the_query->have_posts() ) { $total = 0;?>
					<table class="wp-list-table widefat fixed posts">
						<thead><tr><th scope="col" class="manage-column">ID</th><th class="manage-column">Type</th><th class="manage-column">Amount</th><th class="manage-column">Date</th></tr></thead>
						<?php while ( $the_query->have_posts() ) {
							$the_query->the_post();

							if($post->post_type == 'donation'){
								$amount = (int)get_post_meta( $post->ID, '_contribution-amount', true);
								$total = $total + $amount;
							}
							elseif($post->post_type == 'expense'){
								// Change this below.
								$amount = (int)get_post_meta( $post->ID, '_expense-amount', true);
								$total = $total - $amount;
							}
							?>
							<tbody id="the-list">
								<tr><td><?php echo $post->ID ?></td><td><?php echo $post->post_type ?></td><td><?php echo '$' . $amount . '.00' ?></td><td><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?></td></tr>
							</tbody>
						<?php } ?>
						<tfoot>
						  <tr>
						  	<td></td>
						    <td><h4>Sum</h4></td>
						    <td><h4>$<?php echo $total; ?>.00</h4></td>
						    <td></td>
						  </tr>
						</tfoot>
					</table>
					<br />
					<div class="button">Download CSV</div>
				<?php }
				/* Restore original Post Data */
				wp_reset_postdata();
						
			}
			add_meta_box( 'program-balance', __('Account Activity'), 'balance_admin', 'program', 'normal', 'core' );
		}
	}
	/**
	* SAVE META BOXES
	* if you need to save a metabox of field please add them in the function below.
	*/
	function save_program_meta_boxes_data($post_id){
		//echo '<pre>'; print_r($_POST); print_r($post_id); echo '</pre>';
		
		update_post_meta($post_id, '_fundraising-goal', $_POST['fundraising-goal'] );
		update_post_meta($post_id, '_school-name', $_POST['school-name'] );
		update_post_meta($post_id, '_grade-level', $_POST['grade-level'] );
		update_post_meta($post_id, '_number-students', $_POST['number-students'] );
		update_post_meta($post_id, '_tfa-region', $_POST['tfa-region'] );
		update_post_meta($post_id, '_program-type', $_POST['program-type'] );

		$social = array(
			'google' => $_POST['google-plus'],
			'twitter' => $_POST['twitter'],
			'facebook' => $_POST['facebook']
		);
		update_post_meta($post_id, '_social-networks', $social );

	}
	add_action( 'save_post', 'save_program_meta_boxes_data' );

/* Add a menu item under donations to create a pdf and csv of the donations */

?>