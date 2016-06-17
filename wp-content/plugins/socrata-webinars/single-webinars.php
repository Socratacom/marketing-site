<?php 
$displaydate = rwmb_meta( 'webinars_displaydate' );
$today = strtotime('today UTC');
$date = strtotime(rwmb_meta( 'webinars_starttime' ));
$speakers = rwmb_meta( 'webinars_speakers' );
$section_title = rwmb_meta( 'webinars_section_title' );
$marketo_registration = rwmb_meta( 'webinars_marketo_registration' );
$marketo_on_demand = rwmb_meta( 'webinars_marketo_on_demand' );
$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'feature-image' );
$url = $thumb['0'];
$video = rwmb_meta( 'webinars_video' );
?>
<section class="hero-animated background-primary-alt-2-light overlay overlay-primary-alt-2">
	<div class="outer">
		<div class="inner">
			<div class="container">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<h1 class="text-center text-reverse margin-bottom-15"><?php the_title(); ?></h1>
						<?php if($date >= $today) { ?>
						<h3 class="text-center text-reverse"><?php echo $displaydate;?></h3>
						<ul class="cta-list">
						<?php if ( ! empty( $video ) ) { ?>	
								<li><a href="#on-demand-form" class='btn btn-warning btn-lg'>Watch Webinar</a></li>			
							<?php 
							}
							else { ?> 
								 <li><a href="#registration-form" class='btn btn-warning btn-lg'>Register for Webinar</a></li>
							<?php
							}
						?>						
						<?php if ( ! empty( $speakers ) ) echo "<li><a href='#speakers' class='btn btn-warning btn-lg'>Speakers</a></li>";?>
						</ul>
						<?php
						}
						else { ?>
						<ul class="cta-list">
						<?php if ( ! empty( $video ) ) { ?>
							<?php if ( ! empty( $marketo_on_demand ) ) echo "<li><a href='#on-demand-form' class='btn btn-warning btn-lg'>Watch Webinar</a></li>";?>
							<?php 
						};?>
						<?php if ( ! empty( $speakers ) ) echo "<li><a href='#speakers' class='btn btn-warning btn-lg'>Speakers</a></li>";?>
						</ul>
						<?php
						}; ?>

					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="image animate" style="background-image:url(<?php echo $url;?>);"></div>
</section>
<section class="section-padding">
	<div class="container">
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1">
				<div class="padding-bottom-30 margin-bottom-30" style="border-bottom:#ebebeb solid 1px;">
					<div class="social-sharing-mini"><?php echo do_shortcode('[marketo-share]');?></div>
				</div>

				<?php 
					if($date == $today) { ?>
						<?php
							if ( ! empty( $video ) ) { }
							else { ?>
								<div class="alert alert-info"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <strong>This webinar is scheduled for today</strong>. If you missed the webinar, it will be available on demand soon. Please check back later.</div>
							<?php
							}
						;?>
					<?php }
				;?>
				<?php 
					if($date < $today) { ?>
						<?php
							if ( ! empty( $video ) ) { }
							else { ?>
								<div class="alert alert-info"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <strong>We are currently processing this webinar</strong>. Please check back later.</div>
							<?php
							}
						;?>
					<?php }
				;?>

				<?php echo rwmb_meta( 'webinars_wysiwyg' );?>
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
          $name = isset( $speaker_value['webinars_speaker_name'] ) ? $speaker_value['webinars_speaker_name'] : '';
          $title = isset( $speaker_value['webinars_speaker_title'] ) ? $speaker_value['webinars_speaker_title'] : '';
          $bio = isset( $speaker_value['webinars_what_the'] ) ? $speaker_value['webinars_what_the'] : '';
          $images = isset( $speaker_value['webinars_speaker_headshot'] ) ? $speaker_value['webinars_speaker_headshot'] : array();
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
	if($date < $today) { ?>
		<?php
			if ( ! empty( $video ) ) { ?>
				<section id="on-demand-form" class="section-padding background-light-grey-5" style="border-top:#ebebeb solid 1px;">
					<div class="container">
						<div class="row">
							<div class="col-sm-5 col-sm-offset-1">
								<h2 class="margin-bottom-15">Register to watch this webinar</h2>
								<p> Please fill out this form to watch the <i>"<?php the_title(); ?>"</i> webinar.</p>
							</div>
							<div class="col-sm-5">
								<?php echo do_shortcode('[marketo-form id="'.$marketo_on_demand.'"]');?>
							</div>
						</div>
					</div>
				</section>
			<?php }
			else { }
		;?>
	<?php }
;?>
<?php 
	if($date == $today) { ?>
		<?php
			if ( ! empty( $video ) ) { ?>
				<section id="on-demand-form" class="section-padding background-light-grey-5" style="border-top:#ebebeb solid 1px;">
					<div class="container">
						<div class="row">
							<div class="col-sm-5 col-sm-offset-1">
								<h2 class="margin-bottom-15">Register to watch this webinar</h2>
								<p> Please fill out this form to watch the <i>"<?php the_title(); ?>"</i> webinar.</p>
							</div>
							<div class="col-sm-5">
								<?php echo do_shortcode('[marketo-form id="'.$marketo_on_demand.'"]');?>
							</div>
						</div>
					</div>
				</section>
			<?php }
			else { ?> 
				<section id="registration-form" class="section-padding background-light-grey-5" style="border-top:#ebebeb solid 1px;">
					<div class="container">
						<div class="row">
							<div class="col-sm-5 col-sm-offset-1">
								<h2 class="margin-bottom-15">Register for this webinar</h2>
								<p> Please fill out this form to register for the <i>"<?php the_title(); ?>"</i> webinar.</p>
							</div>
							<div class="col-sm-5">
								<?php echo do_shortcode('[marketo-form id="'.$marketo_registration.'"]');?>
							</div>
						</div>
					</div>
				</section>
			<?php }
		;?>
	<?php }
;?>
<?php 
	if($date > $today) { ?>
		<section id="registration-form" class="section-padding background-light-grey-5" style="border-top:#ebebeb solid 1px;">
			<div class="container">
				<div class="row">
					<div class="col-sm-5 col-sm-offset-1">
						<h2 class="margin-bottom-15">Register for this webinar</h2>
						<p> Please fill out this form to register for the <i>"<?php the_title(); ?>"</i> webinar.</p>
					</div>
					<div class="col-sm-5">
						<?php echo do_shortcode('[marketo-form id="'.$marketo_registration.'"]');?>
					</div>
				</div>
			</div>
		</section>
	<?php }
;?>