<?php
/*
Template Name: Search Page
*/
?>
<?php get_header() ?>
	<div class="white-background page box-shadow search">
		<?php
		global $query_string, $wp_query;

		$query_args = explode("&", $query_string);
		$search_query = array();

		foreach($query_args as $key => $string) {
			$query_split = explode("=", $string);
			$search_query[$query_split[0]] = urldecode($query_split[1]);
		} // foreach

		$search = new WP_Query($search_query);
		?>
		<div class="row">
			<p>You searched for '<b><?php echo $search_query['s'] ?></b>'. Your search returned <b><?php echo $wp_query->found_posts; ?></b> results.</p>
			<br>
		</div>
		<?php // The Loop
		if ( $search->have_posts() ) : ?>
			<div class="row">
			 <?php while ( $search->have_posts() ) : ?>
				<?php $search->the_post(); ?>
				<div class="sixteen columns alpha omega">
					<a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>
					<?php the_excerpt(); ?>
					<hr>
				</div>
			<?php endwhile; ?>
			</div>
		<?php else :; ?>
			
		<?php endif; ?>
		<div class="row">
			<div class="sixteen columns alpha omega">
				<?php echo pagination(); ?>
			</div>
		</div>
		<?php wp_reset_postdata(); ?>	
	</div>
<?php get_footer(); ?>