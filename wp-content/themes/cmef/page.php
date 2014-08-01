<?php get_header(); ?>
	<div class="white-background page box-shadow container-sixteen">
		<div class="breadcrumbs">
		    <?php if(function_exists('bcn_display'))
		    {
		        bcn_display();
		    }?>
		</div>
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
			<h2 class="title"><?php the_title(); ?></h2>
			<div class="two-thirds column content border-right alpha omega">
				<?php the_content(); ?>
			</div>
			<div class="one-third column omega sidebar">
				<ul>
					<li>Page</li>
					<li>Page</li>
					<li>Page</li>
					<li>Page</li>
					<li>Page</li>
					<li>Page</li>
					<li>Page</li>
					<li>Page</li>
					<li>Page</li>
					<li>Page</li>
				</ul>
			</div>
		<?php endwhile; ?>
		<?php endif; ?>
	</div>
<?php get_footer(); ?>