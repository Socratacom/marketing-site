<?php

// Short Codes for Open Data Guide
function toplink() {
    return '<div class="jump-top"><a href="#top">TOP <span class="ss-icon">up</span></a></div>';
}
add_shortcode('top', 'toplink');


function guide_quote($atts) {
  extract(shortcode_atts(array(
    "text"    => 'QUOTE TEXT HERE',
    "credit"  => '',
  ), $atts));
  return '<div class="quote"><p class="triangle-border">"'.$text.'"</p><p class="credit">'.$credit.'</p></div>';
}
add_shortcode('quote', 'guide_quote');

// MODAL WINDOW
function modal_window() {
  wp_enqueue_script( 'modal' );
  return '<div class="md-overlay"></div>';
}
add_shortcode("modal", "modal_window");

// ACCORDION
function accordion_panel() {
  wp_enqueue_script( 'accordion-script' );
  wp_enqueue_style( 'accordion-styles' );  
}
add_shortcode("accordion-scripts", "accordion_panel");

// TABS
function tabs_panel() {
  wp_enqueue_script( 'tab-script' );
  wp_enqueue_style( 'tab-styles' );  
}
add_shortcode("tab-scripts", "tabs_panel");

// TABS
function jumplink_script() {
  wp_enqueue_script( 'jumplinks' );
}
add_shortcode("jumplinks", "jumplink_script");

// CTA BOX
function cta_box($atts) {
  extract(shortcode_atts(array(
    "height"      => '',
    "icon_color"  => '',
    "icon_keyword"  => '',    
    "title"  => '',
    "text"  => '',
    "button_text"  => '',
    "link"  => '',

  ), $atts));
  return '<div class="new-cta" style="height:'.$height.';">
    <h3><span class="ss-icon" style="color:'.$icon_color.';">'.$icon_keyword.'</span>'.$title.'</h3>
    <p class="text">'.$text.'</p>
    <p><a class="button" title="'.$button_text.'" href="'.$link.'">'.$button_text.'</a></p>
  </div>';
}
add_shortcode('cta', 'cta_box');

function postit_box( $atts, $content = null ) {
  return '<div class="postit">'.$content.'</div>';
}
add_shortcode("postit", "postit_box");

function feature_box( $atts, $content = null ) {
  return '<div class="feature-box">'.$content.'</div>';
}
add_shortcode("feature box", "feature_box");



function shared_sidebar($atts, $content = null) {
  ob_start();
  ?>
    <ul style="list-style-type: none; margin:0; padding: 0;"><?php thesis_default_widget('shared'); ?></ul> 
  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode("shared-sidebar", "shared_sidebar");


// Recipes Author
function author_description($atts, $content = null) {
  ob_start();
  ?>
  <div class="author-description">
    <div class="row">
      <div class="col-sm-3">
        <p class="text-center"><?php echo get_avatar( get_the_author_meta('ID'), 100 ); ?></p>
      </div>
      <div class="col-sm-9">
        <h3>About the Author</h3>
        <?php the_author_description(); ?>
      </div>
    </div>
  </div>
  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode("author-description", "author_description");