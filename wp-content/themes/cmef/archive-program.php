<?php get_header();?>
	<div class="white-background page box-shadow donate">
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
		
	</div>
	<?php if (have_posts()) : ?>
		<div class="container-sixteen masonry projects">
			<?php while ( have_posts() ) : ?>
				<?php the_post(); ?>
				<?php include('inc/partials/project-card.php'); ?>
			<?php endwhile; ?>
		</div>
	<?php endif; ?>
<?php get_footer(); ?>