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
      'menu_position' => 5,
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

// Body Classes for Styling 
/* add_filter('thesis_body_classes', 'guide_styling');
function guide_styling($classes) {
  if (is_page('open-data-field-guide') || 'guide' == get_post_type() && is_archive() || 'guide' == get_post_type() && is_single()) { 
    $classes[] = 'guide'; 
  }
  return $classes; 
}

THIS IS WHERE I NEED TO REPLACE WITH A SHORT CODE FOR THE ODFG PAGE
THIS IS EXISTING CONTENT FROM THE LANDING PAGE

<div class="cover">
<h1 class="headline">Open Data Field Guide</h1>
<p class="abstract">A comprehensive guide to ensuring your open data program serves you and your citizens.</p>
<p class="association"><strong>With Insight From:</strong> City of Chicago, City of New York, City of Edmonton, State of Maryland, State of Colorado, Code for America, The World Bank, City of Baltimore, State of Oregon, <a href="/open-data-field-guide-chapter/acknowledgements-glossary/">and more</a>.</p>
</div>

// Display Post Type Query on main page
add_action('thesis_hook_custom_template', 'open_data_guide_page');
function open_data_guide_page(){
if (is_page('open-data-field-guide')) { ?>

<section id="hero">
  <div class="wrapper format_text jumplinks">
    <h1 class="headline">Open Data Field Guide</h1>
    <h2 class="subhead">A comprehensive guide to ensuring your open data program serves you and your citizens.</h2>
    <p class="association"><strong>With Insight From:</strong> City of Chicago, City of New York, City of Edmonton, State of Maryland, State of Colorado, Code for America, The World Bank, City of Baltimore, State of Oregon, <a href="/open-data-field-guide-chapter/acknowledgements-glossary/" style="color:#3498DB">and more</a>.</p>
    <p class="center"><a href="#chapters" class="button">Explore Now</a></p>
  </div>
</section>
<section id="chapters">
  <div class="wrapper format_text">

<?php $query = new WP_Query('post_type=guide&orderby=desc&showposts=40'); ?>
  <?php 
    $count = 0;
    while ($query->have_posts()) : $query->the_post();
    $count++;
    $fourth_div = ($count%4 == 0) ? 'last' : '';
    $fourth_div_clear = ($count%4 == 0) ? '<div class="clearboth"></div>' : '';
  ?>

<article class="one_fourth <?php echo $fourth_div; ?>">
  <div class="chapter-marker">
    <?php $guide_meta = get_guide_meta(); echo "<i class='fa fa-bookmark'></i> $guide_meta[0]"; ?>
  </div>
<h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
<?php $guide_meta = get_guide_meta(); echo "<p>$guide_meta[1]</p>"; ?>
</article>

<?php echo $fourth_div_clear; ?>  
<?php endwhile;  wp_reset_postdata(); ?>

</div>
</section>



<?php }
}
*/

