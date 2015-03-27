<?php
/**
 * Template Name: Homepage
 */
?>
<?php while (have_posts()) : the_post(); ?>
	<div class="jumbotron">
		<div class="slide1">
			<div class="container">
				<div class="col-sm-10 col-sm-offset-1">
					<h1><span class="smaller-text">Engaging the Public with</span>
					Financial Transparency</h1>
					<h2>Mongomery County Live at the Thingstitute</h2>
					<a href="#" class="button">Join the Webinar</a>
				</div>
			</div>
		</div>
		<div class="slide2">
			<div class="container">
				<div class="col-sm-10 col-sm-offset-1">
					<h1><span class="smaller-text">Engaging the Public with</span>
					Financial Transparency</h1>
					<h2>Mongomery County Live at the Thingstitute</h2>
					<a href="#" class="button">Join the Webinar</a>
				</div>
			</div>
		</div>
	</div>
	<section class="featured-videos">
		<div class="container">
			<div class="vid-slider">
				<div class="slide col-sm-4">
					<a href="#">
						<div class="play-btn"></div>
						<div class="video-content"><h3>What is Socrata?</h3>
						<p>Socrata is the cloud technology company focused on accelerating the shift to a more open, connected and data-driven government. Socrata’s turnkey solutions for organizing and publishing government data helps customers succeed in this new digital economy.</p></div>
						<img src="wp-content/themes/sage/assets/images/video1.jpg" alt="" class="img-responsive">
					</a>
				</div>
				<div class="slide col-sm-4">
					<a href="#">
						<div class="play-btn"></div>
						<div class="video-content"><h3>What is Socrata?</h3>
						<p>Socrata is the cloud technology company focused on accelerating the shift to a more open, connected and data-driven government. Socrata’s turnkey solutions for organizing and publishing government data helps customers succeed in this new digital economy.</p></div>
						<img src="wp-content/themes/sage/assets/images/video2.jpg" alt="" class="img-responsive">
					</a>
				</div>
				<div class="slide col-sm-4">
					<a href="#">
						<div class="play-btn"></div>
						<div class="video-content"><h3>What is Socrata?</h3>
						<p>Socrata is the cloud technology company focused on accelerating the shift to a more open, connected and data-driven government. Socrata’s turnkey solutions for organizing and publishing government data helps customers succeed in this new digital economy.</p></div>
						<img src="wp-content/themes/sage/assets/images/video3.jpg" alt="" class="img-responsive">
					</a>
				</div>
				<div class="slide col-sm-4">
					<a href="#">
						<div class="play-btn"></div>
						<div class="video-content"><h3>What is Socrata?</h3>
						<p>Socrata is the cloud technology company focused on accelerating the shift to a more open, connected and data-driven government. Socrata’s turnkey solutions for organizing and publishing government data helps customers succeed in this new digital economy.</p></div>
						<img src="wp-content/themes/sage/assets/images/video1.jpg" alt="" class="img-responsive">
					</a>
				</div>
				<div class="slide col-sm-4">
					<a href="#">
						<div class="play-btn"></div>
						<div class="video-content"><h3>What is Socrata?</h3>
						<p>Socrata is the cloud technology company focused on accelerating the shift to a more open, connected and data-driven government. Socrata’s turnkey solutions for organizing and publishing government data helps customers succeed in this new digital economy.</p></div>
						<img src="wp-content/themes/sage/assets/images/video2.jpg" alt="" class="img-responsive">
					</a>
				</div>
				<div class="slide col-sm-4">
					<a href="#">
						<div class="play-btn"></div>
						<div class="video-content"><h3>What is Socrata?</h3>
						<p>Socrata is the cloud technology company focused on accelerating the shift to a more open, connected and data-driven government. Socrata’s turnkey solutions for organizing and publishing government data helps customers succeed in this new digital economy.</p></div>
						<img src="wp-content/themes/sage/assets/images/video3.jpg" alt="" class="img-responsive">
					</a>
				</div>
			</div>
		</div>
	</section>
	<section class="featured-ctas">
		<div class="container">
			<div class="cta-slider">
				<div class="slide col-sm-4">
					<div class="row">
						<div class="col-xs-3">
							<i class="fa fa-unlock red"></i>
						</div>
						<div class="col-xs-9">
							<h3>How Redmond Freed Its Finances from PDFs</h3>
							<p>Redmond found a better way to tell their finance narrative with Socrata Open Budget. Read the case study.</p>
						</div>
					</div>
					<a href="#" class="button col-xs-offset-3">Read Now</a>
				</div>
				<div class="slide col-sm-4">
					<div class="row">
						<div class="col-xs-3">
							<i class="fa fa-info-circle yellow"></i>
						</div>
						<div class="col-xs-9">
							<h3>5 Things to Know About Financial Transparency</h3>
							<p>Explore financial transparency and why it needs to be the public sector's next open data priority.</p>
						</div>
					</div>
					<a href="#" class="button col-xs-offset-3">Read Now</a>
				</div>
				<div class="slide col-sm-4">
					<div class="row">
						<div class="col-xs-3">
							<i class="fa fa-paper-plane green"></i>
						</div>
						<div class="col-xs-9">
							<h3>Sneak Peek: Socrata Rethinks Open Data</h3>
							<p>Socrata is rethinking open data and data-driven government. Get a glimpse of what we're planning.</p>
						</div>
					</div>
					<a href="#" class="button col-xs-offset-3">Read Now</a>
				</div>
				<div class="slide col-sm-4">
					<div class="row">
						<div class="col-xs-3">
							<i class="fa fa-unlock red"></i>
						</div>
						<div class="col-xs-9">
							<h3>How Redmond Freed Its Finances from PDFs</h3>
							<p>Redmond found a better way to tell their finance narrative with Socrata Open Budget. Read the case study.</p>
						</div>
					</div>
					<a href="#" class="button col-xs-offset-3">Read Now</a>
				</div>
			</div>
		</div>
	</section>
	<?php get_template_part('templates/content', 'page'); ?>
<?php endwhile; ?>