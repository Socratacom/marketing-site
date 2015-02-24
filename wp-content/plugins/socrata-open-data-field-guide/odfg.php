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

// Post Type
add_action( 'init', 'guide_post_type' );
function guide_post_type() {
  $labels = array(
    'name' => _x('Open Data Guide'),
    'singular_name' => _x('Guide'),
    'add_new' => _x('Add New Chapter'),
    'add_new_item' => __('Add New Chapter'),
    'edit_item' => __('Edit Chapter'),
    'new_item' => __('New Chapter'),
    'all_items' => __('All Chapters'),
    'view_item' => __('View Chapter'),
    'search_items' => __('Search Chapters'),
    'not_found' =>  __('No chapters found'),
    'not_found_in_trash' => __('No chapters found in Trash'), 
    'parent_item_colon' => '',
    'menu_name' => 'Open Data Guide'

  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => array('with_front' => false, 'slug' => 'open-data-field-guide-chapter'),
    'capability_type' => 'post',
    'has_archive' => true, 
    'hierarchical' => false,
    'menu_icon' => get_stylesheet_directory_uri() .'/custom/images/icons/menu-socrata.png', // 16px16
    'menu_position' => 10,
    'supports' => array( 'title', 'editor', 'revisions' ),
  ); 
  register_post_type('guide', $args);
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
    wp_register_style( 'fontawesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css', false, null);
    wp_enqueue_style( 'fontawesome' );
    wp_register_script('jumplinks', plugins_url( 'js/jumplinks.js' , __FILE__ ), false, null, true);
    wp_enqueue_script('jumplinks');
  } 
}
add_action('wp_enqueue_scripts', 'guide_script_loading');

// Body Classes for Styling 
add_filter('thesis_body_classes', 'guide_styling');
function guide_styling($classes) {
  if (is_page('open-data-field-guide') || 'guide' == get_post_type() && is_archive() || 'guide' == get_post_type() && is_single()) { 
    $classes[] = 'guide'; 
  }
  return $classes; 
}


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


