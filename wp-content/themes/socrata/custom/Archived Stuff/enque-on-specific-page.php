<?php



// Adding scripts and styles for Home Page Promotion 01-31-14

function child_home_add_scripts() {
    wp_register_script('load', get_stylesheet_directory_uri() . '/custom/scripts/smartform.js',  false, '1.0', true );
    wp_enqueue_script( 'load' );
    wp_register_style('component', get_stylesheet_directory_uri() . '/custom/css/load.css',  false, '1.0', false );
    if ( is_page('home-promotion')) wp_enqueue_style( 'component' );
}
add_action( 'wp_enqueue_scripts', 'child_home_add_scripts' );








