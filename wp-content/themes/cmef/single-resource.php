<?php get_header();?>
	<div class="white-background page box-shadow">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
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
				<h2 class="title"><?php the_title() ?></h2>
				<hr>
			</div>
		</div>
		
		<div class="row">
			<div class="twelve columns alpha">
				<?php the_content(); ?>
			</div>
			<div class="four columns omega">
				<h3>Documents</h3>
				<ul class="documents">
				    <?php
				        $args = array(
					          'post_type' => 'attachment',
					          'post_mime_type' => 'application/pdf,application/msword',
					          'numberposts' => -1,
					          'post_status' => null,
					          'post_parent' => $post->ID,
					          'orderby' => 'menu_order',
					          'order' => 'desc'
				          );
				        $attachments = get_posts($args);
				        if ($attachments) {
				          foreach ($attachments as $attachment) {
				          	if($attachment->post_mime_type == 'application/pdf'): ?>
					            <li class="pdf">
					            	<div class="pdf icon"></div>
					            	<a href="<?php echo $attachment->guid ?>"><?php echo $attachment->post_title ?></a>
					            </li>
				            <?php endif;
				          }
				        }
				    ?>
			    </ul>
			</div>
		</div>
		<?php endwhile; ?>
		<?php endif; ?>
	</div>
<?php get_footer(); ?>