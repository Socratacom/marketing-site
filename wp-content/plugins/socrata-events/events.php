<?php
/*
Plugin Name: Socrata Events
Plugin URI: http://socrata.com/
Description: This plugin manages Socrata Events and Conferences.
Version: 1.0
Author: Michael Church
Author URI: http://socrata.com/
License: GPLv2
*/

add_action( 'init', 'create_socrata_events' );
function create_socrata_events() {
  register_post_type( 'socrata_events',
    array(
      'labels' => array(
        'name' => 'Events',
        'singular_name' => 'Events',
        'add_new' => 'Add New Event',
        'add_new_item' => 'Add New Event',
        'edit' => 'Edit Events',
        'edit_item' => 'Edit Events',
        'new_item' => 'New Event',
        'view' => 'View',
        'view_item' => 'View Event',
        'search_items' => 'Search Events',
        'not_found' => 'Not found',
        'not_found_in_trash' => 'Not found in Trash'
      ),
      'public' => true,
      'menu_position' => 5,
      'supports' => array( 'title', 'thumbnail' ),
      'taxonomies' => array( '' ),
      'menu_icon' => '',
      'has_archive' => false,
      'rewrite' => array('with_front' => false, 'slug' => 'event')
    )
  );
}

// MENU ICON
//Using Dashicon Font https://developer.wordpress.org/resource/dashicons
add_action( 'admin_head', 'add_socrata_events_icon' );
function add_socrata_events_icon() { ?>
  <style>
    #adminmenu .menu-icon-socrata_events div.wp-menu-image:before {
      content: '\f508';
    }
  </style>
  <?php
}

// CUSTOM COLUMS FOR ADMIN
add_filter( 'manage_edit-socrata_events_columns', 'socrata_events_edit_columns' ) ;
function socrata_events_edit_columns( $columns ) {
  $columns = array(
    'cb'          => '<input type="checkbox" />',    
    'title'       => __( 'Name' ),
    'category'    => __( 'Category' ),
    'eventdate'   => __( 'Event Date' ),

  );
  return $columns;
}
// Get Content for Custom Colums
add_action("manage_socrata_events_posts_custom_column",  "socrata_events_columns");
function socrata_events_columns($column){
  global $post;

  switch ($column) {    
    case 'eventdate':
      $timestamp = rwmb_meta( 'socrata_events_starttime' ); echo date("F j, Y, g:i a", $timestamp);
      break;
    case 'category':
      $segment = get_the_terms($post->ID , 'socrata_events_cat');
      echo $segment[0]->name;
      for ($i = 1; $i < count($segment); $i++) {echo ', ' . $segment[$i]->name ;}
      break;
  }
}

// Make these columns sortable
add_filter( "manage_edit-socrata_events_sortable_columns", "socrata_events_sortable_columns" );
function socrata_events_sortable_columns() {
  return array(
    'title'       => 'title',
    'category'    => 'category',
    'eventdate'   => 'eventdate',
  );
}

// TAXONOMIES
add_action( 'init', 'socrata_events_cat', 0 );
function socrata_events_cat() {
  register_taxonomy(
    'socrata_events_cat',
    'socrata_events',
    array(
      'labels' => array(
        'name' => 'Events Category',
        'menu_name' => 'Events Category',
        'add_new_item' => 'Add New Category',
        'new_item_name' => "New Category"
      ),
      'show_ui' => true,
      'show_in_menu' => false,
      'show_tagcloud' => false,
      'hierarchical' => true,
      'sort' => true,      
      'args' => array( 'orderby' => 'term_order' ),
      'show_admin_column' => true,
      'rewrite' => array('with_front' => false, 'slug' => 'events-category'),
    )
  );
}

add_action( 'init', 'socrata_events_region', 0 );
function socrata_events_region() {
  register_taxonomy(
    'socrata_events_region',
    'socrata_events',
    array(
      'labels' => array(
        'name' => 'Region',
        'menu_name' => 'Region',
        'add_new_item' => 'Add New Region',
        'new_item_name' => "New Region"
      ),
      'show_ui' => true,
      'show_in_menu' => false,
      'show_tagcloud' => false,
      'hierarchical' => true,
      'sort' => true,      
      'args' => array( 'orderby' => 'term_order' ),
      'show_admin_column' => true,
      'rewrite' => array('with_front' => false, 'slug' => 'events-region'),
    )
  );
}

