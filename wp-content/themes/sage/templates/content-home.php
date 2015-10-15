<section class="home-hero">
	<div class="text-wrapper">
		<div class="container">
			<div class="row">
                <div class="text">
					<div class="col-sm-6">
						<h1>The Data Platform for 21st Century Digital Government</h1>
						<p class="lead">Leverage the power of data to improve every community - globally and locally.</p>
                        <p><a href="/request-a-demo" class="btn btn-lg btn-warning">Schedule a Meeting</a></p>
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
					<p class="lead">Socrata provides cloud solutions for federal, state, and local governments to transform data into actionable insights for public and government use.</p>
				</div>
			</div>
			<div class="col-sm-6 col-md-4 tile background-belize-hole" data-sr="enter bottom, opacity 0.5">
				<div class="tile-icon">
					<h4 class="text-center icon fed-icon text-reverse">Federal Government</h4>
				</div>
				<div class="tile-text">
					<h4 class="icon fed-icon text-reverse">Federal Government</h4>
					<p class=" text-reverse">Socrata for Federal Government is helping federal departments and agencies maximize the power of their data.</p>
					<p class=" text-reverse stat">"In-Process" for FedRAMP certification as of 2015</p>
					<p><a href="/solutions/federal-government" class="btn btn-default">Learn More</a></p>
				</div>				
			</div>
			<div class="col-sm-6 col-md-4 tile background-green-sea" data-sr="enter bottom, opacity 0.5">
				<div class="tile-icon">
					<h4 class="text-center icon state-icon text-reverse">State Government</h4>
				</div>
				<div class="tile-text">
					<h4 class="icon state-icon text-reverse">State Government</h4>
					<p class="text-reverse">States rely on Socrata to increase transparency, improve operational efficiencies, and stimulate their economy.</p>
					<p class=" text-reverse stat">20+ U.S. States publish public data through Socrata</p>
					<p><a href="/solutions/state-government" class="btn btn-default color-green-sea">Learn More</a></p>
				</div>	
			</div>

			<div class="col-sm-6 col-md-4 tile background-pumpkin" data-sr="enter bottom, opacity 0.5">
				<div class="tile-icon">
					<h4 class="text-center icon city-icon text-reverse">City Government</h4>
				</div>
				<div class="tile-text">
					<h4 class="icon city-icon text-reverse">City Government</h4>
					<p class="text-reverse">Both large and small cities can utilize Socrata solutions to communicate more effectively with their constituents to provide the necessary services they depend on.</p>
					<p class=" text-reverse stat">3k to 8m citizens, cities large and small use Socrata</p>
					<p><a href="/solutions/city-government" class="btn btn-default">Learn More</a></p>
				</div>	
			</div>
			<div class="col-sm-6 col-md-4 tile background-amethyst" data-sr="enter bottom, opacity 0.5">
				<div class="tile-icon">
					<h4 class="text-center icon county-icon text-reverse">County Government</h4>
				</div>
				<div class="tile-text">
					<h4 class="icon county-icon text-reverse">County Government</h4>
					<p class="text-reverse">Aenean lacinia bibendum nulla sed consectetur. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Curabitur blandit tempus porttitor.</p>
					<p class=" text-reverse stat">4,000+ datasets are hosted by counties on Socrata</p>
					<p><a href="/solutions/county-government" class="btn btn-default">Learn More</a></p>
				</div>	
			</div>
			<div class="col-sm-6 col-md-4 tile background-orange" data-sr="enter bottom, opacity 0.5">
				<div class="tile-icon">
					<h4 class="text-center icon ngo-icon text-reverse">Non-Profit and International Organizations</h4>
				</div>
				<div class="tile-text">
					<h4 class="icon ngo-icon text-reverse">Non-Profit and International Organizations</h4>
					<p class="text-reverse">Aenean lacinia bibendum nulla sed consectetur. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Curabitur blandit tempus porttitor.</p>					
					<p class=" text-reverse stat">15 countries receive support from nonprofits on Socrata</p>
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
				<p class="lead">Over XXX federal departments, states, and cities of all sizes are successfully maximizing the value of their data with Socrata.</p>
				<p><a href="/customer-stories">View More Customers</a></p>
			</div>
			<div class="col-sm-3">
				<?php echo do_shortcode('[customer-logos-abstract query="post_type=stories&stories_type=federal&posts_per_page=1"]');?>
			</div>
			<div class="col-sm-3">
				<?php echo do_shortcode('[customer-logos-abstract query="post_type=stories&stories_type=state&posts_per_page=1"]');?>
			</div>
			<div class="col-sm-3">
				<?php echo do_shortcode('[customer-logos-abstract query="post_type=stories&stories_type=city&posts_per_page=1"]');?>
			</div>
		</div>
	</div>
