<?php
$displaydate = rwmb_meta( 'socrata_events_displaydate' );
$location = rwmb_meta( 'socrata_events_location' );
$address = rwmb_meta( 'socrata_events_address' );
$city = rwmb_meta( 'socrata_events_city' );  
$state = rwmb_meta( 'socrata_events_state' );  
$zip = rwmb_meta( 'socrata_events_zip' );
$directions = rwmb_meta( 'socrata_events_directions' );
$speakers = rwmb_meta( 'socrata_events_speakers' );
$today = strtotime('today UTC');
$date = rwmb_meta( 'socrata_events_endtime' );
?>
<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); $url = $thumb['0']; ?>
<section id="top" class="hero-events-single section-padding background-wet-asphalt img-background" style="background-image: url(<?=$url?>);">
    <div class="container">
      <div class="row">
        <div class="col-md-8">
          <div class="padding-15">
            <h1 class="text-reverse margin-bottom-15"><?php the_title(); ?></h1>
            <?php
              if ($directions) { ?>
              <ul class="date-location">
                <li class="text-reverse lead"><?php echo $displaydate;?></li>
                <li class="text-reverse lead"><a href="<?php echo $directions;?>" target="_blank"><?php echo $location;?>, <?php echo $city;?>, <?php echo $state;?></a></li>
              </ul>
              <?php
              }
              else { ?>            
              <ul class="date-location">
                <li class="text-reverse lead"><?php echo $displaydate;?></li>
                <li class="text-reverse lead"><?php echo $city;?>, <?php echo $state;?></li>
              </ul>
              <?php
              } 
            ?>
            <?php            
              if ($speakers) { ?>
                <div><a href="#speakers" target="_blank" class="btn btn-default btn-lg">Meet The Speakers</a></div>
              <?php
              }
            ?>
          </div>
        </div>
        <div class="col-md-4">        
          <div class="box-black padding-15 marketo-form">
            <?php          
            if ($date < $today) { ?>
            <div class="alert alert-info" style="margin:0;"><strong>This is a past event.</strong> Registration is closed.</div>
            <?php
            }
            else { ?>
            <script src="//app-abk.marketo.com/js/forms2/js/forms2.min.js"></script>
            <form id="mktoForm_<?php echo rwmb_meta( 'socrata_events_marketo' );?>"></form>
            <script>MktoForms2.loadForm("//app-abk.marketo.com", "851-SII-641", <?php echo rwmb_meta( 'socrata_events_marketo' );?> );</script>
            <?php
            }
            ?>            
          </div>
        </div>
      </div>
    </div>


</section>
<?php echo rwmb_meta( 'socrata_events_wysiwyg' );?>
<?php
  if ($speakers) { ?>
  <div id="speakers">    
    <?php echo $speakers;?>
  </div>
  <?php
  }
?>