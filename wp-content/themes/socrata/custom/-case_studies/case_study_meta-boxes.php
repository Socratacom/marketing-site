<?php

// Add the Meta Box
function add_case_study_meta_box() {
    add_meta_box(
		'custom_meta_box', // $id
		'Custom Meta Box', // $title
		'show_case_study_meta_box', // $callback
		'case_study', // $page
		'normal', // $context
		'high'); // $priority
}
add_action('add_meta_boxes', 'add_case_study_meta_box');

// Field Array
$prefix = 'custom_';
$custom_case_study_meta_fields = array(
	array(
		'label'=> 'Banner Title',
		'desc'	=> 'Ex. City of Seattle',
		'id'	=> $prefix.'banner_title',
		'type'	=> 'text'
	),
	array(
		'label'=> 'Site Name',
		'desc'	=> 'Ex. Socrata.com',
		'id'	=> $prefix.'site_name',
		'type'	=> 'text'
	),
	array(
		'label'=> 'URL',
		'desc'	=> 'Ex. http://www.socrata.com',
		'id'	=> $prefix.'url',
		'type'	=> 'text'
	),
	array(
		'label'=> 'Pull Quote',
		'desc'	=> 'DO NOT use quote marks',
		'id'	=> $prefix.'pull_quote',
		'type'	=> 'textarea'
	),
	array(
		'label'=> 'Quote Author',
		'desc'	=> 'Author of the quote.',
		'id'	=> $prefix.'author',
		'type'	=> 'text'
	),
	array(
		'label'=> 'Press',
		'desc'	=> 'Use HTML here',
		'id'	=> $prefix.'press',
		'type'	=> 'textarea'
	),
	array(
		'label'=> 'Additional Code',
		'desc'	=> 'Additonal HTML Code',
		'id'	=> $prefix.'additional_code',
		'type'	=> 'textarea'
	),	
	array(
		'label'=> 'Lead Gen Form',
		'desc'	=> 'Code from Marketo',
		'id'	=> $prefix.'marketo',
		'type'	=> 'textarea'
	),
	
);

// The Callback
function show_case_study_meta_box() {
global $custom_case_study_meta_fields, $post;
// Use nonce for verification
echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
// Begin the field table and loop
echo '<table class="form-table">';
foreach ($custom_case_study_meta_fields as $field) {
	// get value of this field if it exists for this post
	$meta = get_post_meta($post->ID, $field['id'], true);
	// begin a table row with
	echo '<tr>
			<th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
			<td>';
			switch($field['type']) {
			
			// Text
			case 'text':
				echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" /><br /><span class="description">'.$field['desc'].'</span>';
			break;

			// Text Area
			case 'textarea':
				echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="6">'.$meta.'</textarea><br /><span class="description">'.$field['desc'].'</span>';				
			break;
				
			} //end switch
	echo '</td></tr>';
} // end foreach
echo '</table>'; // end table
}

// Save the Data
function save_case_study_meta($post_id) {
    global $custom_case_study_meta_fields;
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
	foreach ($custom_case_study_meta_fields as $field) {

		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	} // end foreach
}
add_action('save_post', 'save_case_study_meta');




// Get and return the values for the URL and description
function get_case_study_meta() {
  global $post;
  $custom_banner_title = get_post_meta($post->ID, 'custom_banner_title', true);
  $custom_site_name = get_post_meta($post->ID, 'custom_site_name', true);
  $custom_url = get_post_meta($post->ID, 'custom_url', true);
  $custom_pull_quote = get_post_meta($post->ID, 'custom_pull_quote', true);
  $custom_author = get_post_meta($post->ID, 'custom_author', true);
  $custom_press = get_post_meta($post->ID, 'custom_press', true);
  $custom_additional_code = get_post_meta($post->ID, 'custom_additional_code', true);  
  $custom_marketo = get_post_meta($post->ID, 'custom_marketo', true);  

  return array(
  	$custom_banner_title,
  	$custom_site_name,
  	$custom_url,
  	$custom_pull_quote,
  	$custom_author,
  	$custom_press,
  	$custom_additional_code,  	
  	$custom_marketo
  );
}




