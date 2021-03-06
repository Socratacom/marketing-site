<?php

namespace Roots\Sage\Setup;

use Roots\Sage\Assets;

/**
 * Theme setup
 */
function setup() {
  // Enable features from Soil when plugin is activated
  // https://roots.io/plugins/soil/
  add_theme_support('soil-clean-up');
  add_theme_support('soil-nav-walker');
  add_theme_support('soil-nice-search');
  add_theme_support('soil-jquery-cdn');
  add_theme_support('soil-relative-urls');

  // Make theme available for translation
  // Community translations can be found at https://github.com/roots/sage-translations
  load_theme_textdomain('sage', get_template_directory() . '/lang');

  // Enable plugins to manage the document title
  // http://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
  add_theme_support('title-tag');

  // Register wp_nav_menu() menus
  // http://codex.wordpress.org/Function_Reference/register_nav_menus
  register_nav_menus([    
    'site_nav_solutions' => __('Site Nav Solutions', 'sage'),
    'site_nav_segments' => __('Site Nav Segments', 'sage'),
    'site_nav_why_socrata' => __('Site Nav Why Socrata', 'sage'),
    'site_nav_services' => __('Site Nav Services', 'sage'),
    'site_nav_resources' => __('Site Nav Resources', 'sage'),      
    'site_nav_resources_mobile' => __('Site Nav Resources Mobile', 'sage'),
    'site_nav_about' => __('Site Nav About', 'sage'),
    'site_nav_community' => __('Site Nav Community', 'sage'),
    'site_nav_popular_links' => __('Site Nav Popular Links', 'sage'),
    'product_nav_open_data' => __('Product Nav Open Data', 'sage'),
  ]);

  // Enable post thumbnails
  // http://codex.wordpress.org/Post_Thumbnails
  // http://codex.wordpress.org/Function_Reference/set_post_thumbnail_size
  // http://codex.wordpress.org/Function_Reference/add_image_size
  add_theme_support('post-thumbnails', array('post','socrata_events','case_study','news','socrata_webinars','guest-author','socrata_downloads'));
  set_post_thumbnail_size( 360, 180, array( 'center', 'center')  );
  add_image_size( 'post-image', 850, 400, array( 'center', 'center'));  
  add_image_size( 'post-image-small', 360, 200, array( 'center', 'center'));
  add_image_size( 'feature-image', 1600, 400, array( 'center', 'center'));
  add_image_size( 'full-width-ratio', 9999, 100 );

  // Enable post formats
  // http://codex.wordpress.org/Post_Formats
  add_theme_support('post-formats', ['aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio']);

  // Enable HTML5 markup support
  // http://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
  add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

  // Use main stylesheet for visual editor
  // To add custom styles edit /assets/styles/layouts/_tinymce.scss
  add_editor_style(Assets\asset_path('styles/main.css'));
}
add_action('after_setup_theme', __NAMESPACE__ . '\\setup');

/**
 * Register sidebars
 */
function widgets_init() {
  register_sidebar([
    'name'          => __('Primary', 'sage'),
    'id'            => 'sidebar-primary',
    'before_widget' => '<section class="widget %1$s %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>'
  ]);

  register_sidebar([
    'name'          => __('Footer', 'sage'),
    'id'            => 'sidebar-footer',
    'before_widget' => '<section class="widget %1$s %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>'
  ]);
}
add_action('widgets_init', __NAMESPACE__ . '\\widgets_init');

/**
 * Determine which pages should NOT display the sidebar
 */
function display_sidebar() {
  static $display;

  isset($display) || $display = !in_array(true, [
    // The sidebar will NOT be displayed if ANY of the following return true.
    // @link https://codex.wordpress.org/Conditional_Tags
    is_404(),
    is_front_page(),
    is_home(),
    is_page(),
    is_archive(),
    is_single(),
    is_page_template('template-custom.php'),
  ]);

  return apply_filters('sage/display_sidebar', $display);
}

/**
 * Theme assets
 */
function assets() {
  wp_enqueue_style('sage/css', Assets\asset_path('styles/main.css'), '', '3.7');
  wp_register_style( 'google-fonts', 'https://fonts.googleapis.com/css?family=Open+Sans:400,700,300,600', false, null);
  wp_enqueue_style('google-fonts');

  if (is_single() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }

  wp_enqueue_script('sage/js', Assets\asset_path('scripts/main.js'), ['jquery'], null, true);  
  wp_enqueue_script('ytplayer', Assets\asset_path('scripts/ytplayer.js'), null, true);
  wp_register_script('marketoforms', '//app-abk.marketo.com/js/forms2/js/forms2.min.js', null, true);
  wp_enqueue_script('marketoforms');
  wp_register_script('addthis', '//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-553f9bc9354d386b', null, true);
  wp_enqueue_script('addthis');
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\assets', 100);
