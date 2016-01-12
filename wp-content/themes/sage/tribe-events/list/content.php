<?php
/**
 * List View Content Template
 * The content template for the list view. This template is also used for
 * the response that is returned on list view ajax requests.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/list/content.php
 *
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
} ?>

<section class="breadcrumbs">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
          <a href="/events">Events</a> » <?php events_the_categories(); ?>
      </div>
    </div>
  </div>
</section>

<div class="container page-padding">
	<div class="row">
		<div class="col-sm-8">
        <div class="col-sm-12">
          <h3 class="archive-title">Events: <?php events_the_categories(); ?></h3>
          <hr/>
        </div>
			<div class="row">
				<?php tribe_events_the_notices() ?>

				<?php if ( have_posts() ) : ?>
					<?php tribe_get_template_part( 'list/loop' ) ?>
				<?php endif; ?>




			</div>
		</div>



    <div class="col-sm-4 hidden-xs events-sidebar">
      <div class="next-event">
        <h5>Next Webinar</h5>
        <div class="padding-30">          
          <?php
            $args = array(
            'post_type' => 'tribe_events',
            'tribe_events_cat' => 'webinar',
            'posts_per_page' => 1
            );
            $query = new WP_Query( $args );

            // The Loop
            while ( $query->have_posts() ) {
            $query->the_post(); ?>
              <p><strong><?php the_title();?></strong><br><?php echo tribe_events_event_schedule_details( $event_id ); ?></p>

              <?php $meta = get_marketo_meta(); if ($meta[0]) { ?>
                <p><a href="<?php echo $meta[0];?>" class="btn btn-primary" target="_blank">Register Now</a></p>
                <?php
              } ?>
            <?php
            }
            wp_reset_postdata();
          ?>
        </div>
      </div>
      <h4>Additional Resources</h4>
      <?php wp_nav_menu( array( 'theme_location' => 'site_nav_resources' ) ); ?>
    </div>
	</div>
</div>
