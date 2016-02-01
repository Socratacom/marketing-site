<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); $url = $thumb['0']; ?>
<section id="top" class="events-hero section-padding background-wet-asphalt">
  <div class="text">
    <div class="container">
      <div class="row">
        <div class="col-sm-6 col-md-8 details">
          <h1 class="text-reverse margin-bottom-15"><?php the_title(); ?></h1>
          <?php
            $displaydate = rwmb_meta( 'socrata_events_displaydate' );
            $city = rwmb_meta( 'socrata_events_city' );
            $state = rwmb_meta( 'socrata_events_state' );
            $directions = rwmb_meta( 'socrata_events_directions' );
            if ($directions) { ?>
            <ul>
              <li class="text-reverse lead"><?php echo $displaydate;?></li>
              <li class="text-reverse lead"><a href="<?php echo $directions;?>" target="_blank"><?php echo $city;?>, <?php echo $state;?></a></li>
            </ul>
            <?php
            }
            else { ?>
              <p class="text-reverse"></p>
            <?php
            } 
          ?>
          <?php
            $excerpt = rwmb_meta( 'socrata_events_excerpt' );
            if ($excerpt) { ?>
            <div class="excerpt">
              <?php echo $excerpt;?>
            </div>
            <?php
            }
          ?>
        </div>
        <div class="col-sm-6 col-md-4">
          <div class="marketo-form box-black padding-15">
            <?php
            $today = strtotime('today UTC');
            $date = rwmb_meta( 'socrata_events_endtime' );
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
  </div>
  <div class="image overlay-black img-background hidden-xs" style="background-image: url(<?=$url?>);"></div>
</section>
<?php echo rwmb_meta( 'socrata_events_wysiwyg' );?>