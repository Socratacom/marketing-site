<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'feature-image' ); $url = $thumb['0']; ?>
<div class="feature-image hidden-xs" style="background-image: url(<?=$url?>);">
  <?php echo do_shortcode('[image-attribution]'); ?>
</div>
<section class="section-padding background-clouds">
  <div class="container">
    <div class="row">
      <div class="col-sm-8">
        <h1><?php the_title(); ?></h1>
        <?php echo rwmb_meta( 'socrata_events_wysiwyg' );?> 
      </div>
      <div class="col-sm-4">
        <div class="padding-15 background-clouds-dark margin-bottom-30">
          <h4 class="background-orange text-reverse padding-15" style="text-transform: uppercase; font-weight: 300;">When and Where</h4>
          <div class="padding-15">
            <h5 style="margin-bottom:5px;"><?php echo rwmb_meta( 'socrata_events_location' );?></h5>
            <p style="line-height:normal;"><?php echo rwmb_meta( 'socrata_events_address' );?><br><?php echo rwmb_meta( 'socrata_events_city' );?>, <?php echo rwmb_meta( 'socrata_events_state' );?> <?php echo rwmb_meta( 'socrata_events_zip' );?></p>
            <p><?php echo rwmb_meta( 'socrata_events_displaydate' );?></p>
            <p><a href="<?php echo rwmb_meta( 'socrata_events_directions' );?>" target="_blank">Get Directions</a></p>
          </div>
        </div>
        <div class="padding-15 background-clouds-dark margin-bottom-30">
          <h4 class="background-wet-asphalt text-reverse padding-15" style="text-transform: uppercase; font-weight: 300;">Register</h4>
          <div class="padding-15 marketo-form">
            <script src="//app-abk.marketo.com/js/forms2/js/forms2.min.js"></script>
            <form id="mktoForm_<?php echo rwmb_meta( 'socrata_events_marketo' );?>"></form>
            <script>MktoForms2.loadForm("//app-abk.marketo.com", "851-SII-641", <?php echo rwmb_meta( 'socrata_events_marketo' );?> );</script>
          </div>
        </div>
      </div>
    </div>    
  </div>
</section>