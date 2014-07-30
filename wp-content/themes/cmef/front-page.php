<?php get_header(); ?>
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<h1><?php the_title(); ?></h1>
		<?php //the_content(); ?>
		<div class="container-twelve masonry projects">
			<div class="four columns alpha omega project-card">
				<img src="http://placekitten.com/g/300/350" alt="">
				<div class="description">
				<h2>This is the Title</h2>
				<span class="author-name">Started By: Jay O'Toole</span>
				<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
				<meter value="0.6">60%</meter>
				<span class="alignRight raised-amount">Raised $15k</span><span class="alignLeft goal-amount">Goal: $50K</span>
				<a href="" class="button donate">Donate Now</a>
				<hr>
				<span class="share">Share:</span>
				<ul>
					<li class="twitter"></li>
					<li class="facebook"></li>
					<li class="google"></li>
				</ul>
			</div>
			</div>
			<div class="four columns alpha omega project-card">
				<img src="http://placekitten.com/g/300/200" alt="">
				<div class="description">
				<h2>This is the Title</h2>
				<span class="author-name">Started By: Jay O'Toole</span>
				<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
				Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
				<meter value="0.6">60%</meter>
				<span class="alignRight raised-amount">Raised $15k</span><span class="alignLeft goal-amount">Goal: $50K</span>
				<a href="" class="button donate">Donate Now</a>
				<hr>
				<span class="share">Share:</span>
				<ul>
					<li class="twitter"></li>
					<li class="facebook"></li>
					<li class="google"></li>
				</ul>
			</div>
			</div>
			<div class="four columns alpha omega project-card">
				<img src="http://placekitten.com/g/300/150" alt="">
				<div class="description">
				<h2>This is the Title</h2>
				<span class="author-name">Started By: Jay O'Toole</span>
				<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
				<meter value="0.6">60%</meter>
				<span class="alignRight raised-amount">Raised $15k</span><span class="alignLeft goal-amount">Goal: $50K</span>
				<a href="" class="button donate">Donate Now</a>
				<hr>
				<span class="share">Share:</span>
				<ul>
					<li class="twitter"></li>
					<li class="facebook"></li>
					<li class="google"></li>
				</ul>
			</div>
			</div>
			<div class="four columns alpha omega project-card">
				<img src="http://placekitten.com/g/300/300" alt="">
				<div class="description">
				<h2>This is the Title</h2>
				<span class="author-name">Started By: Jay O'Toole</span>
				<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
				<meter value="0.6">60%</meter>
				<span class="alignRight raised-amount">Raised $15k</span><span class="alignLeft goal-amount">Goal: $50K</span>
				<a href="" class="button donate">Donate Now</a>
				<hr>
				<span class="share">Share:</span>
				<ul>
					<li class="twitter"></li>
					<li class="facebook"></li>
					<li class="google"></li>
				</ul>
			</div>
			</div>
			<div class="four columns alpha omega project-card">
				<img src="http://placekitten.com/g/300/225" alt="">
				<div class="description">
				<h2>This is the Title</h2>
				<span class="author-name">Started By: Jay O'Toole</span>
				<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
				Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.<</p>
				<meter value="0.6">60%</meter>
				<span class="alignRight raised-amount">Raised $15k</span><span class="alignLeft goal-amount">Goal: $50K</span>
				<a href="" class="button donate">Donate Now</a>
				<hr>
				<span class="share">Share:</span>
				<ul>
					<li class="twitter"></li>
					<li class="facebook"></li>
					<li class="google"></li>
				</ul>
			</div>
			</div>
			<div class="four columns alpha omega project-card">
				<img src="http://placekitten.com/g/300/175" alt="">
				<div class="description">
				<h2>This is the Title</h2>
				<span class="author-name">Started By: Jay O'Toole</span>
				<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
				Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.<</p>
				<meter value="0.6">60%</meter>
				<span class="alignRight raised-amount">Raised $15k</span><span class="alignLeft goal-amount">Goal: $50K</span>
				<a href="" class="button donate">Donate Now</a>
				<hr>
				<span class="share">Share:</span>
				<ul>
					<li class="twitter"></li>
					<li class="facebook"></li>
					<li class="google"></li>
				</ul>
			</div>
			</div>
		</div>
	<?php endwhile; ?>
	<?php endif; ?>
<?php get_footer(); ?>