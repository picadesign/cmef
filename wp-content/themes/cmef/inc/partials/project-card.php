<div class="project-card">
	<?php if(!is_search()){ ?>
		<?php if(has_post_thumbnail($post->ID)): ?>
			<?php // NOTE: Originally we were going to set a max height on the images but it was causing all kinds of issues with the layout and the images were getting squished. ?>
			<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail($size = 'Project Card', $attr = ''); ?></a>
		<?php else : ?>
			<a href="<?php the_permalink(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/placeholder.png" alt=""></a>
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
		<h2>
			<a href="<?php the_permalink(); ?>">
				<?php //if length of post title > 30
				if(strlen($post->post_title) > 30) {
					//shorten to 30 chars, add ... 
					echo substr(the_title($before = '', $after = '', FALSE), 0,30) . '...'; 
				} else { 
					the_title(); 
				} ?>
			</a>
		</h2>
		<span class="author-name">Started By: <?php the_author(); ?></span>
		<p><?php echo substr(get_the_excerpt(), 0,175); ?>... <a href="<?php the_permalink(); ?>">MORE</a></p>
		<div class="meter">
			<div class="meter-progress" style="width:<?php echo ($raised/(int) get_post_meta(get_the_ID(), '_fundraising-goal', true))*100; ?>%;"></div>
		</div>
		<span class="alignRight raised-amount">Raised <b><?php echo money_format('%.0n', $raised) . "\n"; ?></b></span><span class="alignLeft goal-amount">Goal <b><?php echo money_format('%.0n', get_post_meta($post->ID, '_fundraising-goal', true)) . "\n"; ?></b></span>
		<?php if(get_post_meta($post->ID, '_program-status', true) == 'ended'): ?>
			<span class="button red alignright ended full-width"><span>Program Ended</span></span>
		<?php else: ?>
			<a href="<?php echo add_query_arg( 'program_id', get_the_ID(), get_the_permalink( 252 ) ); ?>" class="button donate orange"><span>Donate Now</span></a>
		<?php endif; ?>
		<div class="social">
			<span class="share">Share</span>
			<ul>
				<li class="twitter"><a href="http://www.twitter.com/share/?url=<?php echo the_permalink(); ?>" target="_blank"></a></li>
				<li class="linkedin"><a href="https://www.linkedin.com/cws/share?url=<?php echo the_permalink(); ?>" target="_blank"></a></li>
				<li class="facebook"><a href="http://www.facebook.com/sharer.php?u=<?php echo the_permalink(); ?>" target="_blank"></a></li>
				<li class="google"><a href="http://plus.google.com/share?url=<?php echo the_permalink(); ?>" target="_blank"></a></li>
			</ul>
		</div>
	
	</div>
</div>