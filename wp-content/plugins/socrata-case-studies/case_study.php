<?php
/*
Plugin Name: Socrata Case Studies
Plugin URI: http://socrata.com/
Description: This plugin manages Case Studies.
Version: 1.0
Author: Michael Church
Author URI: http://Socrata.com/
License: GPLv2
*/


// REGISTER POST TYPE
add_action( 'init', 'case_study_post_type' );

function case_study_post_type() {
  register_post_type( 'case_study',
    array(
      'labels' => array(
        'name' => 'Case Studies',
        'singular_name' => 'Case Study',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Case Study',
        'edit' => 'Edit',
        'edit_item' => 'Edit Case Study',
        'new_item' => 'New Case Study',
        'view' => 'View',
        'view_item' => 'View Case Studies',
        'search_items' => 'Search Case Studies',
        'not_found' => 'Not found',
        'not_found_in_trash' => 'Not found in Trash',
        'parent' => 'Parent Case Study'
      ),
      'public' => true,
      'menu_position' => 5,
      'supports' => array( 'title', 'thumbnail' ),
      'taxonomies' => array( '' ),
      'menu_icon' => '',
      'has_archive' => true,
      'rewrite' => array('with_front' => false, 'slug' => 'case-study'),
    )
  );
}

// MENU ICON
//Using Dashicon Font http://melchoyce.github.io/dashicons/
add_action( 'admin_head', 'add_case_study_icon' );
function add_case_study_icon() { ?>
  <style>
    #adminmenu .menu-icon-case_study div.wp-menu-image:before {
      content: '\f123';
    }
  </style>
  <?php
}

// Template Paths
add_filter( 'template_include', 'case_study_single_template', 1 );
function case_study_single_template( $template_path ) {
  if ( get_post_type() == 'case_study' ) {
    if ( is_single() ) {
      // checks if the file exists in the theme first,
      // otherwise serve the file from the plugin
      if ( $theme_file = locate_template( array ( 'single-case-study.php' ) ) ) {
        $template_path = $theme_file;
      } else {
        $template_path = plugin_dir_path( __FILE__ ) . 'single-case-study.php';
      }
    }
    if ( is_archive() ) {
      // checks if the file exists in the theme first,
      // otherwise serve the file from the plugin
      if ( $theme_file = locate_template( array ( 'archive-case-study.php' ) ) ) {
        $template_path = $theme_file;
      } else {
        $template_path = plugin_dir_path( __FILE__ ) . 'archive-case-study.php';
      }
    }
  }
  return $template_path;
}

// Custom Body Class
add_action( 'body_class', 'case_study_body_class');
function case_study_body_class( $classes ) {
  if ( is_page('case-studies') || get_post_type() == 'case_study' && is_single() )
    $classes[] = 'case-study';
  return $classes;
}

// CUSTOM EXCERPT
function case_studies_excerpt() {
  global $post;
  $text = rwmb_meta( 'case_study_wysiwyg' );
  if ( '' != $text ) {
    $text = strip_shortcodes( $text );
    $text = apply_filters('the_content', $text);
    $text = str_replace(']]>', ']]>', $text);
    $excerpt_length = 20; // 20 words
    $excerpt_more = apply_filters('excerpt_more', ' ' . ' ...');
    $text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
  }
  return apply_filters('get_the_excerpt', $text);
}

