<?php

// Add the Meta Box
function add_hero_meta_box() {
    add_meta_box(
		'custom_meta_box', // $id
		'Hero Image Options', // $title
		'show_hero_meta_box', // $callback
		'hero', // $page
		'normal', // $context
		'high'); // $priority
}
add_action('add_meta_boxes', 'add_hero_meta_box');

// Field Array
$prefix = 'custom_';
$custom_hero_meta_fields = array(
	array(
		'label'=> 'Headline',
		'desc'	=> '',
		'id'	=> $prefix.'headline',
		'type'	=> 'text'
	),
	array(
		'label'=> 'Subhead',
		'desc'	=> '',
		'id'	=> $prefix.'subhead',
		'type'	=> 'text'
	),	
	array (
		'label' => 'Text Color',
		'desc'	=> '',
		'id'	=> $prefix.'textcolor',
		'type'	=> 'radio',
		'options' => array (
			'one' => array (
			'label' => 'Light',
			'value'	=> 'hero-light'
			),
			'two' => array (
			'label' => 'Dark',
			'value'	=> 'hero-dark'
			)
		)
	),
	array(
		'label'=> 'Button Text',
		'desc'	=> 'Make it short and to the point.',
		'id'	=> $prefix.'button_text',
		'type'	=> 'text'
	),
	array(
		'label'=> 'Link',
		'desc'	=> 'Include HTTP:// or HTTPS:// for external links.',
		'id'	=> $prefix.'link',
		'type'	=> 'text'
	),
	array (
		'label' => 'Open in New Window',
		'desc'	=> '',
		'id'	=> $prefix.'window',
		'type'	=> 'radio',
		'options' => array (
			'one' => array (
			'label' => 'Yes',
			'value'	=> '_blank'
			),
			'two' => array (
			'label' => 'No',
			'value'	=> '_self'
			)
		)
	),
	array (
		'label' => 'Text Alignment',
		'desc'	=> '',
		'id'	=> $prefix.'alignment',
		'type'	=> 'radio',
		'options' => array (
			'one' => array (
			'label' => 'Center',
			'value'	=> 'hero-text-center'
			),
			'two' => array (
			'label' => 'Left',
			'value'	=> 'hero-text-left'
			),
			'three' => array (
			'label' => 'Right',
			'value'	=> 'hero-text-right'
			)
		)
	),	
);

// The Callback
function show_hero_meta_box() {
global $custom_hero_meta_fields, $post;
// Use nonce for verification
echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
// Begin the field table and loop
echo '<table class="form-table">';
foreach ($custom_hero_meta_fields as $field) {
	// get value of this field if it exists for this post
	$meta = get_post_meta($post->ID, $field['id'], true);
	// begin a table row with
	echo '<tr>
			<th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
			<td>';
			switch($field['type']) {
			
			// text
			case 'text':
				echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" /><br /><span class="description">'.$field['desc'].'</span>';
			break;

			// textarea
			case 'textarea':
				echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4">'.$meta.'</textarea><br /><span class="description">'.$field['desc'].'</span>';
			break;

			// radio
			case 'radio':
				foreach ( $field['options'] as $option ) {
				echo '<input type="radio" name="'.$field['id'].'" id="'.$option['value'].'" value="'.$option['value'].'" ',$meta == $option['value'] ? ' checked="checked"' : '',' />
				<label for="'.$option['value'].'">'.$option['label'].'</label><br />';
				}
			break;

			} //end switch
	echo '</td></tr>';
} // end foreach
echo '</table>'; // end table
}

// Save the Data
function save_hero_meta($post_id) {
    global $custom_hero_meta_fields;
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
	foreach ($custom_hero_meta_fields as $field) {

		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	} // end foreach
}
add_action('save_post', 'save_hero_meta');


// Get and return the values for the URL and description
function get_hero_meta() {
  global $post;
  $custom_headline = get_post_meta($post->ID, 'custom_headline', true); 
  $custom_subhead = get_post_meta($post->ID, 'custom_subhead', true);
  $custom_textcolor = get_post_meta($post->ID, 'custom_textcolor', true); 
  $custom_button_text = get_post_meta($post->ID, 'custom_button_text', true);  
  $custom_link = get_post_meta($post->ID, 'custom_link', true);
  $custom_window = get_post_meta($post->ID, 'custom_window', true);  
  $custom_alignment = get_post_meta($post->ID, 'custom_alignment', true);

  return array(
  $custom_headline,
  $custom_subhead,
  $custom_textcolor,
  $custom_button_text,
  $custom_link,
  $custom_window,  
  $custom_alignment,
  
  );
}




