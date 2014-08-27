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
			<div class="sixteen columns alpha omega">
				<form action="">
					<div class="fourteen columns alpha"><input type="text" placeholder="Search" name="search"></div>
					
					<div class="two columns omega">
						<div class="button green alignright"><span>Search</span></div>
					</div>
					<div class="clear"></div>
					<div class="two columns alpha filter-by"><b>Filter by:</b></div>
					<div class="two columns"><div class="button gray full-width filter"><span>Filter</span></div></div>
					<div class="two columns"><div class="button gray full-width filter"><span>Status</span></div></div>
					<div class="two columns"><div class="button gray full-width filter"><span>Regions</span></div></div>
					<div class="two columns"><div class="button gray full-width filter"><span>Name</span></div></div>
					<div class="two columns"><div class="button gray full-width filter"><span>Goal</span></div></div>
					<div class="two columns omega"><div class="button gray full-width filter"><span>Date</span></div></div>
				</form>
			</div>
		</div>
	</div>

	<?php
	$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$query = parse_url($actual_link, PHP_URL_QUERY);
	$vars = array();
	parse_str($query, $vars);
	print_r(the_search_query());
	$args = array(
		'post_type'   => 'program',
		'posts_per_page' => -1,
		's' => $vars['search']
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