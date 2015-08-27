<?php

// Enqueue Scripts
add_action('wp_enqueue_scripts', 'my_scripts_method');
function my_scripts_method() {
  wp_deregister_script( 'jquery' );
  wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js', false, null, false);
  wp_enqueue_script( 'jquery' );
  wp_register_style( 'sssocial', get_stylesheet_directory_uri() . '/custom/fonts/ss-social-regular/webfonts/ss-social-regular.css', false, null );
  wp_enqueue_style( 'sssocial' );
  wp_register_style( 'sspika', get_stylesheet_directory_uri() . '/custom/fonts/ss-pika/webfonts/ss-pika.css', false, null );  
  wp_enqueue_style( 'sspika' );
  wp_register_script( 'modernizr', get_stylesheet_directory_uri() . '/custom/scripts/modernizr.custom.js', false, null, true);
  wp_enqueue_script( 'modernizr' );
  wp_register_script( 'megaMenu', get_stylesheet_directory_uri() . '/custom/scripts/jquery-accessibleMegaMenu.js', false, null, true);
  wp_enqueue_script( 'megaMenu' );
  wp_register_script( 'classie', get_stylesheet_directory_uri() . '/custom/scripts/classie.js', false, null, true);
  wp_enqueue_script( 'classie' );
  wp_register_script( 'uisearch', get_stylesheet_directory_uri() . '/custom/scripts/uisearch.js', false, null, true);
  wp_enqueue_script( 'uisearch' );
  wp_register_script( 'gnmenu', get_stylesheet_directory_uri() . '/custom/scripts/gnmenu.js', false, null, true);
  wp_enqueue_script( 'gnmenu' );
  wp_register_script( 'smartform_script_two', get_stylesheet_directory_uri() . '/custom/scripts/smartform_conflict.js', false, null, true);
  wp_register_script( 'smartform_script_three', 'http://d12ulf131zb0yj.cloudfront.net/SmartForms3-0/SmartForms.js', false, null, true);
  wp_register_script( 'smartform_script_four', get_stylesheet_directory_uri() . '/custom/scripts/smartform.js', false, null, true);
  wp_register_script( 'addthisfire', get_stylesheet_directory_uri() . '/custom/scripts/addthisfire.js', false, null, true);   
  wp_register_script( 'modal', get_stylesheet_directory_uri() . '/custom/scripts/jquery.reveal.js', false, null, true);
  wp_register_style( 'google-fonts', 'http://fonts.googleapis.com/css?family=Open+Sans:400,300,600', false, null);
  wp_enqueue_style('google-fonts');
  wp_register_script( 'accordion-script', get_stylesheet_directory_uri() . '/custom/scripts/jquery.accordion.js', false, null, true);
  wp_register_style( 'accordion-styles', get_stylesheet_directory_uri() . '/custom/css/accordion.css', false, null );
  wp_register_script( 'tab-script', get_stylesheet_directory_uri() . '/custom/scripts/cbpFWTabs.js', false, null, true);
  wp_register_style( 'tab-styles', get_stylesheet_directory_uri() . '/custom/css/tabs.css', false, null );
  wp_register_script( 'jumplinks', get_stylesheet_directory_uri() . '/custom/scripts/jumplinks.js', false, null, true);
  wp_register_style( 'fontawesome', 'http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css', false, null);
  wp_enqueue_style('fontawesome');
}

// Bootstrap Enqueue. This is temporary till whole site retrofit
add_action('wp_enqueue_scripts', 'bootstrap_scripts');
function bootstrap_scripts() {
  if (is_single() || is_page('home')) {
    wp_register_style( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css', false, null);
    wp_enqueue_style('bootstrap');
  }
}

// Recipe Fonts. This is used for Recipes for Civic Success section
add_action('wp_enqueue_scripts', 'recipe_fonts');
function special_fonts() {
  if (is_single()) {
    wp_register_style( 'recipe-fonts', 'http://fonts.googleapis.com/css?family=Indie+Flower', false, null);
    wp_enqueue_style('recipe-fonts');
  }
}

// Rethink Page
add_action('wp_enqueue_scripts', 'rethink_scripts');
function rethink_scripts() {
  if (is_page('rethink')) {
    wp_register_style( 'rethink-styles', get_stylesheet_directory_uri() . '/custom/rethink/css/styles.css', false, null );
    wp_enqueue_style( 'rethink-styles' );
    wp_register_script( 'wistia-popover', '//fast.wistia.com/assets/external/popover-v1.js', false, null, true);
    wp_enqueue_script('wistia-popover');
    wp_register_script( 'jumplinks', get_stylesheet_directory_uri() . '/custom/rethink/js/jumplinks.js', false, null, true );
    wp_enqueue_script( 'jumplinks' );
  }
}

// Data as a Utility Page
add_action('wp_enqueue_scripts', 'dau_scripts');
function dau_scripts() {
  if (is_page('data-as-a-utility')) {
    wp_register_style( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css', false, null);
    wp_enqueue_style('bootstrap');
    wp_register_style( 'dau-styles', get_stylesheet_directory_uri() . '/custom/data-as-utility/css/styles.css', false, null );
    wp_enqueue_style( 'dau-styles' );
    wp_register_style( 'slick-styles', get_stylesheet_directory_uri() . '/custom/data-as-utility/css/slick.css', false, null );
    wp_enqueue_style( 'slick-styles' );
    wp_register_script( 'smooth-scroll', get_stylesheet_directory_uri() . '/custom/data-as-utility/js/smooth-scroll.js', false, null, true);
    wp_enqueue_script('smooth-scroll');
    wp_register_script('wistiaExternal', 'https://fast.wistia.com/assets/external/E-v1.js', false, null, false);
    wp_enqueue_script('wistiaExternal');
    wp_register_script('wistiaCropFill', 'https://fast.wistia.com/labs/crop-fill/plugin.js', false, null, false);
    wp_enqueue_script('wistiaCropFill');
    wp_register_script( 'dau-video', get_stylesheet_directory_uri() . '/custom/data-as-utility/js/video.js', false, null, true);
    wp_enqueue_script('dau-video');
    wp_register_script( 'slick', get_stylesheet_directory_uri() . '/custom/data-as-utility/js/slick.min.js', false, null, true);
    wp_enqueue_script('slick');
    wp_register_script( 'slick-initialize', get_stylesheet_directory_uri() . '/custom/data-as-utility/js/slick-initialize.js', false, null, true);
    wp_enqueue_script('slick-initialize');
  }
}

// Data as a Utility Page
add_action('wp_enqueue_scripts', 'deploying_tomorrows_technology_scripts');
function deploying_tomorrows_technology_scripts() {
  if (is_page('deploying-tomorrows-technology-today')) {
    wp_register_style( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css', false, null);
    wp_enqueue_style('bootstrap');
    wp_register_style( 'deploying-technology-styles', get_stylesheet_directory_uri() . '/custom/deploying-tomorrows-technology-today/css/styles.css', false, null );
    wp_enqueue_style( 'deploying-technology-styles' );
  }
}

