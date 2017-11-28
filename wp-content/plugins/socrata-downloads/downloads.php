<?php
/*
Plugin Name: Socrata Downloads
Plugin URI: http://socrata.com/
Description: This plugin manages downloadable assets.
Version: 1.0
Author: Michael Church
Author URI: http://socrata.com/
License: GPLv2
*/

// REGISTER POST TYPE
add_action( 'init', 'create_socrata_downloads' );

function create_socrata_downloads() {
  register_post_type( 'socrata_downloads',
    array(
      'labels' => array(
        'name' => 'Downloads',
        'singular_name' => 'Downloads',
        'add_new' => 'Add New Asset',
        'add_new_item' => 'Add New Asset',
        'edit' => 'Edit Asset',
        'edit_item' => 'Edit Asset',
        'new_item' => 'New Asset',
        'view' => 'View',
        'view_item' => 'View Asset',
        'search_items' => 'Search Assets',
        'not_found' => 'Not found',
        'not_found_in_trash' => 'Not found in Trash'
      ),
      'description' => 'Add downloadable gated content',
      'supports' => array( 'title','thumbnail'),
      'public' => false,
      'show_ui' => true,
      'show_in_menu' => 'editorial-content',
      'rewrite' => array('with_front' => false, 'slug' => 'papers-and-guides')
    )
  );
}

// TAXONOMIES
add_action( 'init', 'socrata_downloads_cat', 0 );
function socrata_downloads_cat() {
  register_taxonomy(
    'socrata_downloads_cat',
    'socrata_downloads',
    array(
      'labels' => array(
        'name' => 'Asset Type',
        'menu_name' => 'Asset Type',
        'add_new_item' => 'Add New Type',
        'new_item_name' => "New Type"
      ),
      'show_ui' => true,
      'show_in_menu' => true,
      'show_tagcloud' => false,
      'hierarchical' => true,
      'sort' => true,      
      'args' => array( 'orderby' => 'term_order' ),
      'show_admin_column' => true,
      'capabilities'=>array(
        'manage_terms' => 'manage_options',//or some other capability your clients don't have
        'edit_terms' => 'manage_options',
        'delete_terms' => 'manage_options',
        'assign_terms' =>'edit_posts'
      ),
      'rewrite' => array('with_front' => false, 'slug' => 'downloads-category'),
    )
  );
}

// PRINT TAXONOMY CATEGORIES
function downloads_the_categories() {
  // get all categories for this post
  global $terms;
  $terms = get_the_terms($post->ID , 'socrata_downloads_cat');
  // echo the first category
  echo $terms[0]->name;
  // echo the remaining categories, appending separator
  for ($i = 1; $i < count($terms); $i++) {echo ', ' . $terms[$i]->name ;}
}

// TEMPLATES
// Endpoint Rewrites
add_action('init', 'socrata_downloads_add_endpoints');
function socrata_downloads_add_endpoints()
{
  add_rewrite_endpoint('asset', EP_PERMALINK);
}
// Template Paths
add_filter( 'template_include', 'socrata_downloads_single_template', 1 );
function socrata_downloads_single_template( $template_path ) {
  if ( get_post_type() == 'socrata_downloads' ) {
    if ( is_single() ) {
      // checks if the file exists in the theme first,
      // otherwise serve the file from the plugin
      if ( $theme_file = locate_template( array ( 'single-downloads.php' ) ) ) {
        $template_path = $theme_file;
      } else {
        $template_path = plugin_dir_path( __FILE__ ) . 'single-downloads.php';
      }
    }
    if ( get_query_var( 'asset' )  ) {
      $template_path = plugin_dir_path( __FILE__ ) . 'asset.php';
    }
  }
  return $template_path;
}
// Template Request
add_filter( 'request', 'socrata_downloads_filter_request' );
function socrata_downloads_filter_request( $vars )
{
  if( isset( $vars['asset'] ) ) $vars['asset'] = true;
  return $vars;
}

// CUSTOM BODY CLASS
add_action( 'body_class', 'socrata_downloads_body_class');
function socrata_downloads_body_class( $classes ) {
  if ( get_post_type() == 'socrata_downloads' && is_single() || get_post_type() == 'socrata_downloads' && is_archive() )
    $classes[] = 'socrata-downloads';
  return $classes;
}

