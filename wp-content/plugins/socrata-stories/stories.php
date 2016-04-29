<?php
/*
Plugin Name: Socrata Customer Stories
Plugin URI: http://socrata.com/
Description: This plugin manages Socrata Customer Stories.
Version: 1.0
Author: Michael Church
Author URI: http://socrata.com/
License: GPLv2
*/
include_once('metaboxes/meta_box.php');
include_once('inc/fields.php');


// REGISTER POST TYPE
add_action( 'init', 'create_stories' );

function create_stories() {
  register_post_type( 'stories',
    array(
      'labels' => array(
        'name' => 'Stories',
        'singular_name' => 'Stories',
        'add_new' => 'Add New Story',
        'add_new_item' => 'Add New Story',
        'edit' => 'Edit Stories',
        'edit_item' => 'Edit Stories',
        'new_item' => 'New Story',
        'view' => 'View',
        'view_item' => 'View Story',
        'search_items' => 'Search Storiess',
        'not_found' => 'Not found',
        'not_found_in_trash' => 'Not found in Trash',
        'parent' => 'Socrata'
      ),
      'public' => true,
      'menu_position' => 5,
      'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' ),
      'taxonomies' => array( 'post_tag' ),
      'menu_icon' => '',
      'has_archive' => true,
      'rewrite' => array('with_front' => false, 'slug' => 'stories')
    )
  );
}

// MENU ICON
//Using Dashicon Font http://melchoyce.github.io/dashicons/
add_action( 'admin_head', 'add_stories_icon' );
function add_stories_icon() { ?>
  <style>
    #adminmenu .menu-icon-stories div.wp-menu-image:before {
      content: '\f123';
    }
  </style>
  <?php
}

// TAXONOMIES
add_action( 'init', 'create_stories_segment', 0 );
function create_stories_segment() {
  register_taxonomy(
    'stories_segment',
    'stories',
    array(
      'labels' => array(
        'name' => 'Stories Segment',
        'menu_name' => 'Stories Segment',
        'add_new_item' => 'Add New Segment',
        'new_item_name' => "New Segment"
      ),
      'show_ui' => true,
      'show_tagcloud' => false,
      'hierarchical' => true,
      'sort' => true,      
      'args' => array( 'orderby' => 'term_order' ),
      'show_admin_column' => true,
      'rewrite' => array('with_front' => false, 'slug' => 'stories-segment')
    )
  );
}

add_action( 'init', 'create_stories_product', 0 );
function create_stories_product() {
  register_taxonomy(
    'stories_product',
    'stories',
    array(
      'labels' => array(
        'name' => 'Stories Product',
        'menu_name' => 'Stories Product',
        'add_new_item' => 'Add New Product',
        'new_item_name' => "New Product"
      ),
      'show_ui' => true,
      'show_tagcloud' => false,
      'hierarchical' => true,
      'sort' => true,      
      'args' => array( 'orderby' => 'term_order' ),
      'show_admin_column' => true,
      'rewrite' => array('with_front' => false, 'slug' => 'stories-product')
    )
  );
}

// CUSTOM COLUMS FOR ADMIN
add_filter( 'manage_edit-stories_columns', 'stories_edit_columns' ) ;
function stories_edit_columns( $columns ) {
  $columns = array(
    'cb'              => '<input type="checkbox" />',    
    'title'           => __( 'Name' ),
    'segment'         => __( 'Segment' ),
    'product'         => __( 'Product' ),
    'date'            => __( 'Date' ),
    'wpseo-score'     => __( 'SEO' ),

  );
  return $columns;
}
// Get Content for Custom Colums
add_action("manage_stories_posts_custom_column",  "stories_columns");
function stories_columns($column){
  global $post;

  switch ($column) {
    case 'segment':
      $segment = get_the_terms($post->ID , 'stories_segment');
      echo $segment[0]->name;
      for ($i = 1; $i < count($segment); $i++) {echo ', ' . $segment[$i]->name ;}
      break;
    case 'product':
      $product = get_the_terms($post->ID , 'stories_product');
      echo $product[0]->name;
      for ($i = 1; $i < count($product); $i++) {echo ', ' . $product[$i]->name ;}
      break;
  }
}
// Make these columns sortable
add_filter( "manage_edit-stories_sortable_columns", "stories_sortable_columns" );
function stories_sortable_columns() {
  return array(
    'title'       => 'title',
    'segment'     => 'segment',
    'product'     => 'product'
  );
}


// Template Paths
add_filter( 'template_include', 'stories_single_template', 1 );
function stories_single_template( $template_path ) {
  if ( get_post_type() == 'stories' ) {
    if ( is_single() ) {
      // checks if the file exists in the theme first,
      // otherwise serve the file from the plugin
      if ( $theme_file = locate_template( array ( 'single-stories.php' ) ) ) {
        $template_path = $theme_file;
      } else {
        $template_path = plugin_dir_path( __FILE__ ) . 'single-stories.php';
      }
    }
    if ( is_archive() ) {
      // checks if the file exists in the theme first,
      // otherwise serve the file from the plugin
      if ( $theme_file = locate_template( array ( 'archive-stories.php' ) ) ) {
        $template_path = $theme_file;
      } else {
        $template_path = plugin_dir_path( __FILE__ ) . 'archive-stories.php';
      }
    }
  }
  return $template_path;
}

