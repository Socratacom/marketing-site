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
$content = rwmb_meta( 'socrata_events_wysiwyg' );
$form = rwmb_meta( 'socrata_events_form' );
$form_title = rwmb_meta( 'socrata_events_form_title' );
$form_text = rwmb_meta( 'socrata_events_form_text' );
$cta_url = rwmb_meta( 'socrata_events_cta_url' );
$button_text = rwmb_meta( 'socrata_events_button_text' );
$eventbrite = rwmb_meta( 'socrata_events_eventbrite' );
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
  <div class="event-feature-image" style="width:100%; background-image:url(<?php echo $url;?>); background-repeat: no-repeat; background-position: center; background-size: cover; position:relative;">
    <div style="position:absolute; bottom:5px; right:15px; display:inline-block; color:#fff;"><?php echo do_shortcode('[image-attribution]'); ?></div>
  </div>
  <section id="meta" class="section-padding">
    <div class="container">
      <div class="row">
        <div class="col-sm-12 <?php if ( ! empty( $form ) ) { ?>col-md-8<?php } elseif ( ! empty( $cta_url ) ) { ?>col-md-8<?php } else { ?>col-md-8 col-md-offset-2<?php };?>">
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
          
          <?php if ( ! empty($content) ) { ?> 
            <div class="margin-bottom-60">
              <hr/>
              <?php echo $content;?>
            </div>
          <?php };?>

          <?php if ( ! empty($eventbrite) ) { ?> 
            <div class="margin-bottom-60">
            	<iframe id="formIframe" src="//eventbrite.com/tickets-external?eid=<?php echo $eventbrite;?>&ref=etckt" frameborder="0" height="400" width="100%" vspace="0" hspace="0" marginheight="5" marginwidth="5" scrolling="auto" allowtransparency="true"></iframe>
            </div>
          <?php };?>

        </div>

        <?php if ( ! empty( $form ) ) { ?>
        <div class="col-sm-12 col-md-4">
          <div class="padding-30 background-light-grey-4">
            <?php if ( ! empty($form_title) ) echo '<h4 class="margin-bottom-15">'.$form_title.'</h5>';?>
            <?php if ( ! empty($form_text) ) echo '<p>'.$form_text.'</p>';?>
            <?php if ( ! empty( $form ) ) { 
              $str = $form;
              $str = preg_replace('#^https?://go.socrata.com/l/303201/#', '', $str);
              ?> 
              <iframe id="formIframe" style="width: 100%; border: 0;" src="https://go.pardot.com/l/303201/<?php echo $str;?>" scrolling="no"></iframe>
              <script>iFrameResize({log:true}, '#formIframe')</script>
              <?php } 
            ?>
          </div>
        </div>
        <?php } elseif (! empty( $cta_url ) ) { ?>
        <div class="col-sm-12 col-md-4">
          <div class="padding-30 background-light-grey-4">
            <?php if ( ! empty($form_title) ) echo '<h4 class="margin-bottom-15">'.$form_title.'</h5>';?>
            <?php if ( ! empty($form_text) ) echo '<p>'.$form_text.'</p>';?>
            <?php if ( ! empty( $button_text ) )  { ?><p class="margin-bottom-0"><a href="<?php echo $cta_url;?>" target="_blank" class="btn btn-primary"><?php echo $button_text;?></a></p><?php } else { ?><p class="margin-bottom-0"><a href="<?php echo $cta_url;?>" target="_blank" class="btn btn-primary">submit</a></p><?php } ?>
          </div>
        </div>

        <?php };?>

      </div>
    </div>
  </section>
  <script>window.sr=ScrollReveal({reset:!1}),sr.reveal(".reveal",{duration:500}),sr.reveal(".reveal-delay",{duration:500,delay:500}),sr.reveal(".box-reveal",{duration:1e3,delay:500},50);</script>

  <?php 
  } 
;?>