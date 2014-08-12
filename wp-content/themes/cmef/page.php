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
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="row">
			<div class="sixteen columns alpha omega">
				<h2 class="title"><?php the_title(); ?></h2>
				<hr>
			</div>
		</div>
		<?php endwhile; ?>
		<?php endif; ?>
	</div>
<?php get_footer(); ?>