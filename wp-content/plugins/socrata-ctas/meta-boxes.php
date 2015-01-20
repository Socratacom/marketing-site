<?php

// Add the Meta Box
function add_cta_meta_box() {
    add_meta_box(
		'custom_meta_box', // $id
		'Call To Action Options', // $title
		'show_cta_meta_box', // $callback
		'ctas', // $page
		'normal', // $context
		'high'); // $priority
}
add_action('add_meta_boxes', 'add_cta_meta_box');

// Field Array
$prefix = 'custom_';
$custom_cta_meta_fields = array(
	array(
		'label'=> 'Icon',
		'desc'	=> 'Enter keyword. Example: "book"',
		'id'	=> $prefix.'icon',
		'type'	=> 'text'
	),
		array(
		'label'=> 'Social Icon',
		'desc'	=> 'Enter keyword. Example: "twitter"',
		'id'	=> $prefix.'socialicon',
		'type'	=> 'text'
	),
	array(
		'label'=> 'Icon Color',
		'desc'	=> 'Hex value. Example: "#3366cc"',
		'id'	=> $prefix.'icon_color',
		'type'	=> 'text'
	),
	array(
		'label'=> 'Button Text',
		'desc'	=> 'Make it short and to the point.',
		'id'	=> $prefix.'button_text',
		'type'	=> 'text'
	),
	array(
		'label'=> 'CTA URL',
		'desc'	=> 'Include HTTP:// or HTTPS://',
		'id'	=> $prefix.'url',
		'type'	=> 'text'
	),	
	array (
		'label' => 'Open in New Window',
		'desc'	=> '',
		'id'	=> $prefix.'radio',
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
	array(
		'label'=> 'CTA Text',
		'desc'	=> '',
		'id'	=> $prefix.'description',
		'type'	=> 'textarea'
	),
	
);

// The Callback
function show_cta_meta_box() {
global $custom_cta_meta_fields, $post;
// Use nonce for verification
echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
// Begin the field table and loop
echo '<table class="form-table">';
foreach ($custom_cta_meta_fields as $field) {
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
function save_cta_meta($post_id) {
    global $custom_cta_meta_fields;
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
	foreach ($custom_cta_meta_fields as $field) {

		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	} // end foreach
}
add_action('save_post', 'save_cta_meta');


// Get and return the values for the URL and description
function get_cta_meta() {
  global $post;
  $custom_icon = get_post_meta($post->ID, 'custom_icon', true); 
  $custom_icon_color = get_post_meta($post->ID, 'custom_icon_color', true);
  $custom_button_text = get_post_meta($post->ID, 'custom_button_text', true); 
  $custom_url = get_post_meta($post->ID, 'custom_url', true);  
  $custom_radio = get_post_meta($post->ID, 'custom_radio', true);
  $custom_description = get_post_meta($post->ID, 'custom_description', true);
  $custom_socialicon = get_post_meta($post->ID, 'custom_socialicon', true); 

  return array(
  $custom_icon,
  $custom_icon_color,
  $custom_button_text,
  $custom_url,
  $custom_radio,
  $custom_description,
  $custom_socialicon,
  
  );
}




