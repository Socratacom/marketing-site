<?php

// Shortcode [dau-video]
add_shortcode('dau-video','dau_video_shortcode');
function dau_video_shortcode($atts, $content = null) { ob_start(); ?>


<section id="video_container">

<div id="text">
	<div class="vertical-align">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<h1 class="text-center">Introducing Data as a Utility</h1>
					<ul>
						<li class="hidden-xs hidden-sm"><a href="#video-container" class="playbutton" >Watch the Video <i class="fa fa-chevron-circle-right"></i></a></li>
						<li class="hidden-md hidden-lg"><a href="//fast.wistia.net/embed/iframe/p3tr8wbatm?popover=true" class="wistia-popover[height=480,playerColor=7b796a,width=853]">Watch the Video <i class="fa fa-chevron-circle-right"></i></a></li>
						<li><a href="#data">Data is a Critical New Utility <i class="fa fa-chevron-circle-right"></i></a></li>
						<li><a href="#gov">What Can Data-Driven Government Do for You? <i class="fa fa-chevron-circle-right"></i></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="cover-all"></div>
<div id="main-image"></div>
<div id="wistia_fudivnw8is" class="wistia_embed backgroundVideo" ></div>

<div id="ex"><span class="glyphicon glyphicon-remove" aria-hidden="true" style="color:#fff;"></span></div>
<div id="wistia_p3tr8wbatm" class="wistia_embed overlayVideo" ></div>
<script charset="ISO-8859-1" src="//fast.wistia.com/assets/external/popover-v1.js"></script>
</section>








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
	<div class="row personas">
		<div class="col-sm-12 slide program-leaders">
			<div class="container">
				<div class="row">
					<div class="col-lg-offset-6 col-md-5 col-md-offset-7 col-sm-10 col-sm-offset-1 slide-content">
						<h3>Government</h3>
						<p>Collecting and consolidating key data enables a data-driven decision making process that’s impactful and transparent.</p>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-12 slide citizens">
			<div class="container">
				<div class="row">
					<div class="col-lg-offset-6 col-md-5 col-md-offset-7 col-sm-10 col-sm-offset-1 slide-content">
						<h3>Citizens</h3>
						<p>Ubiquitous access to previously scattered and inaccessible data through a cloud-based digital services platform will make your community a better place to live.</p>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-12 slide business">
			<div class="container">
				<div class="row">
					<div class="col-lg-offset-6 col-md-5 col-md-offset-7 col-sm-10 col-sm-offset-1 slide-content">
						<h3>Business</h3>
						<p>A 21st century digital infrastructure will attract new information-based ventures, maintain competitiveness in traditional industry, and dramatically reduce business transaction costs in your community.</p>
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