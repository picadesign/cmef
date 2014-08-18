<?php get_header(); ?>
	<div class="white-background page box-shadow">
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
					<div class="sixteen columns alpha omega"><h2><?php the_title(); ?></h2></div>
					<div class="clear"></div>
					<hr>
				</div>
			<?php endwhile; ?>
		<?php endif; ?>
		<div class="form row">
			
		</div>
	</div>

	<?php
	$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$query = parse_url($actual_link, PHP_URL_QUERY);
	$vars = array();
	parse_str($query, $vars);
	print_r($vars);
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