// Metabox
add_filter( 'rwmb_meta_boxes', 'case_study_register_meta_boxes' );
function case_study_register_meta_boxes( $meta_boxes )
{
  $prefix = 'case_study_';

  $meta_boxes[] = array(
    'title'  => __( 'Case Study Meta', 'case_study_' ),
    'post_types' => array( 'case_study' ),
    'context'    => 'normal',
    'priority'   => 'high',
    'fields' => array(
      // TEXT
      array(
        'name'  => __( 'Customer', 'case_study_' ),
        'id'    => "{$prefix}customer",
        'type'  => 'text',
      ),
      // TEXT
      array(
        'name'  => __( 'Site Name', 'case_study_' ),
        'id'    => "{$prefix}site_name",
        'type'  => 'text',
      ),
      // URL
      array(
        'name' => __( 'URL', 'case_study_' ),
        'id'   => "{$prefix}url",
        'desc' => __( 'Include the http:// or https://', 'case_study_' ),
        'type' => 'url',
      ),
    ),
  );

  $meta_boxes[] = array(
    'title'         => 'Highlights',   
    'post_types'    => 'case_study',
    'context'       => 'normal',
    'priority'      => 'high',
    'fields' => array(
      // TEXT
      array(
        'name'  => esc_html__( 'Highlight', 'case_study_' ),
        'id'    => "{$prefix}highlight",
        'type'  => 'text',
        'clone' => true,
      ),
    ),
  );

  $meta_boxes[] = array(
    'title'         => 'Pull Quote',   
    'post_types'    => 'case_study',
    'context'       => 'normal',
    'priority'      => 'high',
    'fields' => array(
      // TEXT
      array(
        'name'  => __( 'Name', 'case_study_' ),
        'id'    => "{$prefix}name",
        'type'  => 'text',
      ),
      // TEXT
      array(
        'name'  => __( 'Title', 'case_study_' ),
        'id'    => "{$prefix}title",
        'type'  => 'text',
      ),
      // IMAGE ADVANCED (WP 3.5+)
      array(
        'name'             => __( 'Headshot', 'case_study_' ),
        'id'               => "{$prefix}headshot",
        'type'             => 'image_advanced',
        'max_file_uploads' => 1,
      ),
      // TEXTAREA
      array(
        'name' => esc_html__( 'Quote', 'case_study_' ),
        'id'   => "{$prefix}quote",
        'type' => 'textarea',
        'cols' => 20,
        'rows' => 3,
      ),
    ),
  );

  $meta_boxes[] = array(
    'title'         => 'Case Study Content',   
    'post_types'    => 'case_study',
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

  return $meta_boxes;
}


// Shortcode [case-study-posts]
function case_study_posts($atts, $content = null) {
  ob_start();
  ?>
  <section class="filter-bar">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <ul>
            <li><?php echo do_shortcode('[facetwp facet="segment_dropdown"]') ;?></li>
            <li class="border-right"><?php echo do_shortcode('[facetwp facet="product_dropdown"]') ;?></li>
            <li><button onclick="FWP.reset()" class="facetwp-reset">Reset</button></li>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <section class="section-padding">
    <div class="container">
      <div class="row">
        <div class="col-sm-8">
          <?php echo do_shortcode('[facetwp template="case_studies"]') ;?>    
        </div>
        <div class="col-sm-4 hidden-xs">
          <?php echo do_shortcode('[newsletter-sidebar]'); ?> 
          <?php
          $args = array(
          'post_type'         => 'socrata_webinars',
          'order'             => 'desc',
          'posts_per_page'    => 3,
          'post_status'       => 'publish',
          );

          // The Query
          $the_query = new WP_Query( $args );

          // The Loop
          if ( $the_query->have_posts() ) {
          echo '<ul class="no-bullets sidebar-list">';
          echo '<li><h5>Recent Webinars</h5></li>';
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
          echo '<li><a href="/webinars">View all webinars <i class="fa fa-arrow-circle-o-right"></i></a></li>';
          echo '</ul>';
          } else {
          // no posts found
          }
          /* Restore original Post Data */
          wp_reset_postdata(); ?>

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
          <a href="<?php the_permalink() ?>"><img src="https://img.youtube.com/vi/<?php $meta = get_socrata_videos_meta(); echo $meta[1]; ?>/default.jpg" class="img-responsive"></a>
          </div>
          <div class="article-title-container">
          <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
          </div>
          </li>

          <?php }
          }
          echo '<li><a href="/videos">View all videos <i class="fa fa-arrow-circle-o-right"></i></a></li>';
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
add_shortcode('case-study-posts', 'case_study_posts');


