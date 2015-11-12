<?php
/*
Plugin Name: Socrata Open Data Field Guide
Plugin URI: http://socrata.com/
Description: This plugin manages the Open Data Field Guide.
Version: 1.0
Author: Michael Church
Author URI: http://socrata.com/
License: GPLv2
*/
include_once("guide_meta-boxes.php");

add_action( 'init', 'create_guide' );
function create_guide() {
  register_post_type( 'guide',
    array(
      'labels' => array(
        'name' => 'ODFG',
        'singular_name' => 'ODFG',
        'add_new' => 'Add New Chapter',
        'add_new_item' => 'Add New Chapter',
        'edit' => 'Edit Chapter',
        'edit_item' => 'Edit Chapter',
        'new_item' => 'New Chapter',
        'view' => 'View',
        'view_item' => 'View Chapter',
        'search_items' => 'Search Chapters',
        'not_found' => 'Not found',
        'not_found_in_trash' => 'Not found in Trash'
      ),
      'public' => true,
      'menu_position' => 100,
      'supports' => array( 'title', 'editor', 'revisions' ),
      'taxonomies' => array( '' ),
      'menu_icon' => '',
      'has_archive' => true,
      'rewrite' => array('with_front' => false, 'slug' => 'open-data-field-guide-chapter')
    )
  );
}

// MENU ICON
//Using Dashicon Font http://melchoyce.github.io/dashicons/
add_action( 'admin_head', 'add_guide_icon' );
function add_guide_icon(){ ?>
  <style>
    #adminmenu .menu-icon-guide div.wp-menu-image:before {
      content: '\f331';
    }
  </style>
<?php
}

// Custom Columns for admin management page
add_filter( 'manage_edit-guide_columns', 'guide_columns' ) ;
function guide_columns( $columns ) {
  $columns = array(
    'cb' => '<input type="checkbox" />',
    'title' => __( 'Chapter' )
  );
  return $columns;
}

// REGISTER MENUS
add_action( 'init', 'register_odfg_menu' );
function register_odfg_menu() {
  register_nav_menus(
    array(
        'field_guide' => __( 'Field Guide' )
    )
  );
}


// ENQEUE SCRIPTS
function guide_script_loading() {
  if ( 'guide' == get_post_type() && is_single() || 'guide' == get_post_type() && is_archive() || is_page('open-data-field-guide') ) {
    wp_register_style( 'odfg_styles', plugins_url( 'css/styles.css' , __FILE__ ), false, null );
    wp_enqueue_style( 'odfg_styles' );    
  } 
}
add_action('wp_enqueue_scripts', 'guide_script_loading');

// Template Paths
add_filter( 'template_include', 'guide_single_template', 1 );
function guide_single_template( $template_path ) {
  if ( get_post_type() == 'guide' ) {
    if ( is_single() ) {
      // checks if the file exists in the theme first,
      // otherwise serve the file from the plugin
      if ( $theme_file = locate_template( array ( 'single-guide.php' ) ) ) {
        $template_path = $theme_file;
      } else {
        $template_path = plugin_dir_path( __FILE__ ) . 'single-guide.php';
      }
    }
    if ( is_archive() ) {
      // checks if the file exists in the theme first,
      // otherwise serve the file from the plugin
      if ( $theme_file = locate_template( array ( 'archive-guide.php' ) ) ) {
        $template_path = $theme_file;
      } else {
        $template_path = plugin_dir_path( __FILE__ ) . 'archive-guide.php';
      }
    }
  }
  return $template_path;
}

// Custom Body Class
add_action( 'body_class', 'field_guide_body_class');
function field_guide_body_class( $classes ) {
  if ( is_page('open-data-field-guide') || get_post_type() == 'guide' && is_single() )
    $classes[] = 'guide';
  return $classes;
}


// Shortcode [field-guide-posts]
function field_guide_posts($atts, $content = null) {
  ob_start();
  ?>
<section class="section-padding hero-full background-asbestos overlay-midnight-blue odfg-hero">
<div class="vertical-center">
<div class="container">
<div class="row">
<div class="col-sm-10 col-sm-offset-1">
<h1 class="text-center text-reverse margin-bottom-15">Open Data Field Guide</h1>
<h3 class="text-center text-reverse">A comprehensive guide to ensuring your open data program serves you and your citizens.</h3>
<p class="text-center text-reverse">With Insight From: City of Chicago, City of New York, City of Edmonton, State of Maryland, State of Colorado, Code for America, The World Bank, City of Baltimore, State of Oregon, and <a href="/open-data-guide-chapter/acknowledgements-glossary/">more</a>.</p>
<p class="text-center"><a href="#chapters" class="btn btn-lg btn-primary">Explore Now</a></p>
</div>
</div>
</div>
</div>
</section>
<section id="chapters" class="section-padding">
<div class="container">
<div class="row">
<div class="col-sm-8 col-sm-offset-2">
<h2 class="text-center">Chapters</h2>

<?php $query = new WP_Query('post_type=guide&orderby=desc&showposts=40'); ?>
<?php while ($query->have_posts()) : $query->the_post(); ?>
<div><small><?php $guide_meta = get_guide_meta(); echo "$guide_meta[0]"; ?></small></div>
<h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
<?php $guide_meta = get_guide_meta(); echo "<p>$guide_meta[1]</p>"; ?>
<hr/>
<?php endwhile;  wp_reset_postdata(); ?>

</div>
</div>
</div>
</section>
  

  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('field-guide-posts', 'field_guide_posts');
