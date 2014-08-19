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
						<li class="google"><a href=""></a></li>
						<li class="twitter"><a href=""></a></li>
						<li class="facebook"><a href=""></a></li>
					</ul>
				</div>
			</div>
			<div class="sixteen columns alpha omega"><hr></div>
		</div>
		<div class="row">
			<div class="six columns alpha gallery">
				<div class="six columns alpha omega slideshow">
					<?php //THis needs work the images cannot span one columns because on small screens they blow up. ?>
					<?php the_post_thumbnail($size = 'Project Slideshow', $attr = '') ?>
					<?php 	
						/**
						* The WordPress Query class.
						* @link http://codex.wordpress.org/Function_Reference/WP_Query
						*
						*/
						$args = array(
							//Post & Page Parameters
							'post_parent'  => $post->ID,
							'post_type'   => 'attachment',
							'post_status' => 'inherit',
							'post__not_in' => array(get_post_thumbnail_id( $post->ID )),
							'orderby' => 'menu_order',
							'order' => 'ASC'
						);
						$the_query = new WP_Query( $args );
						if ( $the_query->have_posts() ) :
							while ( $the_query->have_posts() ) :
								$the_query->the_post();
								 echo wp_get_attachment_image( $post->ID, $size = 'Project Slideshow', true, array('data-large' => $post->guid, 'data-lightbox' => 'slideshow' ));
							endwhile;
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
								<td class="four columns alpha"><b>School</b></td>
								<td class="five columns alignleft school-name"><?php echo get_post_meta($post->ID, '_school-name', true ) ?></td>
								<td class="five columns alignleft school-name-sel hidden"><input type="text" value="<?php echo get_post_meta($post->ID, '_school-name', true ) ?>"></td>
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
							<div class="button green image-uploader-choose-file"><span>Choose File</span></div>
						</div>
						<div class="eight columns omega uploaded-images">
							
						</div>
						<div class="sixteen columns alpha omega">
							<br>
							<b>Hint:</b>
							<p>Click on one of your uploaded images to make it your program's cover image.</p>
						</div>
					</div>
				</form>
				<hr>
			</div>
			<?php endif; ?>
		</div>
		<div class="row">
			<div class="sixteen columns alpha omega">
				<hr>
			</div>
			<?php if($current_user->ID === get_the_author_meta('ID') && is_user_logged_in()): ?>
			<div class="sixteen columns alpha omega">
				<div class="button green alignleft"><span>Download Activity</span></div>
			</div>
			<?php endif; ?>
			<div class="eight columns alpha">
				<h3>Description</h3>
				<div class="description">
					<?php the_content(); ?>
				</div>
			</div>
			<div class="eight columns omega">
				<h3>Fundraising Activity</h3>
				<table width="100%">
					<thead>
						<tr>
							<td><b>Name</b></td>
							<td><b>Email</b></td>
							<td><b>Amount</b></td>
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
						
							$donation_query = new WP_Query( $args );
							if($donation_query->have_posts()):
								while($donation_query->have_posts()): $donation_query->the_post(); ?>
									<?php if(get_post_meta($post->ID, '_remain-anonymous', true) === 'true') :?>
									<?php else: ?>
									<tr>
										<td><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?></td>
										<td><a id="donation-email">email@email.com</a></td>
										<td><?php echo money_format('%.0n', get_post_meta($post->ID, '_contribution-amount', true )) . "\n"; ?></td>
									</tr>
									<?php endif; ?>
								<?php endwhile;
							endif;
							wp_reset_postdata();
						?>
					</tbody>
				</table>
			</div>
		</div>	
		<?php endwhile; ?>
		<?php endif; ?>
	</div>
<?php get_footer(); ?>