<?php
/*
Plugin Name: Socrata Videos
Plugin URI: http://socrata.com/
Description: This plugin manages Socrata Videos.
Version: 1.0
Author: Michael Church
Author URI: http://socrata.com/
License: GPLv2
*/

// REGISTER POST TYPE
add_action( 'init', 'create_socrata_videos' );

function create_socrata_videos() {
  register_post_type( 'socrata_videos',
    array(
      'labels' => array(
        'name' => 'Videos',
        'singular_name' => 'Videos',
        'add_new' => 'Add New Video',
        'add_new_item' => 'Add New Video',
        'edit' => 'Edit Videos',
        'edit_item' => 'Edit Videos',
        'new_item' => 'New Video',
        'view' => 'View',
        'view_item' => 'View Video',
        'search_items' => 'Search Videos',
        'not_found' => 'Not found',
        'not_found_in_trash' => 'Not found in Trash',
      ),      
      'description' => 'Add videos',
      'supports' => array( 'title' ),
      'public' => true,
      'show_ui' => true,
      'show_in_menu' => 'editorial-content',
      'rewrite' => array('with_front' => false, 'slug' => 'video')
    )
  );
}

add_action( 'init', 'socrata_videos_categories', 0 );
function socrata_videos_categories() {
  register_taxonomy(
    'socrata_videos_category',
    'socrata_videos',
    array(
      'labels' => array(
        'name' => 'Videos Category',
        'menu_name' => 'Videos Category',
        'add_new_item' => 'Add New Category',
        'new_item_name' => "New Category"
      ),
      'show_ui' => true,
      'show_tagcloud' => false,
      'hierarchical' => true,
      'sort' => true,      
      'args' => array( 'orderby' => 'term_order' ),
      'show_admin_column' => true,
      'rewrite' => array('with_front' => false, 'slug' => 'videos-category'),
    )
  );
}

// Template Paths
add_filter( 'template_include', 'socrata_videos_single_template', 1 );
function socrata_videos_single_template( $template_path ) {
  if ( get_post_type() == 'socrata_videos' ) {
    if ( is_single() ) {
      // checks if the file exists in the theme first,
      // otherwise serve the file from the plugin
      if ( $theme_file = locate_template( array ( 'single-videos.php' ) ) ) {
        $template_path = $theme_file;
      } else {
        $template_path = plugin_dir_path( __FILE__ ) . 'single-videos.php';
      }
    }
  }
  return $template_path;
}

// Print Taxonomy Categories
function videos_the_categories() {
  // get all categories for this post
  global $terms;
  $terms = get_the_terms($post->ID , 'socrata_videos_segment');
  // echo the first category
  echo $terms[0]->name;
  // echo the remaining categories, appending separator
  for ($i = 1; $i < count($terms); $i++) {echo ', ' . $terms[$i]->name ;}
}

// Custom Body Class
add_action( 'body_class', 'socrata_videos_body_class');
function socrata_videos_body_class( $classes ) {
  if ( get_post_type() == 'socrata_videos' && is_single() || get_post_type() == 'socrata_videos' && is_archive() )
    $classes[] = 'socrata-videos';
  return $classes;
}


// CUSTOM EXCERPT
function videos_excerpt() {
  global $post;
  $text = get_post_meta($post->ID, 'editorField', true);
  if ( '' != $text ) {
    $text = strip_shortcodes( $text );
    $text = apply_filters('the_content', $text);
    $text = str_replace(']]>', ']]>', $text);
    $excerpt_length = 20; // 20 words
    $excerpt_more = apply_filters('excerpt_more', ' ' . ' ...');
    $text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
  }
  return apply_filters('get_the_excerpt', $text);
}

// ENQEUE SCRIPTS
add_action( 'wp_enqueue_scripts', 'register_socrata_videos_script' );
function register_socrata_videos_script() {
wp_register_script( 'video-slider', plugins_url( '/js/video-slider.js' , __FILE__ ), array(), '1.0.0', true );

// YouTube Button and Shorcode for TinyMCE
add_shortcode("youtube", "cwc_youtube");
function cwc_youtube($atts) {
  extract(shortcode_atts(array(
    "id" => '',
  ), $atts));
  return '<div class="video-container">
  <iframe src="https://www.youtube.com/embed/'.$id.'?rel=0" frameborder="0" allowfullscreen></iframe>
  </div>'
  ;
}

add_action('init', 'add_youtube_button');
function add_youtube_button() {
   if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )
   {
     add_filter('mce_external_plugins', 'add_youtube_plugin');
     add_filter('mce_buttons', 'register_youtube_button');
   }
}

function register_youtube_button($buttons) {
   array_push($buttons, "youtube");
   return $buttons;
}

function add_youtube_plugin($plugin_array) {
   $plugin_array['youtube'] = plugins_url( '/js/youtube.js' , __FILE__ );
       return $plugin_array;
    }
}

// DASHBOARD WIDGET
require_once( plugin_dir_path( __FILE__ ) . '/widget.php' );
class Socrata_Videos_Widget {
 
  function __construct() {
      add_action( 'wp_dashboard_setup', array( $this, 'add_socrata_videos_dashboard_widget' ) );
  }

  function add_socrata_videos_dashboard_widget() {
    global $custom_socrata_videos_dashboard_widget;
 
    foreach ( $custom_socrata_videos_dashboard_widget as $widget_id => $options ) {
      wp_add_dashboard_widget(
          $widget_id,
          $options['title'],
          $options['callback']
      );
    }
  } 
}
 
$wdw = new Socrata_Videos_Widget();

