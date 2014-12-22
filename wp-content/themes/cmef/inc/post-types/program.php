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
		'menu_icon'          => 'dashicons-universal-access',
		'taxonomies' => array('tfa-region')
	);

	register_post_type( 'program', $args );
	/**
	* META BOXES
	* If you need to add more please add them below in the function.
	*/ 
	add_action( 'add_meta_boxes', 'add_program_meta_boxes' );  
	function add_program_meta_boxes(){
		function fundraising_goal_admin($post){ ?>
			<input type="number" value="<?php echo get_post_meta( $post->ID, '_fundraising-goal', true );  ?>" name="fundraising-goal" placeholder="5000 for $5,000">

		<?php }
		add_meta_box('fundraising-goal', __('Fundraising Goal'), 'fundraising_goal_admin', 'program', 'side', 'core');

		function organization_name_admin($post){ ?>
			<input type="text" value="<?php echo get_post_meta( $post->ID, '_organization-name', true );  ?>" name="organization-name" placeholder="Your Organization Name">
		<?php }
		add_meta_box( 'organization-name', __('Organization Name'), 'organization_name_admin', 'program', 'side', 'core' );

		function number_students_admin($post){ ?>
			<input type="number" name="number-students" value="<?php echo get_post_meta( $post->ID, '_number-students', true );  ?>">
		<?php }
		add_meta_box( 'number-students', __('Number of Students'), 'number_students_admin', 'program', 'side', 'core' );

		function social_networks_admin($post){ ?>
			<?php $social_meta = get_post_meta( $post->ID, '_social-networks', true ); ?>
			<h4>Google Plus</h4>
			<input type="url" name="google-plus" placeholder="http://plus.google.com/###" value="<?php echo $social_meta['google'] ?>">
			<h4>Twitter URL</h4>
			<input type="url" name="twitter" placeholder="http://www.twitter.com/" value="<?php echo $social_meta['twitter'] ?>">
			<h4>Facebook URL</h4>
			<input type="url" name="facebook" placeholder="http://www.facebook.com/" value="<?php echo $social_meta['facebook'] ?>">
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
		update_post_meta($post_id, '_organization-name', $_POST['organization-name'] );

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