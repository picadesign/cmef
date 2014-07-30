<?php get_header(); ?>
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<h1><?php the_title(); ?></h1>
		<?php //the_content(); ?>
		<div class="container-twelve masonry projects">
			<div class="project four columns alpha omega">column 1</div>
			<div class="project four columns alpha omega">column 2 <br>column</div>
			<div class="project four columns alpha omega">column 3</div>
			<div class="project four columns alpha omega">column 1</div>
			<div class="project four columns alpha omega">column 2 </div>
			<div class="project four columns alpha omega">column 3</div>
		</div>
	<?php endwhile; ?>
	<?php endif; ?>
<?php get_footer(); ?>