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