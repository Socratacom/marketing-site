<?php
/*
Plugin Name: Socrata Open Data Directory
Plugin URI: http://socrata.com/
Description: This is a directory of Open Data sites broken down by Federal, State, and Cities.
Version: 1.0
Author: Michael Church
Author URI: http://socrata.com/
License: GPLv2
*/

add_action( 'init', 'create_od_directory' );
function create_od_directory() {
  register_post_type( 'od_directory',
    array(
      'labels' => array(
        'name' => 'OD Directory',
        'singular_name' => 'OD Directory',
        'add_new' => 'Add New Listing',
        'add_new_item' => 'Add New Listing',
        'edit' => 'Edit Listing',
        'edit_item' => 'Edit Listing',
        'new_item' => 'New Listing',
        'view' => 'View',
        'view_item' => 'View Listing',
        'search_items' => 'Search Listings',
        'not_found' => 'Not found',
        'not_found_in_trash' => 'Not found in Trash'
      ),
      'public' => true,
      'menu_position' => 100,
      'supports' => array( 'title', 'thumbnail' ),
      'taxonomies' => array( '' ),
      'menu_icon' => '',
      'has_archive' => false,
      'rewrite' => array('with_front' => false, 'slug' => 'open-data-directory')
    )
  );
}

// MENU ICON
//Using Dashicon Font https://developer.wordpress.org/resource/dashicons
add_action( 'admin_head', 'add_od_directory_icon' );
function add_od_directory_icon() { ?>
  <style>
    #adminmenu .menu-icon-od_directory div.wp-menu-image:before {
      content: '\f337';
    }
  </style>
  <?php
}

/*
// CUSTOM COLUMS FOR ADMIN
add_filter( 'manage_edit-od_directory_columns', 'od_directory_edit_columns' ) ;
function od_directory_edit_columns( $columns ) {
  $columns = array(
    'cb'          => '<input type="checkbox" />',    
    'title'       => __( 'Name' ),
    'category'    => __( 'Category' ),
    'eventdate'   => __( 'Event Date' ),

  );
  return $columns;
}
// Get Content for Custom Colums
add_action("manage_od_directory_posts_custom_column",  "od_directory_columns");
function od_directory_columns($column){
  global $post;

  switch ($column) {    
    case 'eventdate':
      $timestamp = rwmb_meta( 'od_directory_starttime' ); echo date("F j, Y, g:i a", $timestamp);
      break;
    case 'category':
      $segment = get_the_terms($post->ID , 'od_directory_cat');
      echo $segment[0]->name;
      for ($i = 1; $i < count($segment); $i++) {echo ', ' . $segment[$i]->name ;}
      break;
  }
}

// Make these columns sortable
add_filter( "manage_edit-od_directory_sortable_columns", "od_directory_sortable_columns" );
function od_directory_sortable_columns() {
  return array(
    'title'       => 'title',
    'category'    => 'category',
    'eventdate'   => 'eventdate',
  );
}

*/

// TAXONOMIES
add_action( 'init', 'od_directory_cat', 0 );
function od_directory_cat() {
  register_taxonomy(
    'od_directory_cat',
    'od_directory',
    array(
      'labels' => array(
        'name' => 'Region',
        'menu_name' => 'Region',
        'add_new_item' => 'Add New Region',
        'new_item_name' => "New Region"
      ),
      'show_ui' => true,
      'show_tagcloud' => false,
      'hierarchical' => true,
      'sort' => true,      
      'args' => array( 'orderby' => 'term_order' ),
      'show_admin_column' => true,
      'rewrite' => array('with_front' => false, 'slug' => 'directory-region'),
    )
  );
}

