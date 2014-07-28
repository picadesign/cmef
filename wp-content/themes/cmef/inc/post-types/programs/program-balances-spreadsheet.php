<?php  
	function create_program_balances_menu() { 
		add_submenu_page('edit.php?post_type=program', 'Program Balances', 'Program Balances', 'edit_posts', basename(__FILE__), 'program_balances_spreadsheet');
		function program_balances_spreadsheet(){  global $post;
			 /* Run Some Query's. Store the query var in a array for we can run the query multiple times. */


	        /* Generate the HTML. */ ?>
	        <div class="container full margin-right">
	            <h1>Program Balances</h1>
	            <br><br>
	            <?php
	                //WP Query Arguments
	                $args = array(
	                    'post_type' => 'program',
	                    'posts_per_page' => -1,
	                );
	               	//print_r($args);
	                /* Run the query. */
                $the_query = new WP_Query( $args ); ?>
                <?php
	                if ( $the_query->have_posts()): ?>
	                <?php
	                /**
	                * WRITE THE TABLE TO A CSV FILE
	                */
	               	$writer = new \EasyCSV\Writer(ABSPATH . 'temp_csv_files/program_balances.csv');
                    $writer->writeRow('program_id, carry_over, revenues, expenses, balance, program_name, active (y/n), date_established, CM_name, CM_email_address');
                    $reader = new \EasyCSV\Reader(ABSPATH . 'temp_csv_files/program_balances.csv');
	                ?>
	                <div class="button" id="download-program-balances-csv">Download CSV</div>
	                <br /><br />
	                <table class="wp-list-table widefat fixed posts">
									<thead>
										<tr>
											<th class="manage-column">Program ID</th>
											<th class="manage-column">Carry Over</th>
											<th class="manage-column">Revenues</th>
											<th class="manage-column">Expenses</th>
											<th class="manage-column">Balance</th>
											<th class="manage-column">Program Name</th>
											<th class="manage-column">Active?</th>
											<th class="manage-column">Date Extablished</th>
											<th class="manage-column">CM Name</th>
											<th class="manage-column">CM Email Address</th>
										</tr>
									</thead> <tbody><?php 
	                	while ( $the_query->have_posts() ) :
	                        $the_query->the_post(); ?>
							<?php
								/**
								 * We Need to do some math in here
								 */
								$temp_post = $post; 
								$transaction_args = array(
				                    'post_type' => array(
				                    	'donation',
				                    	'expense'
				                    ),
				                    'meta_query' => array(
				                    	array(
				                    		'key' => '_program-id',
				                    		'value' => $temp_post->ID
				                    	)
				                    ),
				                    'posts_per_page' => -1,
				                    'date_query' => array(
				                        'after' => array(
				                            'year' => date('Y')-1,
				                            'month'=> 12,
				                            'day' => 31,
				                        ),
				                        'before' => array(
				                            'year' => date('Y')+1,
				                            'month'=> 01,
				                            'day' => 01,
				                        )
				                    )
				                );

				                $transactions = new WP_Query( $transaction_args );
				                if($transactions->have_posts()){
				                	$donations = 0;
				                	$expenses = 0;
				                	$balance = 0;
				                	while($transactions->have_posts()){
				                		$transactions->the_post();
				                		//echo $post->ID;
				                		if($post->post_type === 'donation'){
				                			$donations += (int) get_post_meta($post->ID, '_contribution-amount', true);
				                			$balance += (int) get_post_meta($post->ID, '_contribution-amount', true);;
				                		}
				                		elseif($post->post_type === 'expense'){
				                			$expenses += (int) get_post_meta($post->ID, '_expense-amount', true);
				                			$balance -= (int) get_post_meta($post->ID, '_expense-amount', true);
				                		}


				                	}
				                }
				                 $post = $temp_post; 
							?>
							<tr>
								<td><?php echo $post->ID ?></td>
								<td>Carry Over</td>
								<td><?php echo money_format('$%i', $donations) ?></td>
								<td><?php echo money_format('$(%i)', $expenses) ?></td>
								<td><?php echo money_format('$%i', $balance) ?></td>
								<td><?php echo $post->post_title ?></td>
								<td>?</td>
								<td><?php echo $post->post_date ?></td>
								<td><?php echo get_the_author() ?></td>
								<td><?php echo antispambot(get_the_author_meta('user_email', $post->post_author)); ?></td>
							</tr>
							<?php
								$row = $post->ID . ',';
								$row .= 'Carry Over' . ',';
								$row .= $donations . ',';
								$row .= $expenses . ',';
								$row .= $balance . ',';
								$row .= $post->post_title . ',';
								$row .= 'Active?' . ',';
								$row .= $post->post_date . ',';
								$row .= get_the_author() . ',';
								$row .= get_the_author_meta('user_email', $post->post_author) . ',';
                        		$writer->writeRow($row);
							?>
	                    <?php endwhile;
	                    echo '</tbody></table>';    
	                else:;
	                	echo 'Sorry CMEF doesn\'t have any projects to report.';
	                endif;

                ?>
         	</div> 
        <?php }
	}
	add_action('admin_menu' , 'create_program_balances_menu');