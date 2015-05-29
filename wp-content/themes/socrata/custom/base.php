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

// Image Sizes */
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 100, 100, false );
add_image_size( 'small', 200 );
add_image_size( 'medium-thumb', 350 );

// Adding Image Size Selecto Options in UI
add_filter( 'image_size_names_choose', 'custom_image_sizes_choose' );
function custom_image_sizes_choose( $sizes ) {
  $custom_sizes = array(
    'feature-image' => 'Screen Shot'
  );
  return array_merge( $sizes, $custom_sizes );
}

// Adding New On-the-fly Image resizing
function tuts_custom_img( $thumb_size, $image_width, $image_height, $grayscale ) {
 
  global $post;
 
  $params = array( 'width' => $image_width, 'height' => $image_height, 'grayscale' => $grayscale);
   
  $imgsrc = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID, '' ), $thumb_size );
  $custom_img_src = bfi_thumb( $imgsrc[0], $params );
     
  return $custom_img_src;
   
}

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

  /*wp_register_script( 'smartform_script_one', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js', true );*/

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
}

add_filter( 'avatar_defaults', 'new_custom_default_gravatar' );
function new_custom_default_gravatar ($avatar_defaults) {
$myavatar = get_stylesheet_directory_uri() . '/custom/images/socrata-gravatar.png';
$avatar_defaults[$myavatar] = "Custom Default Gravatar";
return $avatar_defaults;
}

// Search Results Filter 

add_theme_support( 'html5', array( 'search-form' ) );

function my_facetwp_result_count( $output, $params ) {
    $output = $params['lower'] . '-' . $params['upper'] . ' of ' . $params['total'] . ' results';
    return $output;
}

add_filter( 'facetwp_result_count', 'my_facetwp_result_count', 10, 2 );

register_sidebar(array(
  'name' => 'Shared Sidebar',
  'id' => 'shared',
  'before_title'=>'<h3>',
  'after_title'=>'</h3>'
  ));