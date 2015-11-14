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

include_once('metaboxes/meta_box.php');
include_once('inc/fields.php');

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
      'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' ),
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

// TAXONOMIES
add_action( 'init', 'create_case_study_taxonomies', 0 );
function create_case_study_taxonomies() {
  register_taxonomy(
    'case_study_category',
    'case_study',
    array(
    'labels' => array(
      'name' => 'Case Study Category',
      'add_new_item' => 'Add New Category',
      'new_item_name' => "New Category"
    ),
    'show_ui' => true,
    'show_tagcloud' => false,
    'hierarchical' => true,
    'rewrite' => array('with_front' => false, 'slug' => 'case-study-customers'),
    )
  );
}

// Custom Columns for admin management page
add_filter( 'manage_edit-case_study_columns', 'case_study_columns' ) ;
function case_study_columns( $columns ) {
  $columns = array(
    'cb' => '<input type="checkbox" />',
    'title' => __( 'Customer' ),
    'case_study_category' => __( 'Region' ),
    'date' => __( 'Date' )
  );
  return $columns;
}

add_action( 'manage_case_study_posts_custom_column', 'case_study_custom_columns', 10, 2 );
function case_study_custom_columns( $column, $post_id ) {
  global $post;
  switch( $column ) {
    case 'case_study_category' :
      $terms = get_the_terms( $post_id, 'case_study_category' );
      if ( !empty( $terms ) ) {
        $out = array();
        foreach ( $terms as $term ) {
          $out[] = sprintf( '<a href="%s">%s</a>',
            esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'case_study' => $term->slug ), 'edit.php' ) ),
            esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'case_study_category', 'display' ) )
          );
        }
        echo join( ', ', $out );
      }
      else {
        _e( 'No Category' );
      }
      break;
    default :
      break;
  }
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

// Print Taxonomy Categories
function case_study_the_categories() {
    // get all categories for this post
    global $terms;
    $terms = get_the_terms($post->ID , 'case_study_category');
    // echo the first category
    echo $terms[0]->name;
    // echo the remaining categories, appending separator
    for ($i = 1; $i < count($terms); $i++) {echo ', ' . $terms[$i]->name ;}
}

// Shortcode [case-study-posts]
function case_study_posts($atts, $content = null) {
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
                'post_type' => 'case_study',
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
                <div class="text truncate">
                  <div class="post-category background-green-sea">Case Studies</div>
                  <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
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
                'post_type' => 'case_study',
                'paged' => $paged,
                'post__not_in' => $do_not_duplicate 
              );
          $query2 = new WP_Query( $args2 );

          // The 2nd Loop
          while ( $query2->have_posts() ) {
            $query2->the_post(); ?>
            <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'post-thumbnail' ); $url = $thumb['0']; ?>            
            <div class="col-sm-6 col-lg-4">
              <div class="card">
                <div class="card-image hidden-xs">                  
                  <?php if ( has_post_thumbnail() ) { ?>
                    <img src="<?=$url?>" class="img-responsive">
                  <?php
                  } else { ?>
                    <img src="/wp-content/uploads/no-image.png" class="img-responsive">
                  <?php
                  }
                  ?>
                  <a href="<?php the_permalink() ?>"></a>
                </div>
                <div class="card-text truncate">
                  <p class="categories"><small><?php case_study_the_categories(); ?><small></p>
                  <h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
                  <?php the_excerpt(); ?> 
                </div>
              </div>
            </div>

            <?php
          }

          // Pagination
          if (function_exists("pagination")) {pagination($query2->max_num_pages,"",$paged);} 

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
          $taxonomy = 'case_study_category';
          $title = 'Case Study Categories';

          $args = array(
            'orderby' => $orderby,
            'show_count' => $show_count,
            'pad_counts' => $pad_counts,
            'hide_empty' => $hide_empty,
            'hierarchical' => $hierarchical,
            'taxonomy' => $taxonomy,
            'title_li' => '<h5 class="background-green-sea">'. $title .'</h5>'
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
add_shortcode('case-study-posts', 'case_study_posts');


// SHORTCODE FOR CASE STUDY
// [case-study-quote]
add_shortcode('case-study-quote','case_study_quote_shortcode');
function case_study_quote_shortcode ($atts, $content = null) { ob_start(); ?>
<?php $meta = get_case_study_meta();
    if ($meta[4]) {echo "<div class='quote-wrapper'><p class='quote'>&quot;$meta[3]&quot;</p><p class='author'>- $meta[4]</p></div>";}
    elseif ($meta[3]) {echo "<div class='quote-wrapper'><p class='quote'>&quot;$meta[3]&quot;</p></div>";}
    ?>
<?php
$content = ob_get_contents();
ob_end_clean();
return $content;
}

