<section class="home-hero">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h1>Hello World</h1>
			</div>
		</div>
	</div>
</section>
<section class="gray-dark industries">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h1>Hello World</h1>
			</div>
		</div>
	</div>
</section>
<section class="customers">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h1>Hello World</h1>
			</div>
		</div>
	</div>
</section>
<section class="clouds articles">	
	<div class="container">
		<div class="row">
			<div class="col-sm-4">
				<ul>
				<?php
				$isfirst = false;
				$featuredPosts = new WP_Query();
				$featuredPosts->query('showposts=4');
				while ($featuredPosts->have_posts()) : $featuredPosts->the_post(); ?>
				<?php if ( ! $isfirst ): ?>
				<li class="homefirstpost">
					<img src="<?php echo Roots\Sage\Extras\custom_feature_image('full', 360, 200); ?>" class="img-responsive">
					<?php the_title(); ?>
				</li>
				<?php $isfirst = true; ?>
				<?php else: ?>
				<li class="recentpost"><?php the_title(); ?></li>
				<?php endif; ?>
				<?php endwhile; ?>
				<?php wp_reset_query(); ?>
				</ul>
			</div>
			<div class="col-sm-4">
				<ul>
				<?php
				$isfirst = false;
				$featuredPosts = new WP_Query();
				$featuredPosts->query('post_type=case_study&orderby=desc&showposts=4');
				while ($featuredPosts->have_posts()) : $featuredPosts->the_post(); ?>
				<?php if ( ! $isfirst ): ?>
				<li class="homefirstpost">
					<img src="<?php echo Roots\Sage\Extras\custom_feature_image('full', 360, 200); ?>" class="img-responsive">
					<?php the_title(); ?>
				</li>
				<?php $isfirst = true; ?>
				<?php else: ?>
				<li class="recentpost"><?php the_title(); ?></li>
				<?php endif; ?>
				<?php endwhile; ?>
				<?php wp_reset_query(); ?>
				</ul>
			</div>
			<div class="col-sm-4">
				<ul>
				<?php
				$isfirst = false;
				$featuredPosts = new WP_Query();
				$featuredPosts->query('post_type=post&orderby=desc&showposts=4');
				while ($featuredPosts->have_posts()) : $featuredPosts->the_post(); ?>
				<?php if ( ! $isfirst ): ?>
				<li class="homefirstpost">
					<img src="<?php echo Roots\Sage\Extras\custom_feature_image('full', 360, 200); ?>" class="img-responsive">
					<?php the_title(); ?>
				</li>
				<?php $isfirst = true; ?>
				<?php else: ?>
				<li class="recentpost"><?php the_title(); ?></li>
				<?php endif; ?>
				<?php endwhile; ?>
				<?php wp_reset_query(); ?>
				</ul>
			</div>
		</div>
	</div>
</section>
<section class="sun-flower demo-cta">	
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h1>Hello World</h1>
			</div>
		</div>
	</div>
</section>