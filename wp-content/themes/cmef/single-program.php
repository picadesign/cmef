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
				<a href="<?php echo add_query_arg( 'program_id', get_the_ID(), get_the_permalink( 252 ) ); ?>" class="button orange alignright"><span>Donate to this program</span></a>
				<?php if($current_user->ID === get_the_author_meta('ID')){?><a href="" class="button green alignright button-margin"><span>Edit</span></a><?php } ?>
			</div>
		</div>
		<div class="row">
			<div class="eleven columns alpha"><h2>Program Name</h2></div>
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
				<div class="six columns alpha omega">
					<?php //THis needs work the images cannot span one columns because on small screens they blow up. ?>
					<?php the_post_thumbnail($size = 'medium', $attr = '') ?>
				</div>
				<div class="one columns alpha">
					<?php the_post_thumbnail($size = 'thumbnail', $attr = '') ?>
				</div>
				<div class="one columns">
					<?php the_post_thumbnail($size = 'thumbnail', $attr = '') ?>
				</div>
				<div class="one columns">
					<?php the_post_thumbnail($size = 'thumbnail', $attr = '') ?>
				</div>
				<div class="one columns">
					<?php the_post_thumbnail($size = 'thumbnail', $attr = '') ?>
				</div>
				<div class="one columns">
					<?php the_post_thumbnail($size = 'thumbnail', $attr = '') ?>
				</div>
				<div class="one columns omega">
					<?php the_post_thumbnail($size = 'thumbnail', $attr = '') ?>
				</div>
			</div>
			<div class="ten columns omega">
				<section>
				<div class="four columns alpha">Fundraising Progress</div>
				<div class="six columns omega">
					<div class="meter">

						<div class="meter-progress" style="width:<?php $goal = get_post_meta(get_the_ID(), '_fundraising-goal', true); $donation_total = program_donation_total($post->ID); echo ((int) $donation_total/(int) $goal)*100; ?>%;"></div>
					</div>
					<span class="alignleft raised-amount">Raised <b><?php echo money_format('%.0n', $donation_total) . "\n"; ?></b></span><span class="alignright goal-amount">Goal <b><?php echo money_format('%.0n', $goal) . "\n"; ?></b></span>
				</div>
				</section>
				<div class="ten columns alpha omega">
					<section>
					<table width="100%">
						<tr>
							<td class="four columns alpha"><b>Type of Program</b></td>
							<td class="five columns alignleft"><?php echo get_post_meta($post->ID, '_program-type', true ) ?></td>
						</tr>
						<tr>
							<td class="four columns alpha"><b>TFA Region</b></td>
							<td class="five columns alignleft"><?php echo get_post_meta($post->ID, '_tfa-region', true ) ?></td>
						</tr>
						<tr>
							<td class="four columns alpha"><b>School</b></td>
							<td class="five columns alignleft"><?php echo get_post_meta($post->ID, '_school-name', true ) ?></td>
						</tr>
						<tr>
							<td class="four columns alpha"><b>Grade Level</b></td>
							<td class="five columns alignleft"><?php echo get_post_meta($post->ID, '_grade-level', true ) ?></td>
						</tr>
						<tr>
							<td class="four columns alpha"><b>Number of Students</b></td>
							<td class="five columns alignleft"><?php echo get_post_meta($post->ID, '_number-students', true ) ?></td>
						</tr>
					</table>
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
			<hr>
		</div>
		<div class="row">
			<div class="eight columns alpha">
				<h3>Description</h3>
				<p>
					<?php the_content(); ?>
				</p>
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