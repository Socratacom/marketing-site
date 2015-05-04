<?php

include_once("gpmp_meta-boxes.php");

// Post Type
add_action( 'init', 'gpmp_post_type' );
function gpmp_post_type() {
  $labels = array(
    'name' => _x('Government Perfomance Management Playbook', 'gpmpposttype'),
    'singular_name' => _x('GPMP', 'gpmpposttype'),
    'add_new' => _x('Add New Chapter', 'gpmpposttype'),
    'add_new_item' => __('Add New Chapter', 'gpmpposttype'),
    'edit_item' => __('Edit Chapter', 'gpmpposttype'),
    'new_item' => __('New Chapter', 'gpmpposttype'),
    'all_items' => __('All Chapters', 'gpmpposttype'),
    'view_item' => __('View Chapter', 'gpmpposttype'),
    'search_items' => __('Search Chapters', 'gpmpposttype'),
    'not_found' =>  __('No chapters found', 'gpmpposttype'),
    'not_found_in_trash' => __('No chapters found in Trash', 'gpmpposttype'), 
    'parent_item_colon' => '',
    'menu_name' => 'Government Perfomance'

  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => array('with_front' => false, 'slug' => 'government-performance-management-playbook-chapter'),
    'capability_type' => 'post',
    'has_archive' => true, 
    'hierarchical' => false,
    'menu_position' => 6,
    'supports' => array( 'title', 'editor', 'revisions' ),
  ); 
  register_post_type('gpmp', $args);
}

// Custom Columns for admin management page
add_filter( 'manage_edit-gpmp_columns', 'gpmp_columns' ) ;
function gpmp_columns( $columns ) {
  $columns = array(
    'cb' => '<input type="checkbox" />',
    'title' => __( 'Chapter' )
  );
  return $columns;
}

// Custom Icon for Post Type menu
add_action('admin_head', 'gpmp_icon');
function gpmp_icon() {
  global $post_type;
  ?>
<style>
  <?php if (($_GET['post_type'] == 'gpmp') || ($post_type == 'gpmp')) : ?>
  #icon-edit { background:transparent url('<?php echo get_stylesheet_directory_uri();?>/custom/images/icons/socrata-icon-big.png') no-repeat; }
  <?php endif; ?> 
  #adminmenu #menu-posts-gpmp div.wp-menu-image{background:transparent url('<?php echo get_stylesheet_directory_uri();?>/custom/images/icons/socrata-icon-small.png') no-repeat scroll -1px -33px;}
  #adminmenu #menu-posts-gpmp:hover div.wp-menu-image,#adminmenu #menu-posts-gallery.wp-has-current-submenu div.wp-menu-image{background:transparent url('<?php echo get_stylesheet_directory_uri();?>/custom/images/icons/socrata-icon-small.png') no-repeat scroll -1px -1px;} 
</style>
<?php
}

// Add Thesis Meta Boxes
function gpmp_thesis_metabox() {
    $post_options = new thesis_post_options;
  $post_options->meta_boxes();
  foreach ($post_options->meta_boxes as $meta_name => $meta_box) {
        add_meta_box($meta_box['id'], $meta_box['title'], array('thesis_post_options', 'output_' . $meta_name . '_box'), 'gpmp', 'normal', 'low');
    }
  add_action('save_post',array('thesis_post_options','save_meta'));
}
add_action('admin_init','gpmp_thesis_metabox');


// Display Post Type Query on main page
add_action('thesis_hook_custom_template', 'gpmp_page');
function gpmp_page(){
if (is_page('government-performance-management-playbook')) { ?>
<?php thesis_content_column(); ?>
<section class="clearfix">
  <?php
  $gpmp_query = new WP_Query('post_type=gpmp&orderby=desc&showposts=40');
  while ($gpmp_query->have_posts()) : $gpmp_query->the_post(); ?>
  <article>
    <div class="wrapper">
    <?php $gpmp_meta = get_gpmp_meta();
      echo "<p class='chapter-name'>$gpmp_meta[0]</p>";
    ?>
    <h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
    <?php $gpmp_meta = get_gpmp_meta();
      echo "<p>$gpmp_meta[1]</p>";
    ?>
    <p><a href="<?php the_permalink() ?>" class="more">Read More <span>&#x25B6;</span></a></p>
    </div>
  </article>
  <?php endwhile; ?>
  <?php wp_reset_query(); ?>
</section>
<section style="text-align: center; margin-top:2em;">
  <!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style " style="display:inline-block; margin:2em auto;">
<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
<a class="addthis_button_tweet"></a> 
<a class="addthis_button_google_plusone" g:plusone:size="medium"></a> 
<a class="addthis_counter addthis_pill_style"></a>
</div>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4e590fc12e22e79e"></script>
<!-- AddThis Button END -->
</section>
<?php }
}

// Body Classes for Styling 
add_filter('thesis_body_classes', 'gpmp_styling');
function gpmp_styling($classes) {
  if (is_page('government-performance-management-playbook') || 'gpmp' == get_post_type() && is_archive() || 'gpmp' == get_post_type() && is_single()) { 
    $classes[] = 'ebook gpmp'; 
  }
  return $classes; 
}

// Short Codes



// Register Sidebars
register_sidebar(array(
  'name' => 'GPMP Menu',
  'id' => 'gpmp-menu',
  'before_title'=>'<h3>',
  'after_title'=>'</h3>'
  ));