// Template Paths
add_filter( 'template_include', 'socrata_events_single_template', 1 );
function socrata_events_single_template( $template_path ) {
  if ( get_post_type() == 'socrata_events' ) {
    if ( is_single() ) {
      // checks if the file exists in the theme first,
      // otherwise serve the file from the plugin
      if ( $theme_file = locate_template( array ( 'single-events.php' ) ) ) {
        $template_path = $theme_file;
      } else {
        $template_path = plugin_dir_path( __FILE__ ) . 'single-events.php';
      }
    }
  }
  return $template_path;
}

// Print Taxonomy Names
function events_the_categories() {
  // get all categories for this post
  global $terms;
  $terms = get_the_terms($post->ID , 'socrata_events_cat');
  // echo the first category
  echo $terms[0]->name;
  // echo the remaining categories, appending separator
  for ($i = 1; $i < count($terms); $i++) {echo ', ' . $terms[$i]->name ;}
}

// Custom Body Class
add_action( 'body_class', 'socrata_events_body_class');
function socrata_events_body_class( $classes ) {
  if ( get_post_type() == 'socrata_events' && is_single() || get_post_type() == 'socrata_events' && is_archive() )
    $classes[] = 'socrata-events';
  return $classes;
}

// Fixes JS when Yoast enabled and thumbnail disabled
add_action( 'admin_enqueue_scripts', 'socrata_events_box_scripts' );
function socrata_events_box_scripts() {

    global $post;

    wp_enqueue_media( array( 
        'post' => $post->ID, 
    ) );

}


