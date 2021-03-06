<?php
/*
Plugin Name: Socrata Banners
Plugin URI: http://socrata.com/
Description: Simple promotional banner ad management for editorial pages.
Version: 1.0
Author: Michael Church
Author URI: http://socrata.com/
License: GPLv2
*/

// REGISTER POST TYPE
add_action( 'init', 'socrata_banners_post_type' );

function socrata_banners_post_type() {
  register_post_type( 'socrata_banners',
    array(
      'labels' => array(
        'name' => 'Banners',
        'singular_name' => 'Banners',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Banner',
        'edit' => 'Edit',
        'edit_item' => 'Edit Banner',
        'new_item' => 'New Banner',
        'view' => 'View',
        'view_item' => 'View Banner',
        'search_items' => 'Search',
        'not_found' => 'Not found',
        'not_found_in_trash' => 'Not found in Trash'
      ),
      'public' => true,
      'menu_position' => 100,
      'supports' => array( 'title' ),
      'taxonomies' => array( '' ),
      'menu_icon' => '',
      'has_archive' => true,
      'rewrite' => array('with_front' => false, 'slug' => 'socrata-banners'),
    )
  );
}

// MENU ICON
//Using Dashicon Font https://developer.wordpress.org/resource/dashicons
add_action( 'admin_head', 'add_socrata_banners_icon' );
function add_socrata_banners_icon() { ?>
  <style>
    #adminmenu .menu-icon-socrata_banners div.wp-menu-image:before {
      content: '\f128';
    }
  </style>
  <?php
}

// Metabox
add_filter( 'rwmb_meta_boxes', 'socrata_banners_register_meta_boxes' );
function socrata_banners_register_meta_boxes( $meta_boxes )
{
  $prefix = 'socrata_banners_';
  $meta_boxes[] = array(
    'title'  => __( 'Banner Details', 'socrata_banners_' ),
    'post_types' => 'socrata_banners',
    'context'    => 'normal',
    'priority'   => 'high',
    'validation' => array(
      'rules'    => array(
        "{$prefix}link" => array(
            'required'  => true,
        ),
      ),
    ),
    'fields' => array(
      // CHECKBOX
      array(
        'name'  => __( 'Hide this banner', 'socrata_banners_' ),
        'id'   => "{$prefix}hide",
        'desc' => __( 'Yes', 'socrata_banners_' ),
        'type' => 'checkbox',
        // Value can be 0 or 1
        'std'  => 0,
      ), 
      // HEADING
      array(
        'type' => 'heading',
        'name' => __( 'Asset Meta', 'socrata_banners_' ),
        'id'   => 'fake_id', // Not used but needed for plugin
      ),
      // URL
      array(
        'name' => esc_html__( 'Asset Link', 'socrata_banners_' ),
        'id'   => "{$prefix}link",
        'type' => 'url',
      ),      
      // CHECKBOX
      array(
        'name'  => __( 'Open in new window?', 'socrata_banners_' ),
        'id'   => "{$prefix}target",
        'desc' => __( 'Yes', 'socrata_banners_' ),
        'type' => 'checkbox',
        // Value can be 0 or 1
        'std'  => 0,
      ),
      // IMAGE ADVANCED (WP 3.5+)
      array(
        'name'             => __( 'Asset Image', 'socrata_banners_' ),
        'id'               => "{$prefix}asset_image",
        'type'             => 'image_advanced',
        'max_file_uploads' => 1,
        'desc' => __( '360 x 300 pixels', 'socrata_banners_' ),
      ),
    )
  );

  return $meta_boxes;
}

// Shortcode [socrata-banner]
function socrata_banners_posts($atts, $content = null) {
  ob_start();
  ?>

  <?php

      // The Query
    $args = array(
          'post_type' => 'socrata_banners',
          'posts_per_page' => 1
        );
    $query = new WP_Query( $args );

    // The Loop
    while ( $query->have_posts() ) {
      $query->the_post();
      $hidden = rwmb_meta( 'socrata_banners_hide' );
      $ad = rwmb_meta( 'socrata_banners_asset_image', 'size=full' );
      $link = rwmb_meta( 'socrata_banners_link' );            
      $target = rwmb_meta( 'socrata_banners_target' );

      ?>

      <?php if ( ! empty( $hidden ) ) { } else { ?>

        <div class="margin-bottom-30">
          <?php if ( ! empty( $target ) ) { ?> 
            <a href="<?php echo $link;?>" target="_blank"><img src="<?php foreach ( $ad as $image ) { echo $image['url']; } ?>" class="img-responsive"></a>
          <?php } else { ?>  
            <a href="<?php echo $link;?>"><img src="<?php foreach ( $ad as $image ) { echo $image['url']; } ?>" class="img-responsive"></a>
          <?php } ?>                

        </div>

      <?php } ?>      

      <?php
    }

    wp_reset_postdata();

  ?>

  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('socrata-banners', 'socrata_banners_posts');
