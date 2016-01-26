<?

$prefix = 'socrata_events_';

$fields = array(
	array( // jQuery UI Date input
		'label'	=> 'Date', // <label>
		'desc'	=> 'A description for the field.', // description
		'id'	=> $prefix.'date', // field id and name
		'type'	=> 'date' // type of field
	),
	array( // Text Input
		'label'	=> 'Location', // <label>
		'desc'	=> 'Example: Washington, DC', // description
		'id'	=> $prefix.'location', // field id and name
		'type'	=> 'text' // type of field
	),
	array(
	    'label' => 'Event Content',
	    'desc'  => '',
	    'id'    => 'editorField',
	    'type'  => 'editor',
	    'sanitizer' => 'wp_kses_post',
	    'settings' => array(
	        'textarea_name' => 'editorField'
	    )
	),	
);

// Get and return the values for the URL and description
function get_socrata_events_meta() {
  global $post;
  $socrata_events_date = get_post_meta($post->ID, 'socrata_events_date', true); // 0
  $socrata_events_location = get_post_meta($post->ID, 'socrata_events_location', true); // 1
  $editorField = get_post_meta($post->ID, 'editorField', true); // 2

  return array(
	$socrata_events_date,
	$socrata_events_location,
	$editorField
  );
}

/**
 * Instantiate the class with all variables to create a meta box
 * var $id string meta box id
 * var $title string title
 * var $fields array fields
 * var $page string|array post type to add meta box to
 * var $js bool including javascript or not
 */
$socrata_events_box = new socrata_events_custom_add_meta_box( 'socrata_events_box', 'Event Details', $fields, 'socrata_events', true );


