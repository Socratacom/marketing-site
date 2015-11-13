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

<div class="container page-padding">
	<div class="row">
		<div class="col-sm-9">
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
		<div class="col-sm-3">
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
