<?php
/**
 * Single Event Meta (Venue) Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/modules/meta/venue.php
 *
 * @package TribeEventsCalendar
 */

if ( ! tribe_get_venue_id() ) {
	return;
}

$phone   = tribe_get_phone();
$website = tribe_get_venue_website_link();

?>
<div class="col-sm-12">
	<table class="table">
		<thead>
        	<tr>
        		<th><h4><?php _e( tribe_get_venue_label_singular(), 'the-events-calendar' ) ?></h4></th>
        		<th></th>
        	</tr>
        </thead>
        <tbody>

		<?php do_action( 'tribe_events_single_meta_venue_section_start' ) ?>
<tr>
		<td>Venue:</td>


		<?php if ( tribe_address_exists() ) : ?>
		
			<td class="text-right">
				<?php echo tribe_get_venue() ?>
				<address class="tribe-events-address" style="margin:0;">
					<?php echo tribe_get_full_address(); ?>
					<?php if ( tribe_show_google_map_link() ) : ?>
						<?php echo tribe_get_map_link_html(); ?>
					<?php endif; ?>
				</address>
			</td>
		</tr>
		<?php endif; ?>

		<?php if ( ! empty( $phone ) ): ?>
		<tr>
			<td><?php esc_html_e( 'Phone:', 'the-events-calendar' ) ?> </td>
			<td class="text-right"><?php echo $phone ?></td>
		</tr>
		<?php endif ?>

		<?php if ( ! empty( $website ) ): ?>
		<tr>
			<td> <?php esc_html_e( 'Website:', 'the-events-calendar' ) ?> </td>
			<td class="text-right"><?php echo $website ?> </td>
		</tr>
		<?php endif ?>

		<?php do_action( 'tribe_events_single_meta_venue_section_end' ) ?>
	</tbody>
</table>
</div>