// TAXONOMIES
add_action( 'init', 'od_directory_type', 0 );
function od_directory_type() {
  register_taxonomy(
    'od_directory_type',
    'od_directory',
    array(
      'labels' => array(
        'name' => 'Data Type',
        'menu_name' => 'Data Type',
        'add_new_item' => 'Add New Type',
        'new_item_name' => "New Type"
      ),
      'show_ui' => true,
      'show_tagcloud' => false,
      'hierarchical' => true,
      'sort' => true,      
      'args' => array( 'orderby' => 'term_order' ),
      'show_admin_column' => true,
      'rewrite' => array('with_front' => false, 'slug' => 'directory-data-type'),
    )
  );
}

// PRINT TAXONOMIES
function directory_categories() {
  global $terms;
  $terms = get_the_terms($post->ID , 'od_directory_cat');
  echo $terms[0]->name;
  for ($i = 1; $i < count($terms); $i++) {echo ', ' . $terms[$i]->name ;}
}
function directory_data_types() {
  global $terms;
  $terms = get_the_terms($post->ID , 'od_directory_type');
  echo $terms[0]->name;
  for ($i = 1; $i < count($terms); $i++) {echo ', ' . $terms[$i]->name ;}
}


// Template Paths
add_filter( 'template_include', 'od_directory_single_template', 1 );
function od_directory_single_template( $template_path ) {
  if ( get_post_type() == 'od_directory' ) {
    if ( is_single() ) {
      // checks if the file exists in the theme first,
      // otherwise serve the file from the plugin
      if ( $theme_file = locate_template( array ( 'single-directory.php' ) ) ) {
        $template_path = $theme_file;
      } else {
        $template_path = plugin_dir_path( __FILE__ ) . 'single-directory.php';
      }
    }
  }
  return $template_path;
}

// Custom Body Class
add_action( 'body_class', 'od_directory_body_class');
function od_directory_body_class( $classes ) {
  if ( get_post_type() == 'od_directory' && is_single() || get_post_type() == 'od_directory' && is_archive() )
    $classes[] = 'od-directory';
  return $classes;
}

// Fixes JS when Yoast enabled and thumbnail disabled
add_action( 'admin_enqueue_scripts', 'od_directory_box_scripts' );
function od_directory_box_scripts() {
    global $post;
    wp_enqueue_media( array( 
        'post' => $post->ID, 
    ) );
}

// Metabox