// Metabox
add_filter( 'rwmb_meta_boxes', 'socrata_events_register_meta_boxes' );
function socrata_events_register_meta_boxes( $meta_boxes )
{
  $prefix = 'socrata_events_';

  $meta_boxes[] = array(
    'title'  => __( 'Event Date', 'socrata_events_' ),
    'post_types' => 'socrata_events',
    'context'    => 'normal',
    'priority'   => 'high',
    'validation' => array(
      'rules'    => array(
        "{$prefix}displaydate" => array(
            'required'  => true,
        ),
        "{$prefix}endtime" => array(
            'required'  => true,
        ),
        "{$prefix}starttime" => array(
            'required'  => true,
        ),
      ),
    ),
    'fields' => array(
      // DATE
      array(
        'name'        => __( 'Start Date', 'socrata_events_' ),
        'id'          => $prefix . 'starttime',
        'type'        => 'date',
        'timestamp'   => true,        
        'js_options' => array(
          'numberOfMonths'  => 2,
          'showButtonPanel' => true,
        ),
      ),
      // DATE
      array(
        'name'        => __( 'End Date', 'socrata_events_' ),
        'id'          => $prefix . 'endtime',
        'type'        => 'date',
        'timestamp'   => true,        
        'js_options' => array(
          'numberOfMonths'  => 2,
          'showButtonPanel' => true,
        ),
      ),      
      // TEXT
      array(
        'name'  => __( 'Display Date and Time', 'socrata_events_' ),
        'id'    => "{$prefix}displaydate",
        'desc' => __( 'Example: January 1, 1:00 pm - 2:00 pm PT', 'socrata_events_' ),
        'type'  => 'text',
        'clone' => false,
      ),
    )
  );

  $meta_boxes[] = array(
    'id'          => 'geolocation',
    'title'       => 'Event Location',
    'post_types'  => 'socrata_events',
    'context'     => 'normal',
    'priority'    => 'high',
    'validation' => array(
      'rules'    => array(
        "{$prefix}venue" => array(
            'required'  => true,
        ),
        "{$prefix}address" => array(
            'required'  => true,
        ),
        "{$prefix}geometry" => array(
            'required'  => true,
        ),
      ),
    ),
    // Tell WP this Meta Box is GeoLocation
    'geo'         => true,
    // Or you can set advanced settings for Geo, like this example:
    // Restrict results to Australia only.

      /*'geo' => array(
           'componentRestrictions' => array(
               'country' => 'us'
           )
        ),*/
      'fields' => array(              
          // TEXT
          array(
            'name'  => __( 'Venue', 'socrata_events_' ),
            'id'    => "{$prefix}venue",
            'desc' => __( 'Seattle Convention Center', 'socrata_events_' ),
            'type'  => 'text',
            'clone' => false,
          ),
          // Set the ID to `address` or `address_something` to make Auto Complete field
          array(
              'type' => 'text',
              'name' => 'Address',
              'id'    => "{$prefix}address"
          ),
          array(
                'type' => 'text',
                'name' => 'City',
                'id'    => "{$prefix}locality"
            ),
          // In case you want to limit your result like this example.
          // Auto populate short name of `administrative_area_level_1`. For example: QLD
          array(
              'type' => 'select',
              'name' => 'State',
              'placeholder' => 'Select a State',
              'options' => array(
                  'AL' => 'AL',
                  'AK' => 'AK',
                  'AZ' => 'AZ',
                  'AR' => 'AR',
                  'CA' => 'CA',
                  'CO' => 'CO',
                  'CT' => 'CT',
                  'DE' => 'DE',
                  'DC' => 'DC',
                  'FL' => 'FL',
                  'GA' => 'GA',
                  'HI' => 'HI',
                  'ID' => 'ID',
                  'IL' => 'IL',
                  'IN' => 'IN',
                  'IA' => 'IA',
                  'KS' => 'KS',
                  'KY' => 'KY',
                  'LA' => 'LA',
                  'ME' => 'ME',
                  'MD' => 'MD',
                  'MA' => 'MA',
                  'MI' => 'MI',
                  'MN' => 'MN',
                  'MS' => 'MS',
                  'MO' => 'MO',
                  'MT' => 'MT',
                  'NE' => 'NE',
                  'NV' => 'NV',
                  'NH' => 'NH',
                  'NJ' => 'NJ',
                  'NM' => 'NM',
                  'NY' => 'NY',
                  'NC' => 'NC',
                  'ND' => 'ND',
                  'OH' => 'OH',
                  'OK' => 'OK',
                  'OR' => 'OR',
                  'PA' => 'PA',
                  'RI' => 'RI',
                  'SC' => 'SC',
                  'SD' => 'SD',
                  'TN' => 'TN',
                  'TX' => 'TX',
                  'UT' => 'UT',
                  'VT' => 'VT',
                  'VA' => 'VA',
                  'WA' => 'WA',
                  'WV' => 'WV',
                  'WI' => 'WI',
                  'WY' => 'WY'
              ),
              'id'    => "{$prefix}administrative_area_level_1_short"
          ),
          array(
              'type' => 'number',
              'name' => 'Postcode',
              'id'    => "{$prefix}postal_code"
          ),

          // We have custom `geometry` address component. Which is `lat + ',' + lng`
          array(
              'type' => 'text',
              'name' => 'Geometry',
              'id'    => "{$prefix}geometry"
          ),          
      )
  );

  $meta_boxes[] = array(
    'title'  => __( 'Event Branding', 'socrata_events_' ),
    'post_types' => 'socrata_events',
    'context'    => 'normal',
    'priority'   => 'high',
    'fields' => array(      
      // IMAGE ADVANCED (WP 3.5+)
      array(
        'name'              => __( 'Event Logo', 'logos_' ),
        'id'                => "{$prefix}brand",
        'desc'              => __( 'Minimum size 300x300 pixels.', 'logos_' ),
        'type'              => 'image_advanced',
        'max_file_uploads'  => 1,
      ),
      // URL
      array(
      'name' => __( 'Event URL', 'socrata_events_' ),
        'id'   => "{$prefix}url",
        'desc' => __( ' Example: http://somesite.com', 'socrata_events_' ),
        'type' => 'url',
      ),
    )
  );

  /*$meta_boxes[] = array(
    'title'  => __( 'Event CTA', 'socrata_events_' ),
    'post_types' => 'socrata_events',
    'context'    => 'normal',
    'priority'   => 'high',
    'fields' => array(      
      // TEXT
      array(
        'name'  => __( 'CTA Title', 'socrata_events_' ),
        'id'    => "{$prefix}form_title",
        'desc' => __( 'Example: RSVP', 'socrata_events_' ),
        'type'  => 'text',
        'clone' => false,
      ),      
      // TEXT
      array(
        'name'  => __( 'CTA Text', 'socrata_events_' ),
        'id'    => "{$prefix}form_text",
        'desc' => __( 'Example: Please fill out this form to RSVP.', 'socrata_events_' ),
        'type'  => 'text',
        'clone' => false,
      ),
      // URL
      array(
        'name' => esc_html__( 'CTA URL', 'socrata_events_' ),
        'id'   => "{$prefix}cta_url",
        'desc' => esc_html__( 'For other than Pardot forms. Like Eventbrite.', 'webinars_' ),
        'type' => 'url',
      ),      
      // TEXT
      array(
        'name'  => __( 'Button Text', 'socrata_events_' ),
        'id'    => "{$prefix}button_text",
        'desc' => __( 'Example: Submit', 'socrata_events_' ),
        'type'  => 'text',
        'clone' => false,
      ),
      
    )
  );*/

  $meta_boxes[] = array(
    'title'  => __( 'Eventbrite', 'socrata_events_' ),
    'post_types' => 'socrata_events',
    'context'    => 'normal',
    'priority'   => 'high',
    'fields' => array(     
    	// HEADING
			array(
				'type' => 'heading',
				'name' => esc_html__( 'Eventbrite ID', 'socrata_events_' ),
				'desc' => esc_html__( 'Use this option for Eventbrite registration forms. Enter the ID number ONLY from the "Your Event URL". Example: https://www.eventbrite.com/e/some-event-01234567890, enter only the "01234567890" ', 'socrata_events_' ),
			),     
      // NUMBER
			array(
				'name' => esc_html__( 'ID', 'socrata_events_' ),
				'id'   => "{$prefix}eventbrite",
				'type' => 'number',
			),
    )
  );

  $meta_boxes[] = array(
    'title'  => __( 'Pardot', 'socrata_events_' ),
    'post_types' => 'socrata_events',
    'context'    => 'normal',
    'priority'   => 'high',
    'fields' => array(     
    	// HEADING
			array(
				'type' => 'heading',
				'name' => esc_html__( 'Pardot Form URL', 'socrata_events_' ),
				'desc' => esc_html__( 'Use this option for Pardot forms. Enter the form url. Example: http://go.socrata.com/l/303201/...', 'socrata_events_' ),
			),     
      // URL
      array(
        'name' => esc_html__( 'URL', 'socrata_events_' ),
        'id'   => "{$prefix}form",
        'type' => 'url',
      ),
    )
  );

  $meta_boxes[] = array(
    'title'  => __( 'Content', 'socrata_events_' ),
    'post_types' => 'socrata_events',
    'context'    => 'normal',
    'priority'   => 'high',
    'fields' => array(          
      // WYSIWYG/RICH TEXT EDITOR
      array(
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

// Shortcode [current-events]
function events_posts($atts, $content = null) {
  ob_start();
  ?>
  <section class="section-padding">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <h1 class="font-light margin-bottom-60">Events Calendar</h1>
        </div>

        <?php

        $today = strtotime('today UTC');
        $args = array(
          'post_type' => 'socrata_events',
          'post_status' => 'publish',
          'ignore_sticky_posts' => true,
          'meta_key' => 'socrata_events_starttime',
          'orderby' => 'meta_value_num',
          'order' => 'asc',
          'posts_per_page' => 1,
          'meta_query' => array(
              'relation' => 'AND',
              array(
                'key' => 'socrata_events_endtime',
                'value' => $today,
                'compare' => '>='
              )
            )
        );
        $args2 = array(
          'post_type' => 'socrata_events',
          'post_status' => 'publish',
          'ignore_sticky_posts' => true,
          'meta_key' => 'socrata_events_starttime',
          'orderby' => 'meta_value_num',
          'order' => 'asc',
          'posts_per_page' => 100,
          'offset' => 1,
          'meta_query' => array(
              'relation' => 'AND',
              array(
                'key' => 'socrata_events_endtime',
                'value' => $today,
                'compare' => '>='
              )
            )
        );

        // The Query
        $query1 = new WP_Query( $args );

        if ( $query1->have_posts() ) {          
          echo '<div class="col-sm-12">';
          // The Loop
          while ( $query1->have_posts() ) {
            $query1->the_post();
            $date = rwmb_meta( 'socrata_events_starttime' );
            $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'feature-image' );
            $url = $thumb['0'];
            $img_id = get_post_thumbnail_id(get_the_ID());
            $alt_text = get_post_meta($img_id , '_wp_attachment_image_alt', true);
            $city = rwmb_meta( 'socrata_events_locality' );
            $state = rwmb_meta( 'socrata_events_administrative_area_level_1_short' ); ?>
              <div class="feature-event">
                <div class="feature-event-image">
                  <img src="<?php echo $url;?>" <?php if ( ! empty($alt_text) ) { ?> alt="<?php echo $alt_text;?>" <?php } ;?> class="img-responsive">
                </div>
                <div class="feature-event-meta">
                  <div class="date">
                    <div class="day"><?php echo date('j', $date);?></div>
                    <div class="month"><?php echo date('M', $date);?></div>
                  </div>
                  <div class="meta">
                    <div class="category"><?php events_the_categories(); ?></div>
                    <h3 class="title"><?php the_title(); ?></h3>
                    <div class="location"><?php echo $city;?>, <?php echo $state;?></div>
                  </div>
                </div>
                <a href="<?php the_permalink() ?>" class="link"></a>
                <?php echo do_shortcode('[image-attribution]'); ?>
              </div>
            <?php
          }
          wp_reset_postdata();
          echo '</div>';
        } else { ?>
            <div class="col-sm-12">
              <div class="alert alert-info">
                <strong>No events are scheduled at this time.</strong> Do you know of an event we should attend? Suggest an event.
              </div>
            </div>
          <?php
        }

        /* The 2nd Query */
        $query2 = new WP_Query( $args2 );

        if ( $query2->have_posts() ) { ?>
          <div class="col-sm-12 col-md-10 col-md-offset-1">
          <h2 class="font-light margin-bottom-30 padding-bottom-30" style="border-bottom:#ebebeb solid 1px">Additional Events</h2>
          <table class="events-list">
          <?php

          // The 2nd Loop
          while ( $query2->have_posts() ) {
            $query2->the_post();
            $date = rwmb_meta( 'socrata_events_starttime' );
            $city = rwmb_meta( 'socrata_events_locality' );
            $state = rwmb_meta( 'socrata_events_administrative_area_level_1_short' ); ?>

            <tr class="event">
            <td class="date">
            <div class="day"><?php echo date('j', $date);?></div>
            <div class="month"><?php echo date('M', $date);?></div>
            <a href="<?php the_permalink() ?>"></a>
            </td>
            <td class="meta">
            <div class="category"><?php events_the_categories(); ?></div>
            <h3 class="title"><?php the_title(); ?></h3>
            <div class="location"><?php echo $city;?>, <?php echo $state;?></div>   
            <a href="<?php the_permalink() ?>"></a>         
            </td>
            </tr>

            <?php
          }
          wp_reset_postdata(); ?>
          </table>
          </div>
          <?php
        } 

        ?>

      </div>
    </div>
  </section>

  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('current-events', 'events_posts');


// COP Query [ ]
function cop_query($atts, $content = null) {
  extract( shortcode_atts( array(
    'region' => '',
    ), $atts ) );
    ob_start();
    $today = strtotime('today UTC');
    $args = array(
    'post_type' => 'socrata_events',
    'socrata_events_cat' => 'community-of-practice',
    'socrata_events_region' => $region,
		'post_status' => 'publish',
    'ignore_sticky_posts' => true,
    'meta_key' => 'socrata_events_starttime',
    'orderby' => 'meta_value_num',
    'order' => 'asc',
    'posts_per_page' => 1,
    'meta_query' => array(
			'relation' => 'AND',
			array(
				'key' => 'socrata_events_endtime',
				'value' => $today,
				'compare' => '>='
			)
		)
  );
  
$myquery = new WP_Query( $args );

?>
<div id="<?php echo $region;?>" class="col-sm-12 col-md-10 col-md-offset-1">
<h3 class="margin-bottom-30"><?php $term = get_term_by( 'slug', $region, 'socrata_events_region' ); $name = $term->name; echo $name; ?></h3>
<table class="events-list">
<?php


if($myquery->have_posts()) : 
while($myquery->have_posts()) : 
$myquery->the_post();
$date = rwmb_meta( 'socrata_events_starttime' );
$city = rwmb_meta( 'socrata_events_locality' );
$state = rwmb_meta( 'socrata_events_administrative_area_level_1_short' );
?>

<tr class="event">
<td class="date">
<div class="day"><?php echo date('j', $date);?></div>
<div class="month"><?php echo date('M', $date);?></div>
<a href="<?php the_permalink() ?>"></a>
</td>
<td class="meta" style="border:none;">
<div class="category"><?php events_the_categories(); ?></div>
<h3 class="title"><?php the_title(); ?></h3>
<div class="location"><?php echo $city;?>, <?php echo $state;?></div>   
<a href="<?php the_permalink() ?>"></a>         
</td>
</tr>   

<?php
endwhile;
else: 
?>

<div class="alert alert-info">
No events are scheduled for <strong><?php echo $name;?></strong> at this time.
</div>

<?php
endif;
wp_reset_postdata();

?>
</table>
<hr/>
</div>

<?php

  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('cop-query', 'cop_query');


// Shortcode [cop-map]
function cop_map($atts, $content = null) {
  ob_start();
  ?>
    <script>jQuery(function(n){n(".map-button").click(function(){n(".overlay").hide()})});</script>
    <script>
    jQuery(function($) {
        // Asynchronously Load the map API 
        var script = document.createElement('script');
        script.src = "//maps.googleapis.com/maps/api/js?key=AIzaSyD_STOs8I4L5GTLlDIu5aZ-pLs2L69wHMw&callback=initialize";
        document.body.appendChild(script);
    });

    function initialize() {
        var map;
        var bounds = new google.maps.LatLngBounds();
        var mapOptions = {
          scrollwheel: false,
          styles: [{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#93d2ec"},{"visibility":"on"}]}]
        };
                        
        // Display a map on the page
        map = new google.maps.Map(document.getElementById("events-map"), mapOptions);
        map.setTilt(45);
            
        // Multiple Markers
        var markers = [
          <?php
            $today = strtotime('today UTC');
            $args = array(
              'post_type' => 'socrata_events',
              'socrata_events_cat' => 'community-of-practice',
              'post_status' => 'publish',
              'ignore_sticky_posts' => true,
              'meta_key' => 'socrata_events_starttime',
              'orderby' => 'meta_value_num',
              'order' => 'asc',
              "posts_per_page" => 100,
              "meta_query" => array(    
                array(
                  'key'     => 'socrata_hidden_hide',
                  'value' => '0',
                ),
                'relation' => 'AND',
                array(
                  "key" => "socrata_events_endtime",
                  "value" => "$today",
                  "compare" => ">="
                )
              )
            );
            $query = new WP_Query( $args );

            // The Loop
            while ( $query->have_posts() ) {
              $query->the_post();
              $pin = rwmb_meta( 'socrata_events_geometry' ); { ?>
              ['<?php the_title();?>',<?php echo $pin;?>],
              <?php
              };
            }
            wp_reset_postdata();
          ?>
        ];
                            

            
        // Display multiple markers on a map
        var infoWindow = new google.maps.InfoWindow(), marker, i;
        
        // Loop through our array of markers & place each one on the map  
        for( i = 0; i < markers.length; i++ ) {
            var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
            bounds.extend(position);
            marker = new google.maps.Marker({
                position: position,
                map: map,
                title: markers[i][0]
            });
            
            // Allow each marker to have an info window    
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infoWindow.setContent(infoWindowContent[i][0]);
                    infoWindow.open(map, marker);
                }
            })(marker, i));

            // Automatically center the map fitting all markers on the screen
            map.fitBounds(bounds);
        }

        // Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
        var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
            this.setZoom(4);
            google.maps.event.removeListener(boundsListener);
        });
        
    }
    </script>

  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('cop-map', 'cop_map');