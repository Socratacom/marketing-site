<?php
/*
Plugin Name: Socrata Open Performance Guide
Plugin URI: http://socrata.com/
Description: This plugin manages the Socrata Open Performance Guide.
Version: 1.0
Author: Michael Church
Author URI: http://socrata.com/
License: GPLv2
*/

add_action( 'init', 'create_socrata_opg' );
function create_socrata_opg() {
  register_post_type( 'socrata_opg',
    array(
      'labels' => array(
        'name' => 'OPG',
        'singular_name' => 'OPG',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New',
        'edit' => 'Edit',
        'edit_item' => 'Edit',
        'new_item' => 'New',
        'view' => 'View',
        'view_item' => 'View',
        'search_items' => 'Search',
        'not_found' => 'Not found',
        'not_found_in_trash' => 'Not found in Trash'
      ),
      'public' => true,
      'menu_position' => 100,
      'supports' => array( 'title', 'editor', 'revisions' ),
      'taxonomies' => array( '' ),
      'menu_icon' => '',
      'has_archive' => false,
      'rewrite' => array('with_front' => false, 'slug' => 'open-performance-guide')
    )
  );
}

// MENU ICON
//Using Dashicon Font https://developer.wordpress.org/resource/dashicons
add_action( 'admin_head', 'add_socrata_opg_icon' );
function add_socrata_opg_icon() { ?>
  <style>
    #adminmenu .menu-icon-socrata_opg div.wp-menu-image:before {
      content: '\f331';
    }
  </style>
  <?php
}

// TAXONOMIES
add_action( 'init', 'socrata_opg_cat', 0 );
function socrata_opg_cat() {
  register_taxonomy(
    'socrata_opg_cat',
    'socrata_opg',
    array(
      'labels' => array(
        'name' => 'Category',
        'menu_name' => 'Category',
        'add_new_item' => 'Add New Category',
        'new_item_name' => "New Category"
      ),
      'show_ui' => true,
      'show_tagcloud' => false,
      'hierarchical' => true,
    )
  );
}

// Custom Columns for admin management page
add_filter( 'manage_edit-socrata_opg_columns', 'opg_columns' ) ;
function opg_columns( $columns ) {
  $columns = array(
    'cb'              => '<input type="checkbox" />',
    'title'           => __( 'Title' ),
    'category'        => __( 'Category' ),
    'wpseo-score'     => __( 'SEO' ),
  );
  return $columns;
}

add_action( 'manage_socrata_opg_posts_custom_column', 'opg_custom_columns', 10, 2 );
function opg_custom_columns( $column, $post_id ) {
  global $post;
  switch ($column) {
    case 'category':
      $category = get_the_terms($post->ID , 'socrata_opg_cat');
      echo $category[0]->name;
      for ($i = 1; $i < count($category); $i++) {echo ', ' . $category[$i]->name ;}
      break;
  }
}

// REGISTER MENUS
add_action( 'init', 'register_opg_menu' );
function register_opg_menu() {
  register_nav_menus(
    array(
        'open_performance_guide' => __( 'Open Performance Guide' )
    )
  );
}

// Template Paths
add_filter( 'template_include', 'socrata_opg_single_template', 1 );
function socrata_opg_single_template( $template_path ) {
  if ( get_post_type() == 'socrata_opg' ) {
    if ( is_single() ) {
      // checks if the file exists in the theme first,
      // otherwise serve the file from the plugin
      if ( $theme_file = locate_template( array ( 'single-open-performance.php' ) ) ) {
        $template_path = $theme_file;
      } else {
        $template_path = plugin_dir_path( __FILE__ ) . 'single-open-performance.php';
      }
    }
  }
  return $template_path;
}

// Custom Body Class
add_action( 'body_class', 'socrata_opg_body_class');
function socrata_opg_body_class( $classes ) {
  if ( get_post_type() == 'socrata_opg' && is_single() || get_post_type() == 'socrata_opg' && is_archive() )
    $classes[] = 'open-performance-guide';
  return $classes;
}

// Shortcode [current-opg]
function opg_posts($atts, $content = null) {
  ob_start();
  ?>
<section class="section-padding">

</section>
  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('current-opg', 'opg_posts');