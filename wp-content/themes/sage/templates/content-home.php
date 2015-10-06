


<section class="home-hero">
	<div class="text-wrapper">
		<div class="container">
			<div class="row">
                <div class="text">
					<div class="col-sm-6">
						<h1>Socrata is leading the transformation to 21st century digital government</h1>
						<p class="lead">Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Vestibulum id ligula porta felis euismod semper.</p>
                        <p><a href="#" class="btn btn-lg btn-warning">Schedule a Demo</a></p>
					</div>
                </div>
			</div>
		</div>

	</div>
	<div class="slider">
		<div class="background-silver slide slide-one"></div>
		<div class="background-silver slide slide-two"></div>
		<div class="background-silver slide slide-three"></div>
	</div>
</section>





<section class="background-gray-dark industries">
	<div class="container">
		<div class="row no-gutters">
			<div class="col-sm-6 col-md-4">
				<div class="what-we-do">
					<h2>What We Do</h2>
					<p class="lead">Our cloud-based open data platform - developed exclusively for governments - collects, refines, and distributes data to 250 innovative global governments and millions of their connected citizens.</p>
				</div>
			</div>
			<div class="col-sm-6 col-md-4 tile fed-tile" data-sr="enter bottom, opacity 0.5">
				<div class="tile-icon">
					<h4 class="text-center icon fed-icon">Federal Government</h4>
				</div>
				<div class="tile-text">
					<h4 class="icon fed-icon">Federal Government</h4>
					<p>Aenean lacinia bibendum nulla sed consectetur. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Curabitur blandit tempus porttitor. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
					<p><a href="#" class="btn btn-default">Learn More</a></p>
				</div>				
			</div>
			<div class="col-sm-6 col-md-4 tile state-tile" data-sr="enter bottom, opacity 0.5">
				<div class="tile-icon">
					<h4 class="text-center icon state-icon">State Government</h4>
				</div>
				<div class="tile-text">
					<h4 class="icon state-icon">State Government</h4>
					<p>Aenean lacinia bibendum nulla sed consectetur. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Curabitur blandit tempus porttitor. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
					<p><a href="#" class="btn btn-default">Learn More</a></p>
				</div>	
			</div>
			<div class="col-sm-6 col-md-4 tile city-tile" data-sr="enter bottom, opacity 0.5">
				<div class="tile-icon">
					<h4 class="text-center icon city-icon">City Government</h4>
				</div>
				<div class="tile-text">
					<h4 class="icon city-icon">City Government</h4>
					<p>Aenean lacinia bibendum nulla sed consectetur. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Curabitur blandit tempus porttitor. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
					<p><a href="#" class="btn btn-default">Learn More</a></p>
				</div>	
			</div>
			<div class="col-sm-6 col-md-4 tile county-tile" data-sr="enter bottom, opacity 0.5">
				<div class="tile-icon">
					<h4 class="text-center icon county-icon">County Government</h4>
				</div>
				<div class="tile-text">
					<h4 class="icon county-icon">County Government</h4>
					<p>Aenean lacinia bibendum nulla sed consectetur. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Curabitur blandit tempus porttitor. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
					<p><a href="#" class="btn btn-default">Learn More</a></p>
				</div>	
			</div>
			<div class="col-sm-6 col-md-4 tile ngo-tile" data-sr="enter bottom, opacity 0.5">
				<div class="tile-icon">
					<h4 class="text-center icon ngo-icon">Non-Profit and International Organizations</h4>
				</div>
				<div class="tile-text">
					<h4 class="icon ngo-icon">Non-Profit and International Organizations</h4>
					<p>Aenean lacinia bibendum nulla sed consectetur. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Curabitur blandit tempus porttitor. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
					<p><a href="#" class="btn btn-default">Learn More</a></p>
				</div>	
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


<?php
$featuredCustomer = new WP_Query();
$featuredCustomer->query('post_type=stories&orderby=rand&showposts=3');
while ($featuredCustomer->have_posts()) : $featuredCustomer->the_post(); 
?>
<div class="col-sm-3">

	<div class="text-center" style="width:100%; height:180px; border:#ccc solid 5px; position:relative; padding:15px;">
		<img src="<?php echo stories_logo_home( 'full', 100 ); ?>" class="vertical-center" style="margin:auto; width:auto; max-width: 100%;">

	<!--<?php $meta = get_socrata_stories_meta(); if ($meta[6]) echo wp_get_attachment_image($meta[6], 'small', false, array('class' => 'img-responsive')); ?>-->
</div>
<h5><?php the_title(); ?></h5>
</div>
<?php endwhile; ?>
<?php wp_reset_query(); ?>


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
					<div class="card truncate" data-sr="enter bottom, opacity 0.5">
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
					<div class="card truncate" data-sr="enter bottom, opacity 0.5">
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
					<div class="card truncate" data-sr="enter bottom, opacity 0.5">
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