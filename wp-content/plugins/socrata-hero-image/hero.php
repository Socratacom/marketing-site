<?php
/*
Plugin Name: Socrata Hero Image
Plugin URI: http://fishinglounge.com/
Description: This plugin enables manages all the Hero Imags on the homepage.
Version: 1.0
Author: Michael Church
Author URI: http://fishinglounge.com/
License: GPLv2
*/

include_once("meta-boxes.php");


// REGISTER POST TYPE
add_action( 'init', 'create_hero' );

function create_hero() {
  register_post_type( 'hero',
    array(
      'labels' => array(
        'name' => 'Hero Image',
        'singular_name' => 'Hero',
        'add_new' => 'Add New Hero',
        'add_new_item' => 'Add New Hero',
        'edit' => 'Edit Hero',
        'edit_item' => 'Edit Hero',
        'new_item' => 'New Hero',
        'view' => 'View',
        'view_item' => 'View Hero',
        'search_items' => 'Search Heros',
        'not_found' => 'Not found',
        'not_found_in_trash' => 'Not found in Trash',
        'parent' => 'Parent Hero'
      ),
      'public' => true,
      'menu_position' => 100,
      'supports' => array( 'title', 'thumbnail', 'revisions' ),
      'taxonomies' => array( '' ),
      'menu_icon' => plugins_url( 'images/image.png', __FILE__ ),
      'has_archive' => true,
      'rewrite' => array('with_front' => false, 'slug' => 'hero')
    )
  );
}


// ENQEUE SCRIPTS
add_action( 'init', 'register_hero_styles', 0 ); 
function register_hero_styles() {
    wp_register_style( 'hero_styles', plugins_url( 'css/hero-styles.css' , __FILE__ ), false, null );
}

function hero_script_loading() {
    if ( is_page('home') ) {
        wp_enqueue_style( 'hero_styles' );
    } 
}
add_action('wp_enqueue_scripts', 'hero_script_loading');


// SHORTCODE TO DISPLAY Hero GROUP
// [hero-image]
add_shortcode('hero-image','hero_shortcode');
function hero_shortcode( $atts ) {
  /*wp_enqueue_style( 'hero_styles' );*/
  ob_start();
  extract( shortcode_atts( array (
    'type' => 'hero',
    'order' => 'date',
    'orderby' => 'desc',
    'posts' => 1,
  ), $atts ) );
  $options = array(
    'post_type' => $type,
    'order' => $order,
    'orderby' => $orderby,
    'posts_per_page' => $posts,
  );
  $query = new WP_Query( $options );
  if ( $query->have_posts() ) { ?>
  <?php while ( $query->have_posts() ) : $query->the_post(); ?>
  
  <div class="hero-image format_text" style="background-image: url(<?php echo tuts_custom_img('full', 1600, 500); ?>);">
    <div class="hero-wrapper">
      <div class="fade hero-text <?php $meta = get_hero_meta(); if ($meta[6]) echo "$meta[6]"; ?> <?php $meta = get_hero_meta(); if ($meta[2]) echo "$meta[2]"; ?>">
        <?php $meta = get_hero_meta(); if ($meta[0]) echo "<h1>$meta[0]</h1>"; ?>
        <?php $meta = get_hero_meta(); if ($meta[1]) echo "<h2>$meta[1]</h2>"; ?>
        <?php $meta = get_hero_meta(); if ($meta[3]) echo "<a href='$meta[4]' target='$meta[5]' class='button'>$meta[3]</a>"; ?>
      </div>
    </div>
  </div>
  <div class="home-video-ctas format_text">
    <div class="home-video-ctas-wrapper">
      <div class="one_half video-cta"><!-- Left Column -->
        <div class="one_third">
          <div class="home-video-thumb-wrapper">
            <img src="/wp-content/plugins/socrata-hero-image/images/what-is-socrata.jpg" class="img-responsive">
            <div class="home-video-play"></div>
            <a href="/what-is-socrata"></a>
          </div>
        </div>
        <div class="two_third last">
          <small>video</small>
          <h3>What is Socrata?</h3>
          <p>The world leader in cloud solutions for open data and data-driven governments</p>
        </div>
        <div class="clearboth"></div>
      </div>
      <div class="one_half last"><!-- Right Column -->
        <div class="one_third">
          <div class="home-video-thumb-wrapper">
            <img src="/wp-content/plugins/socrata-hero-image/images/socrata-video-thumb.jpg" class="img-responsive">
            <div class="home-video-play"></div>
            <a href="/unleash-the-power-of-open-data"></a>
          </div>
        </div>
        <div class="two_third last">
          <small>video</small>
          <h3>Who uses Socrata?</h3>
          <p>Organizations focused on democratizing access to public sector data</p>
        </div>
      </div>
      <div class="clearboth"></div>
    </div>
  </div>



  <?php endwhile; wp_reset_postdata(); ?>
  <?php $myvariable = ob_get_clean();
  return $myvariable;
  } 
}

