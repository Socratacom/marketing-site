<?php 
$displaydate = rwmb_meta( 'webinars_displaydate' );
$today = strtotime('today UTC');
$date = strtotime(rwmb_meta( 'webinars_starttime' ));
$speakers = rwmb_meta( 'webinars_speakers' );
$section_title = rwmb_meta( 'webinars_section_title' );
$marketo_registration = rwmb_meta( 'webinars_marketo_registration' );
$marketo_on_demand = rwmb_meta( 'webinars_marketo_on_demand' );
$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'post-image' );
$url = $thumb['0'];
$img_id = get_post_thumbnail_id(get_the_ID());
$alt_text = get_post_meta($img_id , '_wp_attachment_image_alt', true);
$video = rwmb_meta( 'webinars_video' );
$content = rwmb_meta( 'webinars_wysiwyg' );
?>


<section class="section-padding">
	<div class="container">
		<div class="row">
			<div class="col-sm-8">
				<h1 class="margin-bottom-15"><?php the_title(); ?></h1>

				<?php if($date >= $today) { ?><h3><?php echo $displaydate;?></h3> <?php } ?>





				<div class="margin-bottom-30"><?php echo do_shortcode('[addthis]');?></div>
				<div class="margin-bottom-30"><img src="<?php echo $url;?>" <?php if ( ! empty($alt_text) ) { ?> alt="<?php echo $alt_text;?>" <?php } ;?> class="img-responsive"><?php echo do_shortcode('[image-attribution]'); ?></div>
				<?php echo $content;?>



												<?php if ( ! empty( $speakers ) ) { ?>
									<hr>
									<?php foreach ( $speakers as $speaker_value ) {
										$id = uniqid();
										$name = isset( $speaker_value['webinars_speaker_name'] ) ? $speaker_value['webinars_speaker_name'] : '';
										$title = isset( $speaker_value['webinars_speaker_title'] ) ? $speaker_value['webinars_speaker_title'] : '';
										$bio = isset( $speaker_value['webinars_what_the'] ) ? $speaker_value['webinars_what_the'] : '';
										$images = isset( $speaker_value['webinars_speaker_headshot'] ) ? $speaker_value['webinars_speaker_headshot'] : array();
										foreach ( $images as $image ) {
											$image = RWMB_Image_Field::file_info( $image, array( 'size' => 'thumbnail' ) );
										} 
										?>

										<div class="media">
											<div class="media-left">
												<img class="media-object img-circle" src="<?php echo $image['url'];?>">
											</div>
											<div class="media-body speakers-list padding-15">
												<h5 class="media-heading margin-bottom-0"><?php echo $name;?></h5>
												<p class="margin-bottom-0"><small><i><?php echo $title;?></i></small></p>
												<?php if ( ! empty( $bio ) ) { ?> 
													<div class="truncate" style="height:24px;"><?php echo $bio; ?></div>
													<p class="margin-bottom-0"><a data-toggle="modal" data-target="#<?php echo 'speaker_'.$id;?>">Full Bio</a></p>

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

												<?php } ;?>
											</div>
										</div>

										<?php 
									} ;?>





									<?php }
								;?>






			</div>
			<div class="col-sm-4">
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


				<?php 
				if($date < $today) { ?>
				<?php
				if ( ! empty( $video ) ) { ?>
				<div class="background-light-grey-4 padding-30">
				<h4 class="margin-bottom-15">Watch this webinar</h4>
				<p> Please fill out this form to watch the <i>"<?php the_title(); ?>"</i> webinar.</p>
				<?php echo do_shortcode('[marketo-form-labels id="'.$marketo_on_demand.'"]');?>
				</div>
				<?php }
				else { }
				;?>
				<?php }
				;?>
				<?php 
				if($date == $today) { ?>
				<?php
				if ( ! empty( $video ) ) { ?>
				<div class="background-light-grey-4 padding-30">
				<h4 class="margin-bottom-15">Watch this webinar</h4>
				<p> Please fill out this form to watch the <i>"<?php the_title(); ?>"</i> webinar.</p>
				<?php echo do_shortcode('[marketo-form-labels id="'.$marketo_on_demand.'"]');?>
				</div>
				<?php }
				else { ?> 
				<div class="background-light-grey-4 padding-30">
				<h4 class="margin-bottom-15">Register for this webinar</h4>
				<p> Please fill out this form to register for the <i>"<?php the_title(); ?>"</i> webinar.</p>
				<?php echo do_shortcode('[marketo-form-labels id="'.$marketo_registration.'"]');?>
				</div>
				<?php }
				;?>
				<?php }
				;?>
				<?php 
				if($date > $today) { ?>
				<div class="background-light-grey-4 padding-30">
				<h4 class="margin-bottom-15">Register for this webinar</h4>
				<p> Please fill out this form to register for the <i>"<?php the_title(); ?>"</i> webinar.</p>
				<?php echo do_shortcode('[marketo-form-labels id="'.$marketo_registration.'"]');?>
				</div>
				<?php }
				;?>
				
			</div>
		</div>
	</div>
</section>


