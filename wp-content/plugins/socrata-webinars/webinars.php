<?php
/*
Plugin Name: Socrata Webinars
Plugin URI: http://socrata.com/
Description: This plugin manages Socrata webinars.
Version: 1.0
Author: Michael Church
Author URI: http://socrata.com/
License: GPLv2
*/

add_action( 'init', 'create_socrata_webinars' );
function create_socrata_webinars() {
  register_post_type( 'socrata_webinars',
    array(
      'labels' => array(
        'name' => 'Webinars',
        'singular_name' => 'Webinars',
        'add_new' => 'Add New Webinar',
        'add_new_item' => 'Add New Webinar',
        'edit' => 'Edit Webinars',
        'edit_item' => 'Edit Webinars',
        'new_item' => 'New Webinar',
        'view' => 'View',
        'view_item' => 'View Webinar',
        'search_items' => 'Search Webinars',
        'not_found' => 'Not found',
        'not_found_in_trash' => 'Not found in Trash'
      ),
      'public' => true,
      'menu_position' => 5,
      'supports' => array( 'title', 'thumbnail' ),
      'taxonomies' => array( '' ),
      'menu_icon' => '',
      'has_archive' => false,
      'rewrite' => array('with_front' => false, 'slug' => 'webinar')
    )
  );
}

// MENU ICON
//Using Dashicon Font https://developer.wordpress.org/resource/dashicons
add_action( 'admin_head', 'add_socrata_webinars_icon' );
function add_socrata_webinars_icon() { ?>
  <style>
    #adminmenu .menu-icon-socrata_webinars div.wp-menu-image:before {
      content: '\f508';
    }
  </style>
  <?php
}

// Template Paths
add_filter( 'template_include', 'socrata_webinars_single_template', 1 );
function socrata_webinars_single_template( $template_path ) {
  if ( get_post_type() == 'socrata_webinars' ) {
    if ( is_single() ) {
      // checks if the file exists in the theme first,
      // otherwise serve the file from the plugin
      if ( $theme_file = locate_template( array ( 'single-webinars.php' ) ) ) {
        $template_path = $theme_file;
      } else {
        $template_path = plugin_dir_path( __FILE__ ) . 'single-webinars.php';
      }
    }
  }
  return $template_path;
}

// Custom Body Class
add_action( 'body_class', 'socrata_webinars_body_class');
function socrata_webinars_body_class( $classes ) {
  if ( get_post_type() == 'socrata_webinars' && is_single() || get_post_type() == 'socrata_webinars' && is_archive() )
    $classes[] = 'socrata-webinars';
  return $classes;
}

