<?php
/*
Plugin Name: Socrata Open Data Directory
Plugin URI: http://socrata.com/
Description: This is a directory of Open Data sites broken down by Federal, State, and Cities.
Version: 1.0
Author: Michael Church
Author URI: http://socrata.com/
License: GPLv2
*/

add_action( 'init', 'create_od_directory' );
function create_od_directory() {
  register_post_type( 'od_directory',
    array(
      'labels' => array(
        'name' => 'OD Directory',
        'singular_name' => 'OD Directory',
        'add_new' => 'Add New Listing',
        'add_new_item' => 'Add New Listing',
        'edit' => 'Edit Listing',
        'edit_item' => 'Edit Listing',
        'new_item' => 'New Listing',
        'view' => 'View',
        'view_item' => 'View Listing',
        'search_items' => 'Search Listings',
        'not_found' => 'Not found',
        'not_found_in_trash' => 'Not found in Trash'
      ),
      'public' => true,
      'menu_position' => 100,
      'supports' => array( 'title', 'thumbnail' ),
      'taxonomies' => array( '' ),
      'menu_icon' => '',
      'has_archive' => false,
      'rewrite' => array('with_front' => false, 'slug' => 'open-data-directory')
    )
  );
}

// MENU ICON
//Using Dashicon Font https://developer.wordpress.org/resource/dashicons
add_action( 'admin_head', 'add_od_directory_icon' );
function add_od_directory_icon() { ?>
  <style>
    #adminmenu .menu-icon-od_directory div.wp-menu-image:before {
      content: '\f337';
    }
  </style>
  <?php
}

/*
// CUSTOM COLUMS FOR ADMIN
add_filter( 'manage_edit-od_directory_columns', 'od_directory_edit_columns' ) ;
function od_directory_edit_columns( $columns ) {
  $columns = array(
    'cb'          => '<input type="checkbox" />',    
    'title'       => __( 'Name' ),
    'category'    => __( 'Category' ),
    'eventdate'   => __( 'Event Date' ),

  );
  return $columns;
}
// Get Content for Custom Colums
add_action("manage_od_directory_posts_custom_column",  "od_directory_columns");
function od_directory_columns($column){
  global $post;

  switch ($column) {    
    case 'eventdate':
      $timestamp = rwmb_meta( 'od_directory_starttime' ); echo date("F j, Y, g:i a", $timestamp);
      break;
    case 'category':
      $segment = get_the_terms($post->ID , 'od_directory_cat');
      echo $segment[0]->name;
      for ($i = 1; $i < count($segment); $i++) {echo ', ' . $segment[$i]->name ;}
      break;
  }
}

// Make these columns sortable
add_filter( "manage_edit-od_directory_sortable_columns", "od_directory_sortable_columns" );
function od_directory_sortable_columns() {
  return array(
    'title'       => 'title',
    'category'    => 'category',
    'eventdate'   => 'eventdate',
  );
}

*/

// TAXONOMIES
add_action( 'init', 'od_directory_cat', 0 );
function od_directory_cat() {
  register_taxonomy(
    'od_directory_cat',
    'od_directory',
    array(
      'labels' => array(
        'name' => 'Region',
        'menu_name' => 'Region',
        'add_new_item' => 'Add New Region',
        'new_item_name' => "New Region"
      ),
      'show_ui' => true,
      'show_tagcloud' => false,
      'hierarchical' => true,
      'sort' => true,      
      'args' => array( 'orderby' => 'term_order' ),
      'show_admin_column' => true,
      'rewrite' => array('with_front' => false, 'slug' => 'directory-region'),
    )
  );
}

// Template Paths
add_filter( 'template_include', 'od_directory_single_template', 1 );
function od_directory_single_template( $template_path ) {
  if ( get_post_type() == 'od_directory' ) {
    if ( is_single() ) {
      // checks if the file exists in the theme first,
      // otherwise serve the file from the plugin
      if ( $theme_file = locate_template( array ( 'single-directory.php' ) ) ) {
        $template_path = $theme_file;
      } else {
        $template_path = plugin_dir_path( __FILE__ ) . 'single-directory.php';
      }
    }
  }
  return $template_path;
}

