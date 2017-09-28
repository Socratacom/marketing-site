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
$geometry = rwmb_meta( 'socrata_events_geometry' );
$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'feature-image' );
$url = $thumb['0'];
$logo = rwmb_meta( 'socrata_events_brand', 'size=medium' );
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
          <div><a href="#meta" class="reveal-delay"><i class="icon-32 icon-down-arrow color-primary" aria-hidden="true"></i></a></div>
        </div>      
      </div>
    </div>
  </section>
  <div class="event-feature-image" style="width:100%; background-image:url(<?php echo $url;?>); background-repeat: no-repeat; background-position: center; background-size: cover;"></div>
  <section id="meta" class="section-padding">
    <div class="container">
      <div class="row">
        <div class="col-sm-12 col-md-8 col-md-offset-2">
          <?php if ( ! empty( $logo ) ) { ?><div class="sixteen-nine margin-bottom-60" style="background-image:url(<?php foreach ( $logo as $image ) { echo $image['url']; } ?>); background-size:contain; background-repeat:no-repeat; background-position:left center; position:relative; width:200px;"></div><?php } ?>
          
          <?php if ( ! empty($website) ) 
            echo '<h5 class="text-uppercase margin-bottom-0">Website:</h5>';
            echo '<p><a href="' . $website . '" target="_blank">'.$website.'</a></p>';
          ?>
          <h5 class="text-uppercase margin-bottom-0">Venue:</h5>
          <p><?php echo $venue;?></p>
          <h5 class="text-uppercase margin-bottom-0">Address:</h5>
          <div class="margin-bottom-60">
            <p><?php echo $address;?><?php if ( ! empty($city) ) echo ", "; echo $city;?><?php if ( ! empty($state) ) echo ", "; echo $state;?><?php if ( ! empty($zip) ) echo ", "; echo $zip;?> - <a id="test" data-toggle="collapse" data-target="#gmap">View Map</a></p>         
            <div id="gmap" class="collapse">            
              <div id="map" style="height:400px; width:100%;"></div>
              <script>
              function initialize() {
                var mapCanvas = document.getElementById("map");
                var myCenter = new google.maps.LatLng(<?php echo $geometry;?>); 
                var mapOptions = {
                  styles: [{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#93d2ec"},{"visibility":"on"}]}],
                  center: myCenter, 
                  zoom: 14
                };
                var map = new google.maps.Map(mapCanvas,mapOptions);
                var marker = new google.maps.Marker({
                  position: myCenter
                });
                marker.setMap(map);
                $('.collapse').on('shown.bs.collapse', function() {
                    google.maps.event.trigger(map, 'resize');
                    map.setCenter(myCenter);
                });
              }
              </script>
              <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD_STOs8I4L5GTLlDIu5aZ-pLs2L69wHMw&callback=initialize"></script>
            </div>    
          </div>
          <?php echo rwmb_meta( 'socrata_events_wysiwyg' );?>
        </div>
      </div>
    </div>
  </section>
  <script>window.sr=ScrollReveal({reset:!1}),sr.reveal(".reveal",{duration:500}),sr.reveal(".reveal-delay",{duration:500,delay:500}),sr.reveal(".box-reveal",{duration:1e3,delay:500},50);</script>

  <?php 
  } 
;?>