// CUSTOM EXCERPT
function downloads_excerpt() {
  global $post;
  $text = rwmb_meta( 'downloads_wysiwyg' );
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

// Metabox
add_filter( 'rwmb_meta_boxes', 'socrata_downloads_register_meta_boxes' );
function socrata_downloads_register_meta_boxes( $meta_boxes )
{
  $prefix = 'downloads_';
  $meta_boxes[] = array(
    'title'  => __( 'Asset Details', 'downloads_' ),
    'post_types' => 'socrata_downloads',
    'context'    => 'normal',
    'priority'   => 'high',
    'validation' => array(
      'rules'    => array(
        "{$prefix}city" => array(
            'required'  => true,
        ),
      ),
    ),
    'fields' => array(
      // HEADING
      array(
        'type' => 'heading',
        'name' => __( 'Gated Content ?', 'downloads_' ),
        'id'   => 'fake_id', // Not used but needed for plugin
      ),
      // CHECKBOX
      array(
        'name'  => __( 'Is this gated?', 'downloads_' ),
        'id'   => "{$prefix}gated",
        'desc' => __( 'Yes', 'downloads_' ),
        'type' => 'checkbox',
        // Value can be 0 or 1
        'std'  => 0,
      ),
      // TEXT
      array(
        'name'  => __( 'Marketo Form ID', 'downloads_' ),
        'id'    => "{$prefix}marketo_form",
        'desc' => __( 'Example: 1234', 'downloads_' ),
        'type'  => 'text',
        'clone' => false,
      ), 
      // HEADING
      array(
        'type' => 'heading',
        'name' => __( 'Asset Meta', 'downloads_' ),
        'id'   => 'fake_id', // Not used but needed for plugin
      ),
      // FILE ADVANCED (WP 3.5+)
      array(
        'name'             => esc_html__( 'Asset File', 'downloads_' ),
        'id'               => "{$prefix}asset",
        'type'             => 'file_advanced',
        'max_file_uploads' => 1,
        'mime_type'        => 'application', // Leave blank for all file types
        'desc' => __( 'Downloadable file (ie. PDF)', 'downloads_' ),
      ),
      // URL
      array(
        'name' => esc_html__( 'Asset Link', 'downloads_' ),
        'id'   => "{$prefix}link",
        'desc' => __( 'Used for external assets like Open Data Field Guide', 'downloads_' ),
        'type' => 'url',
      ),
      // IMAGE ADVANCED (WP 3.5+)
      array(
        'name'             => __( 'Asset Image', 'downloads_' ),
        'id'               => "{$prefix}asset_image",
        'type'             => 'image_advanced',
        'max_file_uploads' => 1,
        'desc' => __( 'Thumbnail of the asset', 'downloads_' ),
      ),
       // TEXTAREA
      array(
        'name' => esc_html__( 'Asset Description', 'downloads_' ),
        'id'   => "{$prefix}asset_description",
        'type' => 'textarea',
        'cols' => 20,
        'rows' => 3,
      ),
    )
  );

  $meta_boxes[] = array(
    'title'         => 'Gated Asset Content',   
    'post_types'    => 'socrata_downloads',
    'context'       => 'normal',
    'priority'      => 'high',
      'fields' => array(
        array(
        'id'      => "{$prefix}wysiwyg",
        'type'    => 'wysiwyg',
        // Set the 'raw' parameter to TRUE to prevent data being passed through wpautop() on save
        'raw'     => false,
        // Editor settings, see wp_editor() function: look4wp.com/wp_editor
        'options' => array(
          'textarea_rows' => 15,
          'teeny'         => false,
          'media_buttons' => true,
        ),
      ),
    ),
  );

  return $meta_boxes;
}

// Shortcode [downloads]
function downloads_posts($atts, $content = null) {
  ob_start();
  ?>

  <section class="section-padding background-light-grey-5">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <h1 class="margin-bottom-60 font-light">Papers and Guides</h1>
        </div>
      </div>
      <div class="row hidden-lg">
        <div class="col-sm-12 margin-bottom-30">
          <div class="padding-15 background-light-grey-4">
            <ul class="filter-bar">
                <li><?php echo facetwp_display( 'facet', 'solution_dropdown' ); ?></li>
              <li><?php echo facetwp_display( 'facet', 'segment_dropdown' ); ?></li>
              <li><?php echo facetwp_display( 'facet', 'product_dropdown' ); ?></li>
              <li><?php echo facetwp_display( 'facet', 'asset_type_dropdown' ); ?></li>
              <li><button onclick="FWP.reset()" class="btn btn-primary"><i class="fa fa-undo" aria-hidden="true"></i></button></li>
            </ul>
          </div>          
        </div>
      </div>
      <div class="row">
        <div class="col-lg-3 hidden-xs hidden-sm hidden-md facet-sidebar">
          <button onclick="FWP.reset()" class="btn btn-primary btn-block margin-bottom-30"><i class="fa fa-undo" aria-hidden="true"></i> Reset Filters</button>
          <div class="filter-list">
            <button type="button" data-toggle="collapse" data-target="#solution">Solution</button>
            <div id="solution" class="collapse in"><?php echo facetwp_display( 'facet', 'solution' ); ?></div>
            <button type="button" data-toggle="collapse" data-target="#segment">Segment</button>
            <div id="segment" class="collapse in"><?php echo facetwp_display( 'facet', 'segment' ); ?></div>
            <button type="button" data-toggle="collapse" data-target="#product">Product</button>
            <div id="product" class="collapse in"><?php echo facetwp_display( 'facet', 'products' ); ?></div>
            <button type="button" data-toggle="collapse" data-target="#type">Type</button>
            <div id="type" class="collapse in"><?php echo facetwp_display( 'facet', 'asset_type' ); ?></div>
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
            <?php echo facetwp_display( 'template', 'downloads' ); ?>
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
  <?php echo do_shortcode('[match-height]');?>
  <script>!function(n){n(function(){FWP.loading_handler=function(){}})}(jQuery);</script>

  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('downloads', 'downloads_posts');
