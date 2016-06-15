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

// TAXONOMIES
add_action( 'init', 'socrata_webinars_cat', 0 );
function socrata_webinars_cat() {
  register_taxonomy(
    'socrata_webinars_cat',
    'socrata_webinars',
    array(
      'labels' => array(
        'name' => 'Webinars Stauts',
        'menu_name' => 'Webinars Status',
        'add_new_item' => 'Add New Status',
        'new_item_name' => "New Status"
      ),
      'show_ui' => false,
      'show_in_menu' => true,
      'show_tagcloud' => false,
      'hierarchical' => true,
      'sort' => true,      
      'args' => array( 'orderby' => 'term_order' ),
      'show_admin_column' => true,
      'capabilities'=>array(
        'manage_terms' => 'manage_options',//or some other capability your clients don't have
        'edit_terms' => 'manage_options',
        'delete_terms' => 'manage_options',
        'assign_terms' =>'edit_posts'),
      'rewrite' => array('with_front' => false, 'slug' => 'webinars-category'),
    )
  );
}
// DEFAULT TAXONOMY
function socrata_webinars_default_taxonomy( $post_id ) {
    $current_post = get_post( $post_id );

    // This makes sure the taxonomy is only set when a new post is created
    if ( $current_post->post_date == $current_post->post_modified ) {
        wp_set_object_terms( $post_id, 'upcoming', 'socrata_webinars_cat', true );
    }
}
add_action( 'save_post_socrata_webinars', 'socrata_webinars_default_taxonomy' );

// PRINT TAXONOMY CATEGORIES
function webinars_the_categories() {
  // get all categories for this post
  global $terms;
  $terms = get_the_terms($post->ID , 'socrata_webinars_cat');
  // echo the first category
  echo $terms[0]->name;
  // echo the remaining categories, appending separator
  for ($i = 1; $i < count($terms); $i++) {echo ', ' . $terms[$i]->name ;}
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

// TEMPLATES
// Endpoint Rewrites
add_action('init', 'socrata_webinars_add_endpoints');
function socrata_webinars_add_endpoints()
{
  add_rewrite_endpoint('webinar-confirmation', EP_PERMALINK);
  add_rewrite_endpoint('webinar-video', EP_PERMALINK);
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
    if ( get_query_var( 'webinar-confirmation' )  ) {
      $template_path = plugin_dir_path( __FILE__ ) . 'confirmation.php';
    }
    if ( get_query_var( 'webinar-video' )  ) {
      $template_path = plugin_dir_path( __FILE__ ) . 'video.php';
    }
  }
  return $template_path;
}
// Template Request
add_filter( 'request', 'socrata_webinars_filter_request' );
function socrata_webinars_filter_request( $vars )
{
  if( isset( $vars['webinar-confirmation'] ) ) $vars['webinar-confirmation'] = true;
  if( isset( $vars['webinar-video'] ) ) $vars['webinar-video'] = true;
  return $vars;
}

