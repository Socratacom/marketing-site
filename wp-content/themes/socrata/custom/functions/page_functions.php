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

add_action('thesis_hook_before_html', 'ask_a_dataset');
function ask_a_dataset() {
  if (is_page('ask-a-dataset')) { ?>
  <div style="margin-top:60px; background-image:url(/wp-content/uploads/ask-a-dataset-hero-banner.jpg); background-repeat: no-repeat; background-size:cover; background-position:center; padding:14% 0;" class="format_text"></div>
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


// Enqueue Scripts
add_action('wp_enqueue_scripts', 'rethink_scripts');
function rethink_scripts() {
  if (is_page('rethink')) {
    wp_register_style( 'rethink-styles', get_stylesheet_directory_uri() . '/custom/rethink/css/styles.css', false, null );
    wp_enqueue_style( 'rethink-styles' );
    wp_register_style( 'fontawesome', 'http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css', false, null);
    wp_enqueue_style('fontawesome');
    wp_register_script( 'wistia-popover', '//fast.wistia.com/assets/external/popover-v1.js', false, null, true);
    wp_enqueue_script('wistia-popover');
    wp_register_script( 'jumplinks', get_stylesheet_directory_uri() . '/custom/rethink/js/jumplinks.js', false, null, true );
    wp_enqueue_script( 'jumplinks' );
  }
}

add_action('wp_enqueue_scripts', 'dau_scripts');
function dau_scripts() {
  if (is_page('data-as-a-utility')) {
    wp_register_style( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css', false, null);
    wp_enqueue_style('bootstrap');
    wp_register_style( 'dau-styles', get_stylesheet_directory_uri() . '/custom/data-as-utility/css/styles.css', false, null );
    wp_enqueue_style( 'dau-styles' );
    wp_register_style( 'fontawesome', 'http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css', false, null);
    wp_enqueue_style('fontawesome');
    wp_register_script( 'wistia-popover', '//fast.wistia.com/assets/external/popover-v1.js', false, null, true);
    wp_enqueue_script('wistia-popover');
  }
}