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
        'name' => __( 'Listing', 'od-directory' ),
        'id'   => 'fake_id', // Not used but needed for plugin
      ),
      // RADIO BUTTONS
      array(
        'name'    => __( 'Does this listing have an Open Data Site', 'od-directory' ),
        'id'      => "{$prefix}datasite",
        'type'    => 'radio',
        // Array of 'value' => 'Label' pairs for radio options.
        // Note: the 'value' is stored in meta field, not the 'Label'
        'options' => array(
          'value1' => __( 'Yes', 'od-directory' ),
          'value2' => __( 'No', 'od-directory' ),
        ),
      ),
      // RADIO BUTTONS
      array(
        'name'    => __( 'Is this a Socrata customer?', 'od-directory' ),
        'id'      => "{$prefix}customer",
        'type'    => 'radio',
        // Array of 'value' => 'Label' pairs for radio options.
        // Note: the 'value' is stored in meta field, not the 'Label'
        'options' => array(
          'value1' => __( 'Yes', 'od-directory' ),
          'value2' => __( 'No', 'od-directory' ),
        ),
      ),
      // HEADING
      array(
        'type' => 'heading',
        'name' => __( 'Location Info', 'od-directory' ),
        'id'   => 'fake_id', // Not used but needed for plugin
      ),
      // TEXT
      array(
        // Field name - Will be used as label
        'name'  => __( 'City', 'your-prefix' ),
        // Field ID, i.e. the meta key
        'id'    => "{$prefix}city-name",
        'type'  => 'text',
        // CLONES: Add to make the field cloneable (i.e. have multiple value)
        'clone' => false,
      ),
      // TEXT
      array(
        // Field name - Will be used as label
        'name'  => __( 'County', 'your-prefix' ),
        // Field ID, i.e. the meta key
        'id'    => "{$prefix}county-name",
        'type'  => 'text',
        // CLONES: Add to make the field cloneable (i.e. have multiple value)
        'clone' => false,
      ),
      // SELECT BOX
      array(
        'name'        => __( 'State', 'socrata-events' ),
        'id'          => "{$prefix}state",
        'type'        => 'select',
        // Array of 'value' => 'Label' pairs for select box
        'options'     => array(
          'AL' => __( 'Alabama', 'socrata-events' ),
          'AK' => __( 'Alaska', 'socrata-events' ),
          'AZ' => __( 'Arizona', 'socrata-events' ),
          'AR' => __( 'Arkansas', 'socrata-events' ),
          'CA' => __( 'California', 'socrata-events' ),
          'CO' => __( 'Colorado', 'socrata-events' ),
          'CT' => __( 'Connecticut', 'socrata-events' ),
          'DE' => __( 'Delaware', 'socrata-events' ),
          'DC' => __( 'District of Columbia', 'socrata-events' ),
          'FL' => __( 'Florida', 'socrata-events' ),
          'GA' => __( 'Georgia', 'socrata-events' ),
          'HI' => __( 'Hawaii', 'socrata-events' ),
          'ID' => __( 'Idaho', 'socrata-events' ),
          'IL' => __( 'Illinois', 'socrata-events' ),
          'IN' => __( 'Indiana', 'socrata-events' ),
          'IA' => __( 'Iowa', 'socrata-events' ),
          'KS' => __( 'Kansas', 'socrata-events' ),
          'KY' => __( 'Kentucky', 'socrata-events' ),
          'LA' => __( 'Louisiana', 'socrata-events' ),
          'ME' => __( 'Maine', 'socrata-events' ),
          'MD' => __( 'Maryland', 'socrata-events' ),
          'MA' => __( 'Massachusetts', 'socrata-events' ),
          'MI' => __( 'Michigan', 'socrata-events' ),
          'MN' => __( 'Minnesota', 'socrata-events' ),
          'MS' => __( 'Mississippi', 'socrata-events' ),
          'MO' => __( 'Missouri', 'socrata-events' ),
          'MT' => __( 'Montana', 'socrata-events' ),
          'NE' => __( 'Nebraska', 'socrata-events' ),
          'NV' => __( 'Nevada', 'socrata-events' ),
          'NH' => __( 'New Hampshire', 'socrata-events' ),
          'NJ' => __( 'New Jersey', 'socrata-events' ),
          'NM' => __( 'New Mexico', 'socrata-events' ),
          'NY' => __( 'New York', 'socrata-events' ),
          'NC' => __( 'North Carolina', 'socrata-events' ),
          'ND' => __( 'North Dakota', 'socrata-events' ),
          'OH' => __( 'Ohio', 'socrata-events' ),
          'OK' => __( 'Oklahoma', 'socrata-events' ),
          'OR' => __( 'Oregon', 'socrata-events' ),
          'PA' => __( 'Pennsylvania', 'socrata-events' ),
          'RI' => __( 'Rhode Island', 'socrata-events' ),
          'SC' => __( 'South Carolina', 'socrata-events' ),
          'SD' => __( 'South Dakota', 'socrata-events' ),
          'TN' => __( 'Tennessee  ', 'socrata-events' ),
          'TX' => __( 'Texas', 'socrata-events' ),
          'UT' => __( 'Utah', 'socrata-events' ),
          'VT' => __( 'Vermont', 'socrata-events' ),
          'VA' => __( 'Virginia', 'socrata-events' ),
          'WA' => __( 'Washington', 'socrata-events' ),
          'WV' => __( 'West Virginia', 'socrata-events' ),
          'WI' => __( 'Wisconsin', 'socrata-events' ),
          'WY' => __( 'Wyoming', 'socrata-events' ),
        ),
        'placeholder' => __( 'Select a State', 'socrata-events' ),
      ),
      // TEXT
      array(
        // Field name - Will be used as label
        'name'  => __( 'Agency', 'your-prefix' ),
        // Field ID, i.e. the meta key
        'id'    => "{$prefix}agency-name",        
        'desc' => __( 'Used for Federal Listings', 'od-directory' ),
        'type'  => 'text',
        // CLONES: Add to make the field cloneable (i.e. have multiple value)
        'clone' => false,
      ),
      // TEXT
      array(
        // Field name - Will be used as label
        'name'  => __( 'Population', 'your-prefix' ),
        // Field ID, i.e. the meta key
        'id'    => "{$prefix}population",        
        'desc' => __( 'Used for City, County, and State', 'od-directory' ),
        'type'  => 'text',
        // CLONES: Add to make the field cloneable (i.e. have multiple value)
        'clone' => false,
      ),
      // HEADING
      array(
        'type' => 'heading',
        'name' => __( 'Site Info', 'od-directory' ),
        'id'   => 'fake_id', // Not used but needed for plugin
      ),
      // TEXT
      array(
        // Field name - Will be used as label
        'name'  => __( 'Site Name', 'your-prefix' ),
        // Field ID, i.e. the meta key
        'id'    => "{$prefix}site-name",        
        'desc' => __( 'Example: Open Data New York', 'od-directory' ),
        'type'  => 'text',
        // CLONES: Add to make the field cloneable (i.e. have multiple value)
        'clone' => false,
      ),
      // URL
      array(
        'name' => __( 'URL', 'your-prefix' ),
        'id'   => "{$prefix}url",
        'desc' => __( 'URL description', 'your-prefix' ),
        'type' => 'url',
        'std'  => 'http://google.com',
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




/* Things to Note:
• Each Record will by Category Entity (i.e City, County, State, and Federal).
• Ability for multiple site entries
• Population will be the default query order. 
• Look into adding a map view. 
• Add Number of open data Datasets
• Socrata Customers will get a Logo and Screenshot
• Socrata Customers will also get "Open Data Leader Since 2004"
• If customers have apps, enter url.
• Add Feedback/Recomend a site. Possibly Marketo.
• Visualizations will be: 150 Cities have Open Data Sites, etc.
*/












