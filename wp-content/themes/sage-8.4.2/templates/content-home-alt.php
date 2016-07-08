<section class="home-hero" style="background-image: url(/wp-content/uploads/home-hero-default.jpg);">
	<div class="inner">
		<div class="container">
			<div class="row">
				<div class="col-sm-6">
					<h1 class="margin-bottom-15 color-primary-dark">The Data Platform for 21st Century Digital Government</h1>
					<p class="lead color-primary-dark">Socrata's cloud-based solution allows government organizations to put their data online, make data-driven decisions, operate more efficiently, and share insights with citizens.</p>
					<p class="margin-bottom-0"><a href="/request-a-demo" class="btn btn-lg btn-primary">Schedule a Meeting</a></p>
				</div>
			</div>
		</div>
	</div>
	<div class="scrim"></div>
	<div class="scroll hidden-xs">
		<div class="mouse"><a href="#start"></a></div>
	</div>
</section>
<section id="start" class="section-padding">
	<div class="container">
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1">
				<h2 class="text-center color-primary-dark">Who we serve</h2>
				<p class="lead text-center margin-bottom-60">Socrata provides cloud solutions for federal, state, and local governments to transform data into actionable insights for public and government use.</p>
			</div>
			<div class="col-sm-3">
				<p class="text-center"><a href="/solutions/federal-government/"><i class="color-primary icon-100 icon-capital"></i></a></p>
				<h5 class="text-center title-border">Federal Government</h5>
				<p>Socrata for Federal Government helps federal departments and agencies maximize the power of their data.</p>
				<div class="alert alert-info"><i class="fa fa-info-circle" aria-hidden="true"></i> <i>In Process for FedRamp certification in 2016</i></div>
				<p><a href="/solutions/federal-government/">Learn More <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a></p>
			</div>
			<div class="col-sm-3">
				<p class="text-center"><a href="/solutions/state-government/"><i class="color-primary icon-100 icon-state"></a></i></p>
				<h5 class="text-center title-border">State Government</h5>
				<p>States rely on Socrata to increase transparency, improve operational efficiencies, and stimulate their economy.</p>
				<div class="alert alert-info"><i class="fa fa-info-circle" aria-hidden="true"></i> <i>25 States use Socrata products and services</i></div>
				<p><a href="/solutions/state-government/">Learn More <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a></p>
			</div>
			<div class="col-sm-3">
				<p class="text-center"><a href="/solutions/county-government/"><i class="color-primary icon-100 icon-map"></i></a></p>
				<h5 class="text-center title-border">County Government</h5>
				<p>With Socrata, counties can publish data that will boost the economy and make the region a better place to live.</p>
				<div class="alert alert-info"><i class="fa fa-info-circle" aria-hidden="true"></i> <i>4,000+ datasets are hosted by counties on Socrata</i></div>
				<p><a href="/solutions/county-government/">Learn More <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a></p>
			</div>
			<div class="col-sm-3">
				<p class="text-center"><a href="/solutions/city-government/"><i class="color-primary icon-100 icon-city"></i></a></p>
				<h5 class="text-center title-border">City Government</h5>
				<p>Large and small cities can utilize Socrata solutions to communicate more effectively with their constituents and to provide the essential services they rely upon.</p>
				<div class="alert alert-info"><i class="fa fa-info-circle" aria-hidden="true"></i> <i>300+ Cities use Socrata</i></div>
				<p><a href="/solutions/city-government/">Learn More <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a></p>
			</div>
		</div>
	</div>
</section>
<section class="video-background">
	<div class="outer">
		<div class="inner">
			<div class="container">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<h2 class="text-center text-reverse margin-bottom-15">Why Socrata?</h2>
						<p class="text-center text-reverse lead">The Data Platform for 21st Century Digital Government &mdash;
						Socrata's cloud-based solution allows government organizations to put their data online, make data-driven decisions, operate more efficiently, and share insights with citizens.</p>
						<p class="text-center"><a href="https://www.youtube.com/watch?v=IICDU-UKrZQ" role="button"><i class="fa fa-play-circle-o"></i></a></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="myvideo" class="video-wrapper img-background overlay overlay-primary" style="background-image:url(https://img.youtube.com/vi/IICDU-UKrZQ/maxresdefault.jpg)"></div>
	<div id="video" class="player overlay overlay-primary" data-property="{videoURL:'IICDU-UKrZQ',containment:'#myvideo', showControls:false, autoPlay:true, loop:true, mute:true, startAt:21, stopAt:41, opacity:1, addRaster:true, quality:'default'}"></div>
	<script>jQuery(function(e){e("#video").YTPlayer()});</script>
	<?php echo do_shortcode('[youtube-modal]');?>
</section>
<section class="section-padding">
	<div class="container">
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1">
				<h2 class="text-center color-primary-dark">Our customers</h2>
				<p class="lead text-center margin-bottom-60">Over 1,400 cities, counties, states, and federal government agencies are successfully maximizing the value of their data with Socrata.</p>				
			</div>
			<div class="col-sm-12 margin-bottom-60">
				<div id="partner-logos">
					<?php
				    $args = array(
				    'post_type'         => 'od_directory',
				    'order'             => 'desc',
				    'orderby'			=> 'rand',
				    'posts_per_page'    => 18,
				    'post_status'       => 'publish',
				    );

				    // The Query
				    $the_query = new WP_Query( $args );

				    // The Loop
				    if ( $the_query->have_posts() ) { while ( $the_query->have_posts() ) { $the_query->the_post(); $logo = rwmb_meta( 'directory_logo', 'size=medium'); {

						if ( !empty( $logo ) ) { ?>
							<div class="sixteen-nine slide">
								<div class="aspect-content logo-background" style="background-image:url(<?php foreach ( $logo as $image ) { echo $image['url']; } ?>);"></div>
							</div>
						<?php }

					}}} 
				    wp_reset_postdata(); ?>
				</div>
				<?php echo do_shortcode('[partner-logos-carousel-js id="partner-logos"]');?>				
			</div>
			<div class="col-sm-10 col-sm-offset-1">
				<p class="text-center">Socrata customer sites are powered by: <a href="https://aws.amazon.com/" target="_blank"><img src="/wp-content/uploads/logo-aws-small.png"></a></p>
			</div>
		</div>
	</div>
</section>
