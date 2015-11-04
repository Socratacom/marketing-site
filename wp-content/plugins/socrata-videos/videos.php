<?php
/*
Plugin Name: Socrata Videos
Plugin URI: http://socrata.com/
Description: This plugin manages Socrata Videos.
Version: 1.0
Author: Michael Church
Author URI: http://socrata.com/
License: GPLv2
*/
include_once('metaboxes/meta_box.php');
include_once('inc/fields.php');


// REGISTER POST TYPE
add_action( 'init', 'create_socrata_videos' );

function create_socrata_videos() {
  register_post_type( 'socrata_videos',
    array(
      'labels' => array(
        'name' => 'Videos',
        'singular_name' => 'Videos',
        'add_new' => 'Add New Video',
        'add_new_item' => 'Add New Video',
        'edit' => 'Edit Videos',
        'edit_item' => 'Edit Videos',
        'new_item' => 'New Video',
        'view' => 'View',
        'view_item' => 'View Video',
        'search_items' => 'Search Videos',
        'not_found' => 'Not found',
        'not_found_in_trash' => 'Not found in Trash',
        'parent' => 'Socrata'
      ),
      'public' => true,
      'menu_position' => 5,
      'supports' => array( 'title', 'revisions' ),
      'taxonomies' => array( '' ),
      'menu_icon' => '',
      'has_archive' => true,
      'rewrite' => array('with_front' => false, 'slug' => 'video')
    )
  );
}

// MENU ICON
//Using Dashicon Font http://melchoyce.github.io/dashicons/
add_action( 'admin_head', 'add_socrata_videos_icon' );
function add_socrata_videos_icon() { ?>
  <style>
    #adminmenu .menu-icon-socrata_videos div.wp-menu-image:before {
      content: '\f236';
    }
  </style>
  <?php
}

// TAXONOMIES
add_action( 'init', 'socrata_videos_category', 0 );
function socrata_videos_category() {
  register_taxonomy(
    'socrata_videos_category',
    'socrata_videos',
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
      'rewrite' => array('with_front' => false, 'slug' => 'video-category')
    )
  );
}

// CUSTOM COLUMS FOR ADMIN
add_filter( 'manage_edit-socrata_videos_columns', 'socrata_videos_edit_columns' ) ;
function socrata_videos_edit_columns( $columns ) {
  $columns = array(
    'cb'              => '<input type="checkbox" />',    
    'title'           => __( 'Name' ),
    'terms'           => __( 'Category' ),
    'featured'        => __( 'Featured' ),
    'date'            => __( 'Date' ),
    'wpseo-score'     => __( 'SEO' ),

  );
  return $columns;
}
// Get Content for Custom Colums
add_action("manage_socrata_videos_posts_custom_column",  "socrata_videos_columns");
function socrata_videos_columns($column){
  global $post;

  switch ($column) {    
    case 'featured':
      $meta = get_socrata_videos_meta(); if ($meta[0]) echo "Yes";
      break;
    case 'terms':
      $terms = get_the_terms($post->ID , 'socrata_videos_category');
      echo $terms[0]->name;
      for ($i = 1; $i < count($terms); $i++) {echo ', ' . $terms[$i]->name ;}
      break;
  }
}
// Make these columns sortable
add_filter( "manage_edit-socrata_videos_sortable_columns", "socrata_videos_sortable_columns" );
function socrata_videos_sortable_columns() {
  return array(
    'title'      => 'title',
    'terms' => 'terms',
    'featured'     => 'featured'
  );
}

// Template Paths
add_filter( 'template_include', 'socrata_videos_single_template', 1 );
function socrata_videos_single_template( $template_path ) {
  if ( get_post_type() == 'socrata_videos' ) {
    if ( is_single() ) {
      // checks if the file exists in the theme first,
      // otherwise serve the file from the plugin
      if ( $theme_file = locate_template( array ( 'single-videos.php' ) ) ) {
        $template_path = $theme_file;
      } else {
        $template_path = plugin_dir_path( __FILE__ ) . 'single-videos.php';
      }
    }
    if ( is_archive() ) {
      // checks if the file exists in the theme first,
      // otherwise serve the file from the plugin
      if ( $theme_file = locate_template( array ( 'archive-videos.php' ) ) ) {
        $template_path = $theme_file;
      } else {
        $template_path = plugin_dir_path( __FILE__ ) . 'archive-videos.php';
      }
    }
  }
  return $template_path;
}

// Print Taxonomy Categories
function videos_the_categories() {
    // get all categories for this post
    global $terms;
    $terms = get_the_terms($post->ID , 'socrata_videos_category');
    // echo the first category
    echo $terms[0]->name;
    // echo the remaining categories, appending separator
    for ($i = 1; $i < count($terms); $i++) {echo ', ' . $terms[$i]->name ;}
}

