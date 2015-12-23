<?php
/*
Plugin Name: Socrata Events
Plugin URI: http://socrata.com
Description: This plugin is a companion plugin for the The Events Calendar. It enables additional custom functionality.
Version: 1.0
Author: Michael Church
Author URI: http://socrata.com/
License: GPLv2
*/

// Print Taxonomy Categories
function events_the_categories() {
    // get all categories for this post
    global $terms;
    $terms = get_the_terms($post->ID , 'tribe_events_cat');
    // echo the first category
    echo $terms[0]->name;
    // echo the remaining categories, appending separator
    for ($i = 1; $i < count($terms); $i++) {echo ', ' . $terms[$i]->name ;}
}

// Shortcode [tribe-events]
function tribe_events_posts($atts, $content = null) {
  ob_start();
  ?>

  <div class="container page-padding">
    <div class="row">
      <div class="col-sm-8">
        
<ul>
  <?php
  $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
  $args = array(
  'post_type' => 'tribe_events',
  'paged' => $paged
  );
  $query = new WP_Query( $args );
  while ( $query->have_posts() ) {
  $query->the_post(); ?>
    <li>
      <p class="meta"><?php echo tribe_events_event_schedule_details(); ?></p>
      <h4><?php the_title(); ?></h4>
      <p><?php events_the_categories(); ?></p>
      <?php the_excerpt(); ?> 
    </li>
  <?php
  }
  ?>
</ul>
<?php     
// Pagination
if (function_exists("pagination")) {pagination($query->max_num_pages,$pages);}
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
          $taxonomy = 'tribe_events_cat';
          $title = 'Event Categories';

          $args = array(
            'orderby' => $orderby,
            'show_count' => $show_count,
            'pad_counts' => $pad_counts,
            'hide_empty' => $hide_empty,
            'hierarchical' => $hierarchical,
            'taxonomy' => $taxonomy,
            'title_li' => '<h5 class="background-wisteria">'. $title .'</h5>'
          );
        ?>
        <ul class="category-nav">
          <?php wp_list_categories($args); ?>
        </ul>
        <?php echo do_shortcode('[newsletter-sidebar]'); ?>
      </div>
    </div>
  </div>

  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('tribe-events', 'tribe_events_posts');