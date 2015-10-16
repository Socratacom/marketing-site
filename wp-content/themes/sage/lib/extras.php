<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Config;

/**
 * Add <body> classes
 */
function body_class($classes) {
  // Add page slug if it doesn't exist
  if (is_single() || is_page() && !is_front_page()) {
    if (!in_array(basename(get_permalink()), $classes)) {
      $classes[] = basename(get_permalink());
    }
  }

  // Add class if sidebar is active
  if (Config\display_sidebar()) {
    $classes[] = 'sidebar-primary';
  }

  return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');

/**
 * Clean up the_excerpt()
 */
function excerpt_more() {
  return '';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');

/**
 * Adds category name to blog
 */
function blog_the_categories() {
  // get all categories for this post
  global $cats;
  $cats = get_the_category();
  // echo the first category
  echo $cats[0]->cat_name;
  // echo the remaining categories, appending separator
  for ($i = 1; $i < count($cats); $i++) {echo ', ' . $cats[$i]->cat_name ;}
}

/**
 * Feature Image Resize
 */
function custom_feature_image( $thumb_size, $image_width, $image_height ) { 
  global $post; 
  $params = array( 'width' => $image_width, 'height' => $image_height );   
  $imgsrc = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID, '' ), $thumb_size );
  $custom_img_src = bfi_thumb( $imgsrc[0], $params );     
  return $custom_img_src;
}

/** SHORTCODES **/

/**
 * Marketo Social Sharing
 */
function marketo_share($atts, $content = null) {
  ob_start();
  ?>
  <div class="cf_widgetLoader cf_w_e136d060830c4c6c86672c9eb0182397"></div>
  <script type="text/javascript" src="//b2c-msm.marketo.com/jsloader/54782eb9-758c-41a0-baac-4a7ead980cba/loader.php.js"></script>
  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('marketo-share', __NAMESPACE__ . '\\marketo_share');

/**
 * Author Description
 */
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
add_shortcode('author-description', __NAMESPACE__ . '\\author_description');

/**
 * Newsletter Signup Forms
 */
function newsletter_sidebar ($atts, $content = null) {
  ob_start();
  ?>
  <div class="newsletter-sidebar newsletter-form marketo-form">
    <p><img src="/wp-content/themes/sage/dist/images/transform.jpg" class="img-responsive"></p>
    <h3>Subscribe to the Socrata newsletter</h3>
    <p>T R A N S F O R M, Socrata’s Newsletter, brings you essential news about open data, best practices for data-driven governments, and resources for successful implementation.</p>
    <script src="//app-abk.marketo.com/js/forms2/js/forms2.min.js"></script>
    <form id="mktoForm_2306"></form>
    <script>MktoForms2.loadForm("//app-abk.marketo.com", "851-SII-641", 2306);</script>
  </div>
  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('newsletter-sidebar', __NAMESPACE__ . '\\newsletter_sidebar');

/**
 * Marketo Form
 */
function marketo_form($atts) {
extract(shortcode_atts(array(
    "id" => '',
  ), $atts));
  return '
    <div class="marketo-form">
    <script src="//app-abk.marketo.com/js/forms2/js/forms2.min.js"></script>
    <form id="mktoForm_'.$id.'"></form>
    <script>MktoForms2.loadForm("//app-abk.marketo.com", "851-SII-641", '.$id.');</script>
    </div>
  ';
}
add_shortcode('marketo-form', __NAMESPACE__ . '\\marketo_form');

/**
 * Query for logos on Solutions Pages
 */
function solutions_logos( $atts ) {
  extract( shortcode_atts( array(
    'query' => ''
  ), $atts ) );
  $query = html_entity_decode( $query );
  ob_start(); 
  $the_query = new \WP_Query( $query );
  while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

  <div class="col-sm-2 solutions-logos">
    <div class="logo-frame text-center">
      <img src="<?php echo stories_logo_home( 'full', 100 ); ?>" class="img-responsive ">
    </div>
    <p class="text-center"><small><?php the_title();?></small></p>
  </div>

  <?php
  endwhile;
  wp_reset_postdata();
  $list = ob_get_clean();
  return $list;
}

add_shortcode( 'solutions-logos', __NAMESPACE__ . '\\solutions_logos' );

/**
 * Query for logos and abstract. Used on the homepage and product pages
 */
function customer_logos_abstract( $atts ) {
  extract( shortcode_atts( array(
    'query' => ''
  ), $atts ) );
  $query = html_entity_decode( $query );
  ob_start(); 
  $the_query = new \WP_Query( $query );
  while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

  <article>
    <div class="logo-frame text-center">
      <img src="<?php echo stories_logo_home( 'full', 100 ); ?>" class="img-responsive">
    </div>
    <div class="customer-text truncate">
      <h5><?php the_title(); ?></h5>
      <?php the_excerpt(); ?>
    </div>
    <ul>
      <li><a href="<?php the_permalink() ?>">Read More</a></li>
      <?php $meta = get_socrata_stories_meta(); if ($meta[2]) {echo "<li><a href='$meta[2]' target='_blank'>Visit Site</a></li>";} ?>
    </ul>
  </article>

  <?php
  endwhile;
  wp_reset_postdata();
  $list = ob_get_clean();
  return $list;
}

add_shortcode( 'customer-logos-abstract', __NAMESPACE__ . '\\customer_logos_abstract' );

