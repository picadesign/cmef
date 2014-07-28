<?php get_header(); ?>
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<h1><?php the_title(); ?></h1>
		<?php //the_content(); ?>
		<h2>H2 Heading</h2>
		<h3>H3 Heading</h3>
		<b>Bold</b><i>Italic</i>
		<p>Paragraph text. Donec sed odio dui. Cras justo odio, dapibus ac facilisis in. Egestas eget quam. Maecenas faucibus mollis interdum maecenas faucibus. Cras mattis consectetur purus sit amet.</p>
		<a href="">Like Style</a>
		<ul>
			<li>Unordered List</li>
			<li>Unordered List</li>
		</ul>

		<ol>
			<li>Ordered List</li>
			<li>Ordered List</li>
		</ol>

	<?php endwhile; ?>
	<?php endif; ?>
<?php get_footer(); ?>