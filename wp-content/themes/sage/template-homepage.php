<?php
/**
 * Template Name: Homepage
 */
?>
<?php while (have_posts()) : the_post(); ?>
	<div class="jumbotron">
		<div class="slide1">
			<div class="container">
				<h1><span class="smaller-text">Engaging the Public with</span>
				Financial Transparency</h1>
				<h2>Mongomery County Live at the Thingstitute</h2>
				<a href="#" class="button">Join the Webinar</a>
			</div>
		</div>
		<div class="slide2">
			<div class="container">
				<h1><span class="smaller-text">Engaging the Public with</span>
				Financial Transparency</h1>
				<h2>Mongomery County Live at the Thingstitute</h2>
				<a href="#" class="button">Join the Webinar</a>
			</div>
		</div>
	</div>
	<section class="featured-videos">
		<div class="container">
			<div class="vid-slider">
				<a href="#" class="slide col-sm-4">
					<div class="play-btn"></div>
					<div class="video-content"><h3>What is Socrata?</h3>
					Socrata is the cloud technology company focused on accelerating the shift to a more open, connected and data-driven government. Socrata’s turnkey solutions for organizing and publishing government data helps customers succeed in this new digital economy.</div>
					<img src="wp-content/themes/sage/assets/images/video1.jpg" alt="" class="img-responsive">
				</a>
				<a href="#" class="slide col-sm-4">
					<div class="play-btn"></div>
					<div class="video-content"><h3>What is Socrata?</h3>
					Socrata is the cloud technology company focused on accelerating the shift to a more open, connected and data-driven government. Socrata’s turnkey solutions for organizing and publishing government data helps customers succeed in this new digital economy.</div>
					<img src="wp-content/themes/sage/assets/images/video2.jpg" alt="" class="img-responsive">
				</a>
				<a href="#" class="slide col-sm-4">
					<div class="play-btn"></div>
					<div class="video-content"><h3>What is Socrata?</h3>
					Socrata is the cloud technology company focused on accelerating the shift to a more open, connected and data-driven government. Socrata’s turnkey solutions for organizing and publishing government data helps customers succeed in this new digital economy.</div>
					<img src="wp-content/themes/sage/assets/images/video3.jpg" alt="" class="img-responsive">
				</a>
				<a href="#" class="slide col-sm-4">
					<div class="play-btn"></div>
					<div class="video-content"><h3>What is Socrata?</h3>
					Socrata is the cloud technology company focused on accelerating the shift to a more open, connected and data-driven government. Socrata’s turnkey solutions for organizing and publishing government data helps customers succeed in this new digital economy.</div>
					<img src="wp-content/themes/sage/assets/images/video1.jpg" alt="" class="img-responsive">
				</a>
				<a href="#" class="slide col-sm-4">
					<div class="play-btn"></div>
					<div class="video-content"><h3>What is Socrata?</h3>
					Socrata is the cloud technology company focused on accelerating the shift to a more open, connected and data-driven government. Socrata’s turnkey solutions for organizing and publishing government data helps customers succeed in this new digital economy.</div>
					<img src="wp-content/themes/sage/assets/images/video2.jpg" alt="" class="img-responsive">
				</a>
				<a href="#" class="slide col-sm-4">
					<div class="play-btn"></div>
					<div class="video-content"><h3>What is Socrata?</h3>
					Socrata is the cloud technology company focused on accelerating the shift to a more open, connected and data-driven government. Socrata’s turnkey solutions for organizing and publishing government data helps customers succeed in this new digital economy.</div>
					<img src="wp-content/themes/sage/assets/images/video3.jpg" alt="" class="img-responsive">
				</a>
			</div>
		</div>
	</section>
	<?php get_template_part('templates/content', 'page'); ?>
<?php endwhile; ?>