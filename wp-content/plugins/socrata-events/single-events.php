<?php 
$displaydate = rwmb_meta( 'socrata_events_displaydate' );
$city = rwmb_meta( 'socrata_events_locality' );  
$state = rwmb_meta( 'socrata_events_administrative_area_level_1_short' );  
$today = strtotime('today UTC');
$date = rwmb_meta( 'socrata_events_endtime' );
$speakers = rwmb_meta( 'socrata_events_speakers' );
$marketo = rwmb_meta( 'socrata_events_marketo' );
$customtitle = rwmb_meta( 'socrata_events_custom_title' );
$customcopy = rwmb_meta( 'socrata_events_custom_copy' );
$customurl = rwmb_meta( 'socrata_events_cta_url' );
$customcta = rwmb_meta( 'socrata_events_custom_cta' );
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
        <!--<div class="col-sm-4 col-sm-push-8">
          <div class="background-light-grey-4 padding-30 margin-bottom-30">
            <h4 class="margin-bottom-15"><?php echo $customtitle;?></h4>
            <p><?php echo $customcopy;?></p>    
            <p class="margin-bottom-0"><a href="<?php echo $customurl;?>" target="_blank" class="btn btn-primary btn-lg"><?php echo $customcta;?></a></p>
          </div>
        </div>-->
        <div class="col-sm-8 col-sm-offset-2">
          <h1 class="margin-bottom-15"><?php the_title(); ?></h1>
          <h4 class="margin-bottom-30 font-light"><?php echo $displaydate;?> | <?php echo $city;?>, <?php echo $state;?></h4>
          <div class="margin-bottom-30"><img src="<?php echo $url;?>" <?php if ( ! empty($alt_text) ) { ?> alt="<?php echo $alt_text;?>" <?php } ;?> class="img-responsive"><?php echo do_shortcode('[image-attribution]'); ?></div>
          <div class="margin-bottom-60">
            <?php echo rwmb_meta( 'socrata_events_wysiwyg' );?>
          </div>
          <div class="background-light-grey-4 padding-30 margin-bottom-30">
            <h4 class="margin-bottom-15"><?php echo $customtitle;?></h4>
            <p><?php echo $customcopy;?></p>    
            <p class="margin-bottom-0"><a href="<?php echo $customurl;?>" target="_blank" class="btn btn-primary btn-lg"><?php echo $customcta;?></a></p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php 
  } 
;?>