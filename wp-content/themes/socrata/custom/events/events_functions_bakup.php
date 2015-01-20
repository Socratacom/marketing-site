<?php

// ADD UPCOMING EVENTS TO THE EVENTS LANDING PAGE
add_action('thesis_hook_custom_template', 'custom_events');
function custom_events() {
  if (is_page('events')) { ?>
  <div class="format_text">
  	<h1 class="headline">Events</h1>
  	<h2 class="subhead">Socrata is attending the following events. Are you? We’d love to meet you.</h2>
  	<?php
		global $post;
		$all_events = tribe_get_events(
		array(
			'eventDisplay'=>'upcoming',
			'posts_per_page'=>1,
			'tax_query'=> array(
			array(
			'taxonomy' => 'tribe_events_cat',
			'field' => 'slug',
			'terms' => 'featured'
			))
		));

		foreach($all_events as $post) {
		setup_postdata($post);
	?>


	<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'case-study' ); $url = $thumb['0']; ?>
  	<div class="event-hero" style="background-image:url(<?=$url?>)">
  		<div class="featured-content-container">
  			<div class="featured-content">
  				<p class="featured-banner">Featured Event</p>
  				<h3><?php the_title(); ?></h3>
  				<p><span class="ss-icon">calendar</span> <?php echo tribe_get_start_date($post->ID, true, 'M j, Y'); ?></p>
  				<p><?php
                $theexcerpt = get_the_excerpt();
                $getlength = strlen($theexcerpt);
                $thelength = 140;
                echo substr($theexcerpt, 0, $thelength);
                if ($getlength > $thelength) echo "...";
               ?></p>
  				<p><a href="<?php the_permalink(); ?>" class="white-button">Read More</a></p>
  			</div>
  		</div>
  		<div class="overlay"></div>
  	</div>


		<?php } //endforeach ?>
        <?php wp_reset_query(); ?>

	<hr/>

  	<div class="two_third">
		<!--<h2>Upcoming Events</h2>-->
		<section class="upcoming-events">

		<?php
		global $post;
		$all_events = tribe_get_events(array(
		'eventDisplay'=>'upcoming',
		'posts_per_page'=>100
		));

		foreach($all_events as $post) {
		setup_postdata($post);
		?>

		<article class="clearfix">
			<div class="one_third" style="padding-top:10px;">
			<?php $smallthumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'home-portfolio-image' ); $url = $smallthumb['0']; ?>
  			<a href="<?php the_permalink(); ?>"><img src="<?=$url?>" style="width:100%;"></a>
			</div>
			<div class="two_third last">
				<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				<p><span class="ss-icon">calendar</span> <?php echo tribe_get_start_date($post->ID, true, 'M j, Y'); ?></p>
				<p><?php
                $theexcerpt = get_the_excerpt();
                $getlength = strlen($theexcerpt);
                $thelength = 140;
                echo substr($theexcerpt, 0, $thelength);
                if ($getlength > $thelength) echo "...";
               ?></p>
			</div>
			<div class="clearboth"></div>
		</article>
<?php } //endforeach ?>
<?php wp_reset_query(); ?>

</section>



	</div><!-- End Two Third -->
	<div class="one_third last event-sidebar">
	<?php echo do_shortcode('[cta icon_color="#659c3d" icon_keyword="feather" title="Invite Socrata" text="Do you have an event you would like Socrata to attend? Please let us know." button_text="Invite" link="mailto:info@socrata.com"]'); ?>
	</div><!-- End One Third -->
	<div class="clearboth"></div>
</div><!-- End Format Text -->

  <?php }
}


// Add the Meta Box
function add_event_meta_box() {
    add_meta_box(
		'custom_meta_box', // $id
		'Lead Gen Form Options', // $title
		'show_event_meta_box', // $callback
		'tribe_events', // $page
		'side', // $context
		'default'); // $priority
}
add_action('add_meta_boxes', 'add_event_meta_box');

// Field Array
$prefix = 'custom_';
$custom_event_meta_fields = array(
	array(
		'label'=> '',
		'desc'	=> 'Hide Form',
		'id'	=> $prefix.'checkbox',
		'type'	=> 'checkbox'
	),
);

// The Callback
function show_event_meta_box() {
global $custom_event_meta_fields, $post;
// Use nonce for verification
echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
// Begin the field table and loop
echo '<table class="form-table">';
foreach ($custom_event_meta_fields as $field) {
	// get value of this field if it exists for this post
	$meta = get_post_meta($post->ID, $field['id'], true);
	// begin a table row with
	echo '<tr>
			<!--<th><label for="'.$field['id'].'">'.$field['label'].'</label></th>-->
			<td>';
			switch($field['type']) {
			
			// checkbox
			case 'checkbox':
				echo '<input type="checkbox" value="hide-form" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/> <label for="'.$field['id'].'">'.$field['desc'].'</label>';
			break;
				
			} //end switch
	echo '</td></tr>';
} // end foreach
echo '</table>'; // end table
}

// Save the Data
function save_event_meta($post_id) {
    global $custom_event_meta_fields;
	// verify nonce
	if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__)))
		return $post_id;
	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return $post_id;
	// check permissions
	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id))
			return $post_id;
		} elseif (!current_user_can('edit_post', $post_id)) {
			return $post_id;
	}
	// loop through fields and save the data
	foreach ($custom_event_meta_fields as $field) {

		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	} // end foreach
}
add_action('save_post', 'save_event_meta');


// Get and return the values for the URL and description
function get_event_meta() {
  global $post;
  $custom_checkbox = get_post_meta($post->ID, 'custom_checkbox', true); 

  return array(
  	$custom_checkbox
  );
}

// Body Classes for Sidebar Styling
add_filter('thesis_body_classes', 'event_styling');
function event_styling($classes) {
  if (get_post_type() == 'tribe_events' && is_single()) { 
    $classes[] = 'single-event'; 
  }
  return $classes; 
}



