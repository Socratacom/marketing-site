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
    'title'  => __( 'Event Details', 'socrata-events' ),
    'post_types' => 'socrata_events',
    'context'    => 'normal',
    'priority'   => 'high',
    'validation' => array(
      'rules'    => array(
        "{$prefix}city" => array(
            'required'  => true,
        ),
        "{$prefix}state" => array(
            'required'  => true,
        ),
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
      // HEADING
      array(
        'type' => 'heading',
        'name' => __( 'Event Date and Time', 'socrata-events' ),
        'id'   => 'fake_id', // Not used but needed for plugin
      ),
      // DATE
      array(
        'name'        => __( 'Start Date', 'socrata-events' ),
        'id'          => $prefix . 'starttime',
        'type'        => 'date',
        'timestamp'   => true,        
        'js_options' => array(
          'numberOfMonths'  => 2,
          'showButtonPanel' => false,
        ),
      ),
      // DATE
      array(
        'name'        => __( 'End Date', 'socrata-events' ),
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
        'name'  => __( 'Display Date and Time', 'socrata-events' ),
        'id'    => "{$prefix}displaydate",
        'desc' => __( 'Example: January 1, 1:00 pm - 2:00 pm PT', 'socrata-events' ),
        'type'  => 'text',
        'clone' => false,
      ),
      // HEADING
      array(
        'type' => 'heading',
        'name' => __( 'Event Location', 'socrata-events' ),
        'id'   => 'fake_id', // Not used but needed for plugin
      ),
      // TEXT
      array(
        'name'  => __( 'Location Name', 'socrata-events' ),
        'id'    => "{$prefix}location",
        'desc' => __( 'Example: Hometown Pub', 'socrata-events' ),
        'type'  => 'text',
        'clone' => false,
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
        'name' => __( 'Event Website', 'socrata-events' ),
        'id'   => 'fake_id', // Not used but needed for plugin
      ),
      // URL
      array(
        'name' => __( 'Event URL', 'socrata-events' ),
        'id'   => "{$prefix}url",
        'desc' => __( 'For non-Socrata events. Example: http://somesite.com', 'socrata-events' ),
        'type' => 'url',
      ),
      // URL
      /*array(
        'name'  => __( 'Google Map Link', 'socrata-events' ),
        'id'    => "{$prefix}directions",
        'desc' => __( 'Link for Directions', 'socrata-events' ),
        'type'  => 'url',
      ),*/
      // HEADING
      array(
        'type' => 'heading',
        'name' => __( 'Registration Form', 'socrata-events' ),
        'id'   => 'fake_id', // Not used but needed for plugin
      ),
      // TEXT
      array(
        'name'  => __( 'Marketo Form ID', 'socrata-events' ),
        'id'    => "{$prefix}marketo",
        'desc' => __( 'Example: 1234', 'socrata-events' ),
        'type'  => 'text',
        'clone' => false,
      ),      
      // HEADING
      array(
        'type' => 'heading',
        'name' => __( 'Additional Options', 'webinars_' ),
        'id'   => 'fake_id', // Not used but needed for plugin
      ),
      // TEXT
      array(
        'name'  => __( 'Additional CTA Button', 'socrata-events' ),
        'id'    => "{$prefix}cta_button",
        'desc' => __( 'Adds a CTA button to the hero. Keep it short.', 'socrata-events' ),
        'type'  => 'text',
        'clone' => true,
      ),
    )
  );

  $meta_boxes[] = array(
    'title'         => 'Content',   
    'post_types'    => 'socrata_events',
    'context'       => 'normal',
    'priority'      => 'high',
      'fields' => array(
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
    ),
  );


  $meta_boxes[] = array(
    'title'         => 'Speakers',   
    'post_types'    => 'socrata_events',
    'context'       => 'normal',
    'priority'      => 'high',
      'fields' => array(
         // HEADING
        array(
          'type' => 'heading',
          'name' => __( 'Speaker Section', 'socrata-events' ),
          'id'   => 'fake_id', // Not used but needed for plugin
        ),
        // TEXT
        array(
          'name'  => __( 'Custom Section Title', 'socrata-events' ),
          'id'    => "{$prefix}section_title",
          'desc' => __( 'Optional. The default is Speakers.' ),
          'type'  => 'text',
        ),
        // HEADING
        array(
          'type' => 'heading',
          'name' => __( 'Speaker Info', 'socrata-events' ),
          'id'   => 'fake_id', // Not used but needed for plugin
        ),
        array(
        'id'     => "{$prefix}speakers",
        'type'   => 'group',
        'clone'  => true,
        'sort_clone' => true,
        // Sub-fields
        'fields' => array(
          array(
            'name' => __( 'Name', 'socrata-events' ),
            'id'   => "{$prefix}speaker_name",
            'type' => 'text',
          ),
          array(
            'name' => __( 'Title', 'socrata-events' ),
            'id'   => "{$prefix}speaker_title",
            'type' => 'text',
          ),
          // IMAGE ADVANCED (WP 3.5+)
          array(
            'name'             => __( 'Headshot', 'socrata-events' ),
            'id'               => "{$prefix}speaker_headshot",
            'desc' => __( 'Minimum size 300x300 pixels.', 'socrata-events' ),
            'type'             => 'image_advanced',
            'max_file_uploads' => 1,
          ),
          // WYSIWYG/RICH TEXT EDITOR
          array(
            'name'    => __( 'Bio', 'socrata-events' ),
            'id'      => "{$prefix}what_the",
            'type'    => 'wysiwyg',
            'raw'     => false,
            'options' => array(
              'textarea_rows' => 4,
              'teeny'         => false,
              'media_buttons' => false,
            ),
          ),
        ),
      ), 
    ),
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
        <div class="filterbar margin-bottom-30">
          <div class="filter-row float-left hidden-xs">
            <label>Showing</label>
            <?php echo do_shortcode('[facetwp counts="true"]') ;?>
          </div>
          <div class="filter-row float-right no-padding">
            <label class="hidden-xs hidden-sm">Filter by</label>
            <?php echo do_shortcode('[facetwp facet="event_categories"]') ;?>
          </div>
          <div class="clearfix"></div>
        </div>
        <?php echo do_shortcode('[facetwp template="events"]') ;?>
        <?php echo do_shortcode('[facetwp pager="true"]') ;?>
      </div>
      <div class="col-sm-4 hidden-xs events-sidebar">
        <div class="alert alert-info margin-bottom-30">
          <strong>Let's meet up!</strong> See an event in your area and want to meet with us? <a href="mailto:events@socrata.com">Send us an email.</a>
        </div>
        <?php echo do_shortcode('[newsletter-sidebar]'); ?> 
        <?php
        $args = array(
        'post_type'         => 'socrata_videos',
        'order'             => 'desc',
        'posts_per_page'    => 3,
        'post_status'       => 'publish',
        );

        // The Query
        $the_query = new WP_Query( $args );

        // The Loop
        if ( $the_query->have_posts() ) {
        echo '<ul class="no-bullets sidebar-list">';
        echo '<li><h5>Recent Videos</h5></li>';
        while ( $the_query->have_posts() ) {
        $the_query->the_post(); { ?> 

        <li>
        <div class="article-img-container">
        <img src="https://img.youtube.com/vi/<?php $meta = get_socrata_videos_meta(); echo $meta[1]; ?>/default.jpg" class="img-responsive">
        </div>
        <div class="article-title-container">
        <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
        </div>
        </li>

        <?php }
        }
        echo '<li><a href="/videos">View All Videos <i class="fa fa-arrow-circle-o-right"></i></a></li>';
        echo '</ul>';
        } else {
        // no posts found
        }
        /* Restore original Post Data */
        wp_reset_postdata(); ?>

        <?php
        $args = array(
        'post_type'         => 'case_study',
        'order'             => 'desc',
        'posts_per_page'    => 3,
        'post_status'       => 'publish',
        );

        // The Query
        $the_query = new WP_Query( $args );

        // The Loop
        if ( $the_query->have_posts() ) {
        echo '<ul class="no-bullets sidebar-list">';
        echo '<li><h5>Recent Case Studies</h5></li>';
        while ( $the_query->have_posts() ) {
        $the_query->the_post(); { ?> 

        <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail' ); $url = $thumb['0'];?>
        <li>
          <div class="article-img-container">
            <img src="<?=$url?>" class="img-responsive">
          </div>
          <div class="article-title-container">
            <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
          </div>
        </li>

        <?php }
        }
        echo '<li><a href="/case-studies">View All Case Studies <i class="fa fa-arrow-circle-o-right"></i></a></li>';
        echo '</ul>';
        } else {
        // no posts found
        }
        /* Restore original Post Data */
        wp_reset_postdata(); ?>
      </div>
    </div>
  </div>
</section>
<script>
(function($) {
    $(function() {
        FWP.loading_handler = function() { }
    });
})(jQuery);
</script>
  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('current-events', 'events_posts');