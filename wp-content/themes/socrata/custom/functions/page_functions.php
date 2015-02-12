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