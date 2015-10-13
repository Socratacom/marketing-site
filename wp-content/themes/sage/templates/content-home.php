<section class="home-hero">
	<div class="text-wrapper">
		<div class="container">
			<div class="row">
                <div class="text">
					<div class="col-sm-6">
						<h1>The Data Platform for 21st Century Digital Government</h1>
						<p class="lead">Leverage the power of data to improve every community - globally and locally.</p>
                        <p><a href="#" class="btn btn-lg btn-warning">Schedule a Meeting</a></p>
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
					<p><a href="/solutions/federal-government" class="btn btn-default">Learn More</a></p>
				</div>				
			</div>
			<div class="col-sm-6 col-md-4 tile state-tile" data-sr="enter bottom, opacity 0.5">
				<div class="tile-icon">
					<h4 class="text-center icon state-icon">State Government</h4>
				</div>
				<div class="tile-text">
					<h4 class="icon state-icon">State Government</h4>
					<p>Aenean lacinia bibendum nulla sed consectetur. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Curabitur blandit tempus porttitor. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
					<p><a href="/solutions/state-government" class="btn btn-default">Learn More</a></p>
				</div>	
			</div>
			<div class="col-sm-6 col-md-4 tile city-tile" data-sr="enter bottom, opacity 0.5">
				<div class="tile-icon">
					<h4 class="text-center icon city-icon">City Government</h4>
				</div>
				<div class="tile-text">
					<h4 class="icon city-icon">City Government</h4>
					<p>Aenean lacinia bibendum nulla sed consectetur. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Curabitur blandit tempus porttitor. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
					<p><a href="/solutions/city-government" class="btn btn-default">Learn More</a></p>
				</div>	
			</div>
			<div class="col-sm-6 col-md-4 tile county-tile" data-sr="enter bottom, opacity 0.5">
				<div class="tile-icon">
					<h4 class="text-center icon county-icon">County Government</h4>
				</div>
				<div class="tile-text">
					<h4 class="icon county-icon">County Government</h4>
					<p>Aenean lacinia bibendum nulla sed consectetur. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Curabitur blandit tempus porttitor. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
					<p><a href="/solutions/county-government" class="btn btn-default">Learn More</a></p>
				</div>	
			</div>
			<div class="col-sm-6 col-md-4 tile ngo-tile" data-sr="enter bottom, opacity 0.5">
				<div class="tile-icon">
					<h4 class="text-center icon ngo-icon">Non-Profit and International Organizations</h4>
				</div>
				<div class="tile-text">
					<h4 class="icon ngo-icon">Non-Profit and International Organizations</h4>
					<p>Aenean lacinia bibendum nulla sed consectetur. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Curabitur blandit tempus porttitor. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
					<p><a href="/solutions/non-profit-and-international-organizations" class="btn btn-default">Learn More</a></p>
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
				<p><a href="/customer-stories">View More Customers</a></p>
			</div>
			<?php
			$featuredCustomer = new WP_Query();
			$featuredCustomer->query('post_type=stories&orderby=rand&showposts=3');
			while ($featuredCustomer->have_posts()) : $featuredCustomer->the_post(); 
			?>
			<div class="col-sm-3">
				<article>
					<div class="logo-frame text-center">
						<img src="<?php echo stories_logo_home( 'full', 100 ); ?>" class="img-responsive">
					</div>
					<div class="customer-text truncate">
						<h5><?php the_title(); ?></h5>
						<?php the_excerpt(); ?>
					</div>
					<ul>
						<li><a href="<?php the_permalink() ?>">Read More</a></li>
						<?php $meta = get_socrata_stories_meta(); if ($meta[2]) {echo "<li><a href='$meta[2]' target='_blank'>Visit Site</a></li>";} ?>
					</ul>
				</article>
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
				$featuredPosts->query('post_type=tribe_events&orderby=desc&showposts=4');
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
								<div class="events-card-avatar img-circle"></div>
							</div>
							<a href="<?php the_permalink() ?>"></a>
						</div>
						<div class="card-text">
							<div class="categories"><?php events_the_categories(); ?></div>
							<h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
							<?php echo tribe_events_event_schedule_details( $event_id, '<small class="card-meta">', '</small>' ); ?>					
							<?php the_excerpt(); ?> 
						</div>
						<div class="padding-fallback"></div>
					</div>					
				</li>
				<?php $isfirst = true; ?>
				<?php else: ?>
				<li class="recentpost">
					<div class="categories"><?php events_the_categories(); ?></div>
					<p><a href="<?php the_permalink() ?>"><?php the_title(); ?></a><?php echo tribe_events_event_schedule_details( $event_id, '<small class="meta">', '</small>' ); ?></p>
				</li>
				<?php endif; ?>
				<?php endwhile; ?>
				<?php wp_reset_query(); ?>
				<li><a href="/events">View All Events</a></li>
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
								<div class="case-study-card-avatar img-circle"></div>
							</div>
							<a href="<?php the_permalink() ?>"></a>
						</div>
						<div class="card-text">
							<h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
							<small class="card-meta">By <strong><?php the_author(); ?></strong>, <?php the_time('F jS, Y') ?></small>
							<?php the_excerpt(); ?> 
						</div>						
						<div class="padding-fallback"></div>
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
				<li><a href="/case-studies">View More Case Studies</a></li>
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
						<div class="padding-fallback"></div>
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
				<li><a href="/blog">View More Articles</a></li>
				</ul>
			</div>
		</div>
	</div>
</section>
<section class="background-sun-flower demo-cta section-padding">	
	<div class="container">
		<div class="row">

			<div class="col-sm-6 col-sm-offset-6">
				<h2 class="text-right">Give us an hour.</h2>
				<p class="text-right lead">Donec ullamcorper nulla non metus auctor fringilla. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sed diam eget risus varius blandit sit amet non magna.</p>
				<p class="text-right"><a href="/request-a-demo" class="btn btn-default btn-lg">Request a Demo</a></p>
				<p class="text-right">Got question now? Chat with someone live or call us (800) 555-1212</p>
			</div>
		</div>
	</div>
</section>