<div class="project-card">
	<?php if(!is_search()){ ?>
		<?php if(has_post_thumbnail($post->ID)): ?>
			<?php // NOTE: Originally we were going to set a max height on the images but it was causing all kinds of issues with the layout and the images were getting squished. ?>
			<?php the_post_thumbnail($size = 'Project Card', $attr = ''); ?>
		<?php else : ?>
			<img src="<?php echo get_template_directory_uri(); ?>/images/placeholder.png" alt="">
		<?php endif; ?>
	<?php } ?>
	<?php
		// Query For Program donations
		$args = array(
			'post_type' => 'donation',
			'post_status' =>'publish',
			'posts_per_page' => -1,
			'meta_key'       => '_program-id',
			'meta_value'     => $post->ID,
		);
		$donations = new WP_Query($args);
	
		// The Loop
		if($donations->have_posts()):
			$raised = 0;
			foreach ($donations->posts as $donation) {
				$raised += (int) get_post_meta($donation->ID, '_contribution-amount', true);
			}
		else:
			$raised = 0;
		endif;
	?>
	<div class="description">
		<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<span class="author-name">Started By: <?php the_author(); ?></span>
		<p><?php echo substr(get_the_excerpt(), 0,175); ?>... <a href="<?php the_permalink(); ?>">MORE</a></p>
		<div class="meter">
			<div class="meter-progress" style="width:<?php echo ($raised/(int) get_post_meta(get_the_ID(), '_fundraising-goal', true))*100; ?>%;"></div>
		</div>
		<span class="alignRight raised-amount">Raised <b><?php echo money_format('%.0n', $raised) . "\n"; ?></b></span><span class="alignLeft goal-amount">Goal <b><?php echo money_format('%.0n', get_post_meta($post->ID, '_fundraising-goal', true)) . "\n"; ?></b></span>
		<a href="<?php echo add_query_arg( 'program_id', get_the_ID(), get_the_permalink( 252 ) ); ?>" class="button donate orange"><span>Donate Now</span></a>
	</div>
</div>