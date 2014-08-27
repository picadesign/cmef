<?php get_header();?>
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
		<div class="row">
			<div class="sixteen columns alpha omega">
				<h2 class="title">Resources</h2>
				<hr>
			</div>
		</div>
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="row">
			<div class="sixteen columns alpha omega">
				<a href="<?php the_permalink(); ?>"><h3 class="alignleft overflow"><?php the_title(); ?></h3></a>
				<div class="stars" data-resource-id="<?php the_ID(); ?>">
					<div class="one star"></div>
					<div class="two star"></div>
					<div class="three star"></div>
					<div class="four star"></div>
					<div class="five star"></div>
				</div>
			</div>
			<div class="sixteen columns alpha omega">
				<?php the_content(); ?>
			</div>
		</div>
		<?php endwhile; ?>
		<?php endif; ?>
		<div class="row">
			<div class="sixteen columns alpha omega">
				<?php echo pagination(); ?>
			</div>
		</div>
		<?php wp_reset_postdata(); ?>
	</div>
<?php get_footer(); ?>