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
        'name' => 'Tech Blog',
        'singular_name' => 'Tech Blog',
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
        'parent' => 'Parent Tech Blog'
      ),
      'public' => true,
      'menu_position' => 5,
      'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'revisions' ),
      'taxonomies' => array( '' ),
      'menu_icon' => '',
      'has_archive' => true,
      'rewrite' => array('with_front' => false, 'slug' => 'tech-blog-posts')
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
      'name' => 'Tech Blog Category',
      'add_new_item' => 'Add New Category',
      'new_item_name' => "New Category"
    ),
    'show_ui' => true,
    'show_tagcloud' => false,
    'hierarchical' => true,
    'rewrite' => array('with_front' => false, 'slug' => 'tech-blog-category')
    )
  );
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

// ADD STYLESHEET TO PAGE
add_action( 'init', 'register_tech_styles' ); 
function register_tech_styles() {
    wp_register_style( 'tech_styles', plugins_url( 'css/tech-styles.css' , __FILE__ ) );
}

add_action( 'wp_enqueue_scripts', 'add_tech_stylesheet' );
function add_tech_stylesheet() {
    if (is_page('tech-blog') || get_post_type() == 'tech_blog' && is_single())
    wp_enqueue_style( 'tech_styles' );
}

// ADD BODY CLASS
add_filter('thesis_body_classes', 'tech_styling');
function tech_styling($classes) {
  if (is_page('tech-blog') || get_post_type() == 'tech_blog' && is_single()) { 
    $classes[] = 'tech'; 
  }
  return $classes; 
}

add_action('thesis_hook_custom_template', 'custom_tech_blog_page');
function custom_tech_blog_page() {
  if (is_page('tech-blog')) { ?>
  <div class="two_third">
  <div class="format_text">

<?php
$number_of_feature_posts = 1;
$number_of_secondary_posts = 6;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$how_many_secondary_posts_past = ($number_of_secondary_posts * ($paged - 1));
$off = $number_of_feature_posts + (($paged > 1) ? $how_many_secondary_posts_past : 0);
?>

<?php
  $feature_query = new WP_Query("post_type=tech_blog&posts_per_page=$number_of_feature_posts");
  while ($feature_query->have_posts()) : $feature_query->the_post(); ?>
  <div class="tech-feature-post">
    <a href="<?php the_permalink() ?>"><img src="<?php echo tuts_custom_img('full', 834, 344); ?>" style="width:100%;"></a>
    <div class="tech-feature-post-wrapper">
      <small style="text-transform: uppercase;"><?php $terms_as_text = get_the_term_list( $post->ID, 'tech_blog_category', '', ', ', '' ) ; echo strip_tags($terms_as_text, ''); ?></small>
      <h1><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>
      <div class="tech-feature-post-avatar">
        <?php echo get_avatar( get_the_author_meta('ID'), 50 ); ?>
        <p><strong>By</strong> <?php the_author(); ?><br><strong>Posted</strong> <?php the_time('F jS, Y') ?></p>
      </div>
    </div>
  </div>
<?php endwhile; ?>
<?php wp_reset_query(); ?>

<?php $guide_query = new WP_Query("post_type=tech_blog&posts_per_page=$number_of_secondary_posts&offset=$off&showposts=$number_of_secondary_posts"); 
    if (have_posts()) : 
    $count = 0;
    while ($guide_query->have_posts()) : $guide_query->the_post(); 
    $count++;
    $second_div = ($count%2 == 0) ? 'last' : '';
    $second_div_clear = ($count%2 == 0) ? '<div class="clearboth"></div>' : '';
  ?>
  <div class="one_half <?php echo $second_div; ?> secondary-posts">
    <a href="<?php the_permalink() ?>"><img src="<?php echo tuts_custom_img('full', 410, 300); ?>" style="width:100%;"></a>
      <small style="text-transform: uppercase; font-size: .7em;"><?php $terms_as_text = get_the_term_list( $post->ID, 'tech_blog_category', '', ', ', '' ) ; echo strip_tags($terms_as_text, ''); ?></small>
    <h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a><h4>
      <p><small><strong>By</strong> <?php the_author(); ?> &bull; <strong>Posted</strong> <?php the_time('F jS, Y') ?></small></p>
  </div>
  <?php echo $second_div_clear; ?>
  <?php endwhile; ?>
  <?php endif; ?>
  <?php wp_reset_query(); ?>    
</div>
</div>
  <!-- Right Column -->
  <div class="blog_one_third last format_text blog-right-column">
    <div class="blog-right-column-wrapper">
      <ul><?php thesis_default_widget('shared'); ?></ul>
      <?php $blog_query = new WP_Query('post_type=post&orderby=desc&showposts=2'); 
        if (have_posts()) : while ($blog_query->have_posts()) : $blog_query->the_post();
      ?>
      <div class="sidebar-post">    
        <a href="<?php the_permalink() ?>"><img src="<?php echo tuts_custom_img('full', 300, 100);?>" style="width:100%;" /></a>
        <p><small>Open Data Blog</small><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></p>
      </div>
      <?php endwhile; ?>
      <?php endif; ?>
      <?php wp_reset_postdata(); ?><?php $blog_query = new WP_Query('post_type=news&orderby=desc&showposts=2'); 
        if (have_posts()) : while ($blog_query->have_posts()) : $blog_query->the_post();
      ?>
      <div class="sidebar-post">    
        <a href="<?php the_permalink() ?>"><img src="<?php echo tuts_custom_img('full', 300, 100);?>" style="width:100%;" /></a>
        <p><small>Press Releases</small><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></p>
      </div>
      <?php endwhile; ?>
      <?php endif; ?>
      <?php wp_reset_postdata(); ?>
    </div>  
  </div>
  <div class="clearboth"></div>
<div class="format_text">
  <hr>
  <?php echo do_shortcode('[cta-group category="homepage"]'); ?>
</div>
  

  <?php }
}



