<?php
/*
Plugin Name: Socrata Open Data Field Guide
Plugin URI: http://socrata.com/
Description: This plugin manages the Open Data Field Guide.
Version: 1.0
Author: Michael Church
Author URI: http://socrata.com/
License: GPLv2
*/
include_once("guide_meta-boxes.php");

add_action( 'init', 'create_guide' );
function create_guide() {
  register_post_type( 'guide',
    array(
      'labels' => array(
        'name' => 'ODFG',
        'singular_name' => 'ODFG',
        'add_new' => 'Add New Chapter',
        'add_new_item' => 'Add New Chapter',
        'edit' => 'Edit Chapter',
        'edit_item' => 'Edit Chapter',
        'new_item' => 'New Chapter',
        'view' => 'View',
        'view_item' => 'View Chapter',
        'search_items' => 'Search Chapters',
        'not_found' => 'Not found',
        'not_found_in_trash' => 'Not found in Trash'
      ),
      'public' => true,
      'menu_position' => 100,
      'supports' => array( 'title', 'editor', 'revisions' ),
      'taxonomies' => array( '' ),
      'menu_icon' => '',
      'has_archive' => true,
      'rewrite' => array('with_front' => false, 'slug' => 'open-data-field-guide-chapter')
    )
  );
}

// MENU ICON
//Using Dashicon Font http://melchoyce.github.io/dashicons/
add_action( 'admin_head', 'add_guide_icon' );
function add_guide_icon(){ ?>
  <style>
    #adminmenu .menu-icon-guide div.wp-menu-image:before {
      content: '\f331';
    }
  </style>
<?php
}

// Custom Columns for admin management page
add_filter( 'manage_edit-guide_columns', 'guide_columns' ) ;
function guide_columns( $columns ) {
  $columns = array(
    'cb' => '<input type="checkbox" />',
    'title' => __( 'Chapter' )
  );
  return $columns;
}

// REGISTER MENUS
add_action( 'init', 'register_odfg_menu' );
function register_odfg_menu() {
  register_nav_menus(
    array(
        'field_guide' => __( 'Field Guide' )
    )
  );
}


// ENQEUE SCRIPTS
function guide_script_loading() {
  if ( 'guide' == get_post_type() && is_single() || 'guide' == get_post_type() && is_archive() || is_page('open-data-field-guide') ) {
    wp_register_style( 'odfg_styles', plugins_url( 'css/styles.css' , __FILE__ ), false, null );
    wp_enqueue_style( 'odfg_styles' );    
  } 
}
add_action('wp_enqueue_scripts', 'guide_script_loading');

// Template Paths
add_filter( 'template_include', 'guide_single_template', 1 );
function guide_single_template( $template_path ) {
  if ( get_post_type() == 'guide' ) {
    if ( is_single() ) {
      // checks if the file exists in the theme first,
      // otherwise serve the file from the plugin
      if ( $theme_file = locate_template( array ( 'single-guide.php' ) ) ) {
        $template_path = $theme_file;
      } else {
        $template_path = plugin_dir_path( __FILE__ ) . 'single-guide.php';
      }
    }
    if ( is_archive() ) {
      // checks if the file exists in the theme first,
      // otherwise serve the file from the plugin
      if ( $theme_file = locate_template( array ( 'archive-guide.php' ) ) ) {
        $template_path = $theme_file;
      } else {
        $template_path = plugin_dir_path( __FILE__ ) . 'archive-guide.php';
      }
    }
  }
  return $template_path;
}

// Custom Body Class
add_action( 'body_class', 'field_guide_body_class');
function field_guide_body_class( $classes ) {
  if ( is_page('open-data-field-guide') || get_post_type() == 'guide' && is_single() )
    $classes[] = 'guide';
  return $classes;
}

