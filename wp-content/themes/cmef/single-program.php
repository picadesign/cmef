<?php get_header(); ?>
	<div class="white-background page program box-shadow">
		<div class="row">
			<div class="sixteen columns alpha omega">
				<div class="breadcrumbs">
				    <?php if(function_exists('bcn_display'))
				    {
				        bcn_display();
				    }?>
				</div>
			</div>
		</div>
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<div class="row">
			<div class="eight columns alpha">&nbsp;</div>
			<div class="eight columns omega">

				<a href="<?php /* Create the url but pass in an argument for the right program EXTREMELY IMPORTANT */ echo add_query_arg( 'program_id', get_the_ID(), get_the_permalink( 252 ) ); ?>" class="button orange alignright"><span>Donate to this program</span></a>
				<?php if($current_user->ID === get_the_author_meta('ID') && is_user_logged_in()){?><div href="" class="button green alignright button-margin edit-program"><span>Edit</span></div><?php } ?>
			</div>
		</div>
		<div class="row">
			<div class="eleven columns alpha"><h2><?php the_title(); ?></h2></div>
			<div class="five columns omega">
				<span class="alignleft">Share this Program:</span>
				<div class="social alignright">
					<ul>
						<li class="mail"><a href=""></a></li>
						<li class="google"><a href="https://plus.google.com/share?url=http%3A%2F%2F<?php echo urlencode(the_permalink());  ?>" target="_blank"></a></li>
						<li class="twitter"><a href="http://twitter.com/share?url=<?php echo urlencode(the_permalink());  ?>" target="_blank"></a></li>
						<li class="facebook"><a href="http://www.facebook.com/sharer.php?u=<?php echo urlencode(the_permalink());  ?>" target="_blank"></a></li>
					</ul>
				</div>
			</div>
			<div class="sixteen columns alpha omega"><hr></div>
		</div>
		<div class="row">
			<div class="six columns alpha gallery">
				<div class="six columns alpha omega slideshow hidden">
					<?php //THis needs work the images cannot span one columns because on small screens they blow up. ?>
					<?php if(has_post_thumbnail($post->ID)): ?>
						<a href="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large' )[0] ?>" data-lightbox="slideshow"><img src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'Project Slideshow' )[0]; ?>"/></a>
					<?php endif; ?>
					<?php 	
						/**
						* The WordPress Query class.
						* @link http://codex.wordpress.org/Function_Reference/WP_Query
						*
						*/
						$image_args = array(
							//Post & Page Parameters
							'post_parent'  => $post->ID,
							'post_type'   => 'attachment',
							'post_status' => 'inherit',
							'post__not_in' => array(get_post_thumbnail_id( $post->ID )),
							'orderby' => 'menu_order',
							'order' => 'ASC',
							'number_posts' => -1
						);
						$image_query = new WP_Query( $image_args );
						if ( $image_query->have_posts() ) :
							while ( $image_query->have_posts() ) :
								$image_query->the_post();?>
								 <a href="<?php echo wp_get_attachment_image_src($post->ID, 'large')[0] ?>" data-lightbox="slideshow"><?php echo wp_get_attachment_image( $post->ID, $size = 'Project Slideshow', true, array('data-large' => $post->guid, 'data-lightbox' => 'slideshow')); ?></a>
							<?php endwhile;
						endif;
						wp_reset_postdata();
					 ?>
				</div>
				<div id="adv-custom-pager" class="six columns alpha omega center external"></div>
			</div>
			<div class="ten columns omega">
				<section>
				<div class="four columns alpha"><h3>Fundraising Progress</h3></div>
				<div class="six columns omega">
					<div class="meter">

						<div class="meter-progress" style="width:<?php $goal = get_post_meta(get_the_ID(), '_fundraising-goal', true); $donation_total = program_donation_total($post->ID); echo ((int) $donation_total/(int) $goal)*100; ?>%;"></div>
					</div>
					<span class="alignleft raised-amount">Raised <b><?php echo money_format('%.0n', $donation_total) . "\n"; ?></b></span><span class="alignright goal-amount">Goal <b><?php echo money_format('%.0n', $goal) . "\n"; ?></b></span>
				</div>
				</section>
				<div class="ten columns alpha omega">
					<section>
					<form>
						<input type="hidden" name="post_id" value="<?php echo $post->ID ?>">
						<table width="100%" class="meta-data">
							<tr>
								<td class="four columns alpha"><b>Type of Program</b></td>
								<?php
									//list terms in a given taxonomy
									$taxonomy = 'program-type';
									$term_args = array(
									  'hide_empty' => false,
									  'orderby' => 'name',
									  'order' => 'ASC'
									);

									$tax_terms = get_terms($taxonomy,$term_args);
									$post_terms = wp_get_post_terms( $post->ID, $taxonomy);
								?>
								<td class="five columns alignleft program-type"><?php echo $post_terms[0]->name?></td> 
								<td class="five columns alignleft program-type-sel hidden">
									<?php if($current_user->ID === get_the_author_meta('ID') && is_user_logged_in()): ?>
										<div class="select">
											<?php //print_r($terms[0]->name) ?>
											<select id="<?php echo $taxonomy ?>">
												<?php
													foreach ($tax_terms as $tax_term) { ?>
														<option value="<?php echo $tax_term->name ?>" data-term-id="<?php echo $tax_term->term_id ?>" <?php selected( $tax_term->name, $post_terms[0]->name); ?>><?php echo $tax_term->name ?></option>
													<?php }
												?>
											</select>
										</div>
									<?php endif; ?>
								</td>
							</tr>
							<tr>
								<td class="four columns alpha"><b>TFA Region</b></td>
								<?php
									//list terms in a given taxonomy
									$taxonomy = 'tfa-region';
									$term_args = array(
									  'hide_empty' => false,
									  'orderby' => 'name',
									  'order' => 'ASC'
									);

									$tax_terms = get_terms($taxonomy,$term_args);
									$post_terms = wp_get_post_terms( $post->ID, $taxonomy);
								?>
								<td class="five columns alignleft tfa-region"><?php echo $post_terms[0]->name ?></td>
								<td class="five columns alignleft tfa-region-sel hidden">
									<?php if($current_user->ID === get_the_author_meta('ID') && is_user_logged_in()): ?>
										<div class="select">
											<?php //print_r($terms[0]->name) ?>
											<select id="<?php echo $taxonomy ?>">
												<?php
													foreach ($tax_terms as $tax_term) { ?>
														<option value="<?php echo $tax_term->name ?>" data-term-id="<?php echo $tax_term->term_id ?>" <?php selected( $tax_term->name, $post_terms[0]->name); ?>><?php echo $tax_term->name ?></option>
													<?php }
												?>
											</select>
										</div>
									<?php endif; ?>
								</td>
							</tr>
							<tr>
								<td class="four columns alpha"><b>Organization Name</b></td>
								<td class="five columns alignleft organization-name"><?php echo get_post_meta($post->ID, '_organization-name', true ) ?></td>
								<td class="five columns alignleft organization-name-sel hidden"><input type="text" value="<?php echo get_post_meta($post->ID, '_organization-name', true ) ?>"></td>
							</tr>
							<tr>
								<td class="four columns alpha"><b>Grade Level</b></td>
								<?php
									//list terms in a given taxonomy
									$taxonomy = 'grade-level';
									$term_args = array(
									  'hide_empty' => false,
									  'orderby' => 'name',
									  'order' => 'ASC'
									);
									
									$tax_terms = get_terms($taxonomy,$term_args);
									$post_terms = wp_get_post_terms( $post->ID, $taxonomy);
								?>
								<td class="five columns alignleft grade-level"><?php echo $post_terms[0]->name ?></td>
								<td class="five columns alignleft grade-level-sel hidden">
									<?php if($current_user->ID === get_the_author_meta('ID') && is_user_logged_in()): ?>
										<div class="select">
											<?php //print_r($terms[0]->name) ?>
											<select id="<?php echo $taxonomy ?>">
												<?php
													foreach ($tax_terms as $tax_term) { ?>
														<option value="<?php echo $tax_term->name ?>" data-term-id="<?php echo $tax_term->term_id ?>" <?php selected( $tax_term->name, $post_terms[0]->name); ?>><?php echo $tax_term->name ?></option>
													<?php }
												?>
											</select>
										</div>
									<?php endif; ?>
								</td>
							</tr>
							<tr>
								<td class="four columns alpha"><b>Number of Students</b></td>
								<td class="five columns alignleft number-students"><?php echo get_post_meta($post->ID, '_number-students', true ) ?></td>
								<td class="five columns alignleft number-students-sel hidden"><input type="number" value="<?php echo get_post_meta($post->ID, '_number-students', true ) ?>" min="0"></td>
							</tr>
							<tr class="goal-sel-row hidden">
								<td class="four columns alpha"><b>Goal</b></td>
								<td class="five columns alignleft goal-sel"><input type="number" value="<?php echo get_post_meta(get_the_ID(), '_fundraising-goal', true) ?>"></td>
							</tr>
						</table>
					</form>
					</section>
					<section>
					<h3>Key Contact</h3>
					<table width="100%">
						<tr>
							<td><?php the_author_posts_link(); ?></td>
							<td><a href="mailto:<?php echo antispambot(the_author_meta('user_email'), $mailto = 0) ?>"><?php echo antispambot(the_author_meta('user_email'), $mailto = 0) ?></a></td>
							<td>207-123-4567</td>
						</tr>
					</table>
					</section>
				</div>
			</div>
			<div class="clear"></div>
			<br>
			<?php if($current_user->ID === get_the_author_meta('ID') && is_user_logged_in()): ?>
			<div class="sixteen columns alpha omega hidden photo-uploader-container">
				<hr>
				<br>
				<h3>Upload Your Photos</h3>
				<form class="" action="<?php echo get_bloginfo('url') . '/wp-admin/admin-ajax.php?&action=upload_image' ?>" id="photo_upload" id="image_uploader" data-program-id="<?php echo $post->ID ?>" enctype="multipart/form-data">
					<div class="sixteen columns alpha omega">
						<div class="eight columns alpha">
							<!--<img src="" alt="">-->
							
							<input type="file" name="image" class="image-uploader">
							<input type="text" placeholder="Choose File" class="image-uploader-placeholder" disabled="disabled">
							<div class="button green image-uploader-button alignleft"><span class="button-text">Upload</span></div>
							<div class="button green image-uploader-choose-file"><span>Choose Image</span></div>
						</div>
						<div class="eight columns omega uploaded-images">
							<?php if(has_post_thumbnail($post->ID)): ?>
								<div class="image-container"><div class="delete-image">&#x2716;</div><img src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail')[0]; ?> " class="uploaded-image" data-image-id="<?php echo get_post_thumbnail_id() ?>"></div>
							<?php endif; ?>
							<?php
								$image_query = new WP_Query( $image_args );
								if ( $image_query->have_posts() ) :
									while ( $image_query->have_posts() ) :
										$image_query->the_post(); ?>
										 <?php //print_r($post) ?>
										 <div class="image-container"><div class="delete-image">&#x2716;</div><img src="<?php echo wp_get_attachment_image_src( $post->ID, 'thumbnail')[0]; ?> " class="uploaded-image" data-image-id="<?php echo $post->ID ?>"></div>
									<?php endwhile;
								endif;
								wp_reset_postdata();
							?>
						</div>
						<div class="sixteen columns alpha omega">
							<br>
							<b>Hint:</b>
							<p>Refresh to see your new images.</p>
							<p>Click on one of your uploaded images to make it your program's cover image.</p>
						</div>
					</div>
				</form>
				<hr>
			</div>
			<?php endif; ?>
		</div>
		<div class="row hidden" id="tabs">
			<div class="sixteen columns alpha omega">
				<ul>
					<li><h3><a href="#description">Description</a></h3></li>
					<li><h3><a href="#activity">Fundraising Activity</a></h3></li>
					<?php if($current_user->ID === get_the_author_meta('ID') && is_user_logged_in()): ?>
						<li><h3><a href="#expenses">Expense Tracker</a></h3></li>
						<li><h3><a href="#balance">Account Balance</a></h3></li>
					<?php endif; ?>
				</ul>
			</div>
			<div class="sixteen columns alpha omega" id="description">
				<div class="description">
					<?php the_content(); ?>
				</div>
			</div>
			<div class="sixteen columns alpha omega" id="activity">
				<table width="100%" id="donation-table" class="tablesorter">
					<thead>
						<tr>
							<th><b>Name</b></th>
							<th><b>Date</b></th>
							<th><b>Amount</b></th>
						</tr>
					</thead>
					<tbody>
						<?php
							/**
							 * The WordPress Query class.
							 * @link http://codex.wordpress.org/Function_Reference/WP_Query
							 *
							 */
							$args = array(
								'post_type'   => 'donation',
								//Custom Field Parameters
								'meta_key'       => '_program-id',
								'meta_value'     => $post->ID,
								'posts_per_page' => -1
								
							);
							$program_author = $post->post_author;
							$donation_query = new WP_Query( $args );
							if($donation_query->have_posts()):
								$i = 1;
								while($donation_query->have_posts()): $donation_query->the_post(); ?>
									<tr class="<?php echo ($i%2 == 0 ? 'even' : 'odd') ?>">
									<?php if(get_post_meta($post->ID, '_remain-anonymous', true) === 'true') :?>
										<td>Anonymous</td>
									<?php elseif(is_user_logged_in() && $current_user->ID == $program_author): ?>
										<td id="donation"><?php echo get_post_meta($post->ID, '_donor-name', true )['first'] ?> <?php echo get_post_meta($post->ID, '_donor-name', true )['last'] ?><a href="mailto:<?php echo antispambot('email@email.com') ?>" title="Send a Thank You to "><span class="mail small"></span></a></td>
									<?php else: ?>
										<td id="donation"><?php echo get_post_meta($post->ID, '_donor-name', true )['first'] ?> <?php echo get_post_meta($post->ID, '_donor-name', true )['last'] ?></td>
									<?php endif; ?>
										<td><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?></td>
										<td><?php echo money_format('%.0n', get_post_meta($post->ID, '_contribution-amount', true )) . "\n"; ?></td>
									</tr>
								<?php endwhile;
							else:
								echo '<tr><td colspan="3">No Fundraising Activity</td></tr>';
							endif;
							wp_reset_postdata();
						?>
					</tbody>
				</table>
			</div>
			<?php if($current_user->ID === get_the_author_meta('ID') && is_user_logged_in()): ?>
				<div class="sixteen columns alpha omega" id="expenses">
					<table id="expense-table" class="tablesorter">
						<thead>
							<tr>
								<th class="dont-sort">Actions</th>
								<th>Expense ID</th>
								<th>Date</th>
								<th>Amount</th>
								<th>Memo</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$expense_args = array(
									'post_type' => 'expense',
									'meta_key'       => '_program-id',
									'meta_value'     => $post->ID,
									'orderby'        => 'date',
									'posts_per_page' => -1,
								);
								$expense_query = new WP_Query( $expense_args );
								if ( $expense_query->have_posts() ) :
									while ( $expense_query->have_posts() ) :
										$expense_query->the_post(); ?>
										 <tr>
										 	<td><small><?php if(has_post_thumbnail()): ?><a href="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'large')[0] ?>" data-lightbox="receipts" data-title="<?php the_content() ?>">View Receipt</a><?php endif; ?><!--<div class="delete-expense action-item" data-expense-id="<?php echo $post->ID ?>">Delete</div>--></small></td>
											<td><?php echo $post->ID ?></td>
											<td><?php echo get_the_date(); ?></td>
											<td><?php echo money_format('-%.0n', (int) get_post_meta( $post->ID, '_expense-amount', true)) . "\n"; ?></td>
											<td><?php the_content(); ?></td>
										</tr>
									<?php endwhile;
								endif;
								wp_reset_postdata();
							?>
							

						</tbody>
					</table>
					<br>
					<div class="button green print alignleft"><span>Print</span></div>
					<div class="button green alignright add-expense"><span>Add Expense</span></div>
					<div class="sixteen columns alpha omega new-expense hidden">
						<hr>
						<h3>New Expense</h3>
						<br>
						<div class="eight columns alpha omega alert-messages">
						
						</div>
						<div class="clear"></div>
						<p>Please ensure accuracy to the best of your ability.</p>
						<form class="" action="<?php echo get_bloginfo('url') . '/wp-admin/admin-ajax.php?&action=upload_expense_image' ?>" id="expense_photo_upload" data-program-id="<?php echo $post->ID ?>" enctype="multipart/form-data">
							<div class="nine columns alpha">
								<h4>Description</h4>
								<div class="memo-container">
									<div class="memo"></div>
								</div>
								<br>
								<div class="two columns alpha"><input type="number" placeholder="Amount" name="expense-amount"></div>
								<div class="clear"></div>
							</div>
							<div class="seven columns omega">
								<h4>Upload Receipt</h4>
								<input type="file" class="hidden" name="expense-image">
								<input type="text" name="expense-image-name" disabled="disabled" placeholder="Select Image">
								<div class="button green choose-expense-image alignleft"><span>Upload Receipt</span></div>
							</div>
						</form>
						<div class="button green submit-expense alignright"><span>Add Expense</span></div>
						<div class="button green closediv alignright button-margin"><span>Close</span></div>
					</div>
				</div>
				<div class="sixteen columns alpha omega" id="balance">
					<?php
							$loop_args = array(
								'post_type'   => array('expense', 'donation'),
								//Custom Field Parameters
								'meta_key'       => '_program-id',
								'meta_value'     => $post->ID,
								'posts_per_page' => -1,
								'orderby' => 'date',
								'order' => 'DESC'
							);

							$transactions = new WP_Query( $loop_args );
							if($transactions->have_posts()):
								$balance = 0;
								//print_r($transactions);
								foreach($transactions->posts as $transaction):
									//print_r($transaction);
									if($transaction->post_type == 'donation'):
										$balance += (int) get_post_meta( $transaction->ID, '_contribution-amount', true);
										//print_r($balance);
									elseif ($transaction->post_type == 'expense') :
										$balance -= (int) get_post_meta( $transaction->ID, '_expense-amount', true);
										//print_r($balance);
									endif;
								endforeach;
							endif;
							//wp_reset_postdata();
							
						?>
					<table>

						<thead>
							<tr>
								<th>Transaction ID</th>
								<th>Date</th>
								<th>Description</th>
								<th>Debit (Expense)</th>
								<th>Check (Donation)</th>
								<th>Balance</th>
							</tr>
						</thead>
						
						<tbody>
							<?php 
							$balance_query = new WP_Query( $loop_args );
								if ( $balance_query->have_posts() ) :
									//$i = 0;
									while ( $balance_query->have_posts() ) :
										$program_id = $post->ID;
										$balance_query->the_post(); ?>
										<tr>
											<td><?php the_ID(); ?></td>
											<td><?php echo get_the_date(); ?></td>
											<td><?php the_content(); ?></td>
											<td><?php if(get_post_meta( $post->ID, '_expense-amount', true) > 0){ ?><?php echo money_format('-%.0n', (int) get_post_meta( $post->ID, '_expense-amount', true)) . "\n"; }?></td>
											<td><?php if(get_post_meta( $post->ID, '_contribution-amount', true) > 0){ ?><?php echo money_format('%.0n', get_post_meta($post->ID, '_contribution-amount', true )) . "\n"; }?></td>
											
											<td><?php echo money_format('%.0n', $balance) . "\n";?></td>
											<?php 
												//reverse
												if($post->post_type == 'donation'){
													$balance -= (int) get_post_meta( $post->ID, '_contribution-amount', true);
												}
												elseif($post->post_type == 'expense'){
													$balance += (int) get_post_meta( $post->ID, '_expense-amount', true);
												}
											?>
										</tr>
									<?php endwhile;
								endif;
								wp_reset_postdata();
							?>
						</tbody>
					</table>
					<br>
					<div class="button green print"><span>Print</span></div>
				</div>
			<?php endif; ?>
		</div>	
		<?php endwhile; ?>
		<?php endif; ?>
	</div>
<?php get_footer(); ?>