// Custom Body Class
add_action( 'body_class', 'stories_body_class');
function stories_body_class( $classes ) {
  if ( is_page('customer-stories') || get_post_type() == 'stories' && is_single() || get_post_type() == 'stories' && is_archive() )
    $classes[] = 'stories';
  return $classes;
}


// Print Taxonomy Categories
function stories_the_categories() {
    // get all categories for this post
    global $terms;
    $terms = get_the_terms($post->ID , 'stories_segment');
    // echo the first category
    echo $terms[0]->name;
    // echo the remaining categories, appending separator
    for ($i = 1; $i < count($terms); $i++) {echo ', ' . $terms[$i]->name ;}
}


// Shortcode [stories-posts]
function stories_posts($atts, $content = null) {
  ob_start();
  ?>

  <div class="container page-padding">
    <div class="row">
      <div class="col-sm-9">
        <div class="row">

          <?php

          $do_not_duplicate = array();

          // The Query
          $args = array(
                'post_type' => 'stories',
                'posts_per_page' => 1
              );
          $query1 = new WP_Query( $args );

          // The Loop
          while ( $query1->have_posts() ) {
            $query1->the_post();
            $do_not_duplicate[] = get_the_ID(); ?>
            <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'post-image' ); $url = $thumb['0']; ?>
            <div class="col-sm-12">
              <div class="featured-post overlay-black" style="background-image: url(<?=$url?>);">
                <div class="text truncate" style="height:200px;">
                  <div class="post-category background-nephritis">Customer Stories</div>
                  <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
                  <?php the_excerpt(); ?>
                </div>
                <a href="<?php the_permalink() ?>" class="link"></a>
              </div>
            </div>

            <?php
          }

          wp_reset_postdata();

          /* The 2nd Query (without global var) */
          $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
          $args2 = array(
                'post_type' => 'stories',
                'paged' => $paged,
                'post__not_in' => $do_not_duplicate 
              );
          $query2 = new WP_Query( $args2 );

          // The 2nd Loop
          while ( $query2->have_posts() ) {
            $query2->the_post(); ?>
            <?php 
            $meta = get_socrata_stories_meta(); 
            $thumb = wp_get_attachment_image_src( $meta[6], 'full-width-ratio' ); 
            $url = $thumb['0']; ?>
            <div class="col-sm-6 col-lg-4">
              <div class="card">
                <div class="card-image hidden-xs">
                  <img src="<?=$url?>" class="img-responsive">                    
                  <a href="<?php the_permalink() ?>"></a>
                </div>
                <div class="card-text truncate">
                  <p class="categories"><?php stories_the_categories(); ?></p>
                  <h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
                  <?php the_excerpt(); ?> 
                </div>
              </div>
            </div>

            <?php
          }

          // Pagination
          if (function_exists("pagination")) {pagination($query2->max_num_pages,$pages);} 

          // Restore original Post Data
          wp_reset_postdata();

          ?>

        </div>      
      </div>
      <div class="col-sm-3">
        <?php
          //list terms in a given taxonomy using wp_list_categories  (also useful as a widget)
          $orderby = 'name';
          $show_count = 0; // 1 for yes, 0 for no
          $pad_counts = 0; // 1 for yes, 0 for no
          $hide_empty = 1;
          $hierarchical = 1; // 1 for yes, 0 for no
          $taxonomy = 'stories_segment';
          $title = 'Segment';

          $args = array(
            'orderby' => $orderby,
            'show_count' => $show_count,
            'pad_counts' => $pad_counts,
            'hide_empty' => $hide_empty,
            'hierarchical' => $hierarchical,
            'taxonomy' => $taxonomy,
            'title_li' => '<h5>'. $title .'</h5>'
          );
        ?>
        <ul class="category-nav">
          <?php wp_list_categories($args); ?>
        </ul>
        <?php
          //list terms in a given taxonomy using wp_list_categories  (also useful as a widget)
          $orderby = 'name';
          $show_count = 0; // 1 for yes, 0 for no
          $pad_counts = 0; // 1 for yes, 0 for no
          $hide_empty = 1;
          $hierarchical = 1; // 1 for yes, 0 for no
          $taxonomy = 'stories_product';
          $title = 'Product';

          $args = array(
            'orderby' => $orderby,
            'show_count' => $show_count,
            'pad_counts' => $pad_counts,
            'hide_empty' => $hide_empty,
            'hierarchical' => $hierarchical,
            'taxonomy' => $taxonomy,
            'title_li' => '<h5>'. $title .'</h5>'
          );
        ?>
        <ul class="category-nav">
          <?php wp_list_categories($args); ?>
        </ul>
        <?php echo do_shortcode('[newsletter-sidebar]'); ?>
      </div>
    </div>
  </div>

  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('stories-posts', 'stories_posts');
