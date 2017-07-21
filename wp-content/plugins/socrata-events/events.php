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
      'show_tagcloud' => false,
      'hierarchical' => true,
      'sort' => true,      
      'args' => array( 'orderby' => 'term_order' ),
      'show_admin_column' => true,
      'rewrite' => array('with_front' => false, 'slug' => 'events-category'),
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

// Print Taxonomy Categories
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
    'title'       => 'Event Meta',
    'post_types'  => 'socrata_events',
    'context'     => 'normal',
    'priority'    => 'high',
    'validation' => array(
      'rules'    => array(
        "{$prefix}address" => array(
            'required'  => true,
        ),
        "{$prefix}locality" => array(
            'required'  => true,
        ),
        "{$prefix}administrative_area_level_1_short" => array(
            'required'  => false,
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

      'geo' => array(
           'componentRestrictions' => array(
               'country' => 'us'
           )
        ),
      'fields' => array(
          // HEADING
          array(
            'type' => 'heading',
            'name' => esc_html__( 'Event Location', 'socrata_events_' ),
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
          // We have custom `geometry` address component. Which is `lat + ',' + lng`
          array(
              'type' => 'text',
              'name' => 'Geometry',
              'id'    => "{$prefix}geometry"
          ),          
          // HEADING
          array(
            'type' => 'heading',
            'name' => esc_html__( 'Event Website', 'socrata_events_' ),
            'desc' => esc_html__( 'Enter a URL for non-socrata events', 'socrata_events_' ),
          ),
          // URL
          array(
          'name' => __( 'Event Website', 'socrata_events_' ),
            'id'   => "{$prefix}url",
            'desc' => __( ' Example: http://somesite.com', 'socrata_events_' ),
            'type' => 'url',
          ),
      )
  );

  $meta_boxes[] = array(
    'title'  => __( 'Socrata Event Meta', 'socrata_events_' ),
    'post_types' => 'socrata_events',
    'context'    => 'normal',
    'priority'   => 'high',
    'fields' => array(          
      // HEADING
      array(
        'type' => 'heading',
        'name' => esc_html__( 'Call to action', 'socrata_events_' ),
      ),
      // URL
      array(
      'name' => __( 'CTA URL', 'socrata_events_' ),
        'id'   => "{$prefix}cta_url",
        'desc' => __( ' Example: http://somesite.com', 'socrata_events_' ),
        'type' => 'url',
      ),
      // TEXT
      array(
        'name'  => __( 'Custom CTA Button Text', 'socrata_events_' ),
        'id'    => "{$prefix}custom_cta",
        'desc' => __( 'Example: Register', 'socrata_events_' ),
        'type'  => 'text',
        'clone' => false,
      ),                
      // HEADING
      array(
        'type' => 'heading',
        'name' => esc_html__( 'Event Content', 'socrata_events_' ),
        'desc' => esc_html__( 'Enter a URL for non-socrata events', 'socrata_events_' ),
      ),

      // WYSIWYG/RICH TEXT EDITOR
      array(
        'name'    => esc_html__( 'Socrata Event Content', 'socrata_events_' ),
        'id'      => "{$prefix}wysiwyg",
        'type'    => 'wysiwyg',
        // Set the 'raw' parameter to TRUE to prevent data being passed through wpautop() on save
        'raw'     => false,
        // Editor settings, see wp_editor() function: look4wp.com/wp_editor
        'options' => array(
          'textarea_rows' => 15,
          'teeny'         => true,
          'media_buttons' => false,
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
      <div class="col-sm-12 margin-bottom-30">
        <div class="padding-15 background-light-grey-4">
          <ul class="filter-bar">
            <li><?php echo facetwp_display( 'facet', 'event_categories_dropdown' ); ?></li>
            <li><button onclick="FWP.reset()" class="btn btn-primary"><i class="fa fa-undo" aria-hidden="true"></i></button></li>
          </ul>
        </div>          
      </div>

      <div class="col-sm-8">
        <?php echo do_shortcode('[facetwp template="events"]') ;?>        
      </div>
      <div class="col-sm-4 hidden-xs events-sidebar">
        <div class="alert alert-info margin-bottom-30">
          <strong>Let's meet up!</strong> See an event in your area and want to meet with us? <a href="mailto:events@socrata.com">Send us an email.</a>
        </div>
        <?php echo do_shortcode('[newsletter-sidebar]'); ?> 
       
        <?php
        $args = array(
        'post_type'         => 'post',
        'order'             => 'desc',
        'posts_per_page'    => 5,
        'post_status'       => 'publish',
        );

        // The Query
        $the_query = new WP_Query( $args );

        // The Loop
        if ( $the_query->have_posts() ) {
        echo '<ul class="no-bullets sidebar-list">';
        echo '<li><h5>Recent Articles</h5></li>';
        while ( $the_query->have_posts() ) {
        $the_query->the_post(); { ?> 

        <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail' ); $url = $thumb['0'];?>
        <li>
          <div class="article-img-container">
            <a href="<?php the_permalink() ?>"><img src="<?=$url?>" class="img-responsive"></a>
          </div>
          <div class="article-title-container">
            <a href="<?php the_permalink() ?>"><?php the_title(); ?></a><br><small><?php the_time('F j, Y') ?></small>
          </div>
        </li>

        <?php }
        }
        echo '<li><a href="/blog">View blog <i class="fa fa-arrow-circle-o-right"></i></a></li>';
        echo '</ul>';
        } else {
        // no posts found
        }
        /* Restore original Post Data */
        wp_reset_postdata(); ?>
      </div>
    </div>
    <div class="row display-settings-bar">
        <div class="col-sm-12">
          <ul class="list-table">
            <li><?php echo do_shortcode('[facetwp per_page="true"]') ;?></li>
            <li class="text-right"><small>Showing: <?php echo do_shortcode('[facetwp counts="true"]') ;?></small></li>
          </ul>          
        </div>
      </div>
  </div>
</section>
<script>!function(n){n(function(){FWP.loading_handler=function(){}})}(jQuery);</script>
  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('current-events', 'events_posts');


// Shortcode [events-map]
function events_map($atts, $content = null) {
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
                            
        // Info Window Content
        var infoWindowContent = [
        <?php
            $today = strtotime('today UTC');
            $args = array(
              'post_type' => 'socrata_events',
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
              $displaydate = rwmb_meta( 'socrata_events_displaydate' );
              $eventsurl = rwmb_meta( 'socrata_events_url' ); { ?>                
                <?php if ( has_term( 'socrata-event','socrata_events_cat' ) ) { ?>
                  ['<small style="text-transform:uppercase;"><?php events_the_categories(); ?></small><br><strong><a href="<?php the_permalink() ?>"><?php the_title();?></a></strong><br><?php echo $displaydate;?>'],<?php }
                  else { ?>
                  ['<small style="text-transform:uppercase;"><?php events_the_categories(); ?></small><br><?php if ( ! empty( $eventsurl ) ) { ?><strong><a href="<?php echo $eventsurl;?>" target="_blank"><?php the_title();?></a></strong> <?php } else { ?><strong><?php the_title();?></strong><?php } ?><br><?php echo $displaydate;?>'],<?php }
                ?>
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
            this.setZoom(3);
            google.maps.event.removeListener(boundsListener);
        });
        
    }
    </script>

  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('events-map', 'events_map');