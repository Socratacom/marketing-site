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
      'supports' => array( 'title', 'revisions' ),
      'taxonomies' => array( '' ),
      'menu_icon' => '',
      'has_archive' => false,
      'rewrite' => array('with_front' => false, 'slug' => 'events')
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

// TAXONOMIES
add_action( 'init', 'socrata_events_cat', 0 );
function socrata_events_cat() {
  register_taxonomy(
    'socrata_events_cat',
    'socrata_events',
    array(
      'labels' => array(
        'name' => 'Category',
        'menu_name' => 'Category',
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
    'title'  => __( 'Event Details', 'socrata-events' ),
    'post_types' => array( 'socrata_events' ),
    'priority'   => 'high',
    'fields' => array(
      // DATETIME
      array(
        'name'        => __( 'Event Date and Time', 'socrata-events' ),
        'id'          => $prefix . 'datetime',
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
      // SELECT BOX
      array(
        'name'        => __( 'Timezone', 'socrata-events' ),
        'id'          => "{$prefix}select",
        'type'        => 'select',
        // Array of 'value' => 'Label' pairs for select box
        'options'     => array(
          'PST' => __( 'PST', 'socrata-events' ),
          'CST' => __( 'CST', 'socrata-events' ),
          'EST' => __( 'EST', 'socrata-events' ),
        ),
        // Select multiple values, optional. Default is false.
        'multiple'    => false,
        'std'         => 'PST',
        'placeholder' => __( 'Select a Timezone', 'socrata-events' ),
      ),
      // URL
      array(
        'name' => __( 'Event URL', 'socrata-events' ),
        'id'   => "{$prefix}url",
        'desc' => __( 'Example: http://somesite.com', 'socrata-events' ),
        'type' => 'url',
      ),
      // TEXT
      array(
        'name'  => __( 'Marketo Form ID', 'socrata-events' ),
        'id'    => "{$prefix}marketo",
        'desc' => __( 'Example: 1234', 'socrata-events' ),
        'type'  => 'text',
        'clone' => false,
      ),
      // WYSIWYG/RICH TEXT EDITOR
      array(
        'name'    => __( 'Content', 'socrata-events' ),
        'id'      => "{$prefix}wysiwyg",
        'type'    => 'wysiwyg',
        // Set the 'raw' parameter to TRUE to prevent data being passed through wpautop() on save
        'raw'     => false,
        // Editor settings, see wp_editor() function: look4wp.com/wp_editor
        'options' => array(
          'textarea_rows' => 15,
          'teeny'         => false,
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

  <div class="container page-padding">
    <div class="row">
      <div class="col-sm-8">

          <?php
          /* The Query */
          $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
          $today = strtotime('today UTC');          

          $event_meta_query = array( 
            'relation' => 'AND',
            array( 
              'key' => 'socrata_events_datetime', 
              'value' => $today, 
              'compare' => '>=', 
            ) 
          ); 

          $args = array(
                'post_type' => 'socrata_events',
                'paged' => $paged,
                'post_status' => 'publish',
                'ignore_sticky_posts' => true,  
                'meta_key' => 'socrata_events_datetime',
                'orderby' => 'meta_value_num',
                'order' => 'asc',
                'meta_query' => $event_meta_query
              );

          $query = new WP_Query( $args );

          // The Loop
          if ( $query->have_posts() ) : 
          while( $query->have_posts() ): $query->the_post();        

          ?>
            <p class="categories"><small><?php events_the_categories(); ?></small></p>            
            <h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
            <p><?php $timestamp = rwmb_meta( 'socrata_events_datetime' ); echo date("F j, Y, g:i a", $timestamp); ?> <?php echo rwmb_meta( 'socrata_events_select' );?></p>
            <p><?php echo rwmb_meta( 'socrata_events_url' );?></p>
            <p><?php echo rwmb_meta( 'socrata_events_marketo' );?></p>
            <?php echo rwmb_meta( 'socrata_events_wysiwyg' );?>
            <hr>
          <?php

          endwhile;
          endif;

          // Restore original Post Data
          wp_reset_postdata();

          ?>
     
      </div>
      <div class="col-sm-4">        
        <?php echo do_shortcode('[newsletter-sidebar]'); ?>
      </div>
    </div>
  </div>

  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('current-events', 'events_posts');