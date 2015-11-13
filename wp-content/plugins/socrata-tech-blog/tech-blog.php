<?php
/*
Plugin Name: Socrata Tech Blog
Plugin URI: http://fishinglounge.com/
Description: This plugin adds a Tech section to the site for tech specific posts.
Version: 1.0
Author: Michael Church
Author URI: http://fishinglounge.com/
License: GPLv2
*/

include_once("meta-boxes.php");


// REGISTER POST TYPE
add_action( 'init', 'create_tech_blog' );

function create_tech_blog() {
  register_post_type( 'tech_blog',
    array(
      'labels' => array(
        'name' => 'Developer Blog',
        'singular_name' => 'Developer Blog',
        'add_new' => 'Add New Post',
        'add_new_item' => 'Add New Post',
        'edit' => 'Edit Post',
        'edit_item' => 'Edit Post',
        'new_item' => 'New Post',
        'view' => 'View',
        'view_item' => 'View Post',
        'search_items' => 'Search Posts',
        'not_found' => 'Not found',
        'not_found_in_trash' => 'Not found in Trash',
        'parent' => 'Parent Developer Blog'
      ),
      'public' => true,
      'menu_position' => 5,
      'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'revisions' ),
      'taxonomies' => array( '' ),
      'menu_icon' => '',
      'has_archive' => true,
      'rewrite' => array('with_front' => false, 'slug' => 'developer-blog-article')
    )
  );
}

// MENU ICON
//Using Dashicon Font http://melchoyce.github.io/dashicons/
add_action( 'admin_head', 'add_tech_blog_icon' );
function add_tech_blog_icon() { ?>
  <style>
    #adminmenu .menu-icon-tech_blog div.wp-menu-image:before {
      content: '\f109';
    }
  </style>
  <?php
}

// TAXONOMIES
add_action( 'init', 'tech_blog_taxonomies', 0 );
function tech_blog_taxonomies() {
  register_taxonomy(
    'tech_blog_category',
    'tech_blog',
    array(
    'labels' => array(
      'name' => 'Developer Blog Category',
      'add_new_item' => 'Add New Category',
      'new_item_name' => "New Category"
    ),
    'show_ui' => true,
    'show_tagcloud' => false,
    'hierarchical' => true,
    'rewrite' => array('with_front' => false, 'slug' => 'developer-blog-category')
    )
  );
}

// Print Taxonomy Categories
function tech_blog_the_categories() {
    // get all categories for this post
    global $terms;
    $terms = get_the_terms($post->ID , 'tech_blog_category');
    // echo the first category
    echo $terms[0]->name;
    // echo the remaining categories, appending separator
    for ($i = 1; $i < count($terms); $i++) {echo ', ' . $terms[$i]->name ;}
}

// ASSIGN DEFAULT CATEGORY
add_action( 'save_post', 'tech_blog_set_default_object_terms', 100, 2 );
function tech_blog_set_default_object_terms( $post_id, $post ) {
  if( 'publish' === $post->post_status ) {
    $defaults = array(
      'tech_blog_category' => array( 'tech' ),
      );
    $taxonomies = get_object_taxonomies( $post->post_type );
    foreach( (array) $taxonomies as $taxonomy ) {
      $terms = wp_get_post_terms( $post_id, $taxonomy );
      if( empty( $terms ) && array_key_exists( $taxonomy, $defaults ) ) {
        wp_set_object_terms( $post_id, $defaults[$taxonomy], $taxonomy );
      }
    }
  }
}

// Single Template Path
add_filter( 'template_include', 'tech_blog_single_template', 1 );
function tech_blog_single_template( $template_path ) {
  if ( get_post_type() == 'tech_blog' ) {
    if ( is_single() ) {
      // checks if the file exists in the theme first,
      // otherwise serve the file from the plugin
      if ( $theme_file = locate_template( array ( 'single-tech-blog.php' ) ) ) {
        $template_path = $theme_file;
      } else {
        $template_path = plugin_dir_path( __FILE__ ) . 'single-tech-blog.php';
      }
    }
    if ( is_archive() ) {
      // checks if the file exists in the theme first,
      // otherwise serve the file from the plugin
      if ( $theme_file = locate_template( array ( 'archive-tech-blog.php' ) ) ) {
        $template_path = $theme_file;
      } else {
        $template_path = plugin_dir_path( __FILE__ ) . 'archive-tech-blog.php';
      }
    }
  }
  return $template_path;
}

// Custom Body Class
add_action( 'body_class', 'tech_blog_body_class');
function tech_blog_body_class( $classes ) {
  if ( is_page('developer-blog') || get_post_type() == 'tech_blog' && is_single() || get_post_type() == 'tech_blog' && is_archive() )
    $classes[] = 'tech-blog';
  return $classes;
}

// Shortcode [tech-blog-posts]
function tech_blog_posts($atts, $content = null) {
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
                'post_type' => 'tech_blog',
                'posts_per_page' => 1
              );
          $query1 = new WP_Query( $args );

          // The Loop
          while ( $query1->have_posts() ) {
            $query1->the_post();
            $do_not_duplicate[] = get_the_ID(); ?>

            <div class="col-sm-12">
              <div class="featured-post overlay-black" style="background-image: url(<?php echo Roots\Sage\Extras\custom_feature_image('full', 850, 400); ?>);">
                <div class="text truncate">
                  <div class="post-category background-sun-flower">Developer Blog</div>
                  <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
                </div>
                <?php get_template_part('templates/entry-meta'); ?>
                <a href="<?php the_permalink() ?>" class="link"></a>
              </div>
            </div>

            <?php
          }

          wp_reset_postdata();

          /* The 2nd Query (without global var) */
          $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
          $args2 = array(
                'post_type' => 'tech_blog',
                'paged' => $paged,
                'post__not_in' => $do_not_duplicate 
              );
          $query2 = new WP_Query( $args2 );

          // The 2nd Loop
          while ( $query2->have_posts() ) {
            $query2->the_post(); ?>
            
            <div class="col-sm-6 col-lg-4">
              <div class="card">
                <div class="card-image hidden-xs">
                  <?php if ( has_post_thumbnail() ) { ?>
                    <img src="<?php echo Roots\Sage\Extras\custom_feature_image('full', 360, 180); ?>" class="img-responsive">
                  <?php
                  } else { ?>
                    <img src="/wp-content/uploads/no-image.png" class="img-responsive">
                  <?php
                  }
                  ?>
                  <div class="card-avatar">
                    <?php echo get_avatar( get_the_author_meta('ID'), 60 ); ?>
                  </div>
                  <a href="<?php the_permalink() ?>"></a>
                </div>
                <div class="card-text truncate">
                  <p class="categories"><small><?php tech_blog_the_categories(); ?><small></p>
                  <h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
                  <p class="meta"><small>By <strong><?php the_author(); ?></strong>, <?php the_time('F jS, Y') ?></small></p>
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
          $taxonomy = 'tech_blog_category';
          $title = 'Developer Blog Categories';

          $args = array(
            'orderby' => $orderby,
            'show_count' => $show_count,
            'pad_counts' => $pad_counts,
            'hide_empty' => $hide_empty,
            'hierarchical' => $hierarchical,
            'taxonomy' => $taxonomy,
            'title_li' => '<h5 class="background-sun-flower">'. $title .'</h5>'
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
add_shortcode('tech-blog-posts', 'tech_blog_posts');
