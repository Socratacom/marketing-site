<?php
/**
 * Single Event Meta (Organizer) Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/modules/meta/details.php
 *
 * @package TribeEventsCalendar
 */

$organizer_ids = tribe_get_organizer_ids();
$multiple = count( $organizer_ids ) > 1;

$phone = tribe_get_organizer_phone();
$email = tribe_get_organizer_email();
$website = tribe_get_organizer_website_link();
?>

<div class="col-sm-12">
	<table class="table">
		<thead>
        	<tr>
        		<th><h4><?php echo tribe_get_organizer_label( ! $multiple ); ?></h4></th>
        		<th></th>
        	</tr>
        </thead>
        <tbody>

		<?php
		do_action( 'tribe_events_single_meta_organizer_section_start' );

		foreach ( $organizer_ids as $organizer ) {
			if ( ! $organizer ) {
				continue;
			}

			?>
			<tr>
			<td>Organizer:</td>
			<td class="text-right">
				<?php echo tribe_get_organizer( $organizer ) ?>
			</td>
			</tr>
			<?php
		}

		if ( ! $multiple ) { // only show organizer details if there is one
			if ( ! empty( $phone ) ) {
				?>
				<tr>
				<td>
					<?php esc_html_e( 'Phone:', 'the-events-calendar' ) ?>
				</td>
				<td class="text-right">
					<?php echo esc_html( $phone ); ?>
				</td>
			</tr>
				<?php
			}//end if

			if ( ! empty( $email ) ) {
				?>
				<tr>
				<td>
					<?php esc_html_e( 'Email:', 'the-events-calendar' ) ?>
				</td>
				<td class="text-right">
					<?php echo esc_html( $email ); ?>
				</td>
			</tr>
				<?php
			}//end if

			if ( ! empty( $website ) ) {
				?>
				<tr>
				<td>
					<?php esc_html_e( 'Website:', 'the-events-calendar' ) ?>
				</td>
				<td class="text-right">
					<?php echo $website; ?>
				</td>
			</tr>
				<?php
			}//end if
		}//end if

		do_action( 'tribe_events_single_meta_organizer_section_end' );
		?>
		</tbody>
	</table>
</div>
