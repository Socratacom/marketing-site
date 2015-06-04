<?php

// Shortcode [dau-video]
add_shortcode('dau-video','dau_video_shortcode');
function dau_video_shortcode($atts, $content = null) { ob_start(); ?>


<section id="video_container" class="video">

<div id="text">

<div class="vertical-align">
<div class="container">
<div class="row">
<div class="col-sm-10 col-sm-offset-1">

	<p class="text-center">Just like water, data is a natural resource. And just as water flows from various sources into many channels where it is collected, centralized, and processed for public consumption, Socrata's solution does the same with government data. We collect data, process it, refine it, and funnel it to multiple channels for multiple uses.</p>
	<div>
		<span class="glyphicon glyphicon-play-circle playbutton" aria-hidden="true"></span>
	</div>

</div>
</div>
</div>
</div>

</div>

<div id="cover-all"></div>
<div id="main-image"></div>
<div id="wistia_g92qhkv74k" class="wistia_embed backgroundVideo" ></div>

</section>



<div id="ex"><span class="glyphicon glyphicon-remove" aria-hidden="true" style="color:#fff;"></span></div>
<div id="wistia_of3560a3ee" class="wistia_embed overlayVideo" ></div>


<?php
$content = ob_get_contents();
ob_end_clean();
return $content;
}

// Shortcode [slider-one]
add_shortcode('slider-one','slider_one_shortcode');
function slider_one_shortcode($atts, $content = null) { ob_start(); ?>

<section class="slider-container">
	<div class="arrowsContainer"></div>
	<div class="row slider">
		<div class="col-sm-12 slide" style="background-color:#ccc;">
			<div class="container">
				<div class="row">
					<div class="col-lg-offset-6 col-md-5 col-md-offset-7 slide-content">
						<h4>Improve Quality of Life</h4>
						<h3>Citizens</h3>
						<p>Socrata helps you deliver great government-to-citizen digital experiences that your citizens expect. With Socrata, you can transform scattered, inaccessible assets into a powerful cloud-based digital services platform with ready-to-deploy interfaces that automatically connect you with the people you serve.</p>
						<p>Socrata’s government-to-citizen solutions aren’t just easy and cost-effective; we provide superior outcomes that delight users, drive engagement and expand your reach. Ubiquitous access to relevant data will make your community a great place to live.</p>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-12 slide" style="background-color:#eee;">
			<div class="container">
				<div class="row">
					<div class="col-lg-offset-6 col-md-5 col-md-offset-7 slide-content">
						<h4>Improve Quality of Life</h4>
						<h3>Citizens</h3>
						<p>Socrata helps you deliver great government-to-citizen digital experiences that your citizens expect. With Socrata, you can transform scattered, inaccessible assets into a powerful cloud-based digital services platform with ready-to-deploy interfaces that automatically connect you with the people you serve.</p>
						<p>Socrata’s government-to-citizen solutions aren’t just easy and cost-effective; we provide superior outcomes that delight users, drive engagement and expand your reach. Ubiquitous access to relevant data will make your community a great place to live.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
$content = ob_get_contents();
ob_end_clean();
return $content;
}