// Metabox
add_filter( 'rwmb_meta_boxes', 'socrata_videos_register_meta_boxes' );
function socrata_videos_register_meta_boxes( $meta_boxes )
{
  $prefix = 'socrata_videos_';
  $meta_boxes[] = array(
    'title'  			=> 'Video Details',
    'post_types' 	=> 'socrata_videos',
    'context'    	=> 'normal',
    'priority'  	=> 'high',
    'fields' => array(
        // CHECKBOX
				array(
					'name' => 'Is this video featured?',
					'id'   => "{$prefix}featured",
					'type' => 'checkbox',
					// Value can be 0 or 1
					'std'  => 0,
				),
        // URL
				array(
					'name' => 'YouTube Share URL',
					'id'   => "{$prefix}id",
					'desc' => 'Example: https://youtu.be/HoEQQfOp1WE',
					'type' => 'url',
				),
        // WYSIWYG/RICH TEXT EDITOR
        array(
            'name'    => 'Video Description',
            'id'      => "editorField",
            'type'    => 'wysiwyg',
            // Set the 'raw' parameter to TRUE to prevent data being passed through wpautop() on save
            'raw'     => false,
            // Editor settings, see wp_editor() function: look4wp.com/wp_editor
            'options' => array(
                'textarea_rows' => 10,
                'teeny'         => true,
                'media_buttons' => false,
            ),
        ),
    ),
);
return $meta_boxes;
}

// Shortcode [videos]
function video_posts($atts, $content = null) {
  ob_start();
  ?>

  <section class="section-padding">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <h1 class="font-light margin-bottom-60">Videos</h1>
        </div>
      </div>

			<?php
				$args = array(
					'post_type' => 'socrata_videos',
					'post_status' => 'publish',
					'order' => 'desc',
					'posts_per_page' => 1,
					'meta_query' => array(
						array(
							'key' => 'socrata_videos_featured',
							'value' => 1,
							'compare' => '='
						)
					)
				);

				$myquery = new WP_Query( $args );

				// The Loop
				while ( $myquery->have_posts() ) { $myquery->the_post();
				$video = rwmb_meta( 'socrata_videos_id' );
				$video_url = $video;
				$video_id = preg_replace('#^https?://youtu.be/#', '', $video_url);

				?>

				<div class="feature-event">
				<div class="feature-event-image sixteen-nine img-background" style="background-image:url(https://img.youtube.com/vi/<?php echo $video_id; ?>/maxresdefault.jpg);"></div>
				<div class="feature-event-meta">
				<div class="meta">
				<div class="category">Featured Video</div>
				<h3 class="title"><?php the_title(); ?></h3>
				</div>
				</div>
				<a href="<?php the_permalink() ?>" class="link"></a>
				<?php echo do_shortcode('[image-attribution]'); ?>
				</div>

				<?php } 
				wp_reset_postdata(); 
			?>

      <div class="row hidden-lg">
        <div class="col-sm-12 margin-bottom-30">
          <div class="padding-15 background-light-grey-4">
            <ul class="filter-bar">
              <li><?php echo facetwp_display( 'facet', 'solution_dropdown' ); ?></li>
              <li><?php echo facetwp_display( 'facet', 'segment_dropdown' ); ?></li>
              <li><?php echo facetwp_display( 'facet', 'product_dropdown' ); ?></li>
              <li><?php echo facetwp_display( 'facet', 'video_categories_dropdown' ); ?></li>
              <li><button onclick="FWP.reset()" class="btn btn-primary"><i class="fa fa-undo" aria-hidden="true"></i></button></li>
            </ul>
          </div>          
        </div>
      </div>
      <div class="row">
        <div class="col-lg-3 hidden-xs hidden-sm hidden-md facet-sidebar">
          <button onclick="FWP.reset()" class="btn btn-primary btn-block margin-bottom-30"><i class="fa fa-undo" aria-hidden="true"></i> Reset Filters</button>
          <div class="filter-list margin-bottom-30">
            <button type="button" data-toggle="collapse" data-target="#solution">Solution</button>
            <div id="solution" class="collapse in"><?php echo facetwp_display( 'facet', 'solution' ); ?></div>
            <button type="button" data-toggle="collapse" data-target="#segment">Segment</button>
            <div id="segment" class="collapse in"><?php echo facetwp_display( 'facet', 'segment' ); ?></div>
            <button type="button" data-toggle="collapse" data-target="#product">Product</button>
            <div id="product" class="collapse in"><?php echo facetwp_display( 'facet', 'products' ); ?></div>
            <button type="button" data-toggle="collapse" data-target="#category">Category</button>
            <div id="category" class="collapse in"><?php echo facetwp_display( 'facet', 'video_categories' ); ?></div>
          </div>              
        </div>
        <div class="col-sm-12 col-lg-9">
          <div class="row">
            <div class="col-sm-12 margin-bottom-30">
              <ul class="list-table">
                <li><small>Showing: <?php echo do_shortcode('[facetwp counts="true"]') ;?></small></li>
                <li class="text-right"><?php echo do_shortcode('[facetwp sort="true"]') ;?></li>
              </ul>
            </div>
            <?php echo facetwp_display( 'template', 'videos' ); ?>
            <div class="col-sm-12 margin-top-30">
              <ul class="list-table">
                <li><small>Showing: <?php echo do_shortcode('[facetwp counts="true"]') ;?></small></li>
                <li class="text-right"><?php echo do_shortcode('[facetwp per_page="true"]') ;?></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <script>!function(n){n(function(){FWP.loading_handler=function(){}})}(jQuery);</script>
  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('videos', 'video_posts');
