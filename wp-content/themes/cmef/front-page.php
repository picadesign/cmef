<?php 
get_header(); 
?>
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<h1 class="box-shadow homepage"><?php echo $post->post_content ?></h1>
		<?php //the_content(); ?>
		<?php
			$args = array(
				'post_type'   => 'program',
				'post_status' => 'publish',
				'posts_per_page' => 6,
				'post__not_in' => array(664),
				'meta_query' => array(
					'relation' => 'AND',
					array(
						'key' => '_thumbnail_id',
						'compare' => 'EXISTS'
					),
					array(
						'relation' => 'OR',
						array(
							'key' => '_program-status',
							'value' => 'open',
							'compare' => '='
						),
						//This part should be phased out when programs get populated.
						array(
							'key' => '_program-status',
							'compare' => 'NOT EXISTS'
						)
					)
				)
			);
			$the_query = new WP_Query( $args ); ?>
			<?php // The Loop
			if ( $the_query->have_posts() ) : ?>
				<div class="container-sixteen masonry projects">
				 <?php while ( $the_query->have_posts() ) : ?>
					<?php $the_query->the_post(); ?>
					<?php include('inc/partials/project-card.php'); ?>
				<?php endwhile; ?>
				</div>
			<?php else :; ?>
				// no posts found  
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>
			<div></div>			
			<hr>
			<div class="bottom-buttons">
				<div href="" class="button gray show-more"><span>Show More</span></div>
				<a href="<?php echo get_the_permalink(201) ?>" class="button green"><span>Start a Program</span></a>
				<a href="" class="button gray back-to-top"><span>Back to Top</span></a>
			</div>
	<?php endwhile; ?>
	<?php endif; ?>
<?php get_footer(); ?>