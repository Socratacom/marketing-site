<?php $post_counter = 0; // start a counter before the loop ?>
<?php if ( have_posts() ) : ?>
<?php while ( have_posts() ) : the_post(); ?>
<?php $post_counter++; // increment the counter for each post ?>
<?php if ( $post_counter <= 1 ) : ?>
	<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'feature-image' ); $url = $thumb['0']; ?>
	<section class="feature-image blog-feature-image overlay-black" style="background-image: url(<?=$url?>);">
		<div class="container">
			<div class="row">
				<div class="col-sm-6">
					<div class="text truncate">
						<div class="categories text-reverse"><?php single_cat_title(); ?></div>
						<h2><a href="<?php the_permalink() ?>" class="text-reverse"><?php the_title(); ?></a></h2>
					</div>							
	            	<ul class="meta">
						<li><?php  global $post; $author_id=$post->post_author; foreach( get_coauthors() as $coauthor ): ?>
		                <?php echo get_avatar( $coauthor->user_email, '50' ); ?>
		                <?php endforeach; ?></li>
		                <li>By <span><?php if(function_exists('coauthors')) coauthors();?></span> / <?php the_time('F j, Y') ?></li>
					</ul>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>
<?php endwhile; ?>
<?php endif; ?>
<?php wp_reset_postdata();?>

<section class="section-padding">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h1 class="margin-bottom-60 text-center">Digital Government Transformation</h1>
			</div>
			<div class="col-sm-8">

				<?php 
				$cat = get_category( get_query_var( 'cat' ) );
				$category = $cat->slug;
				echo do_shortcode('[ajax_load_more category="'.$category.'" posts_per_page="6" offset="1"]');
				?>

			</div>
			<div class="col-sm-4 hidden-xs">
				<?php echo do_shortcode('[newsletter-sidebar]'); ?> 
				<?php
				$args = array(
				'post_type'         => 'post',
				'order'             => 'desc',
				'posts_per_page'    => 3,
				'post_status'       => 'publish',
				);

				// The Query
				$the_query = new WP_Query( $args );

				// The Loop
				if ( $the_query->have_posts() ) {
				echo '<ul class="no-bullets sidebar-list">';
				echo '<li><h5>Recent Articles</h5></li>';
				while ( $the_query->have_posts() ) {
				$the_query->the_post(); { ?> 
				<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail' ); $url = $thumb['0'];?>
				<li>
				  <div class="article-img-container">
				    <img src="<?=$url?>" class="img-responsive">
				  </div>
				  <div class="article-title-container">
				    <a href="<?php the_permalink() ?>"><?php the_title(); ?></a><br><small><?php the_time('F j, Y') ?></small>
				  </div>
				</li>
				<?php }
				}
				echo '<li><a href="/digital-government-transformation">View All Articles <i class="fa fa-arrow-circle-o-right"></i></a></li>';
				echo '</ul>';
				} else {
				// no posts found
				}
				/* Restore original Post Data */
				wp_reset_postdata(); ?>

				<?php
				$args = array(
				'post_type'         => 'socrata_videos',
				'order'             => 'desc',
				'posts_per_page'    => 3,
				'post_status'       => 'publish',
				);

				// The Query
				$the_query = new WP_Query( $args );

				// The Loop
				if ( $the_query->have_posts() ) {
				echo '<ul class="no-bullets sidebar-list">';
				echo '<li><h5>Recent Videos</h5></li>';
				while ( $the_query->have_posts() ) {
				$the_query->the_post(); { ?> 

				<li>
				  <div class="article-img-container">
				    <img src="https://img.youtube.com/vi/<?php $meta = get_socrata_videos_meta(); echo $meta[1]; ?>/default.jpg" class="img-responsive">
				  </div>
				  <div class="article-title-container">
				    <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
				  </div>
				</li>

				<?php }
				}
				echo '<li><a href="/videos">View All Videos <i class="fa fa-arrow-circle-o-right"></i></a></li>';
				echo '</ul>';
				} else {
				// no posts found
				}
				/* Restore original Post Data */
				wp_reset_postdata(); ?>

				<?php
				$args = array(
				'post_type'         => 'case_study',
				'order'             => 'desc',
				'posts_per_page'    => 3,
				'post_status'       => 'publish',
				);

				// The Query
				$the_query = new WP_Query( $args );

				// The Loop
				if ( $the_query->have_posts() ) {
				echo '<ul class="no-bullets sidebar-list">';
				echo '<li><h5>Recent Case Studies</h5></li>';
				while ( $the_query->have_posts() ) {
				$the_query->the_post(); { ?> 

				<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail' ); $url = $thumb['0'];?>
				<li>
				  <div class="article-img-container">
				    <img src="<?=$url?>" class="img-responsive">
				  </div>
				  <div class="article-title-container">
				    <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
				  </div>
				</li>

				<?php }
				}
				echo '<li><a href="/case-studies">View All Case Studies <i class="fa fa-arrow-circle-o-right"></i></a></li>';
				echo '</ul>';
				} else {
				// no posts found
				}
				/* Restore original Post Data */
				wp_reset_postdata(); ?>

				<?php

				$today = strtotime('today UTC');        

				$event_meta_query = array( 
				  'relation' => 'AND',
				  array( 
				    'key' => 'socrata_events_endtime', 
				    'value' => $today, 
				    'compare' => '>=', 
				  ) 
				); 

				$args = array(
				'post_type'           => 'socrata_events',
				'posts_per_page'      => 3,
				'post_status'         => 'publish',
				'ignore_sticky_posts' => true,  
				'meta_key'            => 'socrata_events_endtime',
				'orderby'             => 'meta_value_num',
				'order'               => 'asc',
				'meta_query'          => $event_meta_query
				);

				// The Query
				$the_query = new WP_Query( $args );

				// The Loop
				if ( $the_query->have_posts() ) {
				echo '<ul class="no-bullets sidebar-list">';
				echo '<li><h5>Upcoming Events</h5></li>';
				while ( $the_query->have_posts() ) {
				$the_query->the_post(); { ?> 

				  <?php if ( has_term( 'socrata-event','socrata_events_cat' ) ) { ?>
				  <li><small style="text-transform: uppercase;"><?php events_the_categories(); ?></small><br><a href="<?php the_permalink() ?>"><?php the_title(); ?></a><br><small><?php echo rwmb_meta( 'socrata_events_displaydate' );?></small></li>
				  <?php }
				  else { ?>
				  <li><small style="text-transform: uppercase;"><?php events_the_categories(); ?></small><br>

				  <?php 
				    $url = rwmb_meta( 'socrata_events_url' ); 
				    if ($url) { ?>
				      <a href="<?php echo $url;?>" target="_blank"><?php the_title(); ?></a>
				      <?php 
				    }
				    else { ?>
				      <?php the_title(); ?>
				      <?php
				    }
				  ?>
				  <br><small><?php echo rwmb_meta( 'socrata_events_displaydate' );?></small>

				  </li>
				  <?php
				  } ?>

				<?php }
				}
				echo '<li><a href="/events">View All Events <i class="fa fa-arrow-circle-o-right"></i></a></li>';
				echo '</ul>';
				} else { ?>
				<ul class="no-bullets sidebar-list">
				<li><h5>Upcoming Events</h5></li>
				<li>No events at this time.</li>
				</ul>
				<?php
				}
				/* Restore original Post Data */
				wp_reset_postdata(); ?> 
			</div>
		</div>
	</div>
</section>