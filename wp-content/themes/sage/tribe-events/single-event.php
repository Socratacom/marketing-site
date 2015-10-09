<?php
/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$events_label_singular = tribe_get_event_label_singular();
$events_label_plural = tribe_get_event_label_plural();
$event_id = get_the_ID();

?>

<div class="feature-image hidden-xs" style="background-image: url(<?php echo Roots\Sage\Extras\custom_feature_image('full', 1600, 400); ?>);">
  <div class="pattern-overlay"></div>
  <?php echo do_shortcode('[image-attribution]'); ?>
</div>
<div class="container">
	<div class="row">
		<div class="col-sm-8 col-md-7 col-md-offset-1 article-content">
			<div class="wrapper">
				<?php while (have_posts()) : the_post(); ?>
				<article <?php post_class(); ?>>
					<?php tribe_events_the_notices() ?>
					<?php
					echo tribe_get_event_categories(
					get_the_id(), array(
					'before'       => '',
					'sep'          => ' | ',
					'after'        => '',
					'label'        => '', // An appropriate plural/singular label will be provided
					'label_before' => '<span style="display:none;">',
					'label_after'  => '</span>',
					'wrap_before'  => '<div>',
					'wrap_after'   => '</div>',
					)
					);
					?>
					<h1 class="entry-title"><?php the_title(); ?></h1>
					<?php echo tribe_events_event_schedule_details( $event_id, '<h3>', '</h3>' ); ?>
					<div class="entry-content">
		              <?php the_content(); ?>
		            </div>

					<!-- Event meta -->
					<?php do_action( 'tribe_events_single_event_before_the_meta' ) ?>
					<?php tribe_get_template_part( 'modules/meta' ); ?>
					<?php do_action( 'tribe_events_single_event_after_the_meta' ) ?>

		            <hr/>
		            <div>
		              <?php if( get_posts() ) {
		              previous_post_link('<p><strong><small>NEXT EVENT:</small><br>%link</strong></p>');
		              next_post_link('<p><strong><small>PREVIOUS EVENT:</small><br>%link</strong></p>');
		              }?>
		            </div>
				</article>
				
				<?php endwhile; ?>

				<div class="marketo-share">
					<?php echo do_shortcode( '[marketo-share]' ); ?>
				</div>
			</div>
		</div>
		<div class="col-sm-4 col-md-3 sidebar hidden-xs">
			<?php echo do_shortcode('[newsletter-sidebar]'); ?>
		</div>
	</div>
</div>



