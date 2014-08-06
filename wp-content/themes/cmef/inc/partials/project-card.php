<div class="project-card">
	<?php if(!is_search()){ ?>
	<?php if(has_post_thumbnail($post->ID)): ?>
		<?php the_post_thumbnail($size = 'post-thumbnail', $attr = ''); ?>
	<?php else : ?>
		<img src="<?php echo get_template_directory_uri(); ?>/images/placeholder.png" alt="">
	<?php endif; ?>
	<?php } ?>
	<div class="description">
		<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<span class="author-name">Started By: <?php the_author(); ?></span>
		<p><?php echo substr(get_the_excerpt(), 0,175); ?>... <a href="">MORE</a></p>
		<div class="meter">
			<div class="meter-progress" style="width:<?php $goal = get_post_meta(get_the_ID(), '_fundraising-goal', true); echo (47523/(int) $goal)*100; ?>%;"></div>
		</div>
		<span class="alignRight raised-amount">Raised <b><?php echo money_format('%.0n', 15000) . "\n"; ?></b></span><span class="alignLeft goal-amount">Goal <b><?php echo money_format('%.0n', $goal) . "\n"; ?></b></span>
		<a href="<?php echo add_query_arg( 'program_id', get_the_ID(), get_the_permalink( 252 ) ); ?>" class="button donate orange"><span>Donate Now</span></a>
		<hr>
		
		<div class="social">
			<span class="share">Share</span>
			<ul>
				<li class="twitter"><a href="<?php echo get_post_meta($post->ID, '_social-networks', true)['twitter'] ?>" target="_blank"></a></li>
				<li class="linkedin"><a href="<?php echo get_post_meta($post->ID, '_social-networks', true)['linkedin'] ?>" target="_blank"></a></li>
				<li class="facebook"><a href="<?php echo get_post_meta($post->ID, '_social-networks', true)['facebook'] ?>" target="_blank"></a></li>
				<li class="google"><a href="<?php echo get_post_meta($post->ID, '_social-networks', true)['google'] ?>" target="_blank"></a></li>
			</ul>
		</div>
	</div>
</div>