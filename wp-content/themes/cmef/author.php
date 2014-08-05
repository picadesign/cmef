<?php get_header(); the_post(); global $current_user; $author_meta = get_user_meta(get_the_author_meta('ID'));?>
	<div class="white-background page box-shadow">
		<?php
		$args = array(
			'post_type'   => 'program',
			'posts_per_page' => -1,
			'author' => get_the_author_meta('ID')
		);
		$the_query = new WP_Query( $args ); ?>
		<div class="row author-information">
			<div class="five columns alpha profile-image">
				<div class="image-box">
				<?php echo get_avatar( get_the_author_meta('ID'), 271); ?> 
				</div>
				<div class="one-third alignleft new-avatar">
					<?php echo do_shortcode('[avatar_upload]' ); ?>
				</div> 
			</div>
			<section>
				<div class="eight columns profile-name">
					<h2><?php the_author(); ?></h2>
				</div>
				<div class="three columns omega edit">
					<?php if($current_user->ID === get_the_author_meta('ID')): ?>
						<input type="hidden" id="author_ID" value="<?php the_author_meta('ID') ?>">
						<div href="" class="button no-margin green alignright button-margin edit">
							<span>Edit Profile</span>
						</div>
						<div href="" class="button no-margin green alignright button-margin save">
							<span>Save Profile</span>
						</div>
					<?php endif; ?>
				</div>
				<div class="eleven columns omega quick-stats">
					Started <?php echo $the_query->post_count; ?> Projects • Joined <?php echo date("F Y", strtotime(get_userdata(get_current_user_id( ))->user_registered)); ?>
				</div>
			</section>
			<section>
				<div class="eleven columns omega description">
					<h3>Profile Description</h3>
				</div>
				<div class="eleven columns omega description-content">
					<div id="redactor"><?php the_author_meta('description') ?></div>
				</div>
			</section>
			<?php 
			/**
			 * Below only get output when they are the author and they are logged in.
			 */
			?>
			<?php if($current_user->ID === get_the_author_meta('ID')): ?>
			<div class="sixteen columns alpha omega">
				<div class="edit-author-meta-information">
					<hr>
					<h2>Edit Profile</h2>
					<form action="" autocomplete="off">
						<div class="eight columns alpha">
							<section>
							<h3>Name</h3>
							<input type="text" name="first_name" value="<?php the_author_meta('first_name') ?>" placeholder="First Name" required="required" autocomplete="off">
							<input type="text" name="last_name" value="<?php the_author_meta('last_name') ?>" placeholder="Last Name" required="required" autocomplete="off">
							</section>
							<section>
							<h3>Email</h3>
							<input type="text" name="email_address" value="<?php the_author_meta('user_email') ?>" placeholder="Email Address" required="required" autocomplete="off">
							</section>
							<section>
							<h3>Phone Number</h3>
							<input type="phone" name="phone_number" value="<?php the_author_meta('phone') ?>" placeholder="Phone Number" required="required" autocomplete="off">
							</section>
						</div>
						<div class="eight columns omega">
							<section>
							<h3>Change Password</h3>
							<input type="password" name="old_password" placeholder="Old Password" autocomplete="off">
							<input type="password" name="new_password" placeholder="New Password" autocomplete="off">
							<input type="password" name="conf_new_password" placeholder="Confirm New Password" autocomplete="off">
							<div class="eight columns alpha omega password-matching"></div>
							</section>
						</div>
					</form>
				</div>
			</div>
			<?php endif; ?>
		</div>
	</div>
	
	<?php // The Loop
	if ( $the_query->have_posts() ) : ?>
		<div class="container-twelve masonry projects">
		 <?php while ( $the_query->have_posts() ) : ?>
			<?php $the_query->the_post(); ?>
			<?php include('inc/partials/project-card.php'); ?>
		<?php endwhile; ?>
		</div>
	<?php else :; ?>
		// no posts found
	<?php endif; ?>
	<?php wp_reset_postdata(); ?>
	<div class="clear"></div>
	<hr>
	<div class="bottom-buttons">
		<a href="<?php echo get_the_permalink( 201 ) ?>" class="button green"><span>Add New Program</span></a>
	</div>
<?php get_footer(); ?>