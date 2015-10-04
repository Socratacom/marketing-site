


<section class="home-hero">
	<div class="arrowsContainer"></div>
	<div class="slider">


		<!--<div class="arrowsContainer"></div>-->
		<div class="background-silver" style="height:100vh; width: 100%;" >
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<h1>Hello World</h1>
					</div>
				</div>
			</div>
		</div>
		<div class="background-concrete" style="height:100vh; width: 100%;">
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<h1>Hello World</h1>
					</div>
				</div>
			</div>
		</div>		
		<div class="background-asbestos" style="height:100vh; width: 100%;">
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<h1>Hello World</h1>
					</div>
				</div>
			</div>
		</div>

	</div>
</section>





<section class="background-gray-dark industries">
	<div class="container">
		<div class="row no-gutters">
			<div class="col-sm-6 col-md-4 tile">
				<div class="what-we-do">
					<h2>What We Do</h2>
					<p class="lead">Our cloud-based open data platform - developed exclusively for governments - collects, refines, and distributes data to 250 innovative global governments and millions of their connected citizens.</p>
				</div>
			</div>
			<div class="col-sm-6 col-md-4 tile background-belize-hole">
				<h1>Hello World</h1>
			</div>
			<div class="col-sm-6 col-md-4 tile background-nephritis">
				<h1>Hello World</h1>
			</div>
			<div class="col-sm-6 col-md-4 tile background-pumpkin">
				<h1>Hello World</h1>
			</div>
			<div class="col-sm-6 col-md-4 tile background-amethyst">
				<h1>Hello World</h1>
			</div>
			<div class="col-sm-6 col-md-4 tile background-orange">
				<h1>Hello World</h1>
			</div>
		</div>
	</div>
</section>





<section class="section-padding customers">
	<div class="container">
		<div class="row">
			<div class="col-sm-3">
				<h2>Our Customers</h1>
				<p class="lead">Curabitur blandit tempus porttitor. Sed posuere consectetur est at lobortis. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Maecenas faucibus mollis interdum. </p>
			</div>
			<div class="col-sm-3"></div>
			<div class="col-sm-3"></div>
			<div class="col-sm-3"></div>
		</div>
	</div>
</section>







<section class="background-clouds section-padding articles">	
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
					<div class="card truncate" data-sr="ease-in-out">
						<div class="card-banner background-green-sea">
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
					<div class="card truncate" data-sr="wait .5s, ease-in-out">
						<div class="card-banner background-pumpkin">
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
					<div class="card truncate" data-sr="wait 1s, ease-in-out">
						<div class="card-banner background-wisteria">
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
<section class="background-sun-flower demo-cta">	
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h1>Hello World</h1>
			</div>
		</div>
	</div>
</section>