add_filter( 'rwmb_meta_boxes', 'od_directory_group_register_meta_boxes' );
function od_directory_group_register_meta_boxes( $meta_boxes )
{
  $prefix = 'directory_';

  $meta_boxes[] = array(
    'title'  => __( 'Listing Details', 'directory' ),
    'post_types' => array( 'od_directory' ),
    'context'    => 'normal',
    'priority'   => 'high',
    'fields' => array(
      // CHECKBOX
      array(
        'name' => __( 'Does this listing have an open data site?', 'directory' ),
        'id'   => "{$prefix}datasite",
        'desc' => __( 'Yes' ),
        'type' => 'checkbox',
      ),
      // CHECKBOX
      array(
        'name' => __( 'Is this a Socrata customer?', 'your-directory' ),
        'id'   => "{$prefix}customer",
        'desc' => __( 'Yes' ),
        'type' => 'checkbox',
        'std'  => 0,
      ),
      // HEADING
      array(
        'type' => 'heading',
        'name' => __( 'Geo Location', 'directory' ),
        'id'   => 'fake_id', // Not used but needed for plugin
      ),
      // TEXT
      array(
        'name'  => __( 'Latitude', 'directory' ),
        'id'    => "{$prefix}latitude",
        'desc' => __( 'Eample: 38.5111', 'directory' ),
        'type'  => 'text',
      ),
      // TEXT
      array(
        'name'  => __( 'Longitude', 'directory' ),
        'id'    => "{$prefix}longitude",
        'desc' => __( 'Eample: -96.8005', 'directory' ),
        'type'  => 'text',
      ),
      // HEADING
      array(
        'type' => 'heading',
        'name' => __( 'Profile', 'directory' ),
        'id'   => 'fake_id', // Not used but needed for plugin
      ),
      // PLUPLOAD IMAGE UPLOAD (WP 3.3+)
      array(
        'name'             => __( 'Logo', 'your-prefix' ),
        'id'               => "{$prefix}logo",
        'desc' => __( 'Only for Socrata customers. Minimum size 300x300 pixels.', 'directory' ),
        'type'             => 'plupload_image',
        'max_file_uploads' => 1,
      ),
      // TEXT
      array(
        'name'  => __( 'Population', 'directory' ),
        'id'    => "{$prefix}population",
        'desc' => __( 'ONLY for City, County, and State', 'directory' ),
        'type'  => 'text',
      ),         
    )
  );

  $meta_boxes[] = array(
    'title'  => __( 'Site(s) Information' ),   
      'post_types' => 'od_directory',
      'context'    => 'normal',
      'priority'   => 'high',
      'fields' => array(
        array(
        'id'     => "{$prefix}sites",
        'type'   => 'group',
        'clone'  => true,
        'sort_clone' => true,
        // Sub-fields
        'fields' => array(
          array(
            'name' => __( 'Site Name', 'directory' ),
            'id'   => "{$prefix}site_name",
            'type' => 'text',
          ),
          array(
            'name' => __( 'URL', 'directory' ),
            'id'   => "{$prefix}site_url",
            'desc' => __( 'Include the http:// or https://', 'directory' ),
            'type' => 'url',
          ),
        ),
      ),
      // HEADING
      array(
        'type' => 'heading',
        'name' => __( 'Screen Shots', 'directory' ),
        'id'   => 'fake_id', // Not used but needed for plugin
      ),
      // PLUPLOAD IMAGE UPLOAD (WP 3.3+)
      array(
        'name'             => __( 'Add up to 4 screen shots.', 'your-prefix' ),
        'id'               => "{$prefix}screen",
        'desc' => __( 'Only for Socrata customers. Minimum size 300x300 pixels.', 'directory' ),
        'type'             => 'plupload_image',
        'max_file_uploads' => 4,
      ),
    ),
  );



  return $meta_boxes;
}




/* Things to Note:
• Each Record will by Category Entity (i.e City, County, State, and Federal).
• Ability for multiple site entries
• Population will be the default query order. 
• Look into adding a map view. 
• Add Number of open data Datasets
• Socrata Customers will get a Logo and Screenshot
• Socrata Customers will also get "Open Data Leader Since 2004"
• If customers have apps, enter url.
• Add Feedback/Recomend a site. Possibly Marketo.
• Visualizations will be: 150 Cities have Open Data Sites, etc.
*/




