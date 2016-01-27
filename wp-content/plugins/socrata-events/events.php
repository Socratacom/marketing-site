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
      $timestamp = rwmb_meta( 'socrata_events_datetime' ); echo date("F j, Y, g:i a", $timestamp);
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
    'context'    => 'normal',
    'priority'   => 'high',
    'fields' => array(
      // DATETIME
      array(
        'name'        => __( 'Start Date and Time', 'socrata-events' ),
        'id'          => $prefix . 'starttime',
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
      // DATETIME
      array(
        'name'        => __( 'End Date and Time', 'socrata-events' ),
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
      // HEADING
      array(
        'type' => 'heading',
        'name' => __( 'Event Location', 'socrata-events' ),
        'id'   => 'fake_id', // Not used but needed for plugin
      ),
      // TEXT
      array(
        'name'  => __( 'Street Address', 'socrata-events' ),
        'id'    => "{$prefix}address",
        'type'  => 'text',
        'clone' => false,
      ),
      // TEXT
      array(
        'name'  => __( 'City', 'socrata-events' ),
        'id'    => "{$prefix}city",
        'desc' => __( 'Required', 'socrata-events' ),
        'type'  => 'text',
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
        'desc' => __( 'Required', 'socrata-events' ),
      ),
      // TEXT
      array(
        'name'  => __( 'Zip', 'socrata-events' ),
        'id'    => "{$prefix}zip",
        'type'  => 'text',
        'clone' => false,
      ),
      // HEADING
      array(
        'type' => 'heading',
        'name' => __( 'Additional Info', 'socrata-events' ),
        'id'   => 'fake_id', // Not used but needed for plugin
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
              'key' => 'socrata_events_endtime', 
              'value' => $today, 
              'compare' => '>=', 
            ) 
          ); 

          $args = array(
                'post_type' => 'socrata_events',
                'paged' => $paged,
                'post_status' => 'publish',
                'ignore_sticky_posts' => true,  
                'meta_key' => 'socrata_events_endtime',
                'orderby' => 'meta_value_num',
                'order' => 'asc',
                'meta_query' => $event_meta_query
              );

          $query = new WP_Query( $args );

          // The Loop
          if ( $query->have_posts() ) : 
          while( $query->have_posts() ): $query->the_post();

            if ( has_term( 'lunch-and-learn','socrata_events_cat' ) ) { ?>
            <li>
              <p class="categories"><?php events_the_categories(); ?></p>
              <h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
              <p class="date">
                <?php $starttime = rwmb_meta( 'socrata_events_starttime' ); echo date("M j, g:i a", $starttime); ?>
                <?php $endtime = rwmb_meta( 'socrata_events_endtime' ); echo ' - '; echo date("M j, g:i a", $endtime); ?>
                <?php echo rwmb_meta( 'socrata_events_select' );?></p>              
              <?php 
                $city = rwmb_meta( 'socrata_events_city' );
                if ($city) { ?>
                  <p><?php echo rwmb_meta( 'socrata_events_city' ); echo ', ';?><?php echo rwmb_meta( 'socrata_events_state' );?></p>
                <?php
                }                
              ?>              
              <p style="margin-top:15px;"><a href="<?php the_permalink() ?>" class="btn btn-primary">Learn More</a></p>
            </li>
            <?php
            }
            else { ?>
            <li>
              <p class="categories"><?php events_the_categories(); ?></p>
              <h4><?php the_title(); ?></h4>
              <p class="date">
                <?php $starttime = rwmb_meta( 'socrata_events_starttime' ); echo date("M j, g:i a", $starttime); ?>
                <?php $endtime = rwmb_meta( 'socrata_events_endtime' ); echo ' - '; echo date("M j, g:i a", $endtime); ?>
                <?php echo rwmb_meta( 'socrata_events_select' );?></p>
                <?php $city = rwmb_meta( 'socrata_events_city' );
                  if ($city) { ?>
                    <?php echo rwmb_meta( 'socrata_events_city' ); echo ', ';?><?php echo rwmb_meta( 'socrata_events_state' );?>
                  <?php
                  }             
                ?>
                <?php $url = rwmb_meta( 'socrata_events_url' );
                  if ($url) { ?>
                    | <a href="<?php echo rwmb_meta( 'socrata_events_url' );?>" target="_blank">Visit Site</a>
                  <?php
                  }             
                ?>
              </p>
              <p style="margin-top:15px;"><a href="mailto:events@socrata.com" class="btn btn-primary" target="_blank">Meet Us</a></p>
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
      <div class="col-sm-4 hidden-xs events-sidebar">
        <div class="padding-30 margin-bottom-30 background-clouds">
          <h4>Let's Meet Up</h4>
          <p>See an event you'd like to meet us or want to suggest an event we should attend? Send us and email.</p>
          <p><a href="mailto:events@socrata.com" class="btn btn-warning">Email Us</a></p>
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
add_shortcode('current-events', 'events_posts');