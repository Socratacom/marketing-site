<?php
/*
Plugin Name: Socrata Leadership
Plugin URI: http://socrata.com/
Description: This plugin manages Executives and Advisors.
Version: 1.0
Author: Michael Church
Author URI: http://socrata.com/
License: GPLv2
*/

add_action( 'init', 'create_socrata_leadership' );
function create_socrata_leadership() {
  register_post_type( 'socrata_leadership',
    array(
      'labels' => array(
        'name' => 'Leadership',
        'singular_name' => 'Leadership',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New',
        'edit' => 'Edit',
        'edit_item' => 'Edit',
        'new_item' => 'New',
        'view' => 'View',
        'view_item' => 'View',
        'search_items' => 'Search',
        'not_found' => 'Not found',
        'not_found_in_trash' => 'Not found in Trash'
      ),
      'public' => true,
      'menu_position' => 100,
      'supports' => array( 'title', 'thumbnail' ),
      'taxonomies' => array( '' ),
      'menu_icon' => '',
      'has_archive' => false,
      'rewrite' => array('with_front' => false, 'slug' => 'leadership')
    )
  );
}

// MENU ICON
//Using Dashicon Font https://developer.wordpress.org/resource/dashicons
add_action( 'admin_head', 'add_socrata_leadership_icon' );
function add_socrata_leadership_icon() { ?>
  <style>
    #adminmenu .menu-icon-socrata_leadership div.wp-menu-image:before {
      content: '\f338';
    }
  </style>
  <?php
}

// TAXONOMIES
add_action( 'init', 'socrata_leadership_taxonomie', 0 );
function socrata_leadership_taxonomie() {
  register_taxonomy(
    'socrata_leadership_type',
    'socrata_leadership',
    array(
      'labels' => array(
        'name' => 'Type',
        'menu_name' => 'Type',
        'add_new_item' => 'Add New',
        'new_item_name' => "New Type"
      ),
      'show_ui' => true,
      'show_tagcloud' => false,
      'hierarchical' => true,
      'sort' => true,      
      'args' => array( 'orderby' => 'term_order' ),
      'show_admin_column' => true,
      'rewrite' => array('with_front' => false, 'slug' => 'leadership-type'),
    )
  );
}

// CUSTOM EXCERPT
function leadership_excerpt() {
  global $post;
  $text = rwmb_meta( 'leadership_wysiwyg' );
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

// METABOXES
add_filter( 'rwmb_meta_boxes', 'socrata_leadership_register_meta_boxes' );
function socrata_leadership_register_meta_boxes( $meta_boxes )
{
  $prefix = 'leadership_';

  $meta_boxes[] = array(
    'title'         => 'Profile Info',   
    'post_types'    => 'socrata_leadership',
    'context'       => 'normal',
    'priority'      => 'high',

    'fields' => array(
      // TEXT
      array(
        'name'  => esc_html__( 'Title', 'leadership_' ),
        'id'    => "{$prefix}title",
        'type'  => 'text',
      ),
      // URL
      array(
        'name' => esc_html__( 'Twitter', 'leadership_' ),
        'id'   => "{$prefix}twitter",
        'type' => 'url',
      ),
      // URL
      array(
        'name' => esc_html__( 'Linked In', 'leadership_' ),
        'id'   => "{$prefix}linkedin",
        'type' => 'url',
      ),
      // IMAGE ADVANCED (WP 3.5+)
      array(
        'name'              => __( 'Headshot', 'leadership_' ),
        'id'                => "{$prefix}headshot",
        'desc'              => __( 'Minimum size 300x300 pixels.', 'leadership_' ),
        'type'              => 'image_advanced',
        'max_file_uploads'  => 1,
      ),
    ),
  );

  $meta_boxes[] = array(
    'title'         => 'Bio',   
    'post_types'    => 'socrata_leadership',
    'context'       => 'normal',
    'priority'      => 'high',
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
          'media_buttons' => false,
        ),
      ),
    ),
  );

  return $meta_boxes;
}

