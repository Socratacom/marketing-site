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
      'menu_icon' => get_stylesheet_directory_uri() .'/custom/images/icons/menu-socrata.png',
      'has_archive' => true,
      'rewrite' => array('with_front' => false, 'slug' => 'case-study'),
    )
  );
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
    'case_study_category' => __( 'Status' ),
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

// Display Post Type Query on main page
add_action('thesis_hook_custom_template', 'case_study_main_page');
function case_study_main_page(){
if (is_page('case-studies')) { ?>

<?php thesis_content_column(); ?>

<div class="format_text">
  <?php    
    $page = (get_query_var('paged')) ? get_query_var('paged') : 1;
     query_posts(array(
      'post_type' => 'case_study',
      'order' => 'desc',
      'posts_per_page' => 30, 
      'paged' => $page
    ));
  ?>
  <?php if (have_posts()) : ?>
  <?php
    $count = 0;
    while (have_posts()) : the_post(); 
    $count++;
    $third_div = ($count%3 == 0) ? 'last' : '';
    $third_div_clear = ($count%3 == 0) ? '<div class="clearboth"></div>' : '';
  ?>    
    <article class="one_third <?php echo $third_div; ?>">
      <a href="<?php the_permalink() ?>"><img src="<?php echo tuts_custom_img('full', 400, 200);?>" style="width:100%;" /></a>
      <p >      
        <?php $meta = get_case_study_meta(); if ($meta[0]) echo "<small style='display:block;'>$meta[0]</small>"; ?>
        <a href="<?php the_permalink() ?>">
        <?php the_title(); ?>
        </a>
      </p>
    </article>
    <?php echo $third_div_clear; ?>    
    <?php endwhile; ?>
    <?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
    <?php endif; ?>
    <?php wp_enqueue_style( 'case_study_styles' ); ?>

<?php }
}

// ADD STYLESHEET TO FRONT END
add_action( 'init', 'register_case_study_styles' ); 
function register_case_study_styles() {
    wp_register_style( 'case_study_styles', plugins_url( 'css/styles.css' , __FILE__ ) );
}

// Body Classes for Styling 
add_filter('thesis_body_classes', 'case_study_styling');
function case_study_styling($classes) {
  if ('case_study' == get_post_type() && is_archive() || 'case_study' == get_post_type() && is_single() || is_page('case-studies')) { 
    $classes[] = 'case-study'; 
  }
  return $classes; 
}

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

