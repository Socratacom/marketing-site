<?php

include_once("meta-boxes.php");

// REGISTER POST TYPE
add_action( 'init', 'career_post_type' );

function career_post_type() {
  register_post_type( 'career',
    array(
      'labels' => array(
        'name' => 'Career',
        'singular_name' => 'Career',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Career',
        'edit' => 'Edit',
        'edit_item' => 'Edit Career',
        'new_item' => 'New Career',
        'view' => 'View',
        'view_item' => 'View Employee',
        'search_items' => 'Search Careers',
        'not_found' => 'Not found',
        'not_found_in_trash' => 'Not found in Trash',
        'parent' => 'Parent Career'
      ),
      'public' => true,
      'menu_position' => 5,
      'supports' => array( 'title', 'editor', 'author', 'revisions' ),
      'taxonomies' => array( '' ),
      'menu_icon' => get_stylesheet_directory_uri() .'/custom/images/icons/menu-socrata.png',
      'has_archive' => true,
      'rewrite' => array('with_front' => false, 'slug' => 'career'),
    )
  );
}

// Display Post Type Query on main page
add_action('thesis_hook_custom_template', 'career_main_page');
function career_main_page(){
if (is_page('careers')) { ?>
<?php thesis_content_column(); ?>
<div class="format_text" style="clear:both;">
  <table style="width:100%">
    <thead>
      <tr>
        <th>Position</th>
        <th style="text-align: right;">Department</th>
        <th style="text-align: right;">Location</th>
        <th style="text-align: right;">Employment</th>
      </tr>
    </thead>
    <?php    
      $page = (get_query_var('paged')) ? get_query_var('paged') : 1;
       query_posts(array(
        'post_type' => 'career',
        'orderby' => 'title',
        'order' => 'asc',
        'posts_per_page' => 20, 
        'paged' => $page
      ));
    ?>
    <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
    <tr>   
        <td valign="top"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></td>
        <td valign="top" style="text-align: right;"><?php $meta = get_career_meta(); if ($meta[1]) echo "$meta[1]"; ?></td>
        <td valign="top" style="text-align: right;"><?php $meta = get_career_meta(); if ($meta[2]) echo "$meta[2]"; ?></td>
        <td valign="top" style="text-align: right;"><?php $meta = get_career_meta(); if ($meta[0]) echo "$meta[0]"; ?></td>
    </tr>
    <?php endwhile; ?>
  </table>

    <?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
    <?php endif; ?>
</div>
<?php }
}

add_action ('wp_head','resumator_button_styles');
function resumator_button_styles() {
  if (get_post_type() == 'career' && is_single()) { ?>
<style>
.resumator-buttons input {
  color: #fff;
  border-radius: 5px;
  border:none;    
  text-decoration: none;
  padding: 10px 20px;
  font-size:1em;
  background-color: #3b86c1;
  background-image: -webkit-linear-gradient(top, #4093d1, #3b86c1);
  background-image:    -moz-linear-gradient(top, #4093d1, #3b86c1);
  background-image:     -ms-linear-gradient(top, #4093d1, #3b86c1);
  background-image:      -o-linear-gradient(top, #4093d1, #3b86c1);
  background-image:         linear-gradient(top, #4093d1, #3b86c1);
}
.resumator-buttons input:hover {
  background-color: #4193d2;
  background-image: -webkit-linear-gradient(top, #46a2e0, #4193d2);
  background-image:    -moz-linear-gradient(top, #46a2e0, #4193d2);
  background-image:     -ms-linear-gradient(top, #46a2e0, #4193d2);
  background-image:      -o-linear-gradient(top, #46a2e0, #4193d2);
  background-image:         linear-gradient(top, #46a2e0, #4193d2);
}
.resumator-buttons a {
  display:none;
}
</style>
<?php
 }
}









