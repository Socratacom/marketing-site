<?php

include_once("guide_meta-boxes.php");

// Post Type
add_action( 'init', 'guide_post_type' );
function guide_post_type() {
  $labels = array(
    'name' => _x('Open Data Guide', 'guideposttype'),
    'singular_name' => _x('Guide', 'guideposttype'),
    'add_new' => _x('Add New Chapter', 'guideposttype'),
    'add_new_item' => __('Add New Chapter', 'guideposttype'),
    'edit_item' => __('Edit Chapter', 'guideposttype'),
    'new_item' => __('New Chapter', 'guideposttype'),
    'all_items' => __('All Chapters', 'guideposttype'),
    'view_item' => __('View Chapter', 'guideposttype'),
    'search_items' => __('Search Chapters', 'guideposttype'),
    'not_found' =>  __('No chapters found', 'guideposttype'),
    'not_found_in_trash' => __('No chapters found in Trash', 'guideposttype'), 
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

// Display Post Type Query on main page
add_action('thesis_hook_custom_template', 'open_data_guide_page');
function open_data_guide_page(){
if (is_page('open-data-field-guide')) { ?>
<?php thesis_content_column(); ?>
<div class="format_text">
<section class="clearfix">
  <?php
  $guide_query = new WP_Query('post_type=guide&orderby=desc&showposts=40');
  while ($guide_query->have_posts()) : $guide_query->the_post(); ?>
  <article>
    <div class="wrapper">
    <?php $guide_meta = get_guide_meta();
      echo "<p class='chapter-name'>$guide_meta[0]</p>";
    ?>
    <h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
    <?php $guide_meta = get_guide_meta();
      echo "<p>$guide_meta[1]</p>";
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
</div>
<?php }
}

// Body Classes for Styling 
add_filter('thesis_body_classes', 'guide_styling');
function guide_styling($classes) {
  if (is_page('open-data-field-guide') || 'guide' == get_post_type() && is_archive() || 'guide' == get_post_type() && is_single()) { 
    $classes[] = 'ebook guide'; 
  }
  return $classes; 
}

// Short Codes
function downloadtoolkit($atts) {
  extract(shortcode_atts(array(
    "text"    => '',
  ), $atts));
  return '<div class="toolkit-cta"><p><a href="/open-data-field-guide/field-kit-landing-page/">Download Open Data Field Kit</a><br/>'.$text.'</p></div>';
}
add_shortcode('toolkit', 'downloadtoolkit');

function ctas() {
    return '<section class="ctas clearfix">
      <ul>
        <li><a href="/open-data-field-guide/field-kit-landing-page/" class="ir cta-button cta-download">Download Field Kit</a></li>
        <li><a href="/open-data-field-guide/schedule-a-briefing/" class="ir cta-button cta-briefing cta-middle">Schedule a Briefing</a></li>
        <li><a href="/open-data-field-guide/open-data-guide-feedback/" class="ir cta-button cta-feedback">Give us Feedback</a></li>
      </ul>
    </section>';
}
add_shortcode('guide-cta-buttons', 'ctas');


// Register Sidebars
register_sidebar(array(
  'name' => 'Open Data Guide Menu',
  'id' => 'open-data-guide-menu',
  'before_title'=>'<h3>',
  'after_title'=>'</h3>'
  ));