<?php 
get_header(); 
setlocale(LC_MONETARY, 'en_US');
?>
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<h1><?php the_title(); ?></h1>
		<?php //the_content(); ?>
		<?php
			$args = array(
				'post_type'   => 'program',
			);
			
			$the_query = new WP_Query( $args );
			//print_r($the_query);
			// Create the dropdown usgint he data we gathered above. We will store the program id so we can use if for later.
			//if ( $the_query->have_posts() ) :?>
			<?php // The Loop
			if ( $the_query->have_posts() ) : ?>
				<div class="container-twelve masonry projects">
				 <?php while ( $the_query->have_posts() ) : ?>
					<?php $the_query->the_post(); ?>
					<div class="four columns alpha omega project-card">
						<?php the_post_thumbnail($size = 'post-thumbnail', $attr = ''); ?>
						<div class="description">
							<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<span class="author-name">Started By: <?php the_author(); ?></span>
							<p><?php echo substr(get_the_excerpt(), 0,175); ?>... <a href="">MORE</a></p>
							<div class="meter">
								<div class="meter-progress" style="width:<?php $goal = get_post_meta(get_the_ID(), '_fundraising-goal', true); echo (47523/(int) $goal)*100; ?>%;"></div>
							</div>
							<span class="alignRight raised-amount">Raised <?php echo money_format('%n', 15000) . "\n"; ?></span><span class="alignLeft goal-amount">Goal: <?php echo money_format('%n', $goal) . "\n"; ?></span>
							<a href="" class="button donate orange"><span>Donate Now</span></a>
							<hr>
							
							<div class="social">
								<span class="share">Share:</span>
								<ul>
									<li class="twitter"><a href="<?php echo get_post_meta($post->ID, '_social-networks', true)['twitter'] ?>" target="_blank"></a></li>
									<li class="facebook"><a href="<?php echo get_post_meta($post->ID, '_social-networks', true)['facebook'] ?>" target="_blank"></a></li>
									<li class="google"><a href="<?php echo get_post_meta($post->ID, '_social-networks', true)['google'] ?>" target="_blank"></a></li>
								</ul>
							</div>
						</div>
					</div>
				<?php endwhile; ?>
				</div>
			<?php else :; ?>
				// no posts found
			<?php endif; ?>
			
			<?php wp_reset_postdata(); ?>			
		
			<hr>
			
			
				
			
		
	<?php endwhile; ?>
	<?php endif; ?>
<?php get_footer(); ?>