// Print Taxonomy Categories
function od_directory_the_categories() {
  // get all categories for this post
  global $terms;
  $terms = get_the_terms($post->ID , 'od_directory_cat');
  // echo the first category
  echo $terms[0]->name;
  // echo the remaining categories, appending separator
  for ($i = 1; $i < count($terms); $i++) {echo ', ' . $terms[$i]->name ;}
}

// Custom Body Class
add_action( 'body_class', 'od_directory_body_class');
function od_directory_body_class( $classes ) {
  if ( get_post_type() == 'od_directory' && is_single() || get_post_type() == 'od_directory' && is_archive() )
    $classes[] = 'od-directory';
  return $classes;
}

// Fixes JS when Yoast enabled and thumbnail disabled
add_action( 'admin_enqueue_scripts', 'od_directory_box_scripts' );
function od_directory_box_scripts() {
    global $post;
    wp_enqueue_media( array( 
        'post' => $post->ID, 
    ) );
}

// Metabox
add_filter( 'rwmb_meta_boxes', 'od_directory_register_meta_boxes' );
function od_directory_register_meta_boxes( $meta_boxes )
{
  $prefix = 'od_directory_';
  $meta_boxes[] = array(
    'title'  => __( 'Listing Details', 'od-directory' ),
    'post_types' => array( 'od_directory' ),
    'context'    => 'normal',
    'priority'   => 'high',
    'fields' => array(
      // HEADING
      array(
        'type' => 'heading',
        'name' => __( 'Customer Details', 'od-directory' ),
        'id'   => 'fake_id', // Not used but needed for plugin
      ),
    // RADIO BUTTONS
      array(
        'name'    => __( 'Is this a Socrata customer?', 'od-directory' ),
        'id'      => "{$prefix}radio",
        'type'    => 'radio',
        // Array of 'value' => 'Label' pairs for radio options.
        // Note: the 'value' is stored in meta field, not the 'Label'
        'options' => array(
          'value1' => __( 'Yes', 'od-directory' ),
          'value2' => __( 'No', 'od-directory' ),
        ),
      ),
      // TEXT
      array(
        // Field name - Will be used as label
        'name'  => __( 'Sites', 'your-prefix' ),
        // Field ID, i.e. the meta key
        'id'    => "{$prefix}text",
        // Field description (optional)
        'desc'  => __( 'Text description', 'your-prefix' ),
        'type'  => 'text',
        // Default value (optional)
        'std'   => __( 'Default text value', 'your-prefix' ),
        // CLONES: Add to make the field cloneable (i.e. have multiple value)
        'clone' => true,
      ),
      // URL
      array(
        'name' => __( 'URL', 'your-prefix' ),
        'id'   => "{$prefix}url",
        'desc' => __( 'URL description', 'your-prefix' ),
        'type' => 'url',
        'std'  => 'http://google.com',
        'clone' => true,
      ),
      // HEADING
      array(
        'type' => 'heading',
        'name' => __( 'Data Details', 'od-directory' ),
        'id'   => 'fake_id', // Not used but needed for plugin
      ),
      // CHECKBOX LIST
      array(
        'name'    => __( 'Data Types', 'od-directory' ),
        'id'      => "{$prefix}checkbox_list",
        'type'    => 'checkbox_list',
        // Options of checkboxes, in format 'value' => 'Label'
        'options' => array(
          'asset_disclosure' => __( 'Asset Disclosure', 'od-directory' ),
          'business_listings' => __( 'Business Listings', 'od-directory' ),
          'campaign_finance' => __( 'Campaign Finance', 'od-directory' ),
          'code_enforcement' => __( 'Code Enforcement', 'od-directory' ),
          'construction_permits' => __( 'Construction Permits', 'od-directory' ),
          'crime_police' => __( 'Crime & Police', 'od-directory' ),
          'loby_activity' => __( 'Loby Activity', 'od-directory' ),
          'parcels' => __( 'Parcels', 'od-directory' ),
          'payroll' => __( 'Payroll', 'od-directory' ),
          'procurement_contracts' => __( 'Procurement Contracts', 'od-directory' ),
          'property_assesments' => __( 'Property Assesments', 'od-directory' ),
          'property_deeds' => __( 'Property Deeds', 'od-directory' ),
          'public_buildings' => __( 'Public Buildings', 'od-directory' ),          
          'restaurant_inspections' => __( 'Restaurant Inspections', 'od-directory' ),
          'service_requests' => __( 'Service Requests (311)', 'od-directory' ),
          'spending' => __( 'Spending', 'od-directory' ),          
          'transit' => __( 'Transit', 'od-directory' ),
          'zoning' => __( 'Zoning', 'od-directory' ),
        ),
      ),
      // HEADING
      array(
        'type' => 'heading',
        'name' => __( 'Event Date and Time', 'od-directory' ),
        'id'   => 'fake_id', // Not used but needed for plugin
      ),
      // TEXT
      array(
        'name'  => __( 'Display Date and Time', 'od-directory' ),
        'id'    => "{$prefix}displaydate",
        'desc' => __( 'Example: Jan 1st - 2:00pm PST', 'od-directory' ),
        'type'  => 'text',
        'clone' => false,
      ),
      // HEADING
      array(
        'type' => 'heading',
        'name' => __( 'Event Location', 'od-directory' ),
        'id'   => 'fake_id', // Not used but needed for plugin
      ),
      // TEXT
      array(
        'name'  => __( 'Location Name', 'od-directory' ),
        'id'    => "{$prefix}location",
        'desc' => __( 'Example: Hometown Pub', 'od-directory' ),
        'type'  => 'text',
        'clone' => false,
      ),
      // TEXT
      array(
        'name'  => __( 'Street Address', 'od-directory' ),
        'id'    => "{$prefix}address",
        'type'  => 'text',
        'clone' => false,
      ),
      // TEXT
      array(
        'name'  => __( 'City', 'od-directory' ),
        'id'    => "{$prefix}city",
        'desc' => __( 'Required', 'od-directory' ),
        'type'  => 'text',
        'clone' => false,
      ),      
      // TEXT
      array(
        'name'  => __( 'Zip', 'od-directory' ),
        'id'    => "{$prefix}zip",
        'type'  => 'text',
        'clone' => false,
      ),
      // URL
      array(
        'name'  => __( 'Google Map Link', 'od-directory' ),
        'id'    => "{$prefix}directions",
        'desc' => __( 'Link for Directions', 'od-directory' ),
        'type'  => 'url',
      ),
      // HEADING
      array(
        'type' => 'heading',
        'name' => __( 'Event Info', 'od-directory' ),
        'id'   => 'fake_id', // Not used but needed for plugin
      ),
      // URL
      array(
        'name' => __( 'Event URL', 'od-directory' ),
        'id'   => "{$prefix}url",
        'desc' => __( 'Example: http://somesite.com', 'od-directory' ),
        'type' => 'url',
      ),
      // TEXT
      array(
        'name'  => __( 'Marketo Form ID', 'od-directory' ),
        'id'    => "{$prefix}marketo",
        'desc' => __( 'Example: 1234', 'od-directory' ),
        'type'  => 'text',
        'clone' => false,
      ),
      // WYSIWYG/RICH TEXT EDITOR
      array(
        'name'    => __( 'Content', 'od-directory' ),
        'id'      => "{$prefix}wysiwyg",
        'type'    => 'wysiwyg',
        // Set the 'raw' parameter to TRUE to prevent data being passed through wpautop() on save
        'raw'     => false,
        // Editor settings, see wp_editor() function: look4wp.com/wp_editor
        'options' => array(
          'textarea_rows' => 15,
          'teeny'         => false,
          'media_buttons' => true,
        ),
      ),
    )
  );
  return $meta_boxes;
}