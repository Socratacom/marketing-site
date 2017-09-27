<?php 
$displaydate = rwmb_meta( 'socrata_events_displaydate' );
$address = rwmb_meta( 'socrata_events_address' );  
$city = rwmb_meta( 'socrata_events_locality' );  
$state = rwmb_meta( 'socrata_events_administrative_area_level_1_short' );
$zip = rwmb_meta( 'socrata_events_postal_code' ); 
$today = strtotime('today UTC');
$date = rwmb_meta( 'socrata_events_endtime' );
$venue = rwmb_meta( 'socrata_events_venue' );
$website = rwmb_meta( 'socrata_events_url' );
$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'post-image' );
$url = $thumb['0'];
?>

<?php if($date < $today) { ?>
    <section class="section-padding">
      <div class="container">
        <div class="row">
          <div class="col-sm-10 col-sm-offset-1">
            <div class="alert alert-info"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <strong>This event has expired</strong>. Return to <a href="/events">events</a>.</div>
          </div>
        </div>
      </div>
    </section>
  <?php } 
;?>

<?php if($date >= $today) { ?>
<section class="section-padding">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <h1 class="font-light margin-bottom-15"><?php the_title(); ?></h1>
        <h3 class="margin-bottom-60 font-light"><?php echo $displaydate;?></h3>
        <a href="#meta" class="reveal-delay"><i class="icon-32 icon-down-arrow color-primary" aria-hidden="true"></i></a> 
      </div>      
    </div>
  </div>
</section>
<section class="section-padding background-primary-alt-1">
  <div class="container">
    <div class="row">
      
    </div>
  </div>
</section>
<section id="meta" class="section-padding">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 col-md-8 col-md-offset-2">
        <?php if ( ! empty($website) ) 
          echo '<h5 class="text-uppercase margin-bottom-0">Website</h5>';
          echo '<p><a href="' . $website . '" target="_blank">'.$website.'</a></p>';
        ?>
        <h5 class="text-uppercase margin-bottom-0">Venue:</h5>
        <p><?php echo $venue;?></p>
        <h5 class="text-uppercase margin-bottom-0">Address:</h5>
        <div class="margin-bottom-60">
          <p><?php echo $address;?><?php if ( ! empty($city) ) echo ", "; echo $city;?><?php if ( ! empty($state) ) echo ", "; echo $state;?><?php if ( ! empty($zip) ) echo ", "; echo $zip;?> - <a data-toggle="collapse" data-target="#gmap">View Map</a></p>
          <div id="gmap" class="collapse">

            
<div id="map" style="height:400px; width:100%"></div>
    <script>
    jQuery(function($) {
        // Asynchronously Load the map API 
        var script = document.createElement('script');
        script.src = "//maps.googleapis.com/maps/api/js?key=AIzaSyD_STOs8I4L5GTLlDIu5aZ-pLs2L69wHMw&callback=initialize";
        document.body.appendChild(script);
    });

    function initialize() {
        var map;
        var bounds = new google.maps.LatLngBounds();
        var mapOptions = {
          scrollwheel: false,
          styles: [{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#93d2ec"},{"visibility":"on"}]}]
        };
                        
        // Display a map on the page
        map = new google.maps.Map(document.getElementById("map"), mapOptions);
        map.setTilt(45);
            
        // Multiple Markers
        var markers = [


          <?php            
              $pin = rwmb_meta( 'socrata_events_geometry' ); { ?>
              ['<?php the_title();?>',<?php echo $pin;?>],
              <?php
              };
          ?>


        ];

            
        // Display multiple markers on a map
        var infoWindow = new google.maps.InfoWindow(), marker, i;
        
        // Loop through our array of markers & place each one on the map  
        for( i = 0; i < markers.length; i++ ) {
            var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
            bounds.extend(position);
            marker = new google.maps.Marker({
                position: position,
                map: map,
                title: markers[i][0]
            });
            


            // Automatically center the map fitting all markers on the screen
            map.fitBounds(bounds);
        }

        // Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
        var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
            this.setZoom(3);
            google.maps.event.removeListener(boundsListener);
        });
        
    }
    </script>




          </div>
        </div>




        <?php echo rwmb_meta( 'socrata_events_wysiwyg' );?>
      </div>
    </div>
  </div>
</section>

<script>window.sr=ScrollReveal({reset:!1}),sr.reveal(".reveal",{duration:500}),sr.reveal(".reveal-delay",{duration:500,delay:500}),sr.reveal(".box-reveal",{duration:1e3,delay:500},50);</script>






  <section class="section-padding">
    <div class="container">
      <div class="row">

        <div class="col-sm-8 col-sm-offset-2">
          <h1 class="margin-bottom-15"><?php the_title(); ?></h1>
          <h4 class="margin-bottom-30 font-light"><?php echo $displaydate;?> | <?php echo $city;?>, <?php echo $state;?></h4>
          <div class="margin-bottom-30"><img src="<?php echo $url;?>" <?php if ( ! empty($alt_text) ) { ?> alt="<?php echo $alt_text;?>" <?php } ;?> class="img-responsive"><?php echo do_shortcode('[image-attribution]'); ?></div>

          
        </div>
      </div>
    </div>
  </section>

  <?php 
  } 
;?>