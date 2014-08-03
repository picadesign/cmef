<?php get_header(); ?>
	<div class="white-background page program box-shadow container-twelve">
		<div class="breadcrumbs twelve columns alpha omega">
		    <?php if(function_exists('bcn_display'))
		    {
		        bcn_display();
		    }?>
		</div>
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div class="four offset-by-eight columns alpha omega">
					<a href="" class="button green alignright"><span class="donate-button">Donate to this program</span></a>
				<?php if(is_user_logged_in()) : ?>
					<a class="button green alignright button-margin"><span>Edit</span></a>
				<?php endif; ?>
			</div>
			<h2 class="title eight columns alpha"><?php the_title(); ?></h2>
			<div class="four columns omega">
				<span class="caps">Share this Project:</span>
				<div class="alignright social">
					<ul>
						<li class="mail"><a href=""></a></li>
						<li class="google"><a href=""></a></li>
						<li class="twitter"><a href=""></a></li>
						<li class="facebook"><a href=""></a></li>
					</ul>
				</div>
			</div>
			<div class="clear"></div>
			<hr>
			<div class="four columns alpha program-image">
				<div class="thumbnail"><?php the_post_thumbnail( $size="medium", $attr ); ?></div>
				<div class="clear"></div>
				<div class="twelve columns alpha omega thumbnails">
					<a href=""><img src="http://placekitten.com/g/66/66" alt=""></a>
					<a href=""><img src="http://placekitten.com/g/66/66" alt=""></a>
					<a href=""><img src="http://placekitten.com/g/66/66" alt=""></a>
					<a href=""><img src="http://placekitten.com/g/66/66" alt=""></a>
					<a href=""><img src="http://placekitten.com/g/66/66" alt=""></a>
					<a href=""><img src="http://placekitten.com/g/66/66" alt=""></a>
					<a href=""><img src="http://placekitten.com/g/66/66" alt=""></a>
					<div class="twelve columns alpha omega"><a href="">View All Images</a></div>
				</div>
			</div>
			<div class="eight columns quick-stats omega">
				<div class="twelve columns omega alpha">
					<div class="five columns alpha">
					<span class="caps">Fundraising Progress:</span>
					</div>
					<div class="seven columns omega">
					<div class="meter">
						<div class="meter-progress" style="width:<?php $goal = get_post_meta(get_the_ID(), '_fundraising-goal', true); echo (47523/(int) $goal)*100; ?>%;"></div>
						</div>
					</div>
				</div>
				<div class="clear"></div>
				<div class="twelve columns omega alpha row">
					<table>
						<tr>
							<td>Type of Program:</td>
							<td>Field Trip</td>
						</tr>
						<tr>
							<td>TFA Region:</td>
							<td>Rio Grande Valley</td>
						</tr>
						<tr>
							<td>Fundraising Goal:</td>
							<td>$50,0000</td>
						</tr>
						<tr>
							<td>School:</td>
							<td>Medomak Valley</td>
						</tr>
						<tr>
							<td>Grade Level:</td>
							<td>9-10</td>
						</tr>
						<tr>
							<td>Number of Students:</td>
							<td>120</td>
						</tr>
					</table>
				</div>
				<div class="clear"></div>
				<div class="twelve columns alpha omega row">
					<hr>
					<table>
						<thead>
							<tr>
								<td><b>Name</b></td>
								<td><b>Email</b></td>
								<td><b>Phone Number</b></td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Somebody Special</td>
								<td>somebody@email.com</td>
								<td>207-564-4556</td>
							</tr>
							<tr>
								<td>Somebody Special</td>
								<td>somebody@email.com</td>
								<td>207-564-4556</td>
							</tr>
							<tr>
								<td>Somebody Special</td>
								<td>somebody@email.com</td>
								<td>207-564-4556</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="clear"></div>
			<hr>
			<div class="six columns alpha">
				<h2>Description</h2>
				<?php the_content(); ?>
			</div>
			<div class="six columns omega fundraising-activity">
				<h2>Fundraising Activity Snapshot</h2>
				<table>
					<tr>
						<td>Date</td>
						<td>Donor</td>
						<td>Donation Amount</td>
					</tr>
					<tr>
						<td>02/15/2014</td>
						<td>Jason Walker</td>
						<td>$40.00</td>
					</tr>
					<tr>
						<td>02/15/2014</td>
						<td>Jason Walker</td>
						<td>$40.00</td>
					</tr>
					<tr>
						<td>02/15/2014</td>
						<td>Jason Walker</td>
						<td>$40.00</td>
					</tr>
					<tr>
						<td>02/15/2014</td>
						<td>Jason Walker</td>
						<td>$40.00</td>
					</tr>
					<tr>
						<td>02/15/2014</td>
						<td>Jason Walker</td>
						<td>$40.00</td>
					</tr>
					<tr>
						<td>02/15/2014</td>
						<td>Jason Walker</td>
						<td>$40.00</td>
					</tr>
					<tr>
						<td>02/15/2014</td>
						<td>Jason Walker</td>
						<td>$40.00</td>
					</tr>
					<tr>
						<td>02/15/2014</td>
						<td>Jason Walker</td>
						<td>$40.00</td>
					</tr>
					<tr>
						<td>02/15/2014</td>
						<td>Jason Walker</td>
						<td>$40.00</td>
					</tr>
				</table>
			</div>
		<?php endwhile; ?>
		<?php endif; ?>
	</div>
<?php get_footer(); ?>