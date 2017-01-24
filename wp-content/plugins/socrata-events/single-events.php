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
$customcta = rwmb_meta( 'socrata_events_custom_cta' );
$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'feature-image' );
$url = $thumb['0'];
?>

<?php 
  if($date < $today) { ?>
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

<?php 
  if($date >= $today) { ?>

<section class="background-light-grey-4 masthead">
<div class="text">
<div class="container">
<div class="row">
<div class="col-sm-10 col-sm-offset-1">
<h1 class="text-reverse margin-bottom-0 text-uppercase"><?php the_title(); ?></h1>
<h3 class="text-reverse margin-bottom-0 text-uppercase"><?php echo $displaydate;?></h3>
</div>
</div>    
</div>
</div>
<div class="img img-background" style="background-image:url(<?php echo $url;?>);"></div>
</section>

<section class="cta-bar hidden-xs">
<div class="container">
<div class="row">
<div class="col-sm-10 col-sm-offset-1">
<ul>
<li>
  <?php if ( ! empty( $speakers ) ) { ?>
    <?php if ( ! empty( $customcta ) ) { ?> <a href='#registration-form' class='btn btn-primary'><?php echo $customcta;?></a> <?php } else { ?> <a href='#registration-form' class='btn btn-primary'>Register</a> <?php } ;?> <a href='#speakers' class='btn btn-primary'>Speakers</a>    
  <?php } else { ?>
    <?php if ( ! empty( $customcta ) ) { ?> <a href='#registration-form' class='btn btn-primary'><?php echo $customcta;?></a> <?php } else { ?> <a href='#registration-form' class='btn btn-primary'>Register</a> <?php } ;?>
  <?php } ;?>
</li>
</ul>
</div>
</div>
</div>
</section>

    <section class="section-padding">
      <div class="container">
        <div class="row">
          <div class="col-sm-10 col-sm-offset-1">
            <?php echo rwmb_meta( 'socrata_events_wysiwyg' );?>
          </div>
        </div>
      </div>
    </section>
    <?php
      if ( ! empty( $speakers ) ) { ?>
      <section id="speakers" class="section-padding background-primary-alt-2-light speakers">
        <div class="container">
          <div class="row no-gutters text-center">
            <?php if ( ! empty( $section_title ) ) { ?>
              <h2 class="margin-bottom-60"><?php echo $section_title;?></h2>
              <?php
              }
              else {?>
              <h2 class="margin-bottom-60">Speakers</h2>
              <?php
              }
            ?>
            <?php   
             
            foreach ( $speakers as $speaker_value ) {
              $id = uniqid();
              $name = isset( $speaker_value['socrata_events_speaker_name'] ) ? $speaker_value['socrata_events_speaker_name'] : '';
              $title = isset( $speaker_value['socrata_events_speaker_title'] ) ? $speaker_value['socrata_events_speaker_title'] : '';
              $bio = isset( $speaker_value['socrata_events_what_the'] ) ? $speaker_value['socrata_events_what_the'] : '';
              $images = isset( $speaker_value['socrata_events_speaker_headshot'] ) ? $speaker_value['socrata_events_speaker_headshot'] : array();
              foreach ( $images as $image ) {
                    $image = RWMB_Image_Field::file_info( $image, array( 'size' => 'medium' ) );
                }
              ?>

              <div class="col-xs-12 col-sm-6 col-md-4">
                <?php if ( ! empty( $images ) ) { ?>
                  <div class="padding-15 box truncate">
                    <ul class="profile">
                      <li>
                        <?php if ( ! empty( $bio ) ) { ?>
                        <a class="headshot" style="background-image:url(<?php echo $image['url'];?>);" data-toggle="modal" data-target="#<?php echo 'speaker_'.$id;?>"></a>
                        <div class="modal fade" id="<?php echo 'speaker_'.$id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <div class="close"><button type="button" data-dismiss="modal"><i class="icon-close"></i></button></div>
                              </div>
                              <div class="modal-body">
                                <ul class="profile margin-bottom-30">
                                <li>
                                <div class="headshot" style="background-image:url(<?php echo $image['url'];?>)"></div>
                                </li>
                                <li><?php echo $name;?></li>
                                <li><?php echo $title;?></li>
                                </ul>
                                <?php echo $bio;?>
                              </div>
                            </div>
                          </div>
                        </div>
                        <?php }
                        else { ?>
                        <div class="headshot" style="background-image:url(<?php echo $image['url'];?>);"></div>
                        <?php }?>
                      </li>
                      <li><?php echo $name;?></li>
                      <li><?php echo $title;?></li>
                    </ul>
                  </div>
                <?php
                }
                else { ?>
                  <div class="padding-15 box truncate">
                    <ul class="profile">
                      <li>
                        <?php if ( ! empty( $bio ) ) { ?>
                        <a class="headshot" style="background-image:url(/wp-content/uploads/no-picture.png);" data-toggle="modal" data-target="#<?php echo 'speaker_'.$id;?>"></a>
                        <div class="modal fade" id="<?php echo 'speaker_'.$id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <div class="close"><button type="button" data-dismiss="modal"><i class="icon-close"></i></button></div>
                              </div>
                              <div class="modal-body">
                                <ul class="profile margin-bottom-30">
                                <li>
                                <div class="headshot" style="background-image:url(/wp-content/uploads/no-picture.png)"></div>
                                </li>
                                <li><?php echo $name;?></li>
                                <li><?php echo $title;?></li>
                                </ul>
                                <?php echo $bio;?>
                              </div>
                            </div>
                          </div>
                        </div>
                        <?php }
                        else { ?>
                        <div class="headshot" style="background-image:url(/wp-content/uploads/no-picture.png);"></div>
                        <?php }?>
                      </li>
                      <li><?php echo $name;?></li>
                      <li><?php echo $title;?></li>
                    </ul>
                  </div>
                <?php
                }?>          
              </div>
            <?php
            } ?>
          </div>
        </div>
      </section>
      <?php
      } 
    ?>
    <?php
    if ( ! empty( $marketo ) ) { ?>
    <section id="registration-form" class="section-padding background-light-grey-5" style="border-top:#ebebeb solid 1px;">
      <div class="container">
        <div class="row">
          <div class="col-sm-5 col-sm-offset-1">
          <?php if ( ! empty( $customtitle ) ) { ?>
            <h2><?php echo $customtitle;?></h2>
          <?php } else { ?> 
            <h2 class="margin-bottom-15">Register for this event</h2>
          <?php } ;?>
          <?php if ( ! empty( $customcopy ) ) { ?>
            <p><?php echo $customcopy;?></p>
          <?php } else { ?> 
            <p>Please fill out this form to register for the <i>"<?php the_title(); ?>"</i> event happening, <i><?php echo $displaydate;?></i>.</p>
          <?php } ;?>
          </div>
          <div class="col-sm-5">
            <?php echo do_shortcode('[marketo-form id="'.$marketo.'"]');?>
            <div id="confirmform" class="alert alert-success" style="visibility:hidden;">
              <strong>Success!</strong> You are registered.
            </div>
          </div>
        </div>
      </div>
    </section>
    <script>MktoForms2.whenReady(function(e){e.onSuccess(function(i,n){return e.getFormElem().hide(),document.getElementById("confirmform").style.visibility="visible",!1})});</script>
    <?php
    }
  ?>

  <?php 
  } 
;?>