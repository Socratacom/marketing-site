<?php

// Add the Meta Box
function add_career_meta_box() {
    add_meta_box(
		'custom_meta_box', // $id
		'Job Details', // $title
		'show_career_meta_box', // $callback
		'career', // $page
		'normal', // $context
		'high'); // $priority
}
add_action('add_meta_boxes', 'add_career_meta_box');

// Field Array
$prefix = 'custom_';
$custom_career_meta_fields = array(	
	array(
		'label'=> 'Employment Type',
		'desc'	=> 'Select a Employment Type',
		'id'	=> $prefix.'employment',
		'type'	=> 'select',
		'options' => array (
			'one' => array (
				'label' => 'Select a Type',
				'value'	=> ''
			),
			'two' => array (
				'label' => 'Full Time',
				'value'	=> 'Full Time'
			),
			'three' => array (
				'label' => 'Part Time',
				'value'	=> 'Part Time'
			),
			'four' => array (
				'label' => 'Part Time to Full Time',
				'value'	=> 'Part Time to Full Time'
			),
			'five' => array (
				'label' => 'Temporary',
				'value'	=> 'Temporary'
			),
			'six' => array (
				'label' => 'Temporary to Full Time',
				'value'	=> 'Temporary to Full Time'
			),
			'seven' => array (
				'label' => 'Contracted',
				'value'	=> 'Contracted'
			),
			'eight' => array (
				'label' => 'Contracted to Full Time',
				'value'	=> 'Contracted to Full Time'
			),
			'nine' => array (
				'label' => 'Internship',
				'value'	=> 'Internship'
			),
			'ten' => array (
				'label' => 'Internship to Full Time',
				'value'	=> 'Internship to Full Time'
			),
			'eleven' => array (
				'label' => 'Seasonal',
				'value'	=> 'Seasonal'
			),
			'twelve' => array (
				'label' => 'Volunteer',
				'value'	=> 'Volunteer'
			)
		)
	),	
	array(
		'label'=> 'Department',
		'desc'	=> 'Select a Department',
		'id'	=> $prefix.'department',
		'type'	=> 'select',
		'options' => array (
			'one' => array (
				'label' => 'Select a Department',
				'value'	=> ''
			),
			'two' => array (
				'label' => 'Client Services',
				'value'	=> 'Client Services'
			),			
			'three' => array (
				'label' => 'Emerging Markets',
				'value'	=> 'Emerging Markets'
			),
			'four' => array (
				'label' => 'Engineering',
				'value'	=> 'Engineering'
			),
			'five' => array (
				'label' => 'Executive',
				'value'	=> 'Executive'
			),
			'six' => array (
				'label' => 'Finance',
				'value'	=> 'Finance'
			),
			'seven' => array (
				'label' => 'GovStat',
				'value'	=> 'GovStat'
			),
			'eight' => array (
				'label' => 'Marketing',
				'value'	=> 'Marketing'
			),
			'nine' => array (
				'label' => 'Product',
				'value'	=> 'Product'
			),
			'ten' => array (
				'label' => 'Sales',
				'value'	=> 'Sales'
			)
		)
	),		
	array(
		'label'=> 'Location',
		'desc'	=> 'Select a Location',
		'id'	=> $prefix.'location',
		'type'	=> 'select',
		'options' => array (
			'one' => array (
				'label' => 'Select a Location',
				'value'	=> ''
			),
			'two' => array (
				'label' => '(Multiple States)',
				'value'	=> '(Multiple States)'
			),
			'three' => array (
				'label' => 'London, U.K.',
				'value'	=> 'London'
			),
			'four' => array (
				'label' => 'Seattle, WA',
				'value'	=> 'Seattle, WA'
			),
			'five' => array (
				'label' => 'Washington, D.C.',
				'value'	=> 'Washington, D.C.'
			)
		)
	),
	array(
		'label'=> 'Resumator Apply Code',
		'desc'	=> 'Paste the Submit Button Embed code here.',
		'id'	=> $prefix.'apply',
		'type'	=> 'textarea'
	),
);

// The Callback
function show_career_meta_box() {
global $custom_career_meta_fields, $post;
// Use nonce for verification
echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
// Begin the field table and loop
echo '<table class="form-table">';
foreach ($custom_career_meta_fields as $field) {
	// get value of this field if it exists for this post
	$meta = get_post_meta($post->ID, $field['id'], true);
	// begin a table row with
	echo '<tr>
			<th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
			<td>';
			switch($field['type']) {				

			// Select
			case 'select':
				echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
				foreach ($field['options'] as $option) {
					echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
				}
				echo '</select><br /><span class="description">'.$field['desc'].'</span>';
			break;

			// textarea
			case 'textarea':
				echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4">'.$meta.'</textarea><br /><span class="description">'.$field['desc'].'</span>';
			break;
				
			} //end switch
	echo '</td></tr>';
} // end foreach
echo '</table>'; // end table
}

// Save the Data
function save_career_meta($post_id) {
    global $custom_career_meta_fields;
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
	foreach ($custom_career_meta_fields as $field) {

		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	} // end foreach
}
add_action('save_post', 'save_career_meta');


// Get and return the values for the URL and description
function get_career_meta() {
  global $post;
  $custom_employment = get_post_meta($post->ID, 'custom_employment', true);
  $custom_department = get_post_meta($post->ID, 'custom_department', true);
  $custom_location = get_post_meta($post->ID, 'custom_location', true);  
  $custom_apply = get_post_meta($post->ID, 'custom_apply', true);


  return array(
  	$custom_employment,
  	$custom_department,
  	$custom_location,
  	$custom_apply
  );
}




