<?php get_header(); ?>
	<div class="white-background page box-shadow container-twelve">
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
				<a href="" class="button green alignright button-margin"><span>Edit Profile</span></a>
			</div>
		</div>
		<div class="row">
			<div class="sixteen columns alpha omega"><h2><?php the_author(); ?></h2></div>
			<div class="clear"></div>
			<hr>
			<div class="five columns alpha profile-image">
				<img src="http://placekitten.com/g/274/238" alt="">
			</div>
			<div class="eleven columns omega">Started 5 Projects • Joined May 2014</div>
			<div class="eleven columns omega"><h3>Profile Description</h3></div>
			<div class="eleven columns omega"><?php the_author_meta('description') ?></div>
		</div>
	<?php endwhile; ?>
	<?php endif; ?>
	</div>
	<?php
	$args = array(
		'post_type'   => 'program',
		'posts_per_page' => -1
	);
	$the_query = new WP_Query( $args ); ?>
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
		<a href="" class="button green"><span>Add New Program</span></a>
	</div>
<?php get_footer(); ?>