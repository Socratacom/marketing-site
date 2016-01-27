<?php
/**
 * Sage includes
 *
 * The $sage_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link https://github.com/roots/sage/pull/1042
 */

$sage_includes = [
  'lib/utils.php',                 // Utility functions
  'lib/init.php',                  // Initial theme setup and constants
  'lib/wrapper.php',               // Theme wrapper class
  'lib/conditional-tag-check.php', // ConditionalTagCheck class
  'lib/config.php',                // Configuration
  'lib/assets.php',                // Scripts and stylesheets
  'lib/titles.php',                // Page titles
  'lib/extras.php',                // Custom functions
];

foreach ($sage_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);

/**
 * Pagination
 */


function pagination($pages = '', $range = 4) {  
 $showitems = ($range * 2)+1;
 global $paged;
 if(empty($paged)) $paged = 1;
 if($pages == '')
 {
   global $wp_query;
   $pages = $wp_query->max_num_pages;
   if(!$pages)
   {
       $pages = 1;
   }
 }
 if(1 != $pages)
 {
   echo "<div class=\"pagination\"><div class=\"pagination-wrapper\"><span>Page ".$paged." of ".$pages."</span>";
   if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo; First</a>";
   if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo; Previous</a>";
   for ($i=1; $i <= $pages; $i++)
   {
     if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
     {
         echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
     }
   }
   if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">Next &rsaquo;</a>";  
   if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>Last &raquo;</a>";
   echo "</div></div>\n";
 }
}

function tax_and_offset_homepage( $query ) {
  if ($query->is_home() && $query->is_main_query() && !is_admin()) {
    $query->set( 'post_type', 'post' );
    $query->set( 'post_status', 'publish' );
    $query->set( 'ignore_sticky_posts', '-1' );

    $ppp = get_option('posts_per_page');
    $offset = 1;
    if (!$query->is_paged()) {
      $query->set('posts_per_page',$offset + $ppp);
    } else {
      $offset = $offset + ( ($query->query_vars['paged']-1) * $ppp );
      $query->set('posts_per_page',$ppp);
      $query->set('offset',$offset);
    }
  }
}
add_action('pre_get_posts','tax_and_offset_homepage');

function homepage_offset_pagination( $found_posts, $query ) {
    $offset = 1;

    if( $query->is_home() && $query->is_main_query() ) {
        $found_posts = $found_posts - $offset;
    }
    return $found_posts;
}
add_filter( 'found_posts', 'homepage_offset_pagination', 10, 2 );





