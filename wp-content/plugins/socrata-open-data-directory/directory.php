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
function directory_segments() {
  global $terms;
  $terms = get_the_terms($post->ID , 'segment');
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
    'title'       => 'Listing Details', 'directory',
    'post_types'  => 'od_directory',
    'context'     => 'normal',
    'priority'    => 'high',
      'fields' => array(


      // RADIO BUTTONS
      array(
        'name'    => __( 'Does this listing have an open data site?', 'directory' ),
        'id'      => "{$prefix}open_data_site",
        'type'    => 'radio',
        // Array of 'value' => 'Label' pairs for radio options.
        // Note: the 'value' is stored in meta field, not the 'Label'
        'options' => array(
          'Yes' => __( 'Yes', 'your-prefix' ),
          'No' => __( 'No', 'your-prefix' ),
        ),
      ),
      // RADIO BUTTONS
      array(
        'name'    => __( 'Is this a Socrata customer?', 'directory' ),
        'id'      => "{$prefix}socrata_customer",
        'type'    => 'radio',
        // Array of 'value' => 'Label' pairs for radio options.
        // Note: the 'value' is stored in meta field, not the 'Label'
        'options' => array(
          'Yes' => __( 'Yes', 'your-prefix' ),
          'No' => __( 'No', 'your-prefix' ),
        ),
      ),
      // HEADING
      array(
        'type' => 'heading',
        'name' => __( 'Profile', 'directory' ),
        'id'   => 'fake_id', // Not used but needed for plugin
      ),
      // IMAGE ADVANCED (WP 3.5+)
      array(
        'name'             => __( 'Logo', 'directory' ),
        'id'               => "{$prefix}logo",
        'desc' => __( 'ONLY for Socrata customers. Minimum size 300x300 pixels.', 'directory' ),
        'type'             => 'image_advanced',
        'max_file_uploads' => 1,
      ),
      // NUMBER
      array(
        'name' => __( 'Population', 'your-prefix' ),
        'id'   => "{$prefix}population",
        'desc' => __( 'ONLY for City, County, and State', 'directory' ),
        'type' => 'number',
        'min'  => 0,
        'step' => 5,
      ),
    )
  );

  $meta_boxes[] = array(
    'id'          => 'geolocation',
    'title'       => 'GeoLocation',
    'post_types'  => 'od_directory',
    'context'     => 'normal',
    'priority'    => 'high',
    // Tell WP this Meta Box is GeoLocation
    'geo'         => true,
    // Or you can set advanced settings for Geo, like this example:
    // Restrict results to Australia only.

      'geo' => array(
           'componentRestrictions' => array(
               'country' => 'us'
           )
        ),
      'fields' => array(
          // Set the ID to `address` or `address_something` to make Auto Complete field
          array(
              'type' => 'text',
              'name' => 'Address',
              'id'    => 'address'
          ),
          // Auto populate `postal_code` to this field
          array(
              'type' => 'number',
              'name' => 'Postcode',
              'id'    => 'postal_code'
          ),
          // In case you want to limit your result like this example.
          // Auto populate short name of `administrative_area_level_1`. For example: QLD
          array(
              'type' => 'select',
              'name' => 'State',
              'placeholder' => 'Select a State',
              'options' => array(
                  'AL' => 'AL',
                  'AK' => 'AK',
                  'AZ' => 'AZ',
                  'AR' => 'AR',
                  'CA' => 'CA',
                  'CO' => 'CO',
                  'CT' => 'CT',
                  'DE' => 'DE',
                  'DC' => 'DC',
                  'FL' => 'FL',
                  'GA' => 'GA',
                  'HI' => 'HI',
                  'ID' => 'ID',
                  'IL' => 'IL',
                  'IN' => 'IN',
                  'IA' => 'IA',
                  'KS' => 'KS',
                  'KY' => 'KY',
                  'LA' => 'LA',
                  'ME' => 'ME',
                  'MD' => 'MD',
                  'MA' => 'MA',
                  'MI' => 'MI',
                  'MN' => 'MN',
                  'MS' => 'MS',
                  'MO' => 'MO',
                  'MT' => 'MT',
                  'NE' => 'NE',
                  'NV' => 'NV',
                  'NH' => 'NH',
                  'NJ' => 'NJ',
                  'NM' => 'NM',
                  'NY' => 'NY',
                  'NC' => 'NC',
                  'ND' => 'ND',
                  'OH' => 'OH',
                  'OK' => 'OK',
                  'OR' => 'OR',
                  'PA' => 'PA',
                  'RI' => 'RI',
                  'SC' => 'SC',
                  'SD' => 'SD',
                  'TN' => 'TN',
                  'TX' => 'TX',
                  'UT' => 'UT',
                  'VT' => 'VT',
                  'VA' => 'VA',
                  'WA' => 'WA',
                  'WV' => 'WV',
                  'WI' => 'WI',
                  'WY' => 'WY'
              ),
              'id'    => 'administrative_area_level_1_short'
          ),

          // We have custom `geometry` address component. Which is `lat + ',' + lng`
          array(
              'type' => 'text',
              'name' => 'Geometry',
              'id'    => 'geometry'
          ),
          // Here is the advanced usage of Binding Template.
          // Put any address component + anything you want
          array(
              'type' => 'text',
              'name' => 'State + Country',
              'id'    => 'state_country',
              // Example Output: QLD AU
              'binding' => 'short:administrative_area_level_1 + " " + country'
          ),
      )
  );


  $meta_boxes[] = array(
    'title'         => 'Site(s) Information',   
    'post_types'    => 'od_directory',
    'context'       => 'normal',
    'priority'      => 'high',
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




// Shortcode [directory-stats]
function op_directory_stats($atts, $content = null) {
  ob_start();
  ?>

  <section id="directory-stats" class="hero-animated background-primary-alt-2-light overlay overlay-primary-alt-2">
    <div class="outer">
      <div class="inner">
        <div class="container">
          <div class="row">
            <div class="col-sm-12">
              <h1 class="text-center text-reverse margin-bottom-15">Open Data Directory</h1>
              <h3 class="text-center text-reverse">Who has an open data site?</h3>
            </div>

            <div class="col-sm-3 hidden-xs">
              <div class="stat">
                  <?php
                    $args = array(
                      'post_type' => 'od_directory',
                      'segment' => 'city',
                      'meta_query' => array(
                        array(
                            'key' => 'directory_open_data_site',
                            'value' => 'Yes'
                        )
                      )
                    );
                    $myquery = new WP_Query($args);
                    echo "<div class='number text-reverse'>$myquery->found_posts</div>";
                    wp_reset_postdata();
                  ?>
                  <div class="stat-label text-reverse">Cities</div>
              </div>
            </div>
            <div class="col-sm-3 hidden-xs">
              <div class="stat">
                  <?php
                    $args = array(
                      'post_type' => 'od_directory',
                      'segment' => 'county',
                      'meta_query' => array(
                        array(
                            'key' => 'directory_open_data_site',
                            'value' => 'Yes'
                        )
                      )
                    );
                    $myquery = new WP_Query($args);
                    echo "<div class='number text-reverse'>$myquery->found_posts</div>";
                    wp_reset_postdata();
                  ?>
                  <div class="stat-label text-reverse">Counties</div>
                </div>
            </div>
            <div class="col-sm-3 hidden-xs">
              <div class="stat">
                  <?php
                    $args = array(
                      'post_type' => 'od_directory',
                      'segment' => 'state',
                      'meta_query' => array(
                        array(
                            'key' => 'directory_open_data_site',
                            'value' => 'Yes'
                        )
                      )
                    );
                    $myquery = new WP_Query($args);
                    echo "<div class='number text-reverse'>$myquery->found_posts</div>";
                    wp_reset_postdata();
                  ?>
                  <div class="stat-label text-reverse">States</div>
                </div>
            </div>
            <div class="col-sm-3 hidden-xs">
              <div class="stat">
                  <?php
                    $args = array(
                      'post_type' => 'od_directory',
                      'segment' => 'federal',
                      'meta_query' => array(
                        array(
                            'key' => 'directory_open_data_site',
                            'value' => 'Yes'
                        )
                      )
                    );
                    $myquery = new WP_Query($args);
                    echo "<div class='number text-reverse'>$myquery->found_posts</div>";
                    wp_reset_postdata();
                  ?>
                  <div class="stat-label text-reverse">Federal Agencies</div>
                </div>
            </div>


          </div><!-- row -->
        </div><!-- container -->
      </div><!-- inner -->
    </div><!-- outer -->
    <div class="image" style="background-image:url(/wp-content/uploads/directory-hero.jpg);"></div>
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
<section class="hidden-xs background-light-grey-4">
  <div id="directory-map"></div>
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD_STOs8I4L5GTLlDIu5aZ-pLs2L69wHMw"></script>
  
  <script type="text/javascript">
      // When the window has finished loading create our google map below
      google.maps.event.addDomListener(window, 'load', init);
  
      function init() {
          // Basic options for a simple Google Map
          // For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
          var mapOptions = {
              zoom: 5,
              center: new google.maps.LatLng(38.5111,-96.8005),
              scrollwheel: false,
              styles: [{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#93d2ec"},{"visibility":"on"}]}]
          };

          // Get the HTML DOM element that will contain your map 
          var mapElement = document.getElementById('directory-map');

          // Create the Google Map using our element and options defined above
          var map = new google.maps.Map(mapElement, mapOptions);
          setMarkers(map);
      }
      var beaches = [


<?php
$args = array(
  'post_type' => 'od_directory',
  'posts_per_page' => 10
);
$query = new WP_Query( $args );

// The Loop
while ( $query->have_posts() ) {
  $query->the_post();
  $pin = rwmb_meta( 'geometry' ); { ?>

  ['<?php the_title();?>',<?php echo $pin;?>],

  <?php
  };
}
wp_reset_postdata();

?>

];

function setMarkers(map) {
  // Adds markers to the map.

  // Marker sizes are expressed as a Size of X,Y where the origin of the image
  // (0,0) is located in the top left of the image.

  // Origins, anchor positions and coordinates of the marker increase in the X
  // direction to the right and in the Y direction down.
  var image = {
    url: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png',
    // This marker is 20 pixels wide by 32 pixels high.
    size: new google.maps.Size(20, 32),
    // The origin for this image is (0, 0).
    origin: new google.maps.Point(0, 0),
    // The anchor for this image is the base of the flagpole at (0, 32).
    anchor: new google.maps.Point(0, 32)
  };
  // Shapes define the clickable region of the icon. The type defines an HTML
  // <area> element 'poly' which traces out a polygon as a series of X,Y points.
  // The final coordinate closes the poly by connecting to the first coordinate.
  var shape = {
    coords: [1, 1, 1, 20, 18, 20, 18, 1],
    type: 'poly'
  };
  for (var i = 0; i < beaches.length; i++) {
    var beach = beaches[i];
    var marker = new google.maps.Marker({
      position: {lat: beach[1], lng: beach[2]},
      map: map,
      icon: image,
      shape: shape,
      title: beach[0],
      zIndex: beach[3]
    });
  }
}


  </script>

</section>
<section class="section-padding">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">



<?php
$args = array(
  'post_type' => 'od_directory',
  'posts_per_page' => 10
);
$query = new WP_Query( $args );

// The Loop
while ( $query->have_posts() ) {
  $query->the_post();
  $pin = rwmb_meta( 'geometry' ); { ?>

  ['<?php the_title();?>',<?php echo $pin;?>],

  <?php
  };
}
wp_reset_postdata();

?>


      </div>
    </div>
  </div>
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

  <section id="directory" class="background-light-grey-5">
    <div class="container">
      <div class="row">
        <div class="directory">
          <div class="col-sm-3 left">

            <button onclick="FWP.reset()" class="btn btn-primary btn-block">Clear All Filters</button>
            <div class="filters margin-bottom-15">
              <button type="button" data-toggle="collapse" data-target="#segments">Segment</button> 
              <div id="segments" class="collapse in">
                <?php echo do_shortcode('[facetwp facet="segment"]') ;?>
              </div>

              <button type="button" data-toggle="collapse" data-target="#datatypes">Data Types</button> 
              <div id="datatypes" class="collapse in">
                <?php echo do_shortcode('[facetwp facet="directory_data_type"]') ;?>
              </div>

              <button type="button" data-toggle="collapse" data-target="#population">Population</button> 
              <div id="population" class="collapse in">
                <?php echo do_shortcode('[facetwp facet="directory_population"]') ;?>
              </div>
            </div>
            <p><a data-toggle="modal" data-target="#suggest" class="btn btn-primary btn-block">Suggest a Site</a></p>

          </div>
          <div class="col-sm-9 right">
            <div class="filterbar margin-bottom-15">              
              <div class="filter-row float-left hidden-xs">
                <label>Showing</label>
                <?php echo do_shortcode('[facetwp counts="true"]') ;?>
              </div>              
              <div class="filter-row float-right no-padding">
                <?php echo do_shortcode('[facetwp per_page="true"]') ;?>
                <?php echo do_shortcode('[facetwp sort="true"]') ;?>
              </div>
              <div class="clearfix"></div>
            </div>


            <div class="directory-results">
              <?php echo do_shortcode('[facetwp template="directory"]') ;?>
            </div>
            <?php echo do_shortcode('[facetwp pager="true"]') ;?>
          </div>
        </div>
      </div>
    </div>
  </section>

<div id="suggest" class="modal fade" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<div class="close"><button type="button" data-dismiss="modal"><i class="icon-close"></i></button></div>
<h4 class="modal-title">Suggest a Site</h4>
</div>
<div class="modal-body">
<p>Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Sed posuere consectetur est at lobortis. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
<?php echo do_shortcode('[marketo-form id="2710"]');?>
</div>
</div>
</div>
</div>

  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('directory', 'op_directory');



