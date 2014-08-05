<?php get_header(); ?>
	<div class="white-background page program box-shadow">
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
			<div class="eight columns alpha">&nbsp;</div>
			<div class="eight columns omega">
				<a href="<?php echo add_query_arg( 'program_id', get_the_ID(), get_the_permalink( 252 ) ); ?>" class="button green alignright"><span>Donate to this program</span></a>
				<a href="" class="button green alignright button-margin"><span>Edit</span></a>
			</div>
		</div>
		<div class="row">
			<div class="eleven columns alpha"><h2>Program Name</h2></div>
			<div class="five columns omega">
				<span class="alignleft">Share this Program:</span>
				<div class="social alignright">
					<ul>
						<li class="mail"></li>
						<li class="google"></li>
						<li class="twitter"></li>
						<li class="facebook"></li>
					</ul>
				</div>
			</div>
			<div class="sixteen columns alpha omega"><hr></div>
		</div>
		<div class="row">
			<div class="six columns alpha gallery">
				<div class="six columns alpha omega">
					<?php //THis needs work the images cannot span one columns because on small screens they blow up. ?>
					<?php the_post_thumbnail($size = 'medium', $attr = '') ?>
				</div>
				<div class="one columns alpha">
					<?php the_post_thumbnail($size = 'thumbnail', $attr = '') ?>
				</div>
				<div class="one columns">
					<?php the_post_thumbnail($size = 'thumbnail', $attr = '') ?>
				</div>
				<div class="one columns">
					<?php the_post_thumbnail($size = 'thumbnail', $attr = '') ?>
				</div>
				<div class="one columns">
					<?php the_post_thumbnail($size = 'thumbnail', $attr = '') ?>
				</div>
				<div class="one columns">
					<?php the_post_thumbnail($size = 'thumbnail', $attr = '') ?>
				</div>
				<div class="one columns omega">
					<?php the_post_thumbnail($size = 'thumbnail', $attr = '') ?>
				</div>
			</div>
			<div class="ten columns omega">
				<section>
				<div class="four columns alpha">Fundraising Progress</div>
				<div class="six columns omega">
					<div class="meter">
						<div class="meter-progress" style="width:<?php $goal = get_post_meta(get_the_ID(), '_fundraising-goal', true); echo (47523/(int) $goal)*100; ?>%;"></div>
					</div>
					<span class="alignleft raised-amount">Raised <b><?php echo money_format('%.0n', 15000) . "\n"; ?></b></span><span class="alignright goal-amount">Goal <b><?php echo money_format('%.0n', $goal) . "\n"; ?></b></span>
				</div>
				</section>
				<div class="ten columns alpha omega">
					<section>
					<table width="100%">
						<tr>
							<td class="four columns alpha"><b>Type of Program</b></td>
							<td class="five columns alignleft">Field Trip</td>
						</tr>
						<tr>
							<td class="four columns alpha"><b>TFA Region</b></td>
							<td class="five columns alignleft">Rio Grande Valley</td>
						</tr>
						<tr>
							<td class="four columns alpha"><b>School</b></td>
							<td class="five columns alignleft"> Medomak Valley Highs School</td>
						</tr>
						<tr>
							<td class="four columns alpha"><b>Grade Level</b></td>
							<td class="five columns alignleft">9th</td>
						</tr>
						<tr>
							<td class="four columns alpha"><b>Number of Students</b></td>
							<td class="five columns alignleft">120</td>
						</tr>
					</table>
					</section>
					<section>
					<h3>Key Contact</h3>
					<table width="100%">
						<tr>
							<td><?php the_author_posts_link(); ?></td>
							<td><a href="mailto:<?php echo antispambot(the_author_meta('user_email'), $mailto = 0) ?>"><?php echo antispambot(the_author_meta('user_email'), $mailto = 0) ?></a></td>
							<td>207-123-4567</td>
						</tr>
					</table>
					</section>
				</div>
			</div>
			<div class="clear"></div>
			<br>
			<hr>
		</div>
		<div class="row">
			<div class="eight columns alpha">
				<h3>Description</h3>
				<p>
					<?php the_content(); ?>
				</p>
			</div>
			<div class="eight columns omega">
				<h3>Fundraising Activity</h3>
				<table width="100%">
					<thead>
						<tr>
							<td><b>Name</b></td>
							<td><b>Email</b></td>
							<td><b>Phone Number</b></td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>02/12/2014</td>
							<td>Jason Walker</td>
							<td>$40.00</td>
						</tr>
						<tr>
							<td>02/12/2014</td>
							<td>Jason Walker</td>
							<td>$40.00</td>
						</tr>
						<tr>
							<td>02/12/2014</td>
							<td>Jason Walker</td>
							<td>$40.00</td>
						</tr>
						<tr>
							<td>02/12/2014</td>
							<td>Jason Walker</td>
							<td>$40.00</td>
						</tr>
						<tr>
							<td>02/12/2014</td>
							<td>Jason Walker</td>
							<td>$40.00</td>
						</tr>
						<tr>
							<td>02/12/2014</td>
							<td>Jason Walker</td>
							<td>$40.00</td>
						</tr>
						<tr>
							<td>02/12/2014</td>
							<td>Jason Walker</td>
							<td>$40.00</td>
						</tr>
						<tr>
							<td>02/12/2014</td>
							<td>Jason Walker</td>
							<td>$40.00</td>
						</tr>
						<tr>
							<td>02/12/2014</td>
							<td>Jason Walker</td>
							<td>$40.00</td>
						</tr>
						<tr>
							<td>02/12/2014</td>
							<td>Jason Walker</td>
							<td>$40.00</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
			
		<?php endwhile; ?>
		<?php endif; ?>
	</div>
<?php get_footer(); ?>