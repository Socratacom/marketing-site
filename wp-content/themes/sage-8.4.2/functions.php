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
  'lib/assets.php',    // Scripts and stylesheets
  'lib/extras.php',    // Custom functions
  'lib/setup.php',     // Theme setup
  'lib/titles.php',    // Page titles
  'lib/wrapper.php',   // Theme wrapper class
  'lib/customizer.php' // Theme customizer
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


add_filter( 'wpseo_metabox_prio', function() { return 'low';});


// BLOG DASHBOARD WIDGET
class Socrata_Blog_Widget {

  function __construct() {
      add_action( 'wp_dashboard_setup', array( $this, 'add_socrata_blog_dashboard_widget' ) );
  }

  function add_socrata_blog_dashboard_widget() {
    global $custom_socrata_blog_dashboard_widget;
    foreach ( $custom_socrata_blog_dashboard_widget as $widget_id => $options ) {
      wp_add_dashboard_widget(
          $widget_id,
          $options['title'],
          $options['callback']
      );
    }
  } 
}
 
$wdw = new Socrata_Blog_Widget();

$custom_socrata_blog_dashboard_widget = array(
    'socrata_blog_dashboard_widget' => array(
    'title' => 'Blog',
    'callback' => 'socrata_blog_dashboardWidgetContent'
    )
);

 function socrata_blog_dashboardWidgetContent() {
    $args = array(
      'post_type' => 'post',
    );
    $myquery = new WP_Query($args);
    echo "<div style='text-align:center; padding:30px;'><p style='font-size:50px; margin:0;'>$myquery->found_posts <span style='font-size:14px;'>Articles</span></p></div>";
    echo "<a href='/wp-admin/post-new.php?post_type=post' style='background-color:#3498db; padding:5px 10px; color:#ffffff; border-radius:2px;'>Add New</a>";
    wp_reset_postdata();
}



