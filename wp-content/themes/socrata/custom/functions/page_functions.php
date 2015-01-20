<?php

// Remove Sidebars
add_filter('thesis_show_sidebars', 'no_sidebars');
function no_sidebars() {
    if (is_page())
        return false;
    else
        return true;
}

add_action('thesis_hook_custom_template', 'custom_about');
function custom_about() {
  if (is_page('company-info')) { ?>
  <?php thesis_content_column(); ?>
    <?php }
}

add_action('thesis_hook_before_html', 'custom_about_image');
function custom_about_image() {
  if (is_page('company-info')) { ?>
  <div style="max-width:1600px; margin:60px auto 0 auto; background-image:url(/wp-content/themes/socrata/custom/images/Socrata-Employee-Summit11.jpg); background-repeat: no-repeat; background-size:cover; background-position:center; padding:14% 0;" class="format_text"></div>
    <?php }
}

add_action('thesis_hook_before_html', 'custom_top_datasets');
function custom_top_datasets() {
  if (is_page(array('top-open-data-datasets', 'us-cities', 'us-counties', 'us-states'))) { ?>
<div style="padding: 2em 0; background-image: url('/wp-content/uploads/Top-10-Datasets-background.jpg'); background-repeat:repeat-x; width:100%; max-height:500px; margin-top:60px;" width="100%">
<div style="max-width:1280px; margin: 0 auto;">
<div style="display:inline-block; max-width:20%; vertical-align:middle;">
<p class="mobile-hide"><img src="/wp-content/uploads/top-10-datasets-logo.png" width="245" height="245" alt="Top Open Data Datasets" title="Top Open Data Datasets" style="width:100%; max-width:245px; height:auto; padding:0 1em;"></p>
</div>
<div style="display:inline-block; width:79%; min-width:301px; vertical-align:middle;">
  <div style="padding:0 1em;">
<h1 style="text-align:left;font-size:3em;"><span style="color:#ffffff;">TOP</span> <span style="color:#F7D43D;">DATASETS</span></h1>
<h2 style="color:#9EC2E5; font-weight:bold;text-align:left;font-size:2em;">

    <?php if (is_page('top-open-data-datasets')) :?>
    THE BEST OPEN DATA IN U.S. LOCAL GOVERNMENT
    <?php else :?>
    <?php the_title(); ?>
    <?php endif;?>
</h2>
</div>
</div>
</div>
</div>

    <?php }
}

add_action('thesis_hook_after_html', 'magazine_volume_4_tracking');
function magazine_volume_4_tracking() {
  if (is_page('volume-4')) { ?>
<!-- Facebook Conversion Code for Socrata_V4_OpenInnovation_Native_FB_Web_View -->
<script>(function() {
  var _fbq = window._fbq || (window._fbq = []);
  if (!_fbq.loaded) {
    var fbds = document.createElement('script');
    fbds.async = true;
    fbds.src = '//connect.facebook.net/en_US/fbds.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(fbds, s);
    _fbq.loaded = true;
  }
})();
window._fbq = window._fbq || [];
window._fbq.push(['track', '6022900016514', {'value':'0.00','currency':'USD'}]);
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6022900016514&amp;cd[value]=0.00&amp;cd[currency]=USD&amp;noscript=1" /></noscript>
<script src="//platform.twitter.com/oct.js" type="text/javascript"></script>
<script type="text/javascript">
twttr.conversion.trackPid('l54c9');</script>
<noscript>
<img height="1" width="1" style="display:none;" alt="" src="https://analytics.twitter.com/i/adsct?txn_id=l54c9&p_id=Twitter" />
<img height="1" width="1" style="display:none;" alt="" src="//t.co/i/adsct?txn_id=l54c9&p_id=Twitter" /></noscript>

<script src="//platform.twitter.com/oct.js" type="text/javascript"></script>
<script type="text/javascript">
twttr.conversion.trackPid('l54c9');</script>
<noscript>
<img height="1" width="1" style="display:none;" alt="" src="https://analytics.twitter.com/i/adsct?txn_id=l54c9&p_id=Twitter" />
<img height="1" width="1" style="display:none;" alt="" src="//t.co/i/adsct?txn_id=l54c9&p_id=Twitter" /></noscript>
    <?php }
}

