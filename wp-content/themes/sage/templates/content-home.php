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
<section class="clouds section-padding articles">	
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
					<div class="card" data-sr="ease-in-out">
						<div class="card-banner green-sea">
							Events
						</div>
						<div class="card-image hidden-xs">
							<img src="<?php echo Roots\Sage\Extras\custom_feature_image('full', 360, 180); ?>" class="img-responsive">		
							<div class="card-avatar">
								<?php echo get_avatar( get_the_author_meta('ID'), 60 ); ?>
							</div>
							<a href="<?php the_permalink() ?>"></a>
						</div>
						<div class="card-text">
							<h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
							<small class="card-meta">By <strong><?php the_author(); ?></strong>, <?php the_time('F jS, Y') ?></small>
							<?php the_excerpt(); ?> 
						</div>
					</div>					
				</li>
				<?php $isfirst = true; ?>
				<?php else: ?>
				<li class="recentpost">
					<p><a href="<?php the_permalink() ?>"><?php the_title(); ?></a><small class="meta">By <strong><?php the_author(); ?></strong>, <?php the_time('F jS, Y') ?></small></p>
				</li>
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
					<div class="card" data-sr="wait .5s, ease-in-out">
						<div class="card-banner pumpkin">
							Case Studies
						</div>
						<div class="card-image hidden-xs">
							<img src="<?php echo Roots\Sage\Extras\custom_feature_image('full', 360, 180); ?>" class="img-responsive">		
							<div class="card-avatar">
								<?php echo get_avatar( get_the_author_meta('ID'), 60 ); ?>
							</div>
							<a href="<?php the_permalink() ?>"></a>
						</div>
						<div class="card-text">
							<h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
							<small class="card-meta">By <strong><?php the_author(); ?></strong>, <?php the_time('F jS, Y') ?></small>
							<?php the_excerpt(); ?> 
						</div>
					</div>	
				</li>
				<?php $isfirst = true; ?>
				<?php else: ?>
				<li class="recentpost">
					<p><a href="<?php the_permalink() ?>"><?php the_title(); ?></a><small class="meta">By <strong><?php the_author(); ?></strong>, <?php the_time('F jS, Y') ?></small></p>
				</li>
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
					<div class="card" data-sr="wait 1s, ease-in-out">
						<div class="card-banner wisteria">
							Open Data Blog
						</div>
						<div class="card-image hidden-xs">
							<img src="<?php echo Roots\Sage\Extras\custom_feature_image('full', 360, 180); ?>" class="img-responsive">		
							<div class="card-avatar">
								<?php echo get_avatar( get_the_author_meta('ID'), 60 ); ?>
							</div>
							<a href="<?php the_permalink() ?>"></a>
						</div>
						<div class="card-text">
							<h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
							<small class="card-meta">By <strong><?php the_author(); ?></strong>, <?php the_time('F jS, Y') ?></small>
							<?php the_excerpt(); ?> 
						</div>
					</div>	
				</li>
				<?php $isfirst = true; ?>
				<?php else: ?>
				<li class="recentpost">
					<p><a href="<?php the_permalink() ?>"><?php the_title(); ?></a><small class="meta">By <strong><?php the_author(); ?></strong>, <?php the_time('F jS, Y') ?></small></p>
				</li>
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