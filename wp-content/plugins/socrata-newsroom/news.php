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
      'supports' => array( 'title','thumbnail' ),
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
    'sort' => true,      
    'args' => array( 'orderby' => 'term_order' ),
    'show_admin_column' => true,
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


// Metabox

add_filter( 'rwmb_meta_boxes', 'news_register_meta_boxes' );
function news_register_meta_boxes( $meta_boxes )
{
  $prefix = 'news_';

  $meta_boxes[] = array(
    'title'  => __( 'News Details', 'news' ),
    'post_types' => array( 'news' ),
    'context'    => 'normal',
    'priority'   => 'high',
    'fields' => array(

      // TEXT
      array(
        'name'  => __( 'Source', 'news' ),
        'id'    => "{$prefix}source",
        'desc' => __( 'Eample: Wall Street Journal', 'news' ),
        'type'  => 'text',
      ),
      // URL
      array(
        'name' => __( 'Source URL', 'news' ),
        'id'   => "{$prefix}url",
        'desc' => __( 'Include the http:// or https://', 'news' ),
        'type' => 'url',
      ),
      // FILE ADVANCED (WP 3.5+)
      array(
        'name'             => __( 'Logo', 'news' ),
        'id'               => "{$prefix}logo",
        'desc' => __( 'NOT FOR PRESS RELEASES. Minimum size 300x300 pixels.', 'news' ),
        'type'             => 'file_advanced',
        'max_file_uploads' => 1,
        'mime_type'        => 'image', // Leave blank for all file types
      ),
      array(
        'name'    => __( 'Press Release Content', 'news' ),
        'id'      => "{$prefix}wysiwyg",
        'type'    => 'wysiwyg',
        // Set the 'raw' parameter to TRUE to prevent data being passed through wpautop() on save
        'raw'     => false,
        // Editor settings, see wp_editor() function: look4wp.com/wp_editor
        'options' => array(
          'textarea_rows' => 15,
          'teeny'         => true,
          'media_buttons' => false,
        ),
      ),
    )
  );
  return $meta_boxes;
}


// Shortcode [newsroom-posts]
function newsroom_posts($atts, $content = null) {
  ob_start();
  ?>
  <section class="section-padding background-primary-alt-2-light">
    <div class="container">
      <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
          <h1 class="text-center">News and Press Releases</h1>
        </div>
      </div>
    </div>
  </section>
  <section class="section-padding">
    <div class="container">
      <div class="row">
        <div class="col-sm-8">


<?php
echo '<h3>Featured News</h3>';

$args1 = array(
  'post_type' => 'news',
  'news_category' => array('socrata-in-the-news','customer-news'),
  'posts_per_page' => 3
);
$query1 = new WP_Query( $args1 );

// The Loop
while ( $query1->have_posts() ) {
  $query1->the_post(); { ?>
    <p><?php the_title(); ?></p>
  <?php
  };

}
wp_reset_postdata();

echo '<h3>Recent News Articles</h3>';

/* The 2nd Query (without global var) */
$args2 = array(
  'post_type' => 'news',
  'news_category' => array('socrata-in-the-news','customer-news'),
  'offset' => 3,
  'posts_per_page' => 10
);
$query2 = new WP_Query( $args2 );

// The Loop
while ( $query2->have_posts() ) {
  $query2->the_post();
  echo '<p>' . get_the_title() . '</p>';
}
wp_reset_postdata();

echo '<h3>Recent Press Releases</h3>';

/* The 3rd Query (without global var) */
$args3 = array(
  'post_type' => 'news',
  'news_category' => 'press-releases',
  'posts_per_page' => 10
);
$query3 = new WP_Query( $args3 );

// The 2nd Loop
while ( $query3->have_posts() ) {
  $query3->the_post();
  echo '<p>' . get_the_title( $query3->post->ID ) . '</p>';
}

// Restore original Post Data
wp_reset_postdata();

?>






        </div>
        <div class="col-sm-4">
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
  </section>


  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('newsroom-posts', 'newsroom_posts');