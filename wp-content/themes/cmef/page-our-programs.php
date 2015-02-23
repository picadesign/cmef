<?php get_header(); global $query_string, $wp_query;?>
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
		<?php
			$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$query = parse_url($actual_link, PHP_URL_QUERY);
			$vars = array();
			parse_str($query, $vars);
		?>
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<div class="row">
					<div class="sixteen columns alpha omega"><h2><?php the_title(); ?></h2></div>
					<div class="clear"></div>
					<hr>
				</div>
			
				<div class="form row">
					<div class="sixteen columns alpha omega">
						<form action="<?php the_permalink() ?>">
							<div class="fourteen columns alpha"><input type="text" placeholder="Search" name="s" value=<?php echo $vars['s'] ?>></div>
							<?php 
								if(strpos($actual_link, 'order=ASC') !== false){
									$order = 'DESC';
								}
								elseif(strpos($actual_link, 'order=ASC') == false){
									$order = 'ASC';
								}
								else{
									$order = 'ASC';
								}
							?>
							<div class="two columns omega">
								<div class="button green alignright"><span>Search</span></div>
							</div>
							<div class="clear"></div>
							<div class="two columns alpha filter-by"><h3>Filter by:</h3></div>
							<div class="two columns">
								<a href="<?php echo add_query_arg( array('orderby'=>'meta_value', 'meta_key'=>'_tfa-region', 'order'=> $order), $post->permalink ); ?>">
									<div class="button gray full-width filter regions">
											<span>Regions</span>	
									</div>
								</a>
							</div>
							<div class="two columns">
								<a href="<?php echo add_query_arg( array('orderby'=>'title', 'order'=> $order), $post->permalink ); ?>">
									<div class="button gray full-width filter name">
											<span>Name</span>	
									</div>
								</a>
							</div>
							<div class="two columns">
								<a href="<?php echo add_query_arg( array('orderby'=>'meta_value', 'meta_key'=>'_fundraising-goal', 'order'=> $order), $post->permalink ); ?>">
									<div class="button gray full-width filter goal">
											<span>Goal</span>	
									</div>
								</a>
							</div>
							<div class="two columns omega">
								<a href="<?php echo add_query_arg( array('orderby'=>'date', 'order'=> $order), $post->permalink ); ?>">
									<div class="button gray full-width filter date">
											<span>Date</span>	
									</div>
								</a>
							</div>
						</form>
					</div>
				</div>
			</div>
			<?php endwhile; ?>
		<?php endif; ?>

	<?php
	

	$args = array(
		'post_type'   => 'program',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'post__not_in' => array(947),
	);
	$search_query = array_merge($args, $vars);
	$the_query = new WP_Query( $search_query ); ?>

	<?php // The Loop
	if ( $the_query->have_posts() ) : ?>
		<div class="container-twelve masonry projects">
		 <?php while ( $the_query->have_posts() ) : ?>
			<?php $the_query->the_post(); ?>
			<?php if($post->post_type == 'program'): ?>
				<?php include('inc/partials/project-card.php'); ?>
			<?php endif; ?>
		<?php endwhile; ?>
		</div>
	<?php else :; ?>
		<h2 align="center">No Programs Found</h2>
	<?php endif; ?>
	<?php wp_reset_postdata(); ?>

	<div class="clear"></div>
	<hr>
	<div class="bottom-buttons">
		<a href="" class="button green"><span>Add New Program</span></a>
	</div>
<?php get_footer(); ?>