// Shortcode [newsroom-posts]
function op_directory_stats($atts, $content = null) {
  ob_start();
  ?>

  <section>
    <div class="container" style="width:100%; padding:0;">
    <div class="row no-gutters">
      <div class="col-sm-3">
        <div class="background-asbestos overlay-midnight-blue img-background-fixed" style="background-image:url(/wp-content/uploads/finance-city-street.jpg); height: 300px;">
          <div class="padding-30 vertical-center">
            <?php
              $args = array(
                'post_type' => 'od_directory',
                'od_directory_cat' => 'city',
                'meta_query' => array(
                  array(
                      'key' => 'directory_datasite',
                      'value' => '1'
                  )
                )
              );
              $myquery = new WP_Query($args);
              echo "<h1 class='text-reverse text-center margin-bottom-15'>$myquery->found_posts</h1>";
              wp_reset_postdata();
            ?>
            <div class="text-center text-reverse">Cities have Open Data sites</div>
          </div>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="background-silver overlay-wet-asphalt img-background-fixed" style="background-image:url(/wp-content/uploads/business-crowd-partner-summit-2016.jpg); height: 300px;">
          <div class="padding-30 vertical-center">
            <?php
              $args = array(
                'post_type' => 'od_directory',
                'od_directory_cat' => 'county',
                'meta_query' => array(
                  array(
                      'key' => 'directory_datasite',
                      'value' => '1'
                  )
                )
              );
              $myquery = new WP_Query($args);
              echo "<h1 class='text-reverse text-center margin-bottom-15'>$myquery->found_posts</h1>";
              wp_reset_postdata();
            ?>
            <div class="text-center text-reverse">Counties have Open Data sites</div>
          </div>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="background-asbestos overlay-midnight-blue img-background-fixed" style="background-image:url(/wp-content/uploads/11718018374_29cbdaea40_k.jpg); height: 300px;">
          <div class="padding-30 vertical-center">
            <?php
              $args = array(
                'post_type' => 'od_directory',
                'od_directory_cat' => 'state',
                'meta_query' => array(
                  array(
                      'key' => 'directory_datasite',
                      'value' => '1'
                  )
                )
              );
              $myquery = new WP_Query($args);
              echo "<h1 class='text-reverse text-center margin-bottom-15'>$myquery->found_posts</h1>";
              wp_reset_postdata();
            ?>
            <div class="text-center text-reverse">States have Open Data sites</div>
          </div>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="background-asbestos overlay-wet-asphalt img-background-fixed" style="background-image:url(/wp-content/uploads/what-works-kansas-city.jpg); height: 300px;">
          <div class="padding-30 vertical-center">
            <?php
              $args = array(
                'post_type' => 'od_directory',
                'od_directory_cat' => 'federal',
                'meta_query' => array(
                  array(
                      'key' => 'directory_datasite',
                      'value' => '1'
                  )
                )
              );
              $myquery = new WP_Query($args);
              echo "<h1 class='text-reverse text-center margin-bottom-15'>$myquery->found_posts</h1>";
              wp_reset_postdata();
            ?>
            <div class="text-center text-reverse">Federal Agencies have Open Data sites</div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </section>
  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('directory-stats', 'op_directory_stats');












// Shortcode [directory-map]
function op_directory_map($atts, $content = null) {
  ob_start();
  ?>
<section class="hidden-xs">
  <div id="directory-map"></div>
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD_STOs8I4L5GTLlDIu5aZ-pLs2L69wHMw"></script>
  
  <script type="text/javascript">
      // When the window has finished loading create our google map below
      google.maps.event.addDomListener(window, 'load', init);
  
      function init() {
          // Basic options for a simple Google Map
          // For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
          var mapOptions = {
              // How zoomed in you want the map to start at (always required)
              zoom: 5,

              // The latitude and longitude to center the map (always required)
              center: new google.maps.LatLng(38.5111,-96.8005),
              scrollwheel: false,

              // How you would like to style the map. 
              // This is where you would paste any style found on Snazzy Maps.
              styles: [{"elementType":"geometry","stylers":[{"hue":"#ff4400"},{"saturation":-68},{"lightness":-4},{"gamma":0.72}]},{"featureType":"road","elementType":"labels.icon"},{"featureType":"landscape.man_made","elementType":"geometry","stylers":[{"hue":"#0077ff"},{"gamma":3.1}]},{"featureType":"water","stylers":[{"hue":"#00ccff"},{"gamma":0.44},{"saturation":-33}]},{"featureType":"poi.park","stylers":[{"hue":"#44ff00"},{"saturation":-23}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"hue":"#007fff"},{"gamma":0.77},{"saturation":65},{"lightness":99}]},{"featureType":"water","elementType":"labels.text.stroke","stylers":[{"gamma":0.11},{"weight":5.6},{"saturation":99},{"hue":"#0091ff"},{"lightness":-86}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"lightness":-48},{"hue":"#ff5e00"},{"gamma":1.2},{"saturation":-23}]},{"featureType":"transit","elementType":"labels.text.stroke","stylers":[{"saturation":-64},{"hue":"#ff9100"},{"lightness":16},{"gamma":0.47},{"weight":2.7}]}]
          };

          // Get the HTML DOM element that will contain your map 
          // We are using a div with id="map" seen below in the <body>
          var mapElement = document.getElementById('directory-map');

          // Create the Google Map using our element and options defined above
          var map = new google.maps.Map(mapElement, mapOptions);


          // Let's also add a marker while we're at it
          var marker = new google.maps.Marker({
              position: new google.maps.LatLng(40.6700, -73.9400),            
              map: map,
              title: 'Snazzy!'
          });

          var marker = new google.maps.Marker({
              position: new google.maps.LatLng(41.6700, -73.9400),
              map: map,
              title: 'Snazzy!'
          });
      }
  </script>

