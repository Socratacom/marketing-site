<?php

// HIDE ADMIN BAR
show_admin_bar(FALSE);

// REMOVE WORDPRESS VERSION NUMBER
remove_action('wp_head', 'wp_generator');

// REMOVE THESIS CUSTOM TEMPLATE ACTION
remove_action('thesis_hook_custom_template', 'thesis_custom_template_sample'); 

// REMOVE THESIS ATTRIBUTION
remove_action('thesis_hook_footer', 'thesis_attribution');

// REMOVE THESIS ADMIN LINK
remove_action('thesis_hook_footer', 'thesis_admin_link');

// REMOVE THESIS MENU
remove_action('thesis_hook_before_header', 'thesis_nav_menu');

// REMOVE THESIS DEFAULT HEADER
add_filter('thesis_show_header', 'no_header');
function no_header() {
    if (is_page() || is_home())
    return false;
    else
    return true;
}

// CUSTOM LOGO ON LOGIN SCREEN
add_action('login_head',  'my_custom_login_logo');
function my_custom_login_logo() {
	echo '<style type="text/css">h1 a {background-image:url('.get_stylesheet_directory_uri().'/custom/images/admin-logo.png) !important; background-size:274px 63px !important; height:63px !important; width:274px !important;} </style>';
}

// CUSTOM LOGO ON LOGIN SCREEN LINK
add_filter('login_headerurl', create_function(false, "return 'http://socrata.com';"));

// CUSTOM LOGO ON LOGIN SCREEN ALT TEXT
add_filter('login_headertitle', create_function(false, "return 'Socrata';"));

// REMOVE META BOXES FROM WORDPRESS DASHBOARD FOR ALL USERS
add_action('wp_dashboard_setup', 'example_remove_dashboard_widgets' );
function example_remove_dashboard_widgets() {
  global $wp_meta_boxes;	
	 unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
	 unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
	 unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
}

// DISABLE AUTO SAVE
add_action( 'wp_print_scripts', 'disableAutoSave' );
function disableAutoSave(){
  wp_deregister_script('autosave');
}