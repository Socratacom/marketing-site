<?php
/*
Plugin Name: Socrata Downloads
Plugin URI: http://socrata.com/
Description: This plugin manages downloadable assets.
Version: 1.0
Author: Michael Church
Author URI: http://socrata.com/
License: GPLv2
*/

add_action( 'init', 'create_socrata_downloads' );
function create_socrata_downloads() {
  register_post_type( 'socrata_downloads',
    array(
      'labels' => array(
        'name' => 'Downloads',
        'singular_name' => 'Downloads',
        'add_new' => 'Add New Asset',
        'add_new_item' => 'Add New Asset',
        'edit' => 'Edit Asset',
        'edit_item' => 'Edit Asset',
        'new_item' => 'New Asset',
        'view' => 'View',
        'view_item' => 'View Asset',
        'search_items' => 'Search Downloads',
        'not_found' => 'Not found',
        'not_found_in_trash' => 'Not found in Trash'
      ),
      'public' => true,
      'menu_position' => 5,
      'supports' => array( 'title', 'thumbnail' ),
      'taxonomies' => array( '' ),
      'menu_icon' => '',
      'has_archive' => false,
      'rewrite' => array('with_front' => false, 'slug' => 'event')
    )
  );
}

// MENU ICON
//Using Dashicon Font https://developer.wordpress.org/resource/dashicons
add_action( 'admin_head', 'add_socrata_downloads_icon' );
function add_socrata_downloads_icon() { ?>
  <style>
    #adminmenu .menu-icon-socrata_downloads div.wp-menu-image:before {
      content: '\f123';
    }
  </style>
  <?php
}

// TAXONOMIES
add_action( 'init', 'create_socrata_downloads_segment', 0 );
function create_socrata_downloads_segment() {
  register_taxonomy(
    'downloads_segment',
    'socrata_downloads',
    array(
      'labels' => array(
        'name' => 'Segment',
        'menu_name' => 'Segment',
        'add_new_item' => 'Add New Segment',
        'new_item_name' => "New Segment"
      ),
      'show_ui' => true,
      'show_tagcloud' => false,
      'hierarchical' => true,
      'sort' => true,      
      'args' => array( 'orderby' => 'term_order' ),
      'show_admin_column' => true,
      'rewrite' => array('with_front' => false, 'slug' => 'downloads-segment')
    )
  );
}

add_action( 'init', 'create_socrata_downloads_product', 0 );
function create_socrata_downloads_product() {
  register_taxonomy(
    'downloads_product',
    'socrata_downloads',
    array(
      'labels' => array(
        'name' => 'Product',
        'menu_name' => 'Product',
        'add_new_item' => 'Add New Product',
        'new_item_name' => "New Product"
      ),
      'show_ui' => true,
      'show_tagcloud' => false,
      'hierarchical' => true,
      'sort' => true,      
      'args' => array( 'orderby' => 'term_order' ),
      'show_admin_column' => true,
      'rewrite' => array('with_front' => false, 'slug' => 'downloads-product')
    )
  );
}

// Template Paths
add_filter( 'template_include', 'socrata_downloads_single_template', 1 );
function socrata_downloads_single_template( $template_path ) {
  if ( get_post_type() == 'socrata_downloads' ) {
    if ( is_single() ) {
      // checks if the file exists in the theme first,
      // otherwise serve the file from the plugin
      if ( $theme_file = locate_template( array ( 'single-downloads.php' ) ) ) {
        $template_path = $theme_file;
      } else {
        $template_path = plugin_dir_path( __FILE__ ) . 'single-downloads.php';
      }
    }
  }
  return $template_path;
}

// Print Taxonomy Categories
function downloads_the_categories() {
  // get all categories for this post
  global $terms;
  $terms = get_the_terms($post->ID , 'socrata_downloads_cat');
  // echo the first category
  echo $terms[0]->name;
  // echo the remaining categories, appending separator
  for ($i = 1; $i < count($terms); $i++) {echo ', ' . $terms[$i]->name ;}
}

// Custom Body Class
add_action( 'body_class', 'socrata_downloads_body_class');
function socrata_downloads_body_class( $classes ) {
  if ( get_post_type() == 'socrata_downloads' && is_single() || get_post_type() == 'socrata_downloads' && is_archive() )
    $classes[] = 'socrata-events';
  return $classes;
}

// Fixes JS when Yoast enabled and thumbnail disabled
add_action( 'admin_enqueue_scripts', 'socrata_downloads_box_scripts' );
function socrata_downloads_box_scripts() {

    global $post;
    wp_enqueue_media( array( 
        'post' => $post->ID, 
    ) );

}