</section>

  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('directory-map', 'op_directory_map');










// Shortcode [directory]
function op_directory($atts, $content = null) {
  ob_start();
  ?>




  <section id="directory" class="section-padding background-clouds">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <ul class="directory-list">

<?php
  /* The Query */

  
  
  $args = array(
      'post_type' => 'od_directory',
      'post_status' => 'publish',
      'ignore_sticky_posts' => true,
    );

  $query = new WP_Query( $args );

  // The Loop
  if ( $query->have_posts() ) : 
  while( $query->have_posts() ): $query->the_post(); {  
    
    $customer = rwmb_meta( 'directory_customer' );

    if ( ! empty( $customer ) ) { ?>
    <!-- Code for Socrata customers -->
    <li class="socrata-customer">
      
      <small>Socrata Customer</small>
      <p><?php directory_categories(); ?></p>

      <h4><?php the_title(); ?></h4>






<?php $logo = rwmb_meta( 'directory_logo' );

if ( !empty( $logo ) ) {
    foreach ( $logo as $image ) {
        echo "<img src='{$image['url']}' width='{$image['width']}' height='{$image['height']}' alt='{$image['alt']}' />";
    }
}
?>



      

      <?php $datasite = rwmb_meta( 'directory_datasite' );
        if ( ! empty( $datasite ) )
          {
            echo "<p>Yep, got a Open Data site.</p>";
          }
        else  {
          echo "<p>Nope. Ain't got no Open Data site.</p>";
        }
      ?>

      <?php $sites_group = rwmb_meta( 'directory_sites' );
        if ( ! empty( $sites_group ) )
        { ?>
          <ul>
          <?php foreach ( $sites_group as $group_value )
            {
                $name = isset( $group_value['directory_site_name'] ) ? $group_value['directory_site_name'] : '';
                $url = isset( $group_value['directory_site_url'] ) ? $group_value['directory_site_url'] : '';
                ?>
                <li><a href="<?php echo $url;?>" target="_blank"><?php echo $name;?></a></li>
                <?php
            } ?>
          </ul>
          <?php
        }
      ?>

      <?php $population = rwmb_meta( 'directory_population' );
        if ( ! empty( $population ) )
          { ?>
            <p><?php echo $population;?></p>
            <?php
          }
      ?>

      <p><?php directory_data_types(); ?></p>

      <?php $screen = rwmb_meta( 'directory_screen', 'size=thumbnail' );

      if ( !empty( $screen ) ) {
          foreach ( $screen as $image ) {
              echo "<p><img src='{$image['url']}' width='{$image['width']}' height='{$image['height']}' alt='{$image['alt']}' /></p>";
          }
      }
      ?>



    </li>

    <?php
    }

    else {?>
    <!-- Code for everyone else -->

    <li>
      <h4><?php the_title(); ?></h4>
      <?php $datasite = rwmb_meta( 'directory_datasite' );
        if ( ! empty( $datasite ) )
          {
            echo "<p>Yep, got a Open Data site.</p>";
          }
        else  {
          echo "<p>Nope. Ain't got no Open Data site.</p>";
        }
      ?>
    </li>

    <?php

    }
  
  }



  endwhile;
  endif;

  // Restore original Post Data
  wp_reset_postdata();

?>

          </ul>
        </div>
      </div>
    </div>
  </section>





  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('directory', 'op_directory');



