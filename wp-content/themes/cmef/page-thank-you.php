<?php get_header(); ?>
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
		<?php if (have_posts()) : while (have_posts()) : the_post(); 
			$program = get_post(htmlspecialchars($_GET['program_id']));
			$amount = htmlspecialchars($_GET['amount'])
		?>
		<div class="row">
			<div class="sixteen columns alpha omega">
				<h2 class="title"><?php the_title(); ?></h2>
				<hr>
			</div>
		</div>
		<div class="row">
			<div class="sixteen columns content alpha omega">
				<p>Thank you for your <strong><?php echo money_format('%(10n', $amount); ?></strong> donation to CMEF's <strong><? echo $program->post_title; ?></strong> Program. CMEF’s mission is to empower educators to provide life-changing experiences in and outside the classroom.</p>
				<?php the_content(); ?>
			</div>
		</div>
		<?php endwhile; ?>
		<?php endif; ?>
	</div>
<?php get_footer(); ?>