</section>

<section class="background-clouds section-padding articles">	
	<div class="container">
		<div class="row">
			<div class="col-sm-4">
				<?php
				$featuredPosts = new WP_Query();
				$featuredPosts->query('post_type=tribe_events&orderby=desc&showposts=1');
				while ($featuredPosts->have_posts()) : $featuredPosts->the_post(); ?>
					<div class="card truncate" data-sr="enter bottom, opacity 0.5">
						<div class="card-banner background-green-sea">
							<ul>
								<li>Events</li>
								<li><a href="/events">View All</a></li>
							</ul>
						</div>
						<div class="card-image hidden-xs">
							<img src="<?php echo Roots\Sage\Extras\custom_feature_image('full', 360, 180); ?>" class="img-responsive">		
							<div class="card-avatar">
								<div class="icon-avatar img-circle events"></div>
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
				<?php endwhile; ?>
				<?php wp_reset_query(); ?>
			</div>
			<div class="col-sm-4">
				<?php
				$featuredPosts = new WP_Query();
				$featuredPosts->query('post_type=case_study&orderby=desc&showposts=1');
				while ($featuredPosts->have_posts()) : $featuredPosts->the_post(); ?>
					<div class="card truncate" data-sr="enter bottom, opacity 0.5">
						<div class="card-banner background-pumpkin">
							<ul>
								<li>Case Studies</li>
								<li><a href="/case-studies">View All</a></li>
							</ul>
						</div>
						<div class="card-image hidden-xs">
							<img src="<?php echo Roots\Sage\Extras\custom_feature_image('full', 360, 180); ?>" class="img-responsive">		
							<div class="card-avatar">
								<div class="icon-avatar img-circle case-studies"></div>
							</div>
							<a href="<?php the_permalink() ?>"></a>
						</div>
						<div class="card-text">							
							<div class="categories"><?php case_study_the_categories(); ?></div>
							<h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
							<small class="card-meta"><?php $meta = get_case_study_meta(); if ($meta[0]) echo $meta[0]; ?></small>
							<?php the_excerpt(); ?> 
						</div>						
						<div class="padding-fallback"></div>
					</div>
				<?php endwhile; ?>
				<?php wp_reset_query(); ?>
			</div>
			<div class="col-sm-4">
				<?php
				$featuredPosts = new WP_Query();
				$featuredPosts->query('post_type=post&orderby=desc&showposts=1');
				while ($featuredPosts->have_posts()) : $featuredPosts->the_post(); ?>
					<div class="card truncate" data-sr="enter bottom, opacity 0.5">
						<div class="card-banner background-wisteria">
							<ul>
								<li>Open Data Blog</li>
								<li><a href="/blog">View All</a></li>
							</ul>
						</div>
						<div class="card-image hidden-xs">
							<img src="<?php echo Roots\Sage\Extras\custom_feature_image('full', 360, 180); ?>" class="img-responsive">		
							<div class="card-avatar">
								<?php echo get_avatar( get_the_author_meta('ID'), 60 ); ?>
							</div>
							<a href="<?php the_permalink() ?>"></a>
						</div>
						<div class="card-text">
							<div class="categories"><?php Roots\Sage\Extras\blog_the_categories(); ?></div>
							<h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
							<small class="card-meta">By <strong><?php the_author(); ?></strong>, <?php the_time('F jS, Y') ?></small>
							<?php the_excerpt(); ?> 
						</div>						
						<div class="padding-fallback"></div>
					</div>
				<?php endwhile; ?>
				<?php wp_reset_query(); ?>
			</div>
		</div>
	</div>
</section>
<section class="background-peter-river section-padding">	
	<div class="container">
		<div class="row">
			<div class="col-sm-6 col-sm-offset-1">
				<h2 class="text-reverse">Give us an hour.</h2>
				<p class="lead text-reverse">Donec ullamcorper nulla non metus auctor fringilla. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sed diam eget risus varius blandit sit amet non magna.</p>
				<p class="text-reverse">Got question now? Give us a call at (800) 555-1212</p>
				<p><a href="/request-a-demo" class="btn btn-default btn-lg">Schedule a Meeting</a></p>
			</div>
			<div class="col-sm-4 hidden-xs">				
				<svg id="clock" viewBox="0 0 100 100">
					<circle id="face" cx="50" cy="50" r="45"/>
					<g id="hands">
						<rect id="hour" x="48" y="22.5" width="4" height="30" rx="2" ry="2" />
						<rect id="min" x="48" y="12.5" width="4" height="40" rx="2" ry="2"/>
						<line id="sec" x1="50" y1="50" x2="50" y2="16" />
					</g>
					<circle id="dot" cx="50" cy="50" r="3"/>
				</svg>
			</div>
		</div>
	</div>
</section>