// Shortcode [directory-stats]
function leadership_executive_bios($atts, $content = null) {
  ob_start();
  ?>

  <?php
  $args = array(
  'post_type' => 'socrata_leadership',
  'socrata_leadership_type' => 'executive',
  'posts_per_page' => 100,
  'orderby' => 'date',
  'order'   => 'asc',
  );
  $myquery = new WP_Query($args);
  // The Loop
  while ( $myquery->have_posts() ) { $myquery->the_post(); 
  $title = rwmb_meta( 'leadership_title' );
  $twitter = rwmb_meta( 'leadership_twitter' );
  $linkedin = rwmb_meta( 'leadership_linkedin' );
  $headshot = rwmb_meta( 'leadership_headshot', 'size=medium' );
  $bio = rwmb_meta( 'leadership_wysiwyg' );
  $id = get_the_ID();
  ?>


  <div class="col-sm-6 col-md-4 col-lg-3">
    <div class="card margin-bottom-30 match-height">
      <div class="card-header">
        <div class="sixteen-nine img-background" style="background-image:url(<?php foreach ( $headshot as $image ) { echo $image['url']; } ?>);">
        </div>
      </div>
      <div class="card-body">
        <h5 style="margin-bottom:0;"><?php the_title(); ?></h5>
        <p class="margin-bottom-15 font-normal" style="line-height:normal;"><small><?php echo $title; ?></small></p>
        <p><?php echo leadership_excerpt(); ?></p>
      </div>
      <div class="card-footer padding-15">
        <a href="javascript:;" data-toggle="modal" data-target="#<?php echo $id;?>" class="btn btn-default" style="position:relative; height:auto; width:auto;">Read More</a>
        <div style="position:absolute; right:25px; bottom:25px;">
          <?php if ( ! empty( $linkedin ) ) { ?> <a href="<?php echo $linkedin; ?>" target="_blank" style="padding:0 5px; position:relative; height:auto; width:auto;"><i class="fa fa-linkedin"></i></a> <?php }; ?><?php if ( ! empty( $twitter ) ) { ?> <a href="<?php echo $twitter; ?>" target="_blank" style="padding:0 5px; position:relative; height:auto; width:auto;"><i class="fa fa-twitter"></i></a> <?php }; ?>
        </div>
      </div>
    </div>
  </div>

  <div class="modal leadership-modal" id="<?php echo $id;?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="bio-dialog">
      <div class="bio-content">
        <div class="container">
          <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
              <div class="box">
                <div class="bio-header">
                  <div class="headshot" style="background-image:url(<?php foreach ( $headshot as $image ) { echo $image['url']; } ?>)"></div>
                  <h5 class="margin-bottom-0 title"><?php the_title(); ?></h5>
                  <button type="button" data-dismiss="modal"><i class="icon-close"></i></button>
                </div>              
                <div class="bio-body">
                  <div class="padding-30">
                    <?php echo $bio; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>


  <?php
  }
  wp_reset_postdata();
  ?>

  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('executive_bios', 'leadership_executive_bios');

// Shortcode [directory-stats]
function leadership_advisor_bios($atts, $content = null) {
  ob_start();
  ?>

  <?php
  $args = array(
  'post_type' => 'socrata_leadership',
  'socrata_leadership_type' => 'advisor',
  'posts_per_page' => 100,
  'orderby' => 'date',
  'order'   => 'asc',
  );
  $myquery = new WP_Query($args);
  // The Loop
  while ( $myquery->have_posts() ) { $myquery->the_post(); 
  $title = rwmb_meta( 'leadership_title' );
  $twitter = rwmb_meta( 'leadership_twitter' );
  $linkedin = rwmb_meta( 'leadership_linkedin' );
  $headshot = rwmb_meta( 'leadership_headshot', 'size=medium' );
  $bio = rwmb_meta( 'leadership_wysiwyg' );
  $id = get_the_ID();
  ?>

  <div class="col-sm-6 col-md-4 col-lg-3">
    <div class="card margin-bottom-30 match-height">
      <div class="card-header">
        <div class="sixteen-nine img-background" style="background-image:url(<?php foreach ( $headshot as $image ) { echo $image['url']; } ?>);">
        </div>
      </div>
      <div class="card-body">
        <h5 style="margin-bottom:0;"><?php the_title(); ?></h5>
        <p class="margin-bottom-15 font-normal" style="line-height:normal;"><small><?php echo $title; ?></small></p>
        <p><?php echo leadership_excerpt(); ?></p>
      </div>
      <div class="card-footer padding-15">
        <a href="javascript:;" data-toggle="modal" data-target="#<?php echo $id;?>" class="btn btn-default" style="position:relative; height:auto; width:auto;">Read More</a>
        <div style="position:absolute; right:25px; bottom:25px;">
          <?php if ( ! empty( $linkedin ) ) { ?> <a href="<?php echo $linkedin; ?>" target="_blank" style="padding:0 5px; position:relative; height:auto; width:auto;"><i class="fa fa-linkedin"></i></a> <?php }; ?><?php if ( ! empty( $twitter ) ) { ?> <a href="<?php echo $twitter; ?>" target="_blank" style="padding:0 5px; position:relative; height:auto; width:auto;"><i class="fa fa-twitter"></i></a> <?php }; ?>
        </div>
      </div>
    </div>
  </div>

  <div class="modal leadership-modal" id="<?php echo $id;?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="bio-dialog">
      <div class="bio-content">
        <div class="container">
          <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
              <div class="box">
                <div class="bio-header">
                  <div class="headshot" style="background-image:url(<?php foreach ( $headshot as $image ) { echo $image['url']; } ?>)"></div>
                  <h5 class="margin-bottom-0 title"><?php the_title(); ?></h5>
                  <button type="button" data-dismiss="modal"><i class="icon-close"></i></button>
                </div>              
                <div class="bio-body">
                  <div class="padding-30">
                    <?php echo $bio; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <?php
  }

  wp_reset_postdata();
  ?>                 
 
  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('advisor_bios', 'leadership_advisor_bios');





