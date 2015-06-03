<?php

// Shortcode [dau-video]
add_shortcode('dau-video','dau_video_shortcode');
function dau_video_shortcode($atts, $content = null) { ob_start(); ?>
<section class="video">
<div class="vertical-align">
<div class="container">
<div class="row">
<div class="col-sm-10 col-sm-offset-1">
<p>Just like water, data is a natural resource. And just as water flows from various sources into many channels where it is collected, centralized, and processed for public consumption, Socrata's solution does the same with government data. We collect data, process it, refine it, and funnel it to multiple channels for multiple uses.</p>
</div>
</div>
</div>
<div>
</section>
<?php
$content = ob_get_contents();
ob_end_clean();
return $content;
}