// Custom Body Class
add_action( 'body_class', 'socrata_videos_body_class');
function socrata_videos_body_class( $classes ) {
  if ( get_post_type() == 'socrata_videos' && is_single() || get_post_type() == 'socrata_videos' && is_archive() )
    $classes[] = 'socrata-videos';
  return $classes;
}

// ENQEUE SCRIPTS
add_action( 'wp_enqueue_scripts', 'register_socrata_videos_script' );
function register_socrata_videos_script() {
wp_register_script( 'video-slider', plugins_url( '/js/video-slider.js' , __FILE__ ), array(), '1.0.0', true );
}

//Shortcode [video-cards]

function video_cards( $atts ) {
  extract( shortcode_atts( array(
    'query' => '',
    'class' => '',
  ), $atts ) );
  $query = html_entity_decode( $query );
  ob_start(); 
  $the_query = new \WP_Query( $query );
  while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

  <div class="<?php echo $class; ?>">
    <article class="card card-video truncate">
      <div class="card-image">
        <img src="http://img.youtube.com/vi/<?php $meta = get_socrata_videos_meta(); echo $meta[1]; ?>/mqdefault.jpg" class="img-responsive">
        <a class="link" href="<?php the_permalink() ?>"></a>
      </div>
      <div class="card-text">
        <div class="categories"><?php videos_the_categories(); ?></div>
        <h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
        <?php $meta = get_socrata_videos_meta(); if ($meta[2]) {echo "$meta[2]";} ?>
      </div>
    </article>
  </div>

  <?php
  endwhile;
  wp_reset_postdata();
  $list = ob_get_clean();
  return $list;
}

add_shortcode( 'video-cards', 'video_cards' );


//Shortcode [video-slider]

function video_slider( $atts ) { 
  extract( shortcode_atts( array(
    'query' => ''
  ), $atts ) );
  $query = html_entity_decode( $query );
  ob_start(); ?>
  <div class="video-slide-container">
  <div class="arrowsContainer"></div>
  <div class="container">
  <div class="row slider">
  <?php
  $the_query = new \WP_Query( $query );
  while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

  <div class="col-sm-6 col-md-3 slide">
    <article class="card card-video truncate">
      <div class="card-image">
        <img src="http://img.youtube.com/vi/<?php $meta = get_socrata_videos_meta(); echo $meta[1]; ?>/mqdefault.jpg" class="img-responsive">
        <a class="link" href="<?php the_permalink() ?>"></a>
      </div>
      <div class="card-text">
        <div class="categories"><?php videos_the_categories(); ?></div>
        <h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
        <?php $meta = get_socrata_videos_meta(); if ($meta[2]) {echo "$meta[2]";} ?>
      </div>
    </article>
  </div>

  <?php
  endwhile;
  wp_reset_postdata(); ?>

<?php { ?>
</div>
</div>
</div>

<?php
}; ?>

  <?php
  wp_enqueue_script( 'video-slider' );
  $list = ob_get_clean();
  return $list;
}

add_shortcode( 'video-slider', 'video_slider' );


























































// Shortcode [socrata_videos-posts]
function socrata_videos_posts($atts, $content = null) {
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
                'post_type' => 'socrata_videos',
                'posts_per_page' => 1
              );
          $query1 = new WP_Query( $args );

          // The Loop
          while ( $query1->have_posts() ) {
            $query1->the_post();
            $do_not_duplicate[] = get_the_ID(); ?>

            <div class="col-sm-12">
              <div class="featured-post" style="background-image: url(<?php echo Roots\Sage\Extras\custom_feature_image('full', 850, 400); ?>);">
                <div class="text">
                  <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
                  <div class="truncate">
                    <?php the_excerpt(); ?> 
                  </div>
                  <p><a href="<?php the_permalink() ?>" class="btn btn-primary">Read More</a></p>
                </div>
                <div class="overlay"></div>
                <a href="<?php the_permalink() ?>" class="link"></a>
              </div>
            </div>

            <?php
          }

          wp_reset_postdata();

          /* The 2nd Query (without global var) */
          $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
          $args2 = array(
                'post_type' => 'socrata_videos',
                'paged' => $paged,
                'post__not_in' => $do_not_duplicate 
              );
          $query2 = new WP_Query( $args2 );

          // The 2nd Loop
          while ( $query2->have_posts() ) {
            $query2->the_post(); ?>
            
            <div class="col-sm-6 col-lg-4">
              <div class="card truncate">
                <div class="card-image hidden-xs">
                  <img src="<?php echo socrata_videos_logo_home( 'full', 100 ); ?>" class="img-responsive ">                    
                  <a href="<?php the_permalink() ?>"></a>
                </div>
                <div class="card-text">
                  <div class="categories"><?php socrata_videos_the_categories(); ?></div>
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
          $taxonomy = 'socrata_videos_type';
          $title = 'Type';

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
          $taxonomy = 'socrata_videos_product';
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
add_shortcode('socrata_videos-posts', 'socrata_videos_posts');