// CUSTOM BODY CLASS
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
    'title'  => __( 'Webinar Meta', 'webinars_' ),
    'post_types' => 'socrata_webinars',
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
        "{$prefix}marketo_registration" => array(
            'required'  => true,
        ),
        "{$prefix}marketo_on_demand" => array(
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
        'name' => __( 'Webinar Date and Time', 'webinars_' ),
        'id'   => 'fake_id', // Not used but needed for plugin
      ),
      // DATETIME
      array(
        'name'        => __( 'Date', 'webinars_' ),
        'id'          => $prefix . 'starttime',
        'type'        => 'date',
        'timestamp'   => false,
        'js_options' => array(
          'numberOfMonths'  => 2,
          'showButtonPanel' => true,
        ),
      ),      
      // TEXT
      array(
        'name'  => __( 'Display Date and Time', 'webinars_' ),
        'id'    => "{$prefix}displaydate",
        'desc' => __( 'Example: Monday, January 1, 1:00 pm - 2:00 pm PT', 'webinars_' ),
        'type'  => 'text',
        'clone' => false,
      ),      
      // HEADING
      array(
        'type' => 'heading',
        'name' => __( 'Marketo Forms', 'webinars_' ),
        'id'   => 'fake_id', // Not used but needed for plugin
      ),
      // TEXT
      array(
        'name'  => __( 'Registration Form ID', 'webinars_' ),
        'id'    => "{$prefix}marketo_registration",
        'desc' => __( 'Example: 1234', 'webinars_' ),
        'type'  => 'text',
        'clone' => false,
      ),      
      // TEXT
      array(
        'name'  => __( 'On Demand Form ID', 'webinars_' ),
        'id'    => "{$prefix}marketo_on_demand",
        'desc' => __( 'Example: 1234', 'webinars_' ),
        'type'  => 'text',
        'clone' => false,
      ),
      // HEADING
      array(
        'type' => 'heading',
        'name' => __( 'Downloadable Assets', 'webinars_' ),
        'id'   => 'fake_id', // Not used but needed for plugin
      ),
      // TEXT
      array(
        'name'  => __( 'Asset Title', 'webinars_' ),
        'id'    => "{$prefix}asset_title",
        'type'  => 'text',
        'clone' => false,
      ),      
      // TEXTAREA
      array(
        'name' => esc_html__( 'Asset Description', 'webinars_' ),
        'id'   => "{$prefix}asset_description",
        'type' => 'textarea',
        'cols' => 20,
        'rows' => 3,
      ),
      // IMAGE ADVANCED (WP 3.5+)
      array(
        'name'             => __( 'Asset Image', 'webinars_' ),
        'id'               => "{$prefix}asset_image",
        'type'             => 'image_advanced',
        'max_file_uploads' => 1,
      ),
      // URL
      array(
        'name' => esc_html__( 'Asset Link', 'webinars_' ),
        'id'   => "{$prefix}asset_link",
        'desc' => esc_html__( 'Include http:// or https://', 'webinars_' ),
        'type' => 'url',
      ),
      // URL
      array(
        'name' => esc_html__( 'Slide Deck Link', 'webinars_' ),
        'id'   => "{$prefix}asset_slide_deck",
        'desc' => esc_html__( 'Include http:// or https://', 'webinars_' ),
        'type' => 'url',
      ),      
      // HEADING
      array(
        'type' => 'heading',
        'name' => __( 'Webinar Video', 'webinars_' ),
        'id'   => 'fake_id', // Not used but needed for plugin
      ),
      // TEXT
      array(
        'name'  => __( 'YouTube ID', 'webinars_' ),
        'id'    => "{$prefix}video",
        'desc' => __( 'DO NOT INCLUDE THE https://youtu.be/', 'webinars_' ),
        'type'  => 'text',
        'clone' => false,
      ),   
    )
  );

  $meta_boxes[] = array(
    'title'         => 'Content',   
    'post_types'    => 'socrata_webinars',
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
    'title'         => 'Webinar Status',   
    'post_types'    => 'socrata_webinars',
    'context'       => 'side',
    'priority'      => 'high',
    'fields' => array(
      // TAXONOMY
        array(
          'id'         => "{$prefix}taxonomy",
          'type'       => 'taxonomy',
          // Taxonomy name
          'taxonomy'   => 'socrata_webinars_cat',
          // How to show taxonomy: 'checkbox_list' (default) or 'checkbox_tree', 'select_tree', select_advanced or 'select'. Optional
          'field_type' => 'radio_list',
          // Additional arguments for get_terms() function. Optional
          'query_args' => array(),
        ),
    ),
  );

  $meta_boxes[] = array(
    'title'         => 'Speakers',   
    'post_types'    => 'socrata_webinars',
    'context'       => 'normal',
    'priority'      => 'high',
      'fields' => array(
        // HEADING
        array(
          'type' => 'heading',
          'name' => __( 'Speaker Info', 'webinars_' ),
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
            'name' => __( 'Name', 'webinars_' ),
            'id'   => "{$prefix}speaker_name",
            'type' => 'text',
          ),
          array(
            'name' => __( 'Title', 'webinars_' ),
            'id'   => "{$prefix}speaker_title",
            'type' => 'text',
          ),
          // IMAGE ADVANCED (WP 3.5+)
          array(
            'name'             => __( 'Headshot', 'webinars_' ),
            'id'               => "{$prefix}speaker_headshot",
            'desc' => __( 'Minimum size 300x300 pixels.', 'webinars_' ),
            'type'             => 'image_advanced',
            'max_file_uploads' => 1,
          ),
          // WYSIWYG/RICH TEXT EDITOR
          array(
            'name'    => __( 'Bio', 'webinars_' ),
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



// Shortcode [webinars]
function webinars_posts($atts, $content = null) {
  ob_start();
  ?>

<?php
  $args = array(
  'post_type'             => 'socrata_webinars',
  'socrata_webinars_cat'  => 'upcoming',
  'orderby'               => 'meta_value',
  'meta_key'              => 'webinars_starttime',
  'order'                 => 'asc',
  'posts_per_page'        => 3,
  'post_status'           => 'publish',
  );

  // The Query
  $the_query = new WP_Query( $args );

// The Loop
if ( $the_query->have_posts() ) { ?>
  <section class="section-padding background-light-grey-4 hidden-xs">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <h2 class="text-center margin-bottom-60">Upcoming webinars</h2>
      </div>
    </div>
  <div class="row row-centered">
  <?php

  while ( $the_query->have_posts() ) {
    $the_query->the_post();
    $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'post-image-small' );
    $url = $thumb['0'];
    $displaydate = rwmb_meta( 'webinars_displaydate' ); { ?>
      <div class="col-sm-4 col-centered">
        <div class="thumbnail">
          <?php
            if ( ! empty( $thumb ) ) { ?>
              <a href="<?php the_permalink() ?>"><img src="<?php echo $url;?>" class="img-responsive" /></a>
              <?php
            }     
            else { ?>
              <a href="<?php the_permalink() ?>"><img src="/wp-content/uploads/no-image.png" class="img-responsive" /></a>
              <?php
            }
          ?>
          <div class="caption">
            <h4 class="margin-bottom-5"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="link-black"><?php the_title(); ?></a></h4>
            <p class="margin-bottom-5"><small><?php echo $displaydate;?></small></p>
            <p class="margin-bottom-0"><a href="<?php the_permalink(); ?>">Learn more <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a></p>
          </div>
        </div>
      </div>
    <?php }
  } ?>
  
  </div>
  </div>
  </section>

  <?php
} 
else {
// no posts found
}
/* Restore original Post Data */
wp_reset_postdata(); ?>

  <section class="filter-bar">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <ul>
            <li><?php echo do_shortcode('[facetwp facet="webinar_status"]') ;?></li>
            <li class="hidden-xs"><?php echo do_shortcode('[facetwp facet="segment_dropdown"]') ;?></li>
            <li class="hidden-xs"><?php echo do_shortcode('[facetwp facet="product_dropdown"]') ;?></li>
            <li class="hidden-xs"><button onclick="FWP.reset()" class="facetwp-reset">Reset</button></li>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <section class="section-padding">
    <div class="container">
      <div class="row">
        <div class="col-sm-8">
          <?php echo do_shortcode('[facetwp template="webinars"]') ;?>        
        </div>
        <div class="col-sm-4 hidden-xs events-sidebar">
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
  <section class="settings-bar">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <ul>
            <li>
              <label>Display settings</label>
              <?php echo do_shortcode('[facetwp per_page="true"]') ;?>
            </li>
            <li>
              <label>Showing</label>
              <?php echo do_shortcode('[facetwp counts="true"]') ;?>
            </li>
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
add_shortcode('webinars', 'webinars_posts');