<?php
/*
Plugin Name: Socrata Open Innovation Magazine
Plugin URI: http://fishinglounge.com/
Description: This plugin enables you to easily add and manage the Open Innovation Magazine.
Version: 1.0
Author: Michael Church
Author URI: http://fishinglounge.com/
License: GPLv2
*/
include_once('metaboxes/meta_box.php');
include_once('inc/fields.php');

// REGISTER POST TYPE
add_action( 'init', 'create_oi_magazine' );

function create_oi_magazine() {
  register_post_type( 'oi_magazine',
    array(
      'labels' => array(
        'name' => 'OI Magazine',
        'singular_name' => 'OI Magazine',
        'add_new' => 'Add New Issue',
        'add_new_item' => 'Add New Issue',
        'edit' => 'Edit Issue',
        'edit_item' => 'Edit Issue',
        'new_item' => 'New Issue',
        'view' => 'View',
        'view_item' => 'View Issue',
        'search_items' => 'Search Issues',
        'not_found' => 'Not found',
        'not_found_in_trash' => 'Not found in Trash',
        'parent' => 'Parent Magazine'
      ),
      'public' => true,
      'menu_position' => 100,
      'supports' => array( 'title', 'thumbnail', 'revisions' ),
      'taxonomies' => array( '' ),
      'menu_icon' => plugins_url( 'images/image.png', __FILE__ ),
      'has_archive' => true,
      'rewrite' => array('with_front' => false, 'slug' => 'issue')
    )
  );
}

// ADD STYLESHEET TO PAGE
add_action( 'init', 'register_magazine_scripts', 0 ); 
function register_magazine_scripts() {
    wp_register_style( 'magazine_styles', plugins_url( 'css/styles.css' , __FILE__ ), false, null );
    wp_register_script( 'magazine_sf', plugins_url( 'js/smartform.js' , __FILE__ ), false, null, true );
}

add_action( 'wp_enqueue_scripts', 'magazine_script_loading' );
function magazine_script_loading() {
    if (is_page('open-innovation-magazine') || 'oi_magazine' == get_post_type() && is_single()) {
    wp_enqueue_style( 'magazine_styles' );
  }
}

add_action( 'wp_enqueue_scripts', 'magazine_single_script_loading' );
function magazine_single_script_loading() {
    if ('oi_magazine' == get_post_type() && is_single()) {
    wp_enqueue_script( 'magazine_sf' );
  }
}




// BODY CLASSES FOR STYLING
add_filter('thesis_body_classes', 'magazine_styling');
function magazine_styling($classes) {
  if (is_page('open-innovation-magazine') || get_post_type() == 'oi_magazine' && is_single()) { 
    $classes[] = 'magazine'; 
  }
  return $classes; 
}
add_filter('thesis_body_classes', 'magazine_single_styling');
function magazine_single_styling($classes) {
  if (get_post_type() == 'oi_magazine' && is_single()) { 
    $classes[] = 'single'; 
  }
  return $classes; 
}

// FLUSH REWRITE RULES
function oi_magazine_activate() {
  // register taxonomies/post types here
  flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'oi_magazine_activate' );

function oi_magazine_deactivate() {
  flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'oi_magazine_deactivate' );

// SHORTCODE FOR MAGAZINE
// [all-magazine-issues]
add_shortcode('all-magazine-issues','all_magazine_issues');
function all_magazine_issues( $atts ) {
  ob_start();
  extract( shortcode_atts( array (
    'type' => 'oi_magazine',
    'order' => 'date',
    'orderby' => 'desc',
    'posts' => 100,
  ), $atts ) );
  $options = array(
    'post_type' => $type,
    'order' => $order,
    'orderby' => $orderby,
    'posts_per_page' => $posts,
  );
  $query = new WP_Query( $options );
  if ( $query->have_posts() ) { ?>  
  <?php
    $count = 0;
    while ($query->have_posts()) : $query->the_post();
    $count++;
    $fourth_div = ($count%4 == 0) ? 'last' : '';
    $fourth_div_clear = ($count%4 == 0) ? '<div class="clearboth"></div>' : '';
    ?>
  <div class="one_fourth <?php echo $fourth_div; ?> issue-landing">
    <a href="<?php the_permalink() ?>"><img src="<?php echo tuts_custom_img('full', 282);?>" class="magazine-thumb img-responsive"></a>
    <h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
    <p><strong>IN THIS ISSUE:</strong> <?php $meta = get_socrata_magazine_meta(); if ($meta[0]) {echo "$meta[0]";} ?><?php $meta = get_socrata_magazine_meta(); if ($meta[1]) {echo ", $meta[1]";} ?><?php $meta = get_socrata_magazine_meta(); if ($meta[2]) {echo ", $meta[2]";} ?><?php $meta = get_socrata_magazine_meta(); if ($meta[3]) {echo ", $meta[3]";} ?><?php $meta = get_socrata_magazine_meta(); if ($meta[4]) {echo ", $meta[4]";} ?><?php $meta = get_socrata_magazine_meta(); if ($meta[5]) {echo ", $meta[5]";} ?></p>
  </div>
  <?php echo $fourth_div_clear; ?>
  <?php endwhile;?>
  <?php wp_reset_postdata(); ?>
  <?php $myvariable = ob_get_clean();
  return $myvariable;
  } 
}

