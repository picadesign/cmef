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
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="row">
			<div class="sixteen columns alpha omega">
				<h2 class="title"><?php the_title(); ?></h2>
				<hr>
			</div>
		</div>
		<div class="row">
			<div class="sixteen columns alpha omega">
				<div class="eight columns alpha">
					<?php the_content(); ?>
				</div>
				<div class="eight columns omega">
					<form action="">
						<div class="eight columns alpha">
							<input type="text" name="email" placeholder="Email Address">
							<div class="button submit green alignright"><span>Submit</span></div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="row not-approved hidden">
			<div class="sixteen columns alpha omega">
				You have not been approved by the admin
			</div>
		</div>
		<div class="row approved hidden">
			<div class="sixteen columns alpha omega">
				Approved and Sending Email Hide this (show when approveod user)
			</div>
		</div>
		<?php endwhile; ?>
		<?php endif; ?>
	</div>
<?php get_footer(); ?>