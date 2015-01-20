<?

$prefix = 'socrata_magazine_';

$fields = array(
	array( // Text Input
		'label'	=> 'Magazine URL', // <label>
		'desc'	=> 'Please include the http:// or https://', // description
		'id'	=> $prefix.'link', // field id and name
		'type'	=> 'text' // type of field
	),
		array( // Text Input
		'label'	=> 'SmartForm ID', // <label>
		'desc'	=> 'Enter the ID of the form', // description
		'id'	=> $prefix.'smartform', // field id and name
		'type'	=> 'text' // type of field
	),
	array( // Text Input
		'label'	=> 'Highlight 1', // <label>
		'desc'	=> '', // description
		'id'	=> $prefix.'one', // field id and name
		'type'	=> 'text' // type of field
	),
	array( // Text Input
		'label'	=> 'Highlight 2', // <label>
		'desc'	=> '', // description
		'id'	=> $prefix.'two', // field id and name
		'type'	=> 'text' // type of field
	),
	array( // Text Input
		'label'	=> 'Highlight 3', // <label>
		'desc'	=> '', // description
		'id'	=> $prefix.'three', // field id and name
		'type'	=> 'text' // type of field
	),
	array( // Text Input
		'label'	=> 'Highlight 4', // <label>
		'desc'	=> '', // description
		'id'	=> $prefix.'four', // field id and name
		'type'	=> 'text' // type of field
	),
	array( // Text Input
		'label'	=> 'Highlight 5', // <label>
		'desc'	=> '', // description
		'id'	=> $prefix.'five', // field id and name
		'type'	=> 'text' // type of field
	),
	array( // Text Input
		'label'	=> 'Highlight 6', // <label>
		'desc'	=> '', // description
		'id'	=> $prefix.'six', // field id and name
		'type'	=> 'text' // type of field
	),
);

// Get and return the values for the URL and description
function get_socrata_magazine_meta() {
  global $post;
  $socrata_magazine_one = get_post_meta($post->ID, 'socrata_magazine_one', true); // 0
  $socrata_magazine_two = get_post_meta($post->ID, 'socrata_magazine_two', true); // 1
  $socrata_magazine_three = get_post_meta($post->ID, 'socrata_magazine_three', true); // 2
  $socrata_magazine_four = get_post_meta($post->ID, 'socrata_magazine_four', true); // 3
  $socrata_magazine_five = get_post_meta($post->ID, 'socrata_magazine_five', true); // 4
  $socrata_magazine_six = get_post_meta($post->ID, 'socrata_magazine_six', true); // 5
  $socrata_magazine_link = get_post_meta($post->ID, 'socrata_magazine_link', true); // 6
  $socrata_magazine_smartform = get_post_meta($post->ID, 'socrata_magazine_smartform', true); // 7

  return array(
	$socrata_magazine_one,
	$socrata_magazine_two,
	$socrata_magazine_three,
	$socrata_magazine_four,
	$socrata_magazine_five,
	$socrata_magazine_six,	
	$socrata_magazine_link,
	$socrata_magazine_smartform
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
$socrata_magazine_box = new socrata_magazine_custom_add_meta_box( 'socrata_magazine_box', 'In This Issue', $fields, 'oi_magazine', true );


