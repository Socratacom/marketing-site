<?php
/**
 * Single Event Meta (Details) Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/modules/meta/details.php
 *
 * @package TribeEventsCalendar
 */


$time_format = get_option( 'time_format', Tribe__Events__Date_Utils::TIMEFORMAT );
$time_range_separator = tribe_get_option( 'timeRangeSeparator', ' - ' );

$start_datetime = tribe_get_start_date();
$start_date = tribe_get_start_date( null, false );
$start_time = tribe_get_start_date( null, false, $time_format );
$start_ts = tribe_get_start_date( null, false, Tribe__Events__Date_Utils::DBDATEFORMAT );

$end_datetime = tribe_get_end_date();
$end_date = tribe_get_end_date( null, false );
$end_time = tribe_get_end_date( null, false, $time_format );
$end_ts = tribe_get_end_date( null, false, Tribe__Events__Date_Utils::DBDATEFORMAT );

$cost = tribe_get_formatted_cost();
$website = tribe_get_event_website_link();
?>

<div class="col-sm-12">
	<table class="table">
		<thead>
        	<tr>
        		<th><h4><?php esc_html_e( 'Details', 'the-events-calendar' ) ?></h4></th>
        		<th></th>
        	</tr>
        </thead>
        <tbody>

		<?php
		do_action( 'tribe_events_single_meta_details_section_start' );

		// All day (multiday) events
		if ( tribe_event_is_all_day() && tribe_event_is_multiday() ) :
			?>

<tr>
	<td><?php esc_html_e( 'Start:', 'the-events-calendar' ) ?></td>
	<td class="text-right"><?php esc_html_e( $start_date ) ?></td>
</tr>
<tr>
	<td><?php esc_html_e( 'End:', 'the-events-calendar' ) ?></td>
	<td class="text-right"><?php esc_html_e( $end_date ) ?></td>
</td>

		<?php
		// All day (single day) events
		elseif ( tribe_event_is_all_day() ):
			?>
<tr>
	<td><?php esc_html_e( 'Date:', 'the-events-calendar' ) ?></td>
	<td class="text-right"><?php esc_html_e( $start_date ) ?></td>
</tr>
		<?php
		// Multiday events
		elseif ( tribe_event_is_multiday() ) :
			?>
<tr>
	<td><?php esc_html_e( 'Start:', 'the-events-calendar' ) ?></td>
	<td class="text-right"><?php esc_html_e( $start_datetime ) ?></td>
</tr>
<tr>
	<td><?php esc_html_e( 'End:', 'the-events-calendar' ) ?></td>
	<td class="text-right"><?php esc_html_e( $end_datetime ) ?></td>
</tr>

		<?php
		// Single day events
		else :
			?>
		<tr>

			<td><?php esc_html_e( 'Date:', 'the-events-calendar' ) ?></td>
			<td class="text-right"><?php esc_html_e( $start_date ) ?></td>
		</tr>
		<tr>
			<td> <?php esc_html_e( 'Time:', 'the-events-calendar' ) ?></td>
			<td class="text-right">
					<?php if ( $start_time == $end_time ) {
						esc_html_e( $start_time );
					} else {
						esc_html_e( $start_time . $time_range_separator . $end_time );
					} ?>
				
			</td>
		</tr>

		<?php endif ?>

		<?php
		// Event Cost
		if ( ! empty( $cost ) ) : ?>
		<tr>
			<td><?php esc_html_e( 'Cost:', 'the-events-calendar' ) ?></td>
			<td class="text-right"><?php esc_html_e( $cost ); ?></td>
		</tr>
		<?php endif ?>
		<tr>
			<td>Event Category:</td>
			<td class="text-right"><?php events_the_categories(); ?></td>
		</tr>

		<?php echo tribe_meta_event_tags( sprintf( __( '%s Tags:', 'the-events-calendar' ), tribe_get_event_label_singular() ), ', ', false ) ?>

		<?php
		// Event Website
		if ( ! empty( $website ) ) : ?>
<tr>
			<td><?php esc_html_e( 'Website:', 'the-events-calendar' ) ?></td>
			<td class="text-right"><?php echo $website; ?></td>
			</li>
		</tr>
		<?php endif ?>

		<?php do_action( 'tribe_events_single_meta_details_section_end' ) ?>
		</tbody>
	</table>
</div>
