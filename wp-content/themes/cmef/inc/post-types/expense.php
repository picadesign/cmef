<?php
	
	// Pretty self explanitory but we are creating the expense post type.

	$labels = array(
		'name'               => _x( 'Expenses', 'post type general name', 'your-plugin-textdomain' ),
		'singular_name'      => _x( 'Expense', 'post type singular name', 'your-plugin-textdomain' ),
		'menu_name'          => _x( 'Expenses', 'admin menu', 'your-plugin-textdomain' ),
		'name_admin_bar'     => _x( 'Expense', 'add new on admin bar', 'your-plugin-textdomain' ),
		'add_new'            => _x( 'Add New', 'Expense', 'your-plugin-textdomain' ),
		'add_new_item'       => __( 'Add New Expense', 'your-plugin-textdomain' ),
		'new_item'           => __( 'New Expense', 'your-plugin-textdomain' ),
		'edit_item'          => __( 'Edit Expense', 'your-plugin-textdomain' ),
		'view_item'          => __( 'View Expense', 'your-plugin-textdomain' ),
		'all_items'          => __( 'All Expenses', 'your-plugin-textdomain' ),
		'search_items'       => __( 'Search Expenses', 'your-plugin-textdomain' ),
		'parent_item_colon'  => __( 'Parent Expenses:', 'your-plugin-textdomain' ),
		'not_found'          => __( 'No Expenses found.', 'your-plugin-textdomain' ),
		'not_found_in_trash' => __( 'No Expenses found in Trash.', 'your-plugin-textdomain' )
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'expense' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array('editor'),
		'menu_icon'          => 'dashicons-color-coin'
	);

	register_post_type( 'expense', $args );

	/**
	* Below we need to add the metaboxes for the fields listed below. 
	*
	* • expense Amount
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
	* • Anonomize expense Checkbox.
	* • Payment Type (Check or Credit Card)
	* • Program ID
	*/

	add_action( 'add_meta_boxes', 'add_expense_meta_boxes' );  
	function add_expense_meta_boxes(){

		// Create expense amount meta box
		function expense_amount_admin($post){
			// Store the existing meta data in a variable so we can access it later and prefill the fields.
			$expense_amount = get_post_meta( $post->ID, '_expense-amount', true);
			wp_nonce_field( 'meta_box', 'expensemeta_box_nonce' );
			

			// CMEF has a few prefilled expense amounts. I'm giving them one more. This part needs a bit more work once we get to the front end. 
			?>
			<div class="container">

					<input type="number" name="expense-amount" placeholder="50 for $50.00" value="<?php echo $expense_amount ?>">
			</div>

		<?php }
		add_meta_box('expense-amount', __('Expense Amount'), 'expense_amount_admin', 'expense', 'side', 'core');

		// Create program ID meta box
		function expense_program_id_admin(){
			global $post;
			// Store the existing meta data in a variable so we can access it later and prefill the fields.
			$program_id = get_post_meta( $post->ID, '_program-id', true);

			/** 
			* Here we will give the admin user a dropdown to select the program. 
			* The program will store it's ID as meta data in the expense so we 
			* can track how much the program has for expenses.
			*/

			$args = array(
				'post_type'   => 'program',
			);
			
			$the_query = new WP_Query( $args );

			// Create the dropdown usgint he data we gathered above. We will store the program id so we can use if for later.
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
		add_meta_box('program-id', __('Program'), 'expense_program_id_admin', 'expense', 'side', 'core');

	}

	// This function will be used to save the post.
	function save_expense_meta_boxes_data( $post_id ) {
		// Make $post available
		global $post, $wpdb;
		// Check if we have a nounce set. We use this for an authentication method to make sure we are on the right page.
		if(isset($_POST['expensemeta_box_nonce'])){
			update_post_meta( $post_id, '_program-id', $_POST['program-id'] );
			update_post_meta( $post_id, '_expense-amount', $_POST['expense-amount'] );
		}
	}
	add_action( 'save_post', 'save_expense_meta_boxes_data' );

	/**
	* Below we are going to update the columns on the edit expenses page. (The page where you see the table of all expenses).
	*/

	function expense_columns( $columns ){
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'expense_ID' => __('Expense ID'),
			'expense-amount' => __( 'Amount' ),
			'program' => __('Program'),
			'date' => __( 'Date' ),
		);

		return $columns;
	}
	add_filter( 'manage_expense_posts_columns', 'expense_columns' ) ;

	/** 
	* Below we show the expense post content in the column. 
	* First Column is the ID with a link to the edit post page. 
	* Second is the expense amount. 
	* Third is the program ID that it belong to. 
	* Fourth is the payment method for wuick reference.
	*/

	add_action( 'manage_expense_posts_custom_column' , 'custom_expenses_columns', 10, 2 );
	function custom_expenses_columns( $column, $post_id ) {
		
	    switch ( $column ) {
	    case 'expense_ID' :
	    	echo '<a href="' . get_edit_post_link($post_id) . '">' . $post_id . '</a>';
	    	break;
		case 'expense-amount' :
			echo '$' . get_post_meta( $post_id , '_expense-amount' , true ) . '.00';
			break;
		case 'program' :
		    echo '<a href="' . get_edit_post_link(get_post_meta( $post_id, '_program-id', true)) . '">' . get_the_title(get_post_meta( $post_id, '_program-id', true)) .'</a>';
		    break;
	    }
	}

	// Add a menu item under expenses to create a pdf and csv of the expenses
	add_action('admin_menu' , 'create_custom_expense_menu');
	function create_custom_expense_menu() {
		// We are creating a page to export our expenses to a pdf or csv...Need to find the support for that. Below we will create some HTML to output on to the adminb screen. then well addin a custom query when they decide to filter.
		add_submenu_page('edit.php?post_type=expense', 'Export Expenses to PDF or CSV', 'Export to PDF or CSV', 'edit_posts', basename(__FILE__), 'create_expense_spreadsheets');
		function create_expense_spreadsheets(){ global $post ?>
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
						'post_type' => 'expense',
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
						echo '<thead><tr><th scope="col" class="manage-column">Expense ID</th><th class="manage-column">Amount</th><th class="manage-column">Program ID</th><th class="manage-column">Date</th></tr></thead>';
						echo '<tbody id="the-list">';
						while ( $the_query->have_posts() ) {
							$the_query->the_post();
							//print_r($post);
							echo '<tr><td>' . $post->ID . '</td><td>' . '$' . get_post_meta( $post->ID, '_expense-amount', true) . '</td><td>' . get_post_meta( $post->ID, '_program-id', true) . '</td><td>' . $post->post_date . '</td></tr>';
						};
						echo '</tbody>';
						echo '</table>';
					}
					else{
						// no posts found
					}

					/* Restore original Post Data */
					wp_reset_postdata();

				} ?>
				<br />
		<?php	if($_POST && $_POST['csv'] == 'CSV'){
					echo '<div class="button" id="download-csv">Download CSV</div>';
				}
				elseif($_POST && $_POST['pdf'] == 'PDF'){
					echo '<div class="button" id="download-pdf">Download PDF</div>';
				}
				else{

				} ?>
			</div>
<?php
			}
	}