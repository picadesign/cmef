<?php 
function create_custom_program_menu() {
    /**
     * We are creating a page to export our donations to a csv...Need to find the support for that.
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
	                	<input type="text" class="datepicker" name="start-date" value="<?php echo $_POST['start-date'] ?>" required="required">
	                </td>
	                <td>
	                	<label for="end-date">Ending Date:</label>
	                </td>
	                <td>
	                	<input type="text" class="datepicker" name="end-date" value="<?php echo $_POST['end-date'] ?>" required="required">
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