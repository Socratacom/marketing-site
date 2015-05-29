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

// PAGINATION USING "WP PAGENAVI" PLUGIN
remove_action('thesis_hook_after_content', 'thesis_post_navigation');
add_action('thesis_hook_after_content', 'page_numbers');
function page_numbers() {
    if(function_exists('wp_pagenavi')) { 
        wp_pagenavi();
        } 
}

// REMOVE HEADLINE AREA ON PAGES
add_filter('thesis_show_headline_area', 'no_headline');
function no_headline() { 
	if (is_page() || is_home() ) 
	return false; 
	else 
	return true; 
}

// Add support for HTML5 
function html5_doctype($content) {
  return '<!DOCTYPE html>';
}
add_filter('thesis_doctype', 'html5_doctype');

function html5_profile_removal($content) {
  return '';
}
add_filter('thesis_head_profile', 'html5_profile_removal');

// Gravity Forms Alert
add_filter( 'gform_validation_message', 'sw_gf_validation_message', 10, 2 );
function sw_gf_validation_message( $validation_message ) {
  add_action( 'wp_footer', 'sw_gf_js_error' );
}
function sw_gf_js_error() { ?>
  <script type="text/javascript">
    alert( "Oops, you must have forgotten something...fields marked in RED are required! Please check your form." );
  </script>
<?php }

/* Custom 404 Page */
remove_action('thesis_hook_404_title', 'thesis_404_title');
add_action('thesis_hook_404_title', 'custom_thesis_404_title');
function custom_thesis_404_title() {?>
  Ouch! Something went wrong.
<?
}

remove_action('thesis_hook_404_content', 'thesis_404_content');
add_action('thesis_hook_404_content', 'custom_thesis_404_content');
function custom_thesis_404_content() {?>
<style type="text/css">
#sidebars, .wp-pagenavi, #page .menu {display:none;}
#content {width:100%; text-align:center;}
</style>
<p>The page you are looking for is no longer available or has moved.</p>
<p>You may want to try again or start from our <a href="http://www.socrata.com">home page</a>.</p>
<?
}

//Find the caption for feature image
function the_post_thumbnail_caption_from_id($post_id) {
  $thumbnail_id    = get_post_thumbnail_id($post_id);
  $thumbnail_image = get_posts(array('p' => $thumbnail_id, 'post_type' => 'attachment'));
  if ($thumbnail_image && isset($thumbnail_image[0])) {
    echo ($thumbnail_image[0]->post_excerpt);
  }
}

// Remove all Thesis metaboxes
add_action('admin_init', 'remove_thesis_post_boxes');

function remove_thesis_post_boxes() {
    $post_options = new thesis_post_options;
    $post_options->meta_boxes();
    foreach ($post_options->meta_boxes as $meta_name => $meta_box) {
        remove_meta_box($meta_box['id'], 'post', 'normal');
        remove_meta_box($meta_box['id'], 'page', 'normal');
    }
}