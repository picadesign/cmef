<?php get_header(); global $query_string;?>
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
				<h2 class="title"><?php $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); echo $term->name; ?></h2>
				<hr>
			</div>
		</div>
		<div class="row">
			<div class="twelve columns alpha">
				<?php query_posts($query_string . '&orderby=menu_order&order=ASC'); ?>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<?php 
					$pdfs = get_attached_media('application/pdf', $post->ID);
					// print_r($pdfs);
				?>
				<div class="twelve columns alpha omega resource">
					<a href="<?php the_permalink(); ?>"><h3 class="alignleft overflow resource-heading"><?php the_title(); ?></h3></a>
					<?php if(!empty($pdfs)): ?>
						<div class="pdfs">
							<h4>Download:</h4>
							<?php
								foreach ($pdfs as $pdf) { ?>
									<a href="<?php echo $pdf->guid ?>"><small><?php echo $pdf->post_title ?></small></a>
								<?php }
							?>
						</div>
					<?php endif; ?>
					<div class="twelve columns alpha omega">
						<?php the_excerpt(); ?>
						<hr>
					</div>
				</div>
				<?php endwhile; ?>
				<?php endif; ?>
			</div>
			<div class="four columns omega">
				<h3>Categories</h3>
				<hr>
				<?php 
				// no default values. using these as examples
				$taxonomies = array( 
				    'resource_type'
				);
				$terms = get_terms($taxonomies, $args);
				
				?>
				<?php if(!empty($terms)): ?>
					<ul class="terms">
						<?php foreach($terms as $term): ?>
							<li>
								<a href="<?php echo esc_html(get_term_link($term)); ?>"><h4><?php echo esc_html( $term->name ); ?></h4></a>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
		</div>
		<div class="row">
			<div class="sixteen columns alpha omega">
				<?php echo pagination(); ?>
			</div>
		</div>
		<?php wp_reset_postdata(); ?>
	</div>
<?php get_footer(); ?>