<?php
/*
Template Name: Search Page
*/
?>
<?php get_header() ?>
	<div class="white-background page box-shadow search">
		<?php
		global $query_string;

		$query_args = explode("&", $query_string);
		$search_query = array();

		foreach($query_args as $key => $string) {
			$query_split = explode("=", $string);
			$search_query[$query_split[0]] = urldecode($query_split[1]);
		} // foreach

		$search = new WP_Query($search_query);
		?>
		</div>
		<?php // The Loop
		if ( $search->have_posts() ) : ?>
			<div class="container-sixteen masonry projects">
			 <?php while ( $search->have_posts() ) : ?>
				<?php $search->the_post(); ?>
				<?php include('inc/partials/project-card.php'); ?>
			<?php endwhile; ?>
			</div>
		<?php else :; ?>
			// no posts found
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>	
	
<?php get_footer(); ?>