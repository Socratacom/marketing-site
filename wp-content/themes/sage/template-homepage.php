<?php
/**
 * Template Name: Homepage
 */
?>
<?php while (have_posts()) : the_post(); ?>
	<div class="jumbotron">
		<?php
		if( have_rows('hero') ):
			while ( have_rows('hero') ) : the_row();
				// get vars
				$rtp_id = get_sub_field('rtp_id');
				$background = get_sub_field('slider_image');
				$small_text = get_sub_field('header_small_text');
				$large_text = get_sub_field('header_large_text');
				$italic_text = get_sub_field('header_italic_text');

				if( have_rows('cta') ):
					while ( have_rows('cta') ) : the_row();
						$link = '';
						$link_text = '';
						if( get_row_layout() == 'internal_link' ):
							$link = get_sub_field('internal_link');
							$link_text = get_sub_field('internal_link_text');
						elseif( get_row_layout() == 'external_link' ):
							$link = get_sub_field('external_link');
							$link_text = get_sub_field('external_link_text');
						endif;
					endwhile;
				else :
					// no layouts found
				endif;

				echo '<div id="'.$rtp_id.'" class="slide" style="background-image: url('.$background.');"><div class="container"><div class="col-sm-10 col-sm-offset-1">';
					echo '<h1>';
					if ($small_text) {
						echo '<span class="smaller-text">'.$small_text.'</span>';
					}
					if ($large_text) {
						echo $large_text;
					}
					echo '</h1>';
					if ($italic_text) {
						echo '<h2>'.$italic_text.'</h2>';
					}
					if ($link) {
						echo '<a href="'.$link.'" class="button">'.$link_text.'</a>';
					}
				echo '</div></div></div>';
			endwhile;
		else :
			// no hero found
		endif;
		?>
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
	<section class="cloud-overview">

	</section>
	<?php get_template_part('templates/content', 'page'); ?>
<?php endwhile; ?>