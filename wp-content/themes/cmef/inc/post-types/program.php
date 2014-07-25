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

function create_custom_program_menu() {
    /**
     * We are creating a page to export our donations to a pdf or csv...Need to find the support for that.
     * Below we will create some HTML to output on to the admin screen then well addin a custom query when they decide to filter.
     */
    add_submenu_page('edit.php?post_type=program', 'Create a Report', 'Create a Report', 'edit_posts', basename(__FILE__), 'create_program_spreadsheets');
    function create_program_spreadsheets(){ global $post;
        /* Run Some Query's. Store the query var in a array for we can run the query multiple times. */


        /* Generate the HTML. */ ?>
        <div class="container full margin-right">
            <form action="" method="post">
                <h1>Export to PDF or CSV</h1>
                <br />
				<table>
					<tr>
	                <td>
	                	<label for="start-date">Starting Date:</label>
	                </td>
	                <td>
	                	<input type="date" name="start-date" value="<?php echo $_POST['start-date'] ?>" required="required">
	                </td>
	                <td>
	                	<label for="end-date">Ending Date:</label>
	                </td>
	                <td>
	                	<input type="date" name="end-date" value="<?php echo $_POST['end-date'] ?>" required="required">
	                </td>
	            	</tr>
	                <tr>
	                <td>
	                	<label for="post-type">Run Report for:</label>
	                </td>
	                <td>
		                <select name="post-type">
		                    <option value="">Select</option>
		                    <option value="donation" <?php selected( $_POST['post-type'], 'donation', true ); ?>>Donations</option>
		                    <option value="expense" <?php selected( $_POST['post-type'], 'expense', true ); ?>>Expenses</option>
		                </select>
		            </td>
	                <td>
	                	<label for="program-id">Program: </label>
	                </td>
	                <td>
		                <?php
		                    $args = array(
		                        'post_type' => 'program',
		                        'posts_per_page' => -1,
		                    );

		                    $program_query = new WP_Query($args);
		                    if ( $program_query->have_posts() ) {
		                        echo '<select name="program-id">
		                                    <option value="">- None -</option>';
		                        while($program_query->have_posts() ){
		                            $program_query->the_post(); ?>
		                            <option value="<?php echo $post->ID; ?>" <?php selected( $_POST['program-id'], $post->ID, true ); ?>><?php echo $post->post_title . ' - PID:' . $post->ID ?></option>
		                       <?php }
		                        echo '</select>';
		                    }
		                    /* Restore original Post Data */
		                    wp_reset_postdata();
		                ?>
		            </td>
	            	</tr>
            	</table>
                <br/>
                <?php /* We need to create few hidden fields so we can access some information with javascript. */ ?>
                <input type="hidden" value="<?php echo rand(1111111111111, 99999999999999) ?>" name="filename">
                <input type="hidden" value="<?php echo get_bloginfo( 'url' ); ?>" name="bloginfoURL">
                <input class="submit button" type="submit">
            </form>
            <br><br>
            <?php
            /* Create the query if we are on have the variable $_POST; (You clicked submit.) */
            if($_POST){
                /* Create an array of the date so we can use it in the query. */
                $start_date = explode('-', $_POST['start-date']);
                $end_date = explode('-', $_POST['end-date']);
                $post_type = $_POST['post-type'];
                if($post_type === ''){
                	$post_type = 'donation';
                }
                $program_id = $_POST['program-id'];

                //WP Query Arguments
                $args = array(
                    'post_type' => $post_type,
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
                if($program_id != ''){
                	$args['meta_query'] = array(
                		array(
                			'key' => '_program-id',
                			'value' => $program_id,
                		)
                	);
                }
               	//print_r($args);
                /* Run the query. */
                $the_query = new WP_Query( $args );

                /* The Loop */
                if ( $the_query->have_posts() && $post_type === 'donation') {

                    /* Start the table and include the header row. */

                    echo '	<h3>Donations</h3><table class="wp-list-table widefat fixed posts">
									<thead>
										<tr>
											<th class="manage-column">Program ID</th>
											<th class="manage-column">First Name</th>
											<th class="manage-column">Last Name</th>
											<th class="manage-column">Street Address</th>
											<th class="manage-column">City</th>
											<th class="manage-column">State</th>
											<th class="manage-column">Zip</th>
											<th class="manage-column">Date</th>
											<th class="manage-column">Amount</th>
											<th class="manage-column">checkB</th>
											<th class="manage-column">Memo</th>
										</tr>
									</thead>';

                    /* We are creating a javascript element so we can access the information from the above form. Which ultimately includes the information in the hidden fields (the important bits). */ ?>

                    <script type='text/javascript'> var $_POST = <?php echo !empty($_POST)?json_encode($_POST):'null';?>; </script> <?php

                    /**
                     * We have included a library to help us with writing to a csv file. We are going to write to a temp file.
                     * After/if the user clicks on the download the template file (see the javascript documentation). The file will then be deleted.
                     */

                    $writer = new \EasyCSV\Writer(ABSPATH . 'temp_csv_files/exported-csv-' . $_POST['filename'] .'.csv');
                    $writer->writeRow('program_id, first_name, last_name, street_address, city, state, zip, date, amount, checkB, memo');
                    $reader = new \EasyCSV\Reader(ABSPATH . 'temp_csv_files/exported-csv-' . $_POST['filename'] .'.csv');

                    /* Loop through the posts. */
                    while ( $the_query->have_posts() ) {
                        $the_query->the_post();
                        if(get_post_meta( $post->ID , '_payment-method' , true ) == 'Check'){
                            $check = 1;
                        }
                        else{
                            $check = 0;
                        }
                        echo '	<tr>
										<td>' . get_post_meta( $post->ID, '_program-id', true) . '</td>
										<td>' . get_post_meta( $post->ID, '_donor-name', true )['first'] . '</td>
										<td>' . get_post_meta( $post->ID, '_donor-name', true )['last'] . '</td>
										<td>' . get_post_meta( $post->ID, '_donation-address', true )['street_1'] . ' ' . get_post_meta( $post->ID, '_donation-address', true )['street_2'] . '</td>
										<td>' . get_post_meta( $post->ID, '_donation-address', true )['city'] . '</td>
										<td>' . get_post_meta( $post->ID, '_donation-address', true )['state'] . '</td>
										<td>' . get_post_meta( $post->ID, '_donation-address', true )['zip'] . '</td>
										<td>' . $post->post_date . '</td>
										<td>' . '$' . get_post_meta( $post->ID, '_contribution-amount', true) . '.00' . '</td>
										<td>' . $check . '</td>
										<td>' . $post->post_content . '</td>

									</tr>';

                        /* Write the row to the csv file */
                        $row = get_post_meta( $post->ID, '_program-id', true) . ',' . get_post_meta( $post->ID, '_donor-name', true )['first'] . ',' . get_post_meta( $post->ID, '_donor-name', true )['last'] . ',' . get_post_meta( $post->ID, '_donation-address', true )['street_1'] . ' ' . get_post_meta( $post->ID, '_donation-address', true )['street_2'] . ',' . get_post_meta( $post->ID, '_donation-address', true )['city'] . ',' . get_post_meta( $post->ID, '_donation-address', true )['state'] . ',' . get_post_meta( $post->ID, '_donation-address', true )['zip'] . ',' . $post->post_date . ',' . get_post_meta( $post->ID, '_contribution-amount', true) . ',' . $check . ',' . $post->post_content;
                        $writer->writeRow($row);

                    };
                    /* Close the table. */
                    echo '</table>';
                }
                elseif($the_query->have_posts() && $post_type === 'expense'){
                	/* Start the table and include the header row. */

                    echo '	<h3>Expenses</h3><table class="wp-list-table widefat fixed posts">
									<thead>
										<tr>
											<th class="manage-column">Expense ID</th>
											<th class="manage-column">Program ID</th>
											<th class="manage-column">Date</th>
											<th class="manage-column">Amount</th>
											<th class="manage-column">Memo</th>
										</tr>
									</thead>';

                    /* We are creating a javascript element so we can access the information from the above form. Which ultimately includes the information in the hidden fields (the important bits). */ ?>

                    <script type='text/javascript'> var $_POST = <?php echo !empty($_POST)?json_encode($_POST):'null';?>; </script> <?php

                    /**
                     * We have included a library to help us with writing to a csv file. We are going to write to a temp file.
                     * After/if the user clicks on the download the template file (see the javascript documentation). The file will then be deleted.
                     */

                    $writer = new \EasyCSV\Writer(ABSPATH . 'temp_csv_files/exported-csv-' . $_POST['filename'] .'.csv');
                    $writer->writeRow('expense_id, program_id, date, amount, memo');
                    $reader = new \EasyCSV\Reader(ABSPATH . 'temp_csv_files/exported-csv-' . $_POST['filename'] .'.csv');

                    /* Loop through the posts. */
                    while ( $the_query->have_posts() ) {
                        $the_query->the_post();
                        if(get_post_meta( $post->ID , '_payment-method' , true ) == 'Check'){
                            $check = 1;
                        }
                        else{
                            $check = 0;
                        }
                        echo '	<tr>	
                        				<td>' . $post->ID . '</td>
										<td>' . get_post_meta( $post->ID, '_program-id', true) . '</td>
										<td>' . $post->post_date . '</td>
										<td>' . '-$' . get_post_meta( $post->ID, '_expense-amount', true) . '.00' . '</td>
										<td>' . $post->post_content . '</td>

									</tr>';

                        /* Write the row to the csv file */
                        $row = $post->ID . ',' . get_post_meta( $post->ID, '_program-id', true) . ',' . $post->post_date . ',' . '-' . get_post_meta( $post->ID, '_expense-amount', true) . ',' . $post->post_content;
                        $writer->writeRow($row);

                    };
                    /* Close the table. */
                    echo '</table>';
                }

                /* Restore original Post Data */
                wp_reset_postdata();

            } ?>
            <br />
            	<?php if(isset($_POST['start-date'])): ?>
                <div class="button" id="download-csv">Download CSV</div>
				<!--<div class="button" id="download-pdf">Download PDF</div>-->
				<?php endif; ?>
        </div>
    <?php
    }
}
add_action('admin_menu' , 'create_custom_program_menu');
?>