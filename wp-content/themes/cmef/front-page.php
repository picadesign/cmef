<?php 
get_header(); 
?>
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<h1 class="box-shadow homepage"><?php echo $post->post_content ?></h1>
		<?php //the_content(); ?>
		<?php
			$args = array(
				'post_type'   => 'program',
				'posts_per_page' => 6
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
			<hr>
			<div class="bottom-buttons">
				<div href="" class="button gray show-more"><span>Show More</span></div>
				<a href="" class="button green"><span>Start a Program</span></a>
				<a href="" class="button gray back-to-top"><span>Back to Top</span></a>
			</div>
	<?php endwhile; ?>
	<?php endif; ?>
<?php get_footer(); ?>