// Metabox
add_filter( 'rwmb_meta_boxes', 'socrata_webinars_register_meta_boxes' );
function socrata_webinars_register_meta_boxes( $meta_boxes )
{
  $prefix = 'webinars_';
  $meta_boxes[] = array(
    'title'  => __( 'Webinar Details', 'webinars_' ),
    'post_types' => array( 'socrata_webinars' ),
    'context'    => 'normal',
    'priority'   => 'high',
    'fields' => array(
      // HEADING
      array(
        'type' => 'heading',
        'name' => __( 'Webinar Date and Time', 'webinars_' ),
        'id'   => 'fake_id', // Not used but needed for plugin
      ),
      // DATETIME
      array(
        'name'        => __( 'Start Date and Time', 'webinars_' ),
        'id'          => $prefix . 'starttime',
        'type'        => 'datetime',
        'timestamp'   => false,
        // jQuery datetime picker options.
        // For date options, see here http://api.jqueryui.com/datepicker
        // For time options, see here http://trentrichardson.com/examples/timepicker/
        'js_options'  => array(
          'timeFormat'      => 'hh:mm TT',
          'stepMinute'      => 15,
          'showTimepicker'  => true,
        ),
      ),
      // DATETIME
      array(
        'name'        => __( 'End Date and Time', 'webinars_' ),
        'id'          => $prefix . 'endtime',
        'type'        => 'datetime',
        'timestamp'   => true,
        // jQuery datetime picker options.
        // For date options, see here http://api.jqueryui.com/datepicker
        // For time options, see here http://trentrichardson.com/examples/timepicker/
        'js_options'  => array(
          'timeFormat'      => 'hh:mm TT',
          'stepMinute'      => 15,
          'showTimepicker'  => true,
        ),
      ),      
      // TEXT
      array(
        'name'  => __( 'Display Date and Time', 'webinars_' ),
        'id'    => "{$prefix}displaydate",
        'desc' => __( 'Example: Jan 1st - 2:00pm PST', 'webinars_' ),
        'type'  => 'text',
        'clone' => false,
      ),
      // HEADING
      array(
        'type' => 'heading',
        'name' => __( 'Webinar Location', 'webinars_' ),
        'id'   => 'fake_id', // Not used but needed for plugin
      ),
      // TEXT
      array(
        'name'  => __( 'Location Name', 'webinars_' ),
        'id'    => "{$prefix}location",
        'desc' => __( 'Example: Hometown Pub', 'webinars_' ),
        'type'  => 'text',
        'clone' => false,
      ),      
      // WYSIWYG/RICH TEXT EDITOR
      array(
        'name'    => __( 'Speakers', 'webinars_' ),
        'id'      => "{$prefix}speakers",
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



// Shortcode [current-webinars]
function webinars_posts($atts, $content = null) {
  ob_start();
  ?>
<section class="section-padding">
  <div class="container">
    <div class="row">
      <div class="col-sm-8">
        <ul class="event-list">

          <?php
          /* The Query */
          $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
          $today = strtotime('today UTC');          

          $event_meta_query = array( 
            'relation' => 'AND',
            array( 
              'key' => 'socrata_webinars_endtime', 
              'value' => $today, 
              'compare' => '>=', 
            ) 
          ); 

          $args = array(
                'post_type' => 'socrata_webinars',
                'paged' => $paged,
                'post_status' => 'publish',
                'ignore_sticky_posts' => true,  
                'meta_key' => 'socrata_webinars_endtime',
                'orderby' => 'meta_value_num',
                'order' => 'asc',
                'meta_query' => $event_meta_query
              );

          $query = new WP_Query( $args );

          // The Loop
          if ( $query->have_posts() ) : 
          while( $query->have_posts() ): $query->the_post();

            if ( has_term( 'socrata-event','socrata_webinars_cat' ) ) { ?>
            <li>
              <p class="categories"><?php webinars_the_categories(); ?></p>
              <h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
              <p class="date"><?php echo rwmb_meta( 'socrata_webinars_displaydate' );?></p>             
              <?php 
                $city = rwmb_meta( 'socrata_webinars_city' );
                $state = rwmb_meta( 'socrata_webinars_state' );
                if ($city) { ?>
                  <p><?php echo $city;?>, <?php echo $state;?></p>
                <?php
                }                
              ?>              
              <p id="event-socrata-event" style="margin-top:15px;"><a href="<?php the_permalink() ?>" class="btn btn-primary">Learn More</a></p>
            </li>
            <?php
            }
            else { ?>
            <li>
              <p class="categories"><?php webinars_the_categories(); ?></p>
              <h4><?php the_title(); ?></h4>
              <p class="date"><?php echo rwmb_meta( 'socrata_webinars_displaydate' );?></p>
              <?php 
                $city = rwmb_meta( 'socrata_webinars_city' );
                $state = rwmb_meta( 'socrata_webinars_state' );
                $url = rwmb_meta( 'socrata_webinars_url' );
                if ($url) { ?>
                  <p><?php echo $city;?>, <?php echo $state;?> | <a href="<?php echo $url;?>" target="_blank">Visit Site</a></p>
                <?php
                }
                elseif ($city) { ?>
                  <p><?php echo $city;?>, <?php echo $state;?></p>
                <?php
                }
              ?>
              <p id="event-conference" style="margin-top:15px;"><a href="mailto:webinars@socrata.com" class="btn btn-primary" target="_blank">Meet Us</a></p>
            </li>
            <?php
            }

          endwhile;
          endif;

          // Restore original Post Data
          wp_reset_postdata();

          ?>
        </ul>
        <?php if (function_exists("pagination")) {pagination($query->max_num_pages,$pages);} ?>
      </div>
      <div class="col-sm-4 hidden-xs webinars-sidebar">
        <div class="padding-15 margin-bottom-30 background-clouds">          
          <h4 class="background-orange padding-15 text-reverse">Let's Meet Up</h4>
          <div class="padding-15">
            <p>See an event in your area and want to meet with us?  Send us an email.</p>
            <p id="event-side-rail"><a href="mailto:webinars@socrata.com" class="btn btn-primary">Email Us</a></p>
          </div>
        </div>
        <h4>Additional Resources</h4>
        <?php wp_nav_menu( array( 'theme_location' => 'site_nav_resources' ) ); ?>
      </div>
    </div>
  </div>
</section>
  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('current-webinars', 'webinars_posts');