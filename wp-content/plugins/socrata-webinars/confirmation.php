<?php 
$displaydate = rwmb_meta( 'webinars_displaydate' );
$today = strtotime('today UTC');
$date = strtotime(rwmb_meta( 'webinars_starttime' ));
$asset_link = rwmb_meta( 'webinars_asset_link' );
$asset_title = rwmb_meta( 'webinars_asset_title' );
$asset_description = rwmb_meta( 'webinars_asset_description' );
$asset_image = rwmb_meta( 'webinars_asset_image', 'size=medium' );
?>

<?php 
	if($date <= $today) { ?>
		<section class="section-padding">
			<div class="container">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="alert alert-info"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <strong>Registration for this webinar has expired</strong>. Watch the <a href="<?php the_permalink() ?>"><?php the_title(); ?></a> webinar or <a href="/webinars">view all webinars</a>.</div>
					</div>
				</div>
			</div>
		</section>
	<?php } 
;?>

<?php 
	if($date > $today) { ?>
		<section class="section-padding">
			<div class="container">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<p class="text-center"><i class="icon-thumb-up color-success icon-100"></i></p>
						<h2 class="text-center margin-bottom-15">Thank you for registering!</h2>
						<h1 class="text-center"><?php the_title(); ?></h1>
						<h3 class="text-center"><?php echo $displaydate; ?></h3>
					</div>
				</div>
			</div>
		</section>
		<?php if ( ! empty( $asset_link ) ) { ?>
			<section class="section-padding background-primary-light">
				<div class="container">
					<div class="row">
						<div class="col-sm-12">							
							<h2 class="text-center margin-bottom-60">You may also like this additional download</h2>
						</div>
						<?php if ( !empty( $asset_image ) ) { ?>
							<div class="col-sm-5 col-md-4 col-sm-offset-2 col-md-offset-3">
								<h4 class="margin-bottom-15"><?php echo $asset_title;?></h4>
								<div class="margin-bottom-30"><?php echo $asset_description;?></div>
								<p><a href="<?php echo $asset_link;?>" target="_blank" class="btn btn-primary btn-lg">Download</a></p>
							</div>
							<div class="col-sm-3 col-md-2 hidden-xs text-center">
							<?php foreach ( $asset_image as $image ) {
								echo "<img src='{$image['url']}' class='img-responsive' />"; 
							} ;?>
							</div>
							<?php }
							else { ?>
								<div class="col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
									<h4 class="margin-bottom-15"><?php echo $asset_title;?></h4>
									<div class="margin-bottom-30"><?php echo $asset_description;?></div>
									<p><a href="<?php echo $asset_link;?>" target="_blank" class="btn btn-primary btn-lg">Download</a></p>
								</div>
							<?php } 
						;?>
						
					</div>
				</div>
			</section>
			<?php } 
		;?>

		<?php 
		$custom_taxterms = wp_get_object_terms( $post->ID, 'product', array('fields' => 'ids') );
		$args = array(
		'post_type' => 'socrata_webinars',
		'post_status' => 'publish',
		'posts_per_page' => 3, // you may edit this number
		'orderby' => 'rand',
		'tax_query' => array(
		    array(
		        'taxonomy' => 'product',
		        'field' => 'id',
		        'terms' => $custom_taxterms
		    )
		),
		'post__not_in' => array ($post->ID),
		);
		$related_items = new WP_Query( $args );
		// loop over query
		if ($related_items->have_posts()) : { ?>
		<section class="section-padding background-light-grey-5">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<h2 class="text-center margin-bottom-60">Other related webinars</h2>
					</div>
				</div>
				<div class="row row-centered">
					<?php
					}
					while ( $related_items->have_posts() ) : $related_items->the_post();
					$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'post-image-small' );
					$url = $thumb['0'];
					$today = strtotime('today UTC');
					$date = strtotime(rwmb_meta( 'webinars_starttime' ));
					?>				   
					  <div class="col-md-4 col-centered">
					    <div class="thumbnail">
					      <a href="<?php the_permalink(); ?>"><img src="<?php echo $url;?>" alt="..."></a>
					      <div class="caption">
					      	<?php if($date > $today) echo "<p class='margin-bottom-0 color-secondary text-uppercase text-semi-bold'><small>Upcoming Webinar</small></p>" ;?>
					      	<?php if($date <= $today) echo "<p class='margin-bottom-0 color-secondary text-uppercase text-semi-bold'><small>On Demand Webinar</small></p>" ;?>
					        <h4 class="margin-bottom-0"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="link-black"><?php the_title(); ?></a></h4>
					      </div>
					    </div>
					  </div>
						<?php
						endwhile; { ?>			
					</div>
				</div>
			</div> 
		</section>
		<?php 
		}
		endif;
		// Reset Post Data
		wp_reset_postdata(); ?>

	<?php 
	} 
;?>











 

 
 









