<?php
/*
Plugin Name: Socrata Newsroom
Plugin URI: http://fishinglounge.com/
Description: This plugin adds the Newsroom for press releases.
Version: 1.0
Author: Michael Church
Author URI: http://fishinglounge.com/
License: GPLv2
*/




// REGISTER POST TYPE
add_action( 'init', 'news_post_type' );

function news_post_type() {
  register_post_type( 'news',
    array(
      'labels' => array(
        'name' => 'Socrata News',
        'singular_name' => 'Socrata News',
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
        'parent' => 'Parent Socrata News'
      ),
      'public' => true,
      'menu_position' => 5,
      'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'revisions' ),
      'taxonomies' => array( '' ),
      'menu_icon' => '',
      'has_archive' => true,
      'rewrite' => array('with_front' => false, 'slug' => 'newsroom-article')
    )
  );
}

// MENU ICON
//Using Dashicon Font http://melchoyce.github.io/dashicons/
add_action( 'admin_head', 'add_news_icon' );
function add_news_icon() { ?>
  <style>
    #adminmenu .menu-icon-news div.wp-menu-image:before {
      content: '\f123';
    }
  </style>
  <?php
}

// TAXONOMIES
add_action( 'init', 'create_news_taxonomies', 0 );
function create_news_taxonomies() {
  register_taxonomy(
    'news_category',
    'news',
    array (
    'labels' => array(
    'name' => 'Newsroom Category',
    'add_new_item' => 'Add New Category',
    'new_item_name' => "New Category"
  ),
    'show_ui' => true,
    'show_tagcloud' => false,
    'hierarchical' => true,
    'rewrite' => array('with_front' => false, 'slug' => 'newsroom')
    )
  );
}

// Print Taxonomy Categories
function news_the_categories() {
    // get all categories for this post
    global $terms;
    $terms = get_the_terms($post->ID , 'news_category');
    // echo the first category
    echo $terms[0]->name;
    // echo the remaining categories, appending separator
    for ($i = 1; $i < count($terms); $i++) {echo ', ' . $terms[$i]->name ;}
}

// Template Paths
add_filter( 'template_include', 'news_single_template', 1 );
function news_single_template( $template_path ) {
  if ( get_post_type() == 'news' ) {
    if ( is_single() ) {
      // checks if the file exists in the theme first,
      // otherwise serve the file from the plugin
      if ( $theme_file = locate_template( array ( 'single-news.php' ) ) ) {
        $template_path = $theme_file;
      } else {
        $template_path = plugin_dir_path( __FILE__ ) . 'single-news.php';
      }
    }
    if ( is_archive() ) {
      // checks if the file exists in the theme first,
      // otherwise serve the file from the plugin
      if ( $theme_file = locate_template( array ( 'archive-news.php' ) ) ) {
        $template_path = $theme_file;
      } else {
        $template_path = plugin_dir_path( __FILE__ ) . 'archive-news.php';
      }
    }
  }
  return $template_path;
}

// Custom Body Class
add_action( 'body_class', 'news_body_class');
function news_body_class( $classes ) {
  if ( is_page('newsroom') || get_post_type() == 'news' && is_single() || get_post_type() == 'news' && is_archive() )
    $classes[] = 'news';
  return $classes;
}

// Shortcode [newsroom-posts]
function newsroom_posts($atts, $content = null) {
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
                'post_type' => 'news',
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
                  <div class="post-category background-alizarin">Newsroom</div>
                  <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
                </div>
                <p class="meta"><strong>Posted</strong>, <?php the_time('F jS, Y') ?></p>
                <a href="<?php the_permalink() ?>" class="link"></a>
              </div>
            </div>

            <?php
          }

          wp_reset_postdata();

          /* The 2nd Query (without global var) */
          $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
          $args2 = array(
                'post_type' => 'news',
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
                  <a href="<?php the_permalink() ?>"></a>
                </div>
                <div class="card-text truncate">
                  <p class="categories"><small><?php news_the_categories(); ?><small></p>
                  <h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
                  <p class="meta"><small><strong>Posted</strong>, <?php the_time('F jS, Y') ?></small></p>
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
          $taxonomy = 'news_category';
          $title = 'Newsroom Categories';

          $args = array(
            'orderby' => $orderby,
            'show_count' => $show_count,
            'pad_counts' => $pad_counts,
            'hide_empty' => $hide_empty,
            'hierarchical' => $hierarchical,
            'taxonomy' => $taxonomy,
            'title_li' => '<h5 class="background-alizarin">'. $title .'</h5>'
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
add_shortcode('newsroom-posts', 'newsroom_posts');