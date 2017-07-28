<?php
/*
Plugin Name: Socrata Customer Logos
Plugin URI: http://socrata.com/
Description: This plugin manages customer logos.
Version: 1.0
Author: Michael Church
Author URI: http://socrata.com/
License: GPLv2
*/

add_action( 'init', 'create_socrata_logos' );
function create_socrata_logos() {
  register_post_type( 'socrata_logos',
    array(
      'labels' => array(
        'name' => 'Logos',
        'singular_name' => 'Logos',
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
      'supports' => array( 'title' ),
      'taxonomies' => array( '' ),
      'menu_icon' => '',
      'has_archive' => false,
      'rewrite' => array('with_front' => false, 'slug' => 'logos')
    )
  );
}

// MENU ICON
//Using Dashicon Font https://developer.wordpress.org/resource/dashicons
add_action( 'admin_head', 'add_socrata_logos_icon' );
function add_socrata_logos_icon() { ?>
  <style>
    #adminmenu .menu-icon-socrata_logos div.wp-menu-image:before {
      content: '\f159';
    }
  </style>
  <?php
}

// METABOXES
add_filter( 'rwmb_meta_boxes', 'socrata_logos_register_meta_boxes' );
function socrata_logos_register_meta_boxes( $meta_boxes )
{
  $prefix = 'logos_';

  $meta_boxes[] = array(
    'title'         => 'Customer Info',   
    'post_types'    => 'socrata_logos',
    'context'       => 'normal',
    'priority'      => 'high',
    'fields' => array(
      // IMAGE ADVANCED (WP 3.5+)
      array(
        'name'              => __( 'Logo', 'logos_' ),
        'id'                => "{$prefix}brand",
        'desc'              => __( 'Minimum size 300x300 pixels.', 'logos_' ),
        'type'              => 'image_advanced',
        'max_file_uploads'  => 1,
      ),
      // WYSIWYG/RICH TEXT EDITOR
      array(
        'name'    => esc_html__( 'Content', 'logos_' ),
        'id'      => "{$prefix}wysiwyg",
        'type'    => 'wysiwyg',
        // Set the 'raw' parameter to TRUE to prevent data being passed through wpautop() on save
        'raw'     => false,
        // Editor settings, see wp_editor() function: look4wp.com/wp_editor
        'options' => array(
          'textarea_rows' => 4,
          'teeny'         => false,
          'media_buttons' => false,
        ),
      ),
    ),
  );

  return $meta_boxes;
}

// Shortcode [logo-slider solution="SOLUTION SLUG" segment="SEGMENT SLUG" product="PRODUCT SLUG"]
function socrata_logo_slider($atts, $content = null) {
  extract( shortcode_atts( array(
    'solution' => '',
    'segment' => '',
    'product' => '',
  ), $atts ) );
  ob_start();
  ?>
  <div id="logos">
    <div class="container">
      <div class="customer-logos">   
        <?php
        $args = array(
        'post_type' => 'socrata_logos',  
        'solution' => $solution,
        'segment' => $segment,
        'product' => $product,
        'posts_per_page' => 100,
        'orderby' => 'date',
        'order'   => 'asc',
        );
        $myquery = new WP_Query($args);
        // The Loop
        while ( $myquery->have_posts() ) { $myquery->the_post(); 
        $logo = rwmb_meta( 'logos_brand', 'size=medium' );
        ?>

        <div class="text-center">
          <div class="match-height" style="padding:0 15px;">
            <div class="sixteen-nine margin-bottom-15" style="background-image:url(<?php foreach ( $logo as $image ) { echo $image['url']; } ?>); background-size:contain; background-repeat:no-repeat; background-position:center center;"></div>
            <?php the_title();?>
          </div>
        </div>

        <?php
        }
        wp_reset_postdata();
        ?>
      </div>
    </div>
  </div>

  <script type="text/javascript">
  $(document).ready(function(){
    $('.customer-logos').slick({
      arrows: true,
      appendArrows: $('#logos'),
      prevArrow: '<div class="toggle-left"><i class="fa slick-prev fa-long-arrow-left"></i></div>',
      nextArrow: '<div class="toggle-right"><i class="fa slick-next fa-long-arrow-right"></i></div>',
      autoplay: true,
      autoplaySpeed: 5000,
      speed: 800,
      slidesToShow: 5,
      slidesToScroll: 1,
      accessibility:false,
      dots:false,
      responsive: [
          {
            breakpoint: 992,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 1
            }
          },
          {
            breakpoint: 768,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 1
            }
          },
          {
            breakpoint: 480,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }
        ]
    });
    $('.customer-logos').show();
  });
  </script>

  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('logo-slider', 'socrata_logo_slider');

// Shortcode [logo-slider-content solution="SOLUTION SLUG" segment="SEGMENT SLUG" product="PRODUCT SLUG"]
function socrata_logo_slider_content($atts, $content = null) {
  extract( shortcode_atts( array(
    'solution' => '',
    'segment' => '',
    'product' => '',
  ), $atts ) );
  ob_start();
  ?>
  <div id="logos">
    <div class="container">
      <div class="row">
        <div class="customer-logos">   
          <?php
          $args = array(
          'post_type' => 'socrata_logos',  
          'solution' => $solution,
          'segment' => $segment,
          'product' => $product,
          'posts_per_page' => 100,
          'orderby' => 'date',
          'order'   => 'asc',
          );
          $myquery = new WP_Query($args);
          // The Loop
          while ( $myquery->have_posts() ) { $myquery->the_post(); 
          $logo = rwmb_meta( 'logos_brand', 'size=medium' );
          $content = rwmb_meta( 'logos_wysiwyg' );
          ?>

          
            <div class="match-height" style="padding:0 15px;">
              <div class="padding-30 margin-bottom-15" style="border-bottom:#d6d6d6 solid 1px;">
                <div class="sixteen-nine" style="background-image:url(<?php foreach ( $logo as $image ) { echo $image['url']; } ?>); background-size:contain; background-repeat:no-repeat; background-position:center center;"></div>
              </div>
              <div style="text-align: left;">
                <h5 class="margin-bottom-15"><?php the_title();?></h5>
                <?php echo $content;?>
              </div>
            </div>
          
          

          <?php
          }
          wp_reset_postdata();
          ?>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
  $(document).ready(function(){
    $('.customer-logos').slick({
      arrows: true,
      appendArrows: $('#logos'),
      prevArrow: '<div class="toggle-left"><i class="fa slick-prev fa-long-arrow-left"></i></div>',
      nextArrow: '<div class="toggle-right"><i class="fa slick-next fa-long-arrow-right"></i></div>',
      autoplay: true,
      autoplaySpeed: 5000,
      speed: 800,
      slidesToShow: 4,
      slidesToScroll: 1,
      accessibility:false,
      dots:false,
      responsive: [
          {
            breakpoint: 992,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 1
            }
          },
          {
            breakpoint: 768,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 1
            }
          },
          {
            breakpoint: 480,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }
        ]
    });
    $('.customer-logos').show();
  });
  </script>

  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('logo-slider-content', 'socrata_logo_slider_content');