// Metabox
add_filter( 'rwmb_meta_boxes', 'socrata_downloads_register_meta_boxes' );
function socrata_downloads_register_meta_boxes( $meta_boxes )
{
  $prefix = 'socrata_downloads_';
  $meta_boxes[] = array(
    'title'  => __( 'Download Details', 'socrata-downloads' ),
    'post_types' => array( 'socrata_downloads' ),
    'context'    => 'normal',
    'priority'   => 'high',
    'fields' => array(
       // TEXT
      array(
        // Field name - Will be used as label
        'name'  => __( 'Marketo ID', 'socrata-downloads' ),
        // Field ID, i.e. the meta key
        'id'    => "{$prefix}marketo",
        'type'  => 'text',
        // CLONES: Add to make the field cloneable (i.e. have multiple value)
        'clone' => false,
      ),
      // WYSIWYG/RICH TEXT EDITOR
      array(
        'name'    => __( 'Content', 'socrata-downloads' ),
        'id'      => "{$prefix}speakers",
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
    )
  );
  return $meta_boxes;
}



// Shortcode [downloads]
function downloads_posts($atts, $content = null) {
  ob_start();
  ?>
<section class="section-padding">
  <div class="container">
    <div class="row">
      <div class="col-sm-6">
        <div class="padding-15 background-clouds">
          Filter Bar
        </div>






<?php
$args = array(
'post_type' => 'socrata_downloads',
'order' => 'asc'
);

// The Query
$the_query = new WP_Query( $args );

// The Loop
if ( $the_query->have_posts() ) {
echo '<ul>';
while ( $the_query->have_posts() ) {
$the_query->the_post(); { ?> 

<li><?php the_title(); ?></li>

<?php }
}
echo '</ul>';
} else {
// no posts found
}
/* Restore original Post Data */
wp_reset_postdata(); ?>

</div>

<div class="col-sm-3">

<?php
$args = array(
'post_type'         => 'post',
'order'             => 'asc',
'posts_per_page'    => 3,
'post_status'       => 'publish',
);

// The Query
$the_query = new WP_Query( $args );

// The Loop
if ( $the_query->have_posts() ) {
echo '<ul class="no-bullets sidebar-list">';
echo '<li><h5>Recent Articles</h5></li>';
while ( $the_query->have_posts() ) {
$the_query->the_post(); { ?> 
<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail' ); $url = $thumb['0'];?>
<li>
  <div class="article-img-container">
    <img src="<?=$url?>" class="img-responsive">
  </div>
  <div class="article-title-container">
    <a href="<?php the_permalink() ?>"><?php the_title(); ?></a><br><small><?php the_time('F j, Y') ?></small>
  </div>
</li>
<?php }
}
echo '<li><a href="/blog">View All Articles <i class="fa fa-arrow-circle-o-right"></i></a></li>';
echo '</ul>';
} else {
// no posts found
}
/* Restore original Post Data */
wp_reset_postdata(); ?>

<?php
$args = array(
'post_type'         => 'socrata_videos',
'order'             => 'asc',
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
'order'             => 'asc',
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

<?php

$today = strtotime('today UTC');        

$event_meta_query = array( 
  'relation' => 'AND',
  array( 
    'key' => 'socrata_events_endtime', 
    'value' => $today, 
    'compare' => '>=', 
  ) 
); 

$args = array(
'post_type'         => 'socrata_events',
'posts_per_page'    => 3,
'post_status' => 'publish',
'ignore_sticky_posts' => true,  
'meta_key' => 'socrata_events_endtime',
'orderby' => 'meta_value_num',
'order' => 'asc',
'meta_query' => $event_meta_query
);

// The Query
$the_query = new WP_Query( $args );

// The Loop
if ( $the_query->have_posts() ) {
echo '<ul class="no-bullets sidebar-list">';
echo '<li><h5>Upcoming Events</h5></li>';
while ( $the_query->have_posts() ) {
$the_query->the_post(); { ?> 

<li><?php the_title(); ?></li>

<?php }
}
echo '<li><a href="/events">View All Events <i class="fa fa-arrow-circle-o-right"></i></a></li>';
echo '</ul>';
} else { ?>
<ul class="no-bullets sidebar-list">
<li><h5>Upcoming Events</h5></li>
<li>No Events</li>
</ul>
<?php
}
/* Restore original Post Data */
wp_reset_postdata(); ?>



 
</div>

<div class="col-sm-3 hidden-xs">
<?php echo do_shortcode('[newsletter-sidebar]'); ?> 
</div>

    </div>
  </div>
</section>
  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('downloads', 'downloads_posts');