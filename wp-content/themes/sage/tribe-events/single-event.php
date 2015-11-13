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
					<small class="category-name"><?php events_the_categories(); ?></small>
					<h1 class="entry-title"><?php the_title(); ?></h1>
					<?php echo tribe_events_event_schedule_details( $event_id, '<h4 class="meta">', '</h4>' ); ?>
					<hr/>
					<div class="entry-content">
		              <?php the_content(); ?>
		            </div>

					<!-- Event meta -->
					<?php do_action( 'tribe_events_single_event_before_the_meta' ) ?>
					<?php tribe_get_template_part( 'modules/meta' ); ?>
					<?php do_action( 'tribe_events_single_event_after_the_meta' ) ?>

		            
				</article>
				
				<?php endwhile; ?>

				<div class="marketo-share">
					<?php echo do_shortcode( '[marketo-share]' ); ?>
				</div>
			</div>
		</div>
		<div class="col-sm-4 col-md-3 sidebar hidden-xs">
	      <?php
	        //list terms in a given taxonomy using wp_list_categories  (also useful as a widget)
	        $orderby = 'name';
	        $show_count = 0; // 1 for yes, 0 for no
	        $pad_counts = 0; // 1 for yes, 0 for no
	        $hide_empty = 1;
	        $hierarchical = 1; // 1 for yes, 0 for no
	        $taxonomy = 'tribe_events_cat';
          	$title = 'Event Categories';

	        $args = array(
	          'orderby' => $orderby,
	          'show_count' => $show_count,
	          'pad_counts' => $pad_counts,
	          'hide_empty' => $hide_empty,
	          'hierarchical' => $hierarchical,
	          'taxonomy' => $taxonomy,
	          'title_li' => '<h5 class="background-wisteria">'. $title .'</h5>'
	        );
	      ?>
	      <ul class="category-nav">
	        <?php wp_list_categories($args); ?>
	      </ul>
	      <?php echo do_shortcode('[newsletter-sidebar]'); ?>
		</div>
	</div>
</div>



