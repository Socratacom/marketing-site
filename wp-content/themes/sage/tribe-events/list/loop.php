<?php
/**
 * List View Loop
 * This file sets up the structure for the list loop
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/list/loop.php
 *
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
} ?>

<?php
global $post;
global $more;
$more = false;
?>

<?php while ( have_posts() ) : the_post(); ?>
<div class="col-sm-6 col-lg-4">
<div class="card">
<div class="card-image hidden-xs">
<?php if ( has_post_thumbnail() ) { ?>
<img src="<?php echo Roots\Sage\Extras\custom_feature_image('full', 360, 180); ?>" class="img-responsive">
<?php
} else { ?>
<img src="/wp-content/uploads/no-image.png" class="img-responsive">
<?php
}
?>							
<a href="<?php the_permalink() ?>"></a>
</div>
<div class="card-text truncate">
<p class="categories"><small><?php events_the_categories(); ?><small></p>
<h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
<p class="meta"><?php echo tribe_events_event_schedule_details( $event_id, '<small style="font-weight:400;">', '</small>' ); ?></p>
<?php the_excerpt(); ?> 
</div>
</div>
</div>
<?php endwhile; ?>