add_action('thesis_hook_before_html', 'custom_rethink_hero');
function custom_rethink_hero() {
  if (is_page('rethink')) { ?>
  <div id="full_hero" class="container intro-effect-push">
    <div class="full-hero-image">
      <div class="bg-img" style="background-color:#b1cee9; background: url('/wp-content/uploads/rethink-socrata-background.jpg'); background-size: cover;"></div>
      <div class="title" style="top: 25%;">
        <div class="title-inner format_text">
       <h1 class="center" style="color:#fff; max-width: none !important; font-size: 4em; font-weight: 600; line-height: 1em; text-shadow: 0px 0px 10px #000; letter-spacing: -2px; padding-top: 2%; margin-bottom: 1em; text-transform: uppercase; ">We're Rethinking Open Data</h1>
<div class="one_third">
<p class="mobile-hide" style="text-align:right;font-variant:small-caps;color:#666666;font-weight:bold;line-height:2em;">
Point Maps <span style="color:#ffffff;">◄</span><br>
Discovery Experience <span style="color:#ffffff;">◄</span><br>
Event Timeline <span style="color:#ffffff;">◄</span><br>
Federated Auth <span style="color:#ffffff;">◄</span><br>
Publisher Experience <span style="color:#ffffff;">◄</span>
</p>
</div>
<div class="one_third">
<p class="center"><img src="/wp-content/uploads/socrata-rethink-lightbulb.png" width="400" height="396" style="width:100%; height:auto; max-width:160px;"></p>
</div>
<div class="one_third last">
<p class="mobile-hide" style="font-variant:small-caps;color:#666666;font-weight:bold;line-height:2em;">
<span style="color:#ffffff;">►</span> Composite Visualizations<br>
<span style="color:#ffffff;">►</span> Search</br>
<span style="color:#ffffff;">►</span> Developer Experience</br>
<span style="color:#ffffff;">►</span> Responsive Design</br>
<span style="color:#ffffff;">►</span> Site Analytics
</p>
</div>
<div class="clearboth"></div>
<div class="desktop-hidden" style="max-width: 300px; margin: 0 auto;">
<p style="font-variant:small-caps;color:#666666;font-weight:bold;line-height:2em; width:49%;display:inline-block;">
<span style="color:#ffffff;">►</span> Composite Visualizations<br>
<span style="color:#ffffff;">►</span> Search</br>
<span style="color:#ffffff;">►</span> Developer Experience</br>
<span style="color:#ffffff;">►</span> Responsive Design</br>
<span style="color:#ffffff;">►</span> Site Analytics
</p>
<p style="text-align:right;font-variant:small-caps;color:#666666;font-weight:bold;line-height:2em; width:49%;display:inline-block;">
Point Maps <span style="color:#ffffff;">◄</span><br>
Discovery Experience <span style="color:#ffffff;">◄</span><br>
Event Timeline <span style="color:#ffffff;">◄</span><br>
Federated Auth <span style="color:#ffffff;">◄</span><br>
Publisher Experience <span style="color:#ffffff;">◄</span>
</p>
<style type="text/css">
.desktop-hidden {visibility: hidden;}
@media screen and (max-width: 568px) { .desktop-hidden {visibility: visible;} }

</style>
</div>
        </div>
      </div>
    </div>
    <button class="trigger" data-info="CLICK OR SCROLL"><span>&nbsp;</span></button>
    <?php }
}

add_action('thesis_hook_custom_template', 'custom_rethink');
function custom_rethink() {
  if (is_page('rethink')) { ?>
  <div class="content">
    <?php thesis_content_column(); ?>
  </div>
</div>
    <?php }
}

// Enqueue Scripts
add_action('wp_enqueue_scripts', 'rethink_scripts');
function rethink_scripts() {
  if (is_page('rethink')) {
    wp_register_style( 'component', get_stylesheet_directory_uri() . '/custom/ndoch/css/component.css' );
    wp_register_script( 'fullhero', get_stylesheet_directory_uri() . '/custom/ndoch/scripts/full-hero.js','','1.1', true); 
    wp_enqueue_style( 'component' );
    wp_enqueue_script( 'fullhero' );
  }
}