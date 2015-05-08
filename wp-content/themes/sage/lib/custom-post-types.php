<?php

/*---------------------------------------*/
// CASE STUDIES
/*---------------------------------------*/

// REGISTER POST TYPE
add_action( 'init', 'case_study_post_type' );
function case_study_post_type() {
  register_post_type( 'case_study',
    array(
      'labels' => array(
        'name' => 'Case Studies',
        'singular_name' => 'Case Study',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Case Study',
        'edit' => 'Edit',
        'edit_item' => 'Edit Case Study',
        'new_item' => 'New Case Study',
        'view' => 'View',
        'view_item' => 'View Case Studies',
        'search_items' => 'Search Case Studies',
        'not_found' => 'Not found',
        'not_found_in_trash' => 'Not found in Trash',
        'parent' => 'Parent Case Study'
      ),
      'public' => true,
      'menu_position' => 5,
      'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' ),
      'taxonomies' => array( '' ),
      'menu_icon' => get_stylesheet_directory_uri() .'/custom/images/icons/menu-socrata.png',
      'has_archive' => true,
      'rewrite' => array('with_front' => false, 'slug' => 'case-study'),
    )
  );
}

// TAXONOMIES
add_action( 'init', 'create_case_study_taxonomies', 0 );
function create_case_study_taxonomies() {
    register_taxonomy(
        'case_study_category',
        'case_study',
        array(
            'labels' => array(
                'name' => 'Case Study Category',
                'add_new_item' => 'Add New Category',
                'new_item_name' => "New Category"
            ),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true,
            'rewrite' => array('with_front' => false, 'slug' => 'case-study-customers'),
        )
    );
}

// Custom Columns for admin management page
add_filter( 'manage_edit-case_study_columns', 'case_study_columns' ) ;
function case_study_columns( $columns ) {
  $columns = array(
    'cb' => '<input type="checkbox" />',
    'title' => __( 'Customer' ),
    'case_study_category' => __( 'Status' ),
    'date' => __( 'Date' )
  );
  return $columns;
}

add_action( 'manage_case_study_posts_custom_column', 'case_study_custom_columns', 10, 2 );
function case_study_custom_columns( $column, $post_id ) {
  global $post;
  switch( $column ) {
    case 'case_study_category' :
      $terms = get_the_terms( $post_id, 'case_study_category' );
      if ( !empty( $terms ) ) {
        $out = array();
        foreach ( $terms as $term ) {
          $out[] = sprintf( '<a href="%s">%s</a>',
            esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'case_study' => $term->slug ), 'edit.php' ) ),
            esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'case_study_category', 'display' ) )
          );
        }
        echo join( ', ', $out );
      }
      else {
        _e( 'No Category' );
      }
      break;
    default :
      break;
  }
}


/*---------------------------------------*/
// USER STORIES
/*---------------------------------------*/

// REGISTER POST TYPE
add_action( 'init', 'create_stories' );
function create_stories() {
  register_post_type( 'stories',
    array(
      'labels' => array(
        'name' => 'Stories',
        'singular_name' => 'Stories',
        'add_new' => 'Add New Story',
        'add_new_item' => 'Add New Story',
        'edit' => 'Edit Stories',
        'edit_item' => 'Edit Stories',
        'new_item' => 'New Story',
        'view' => 'View',
        'view_item' => 'View Story',
        'search_items' => 'Search Storiess',
        'not_found' => 'Not found',
        'not_found_in_trash' => 'Not found in Trash',
        'parent' => 'Socrata'
      ),
      'public' => true,
      'menu_position' => 5,
      'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' ),
      'taxonomies' => array( '' ),
      'menu_icon' => plugins_url( 'images/image.png', __FILE__ ),
      'has_archive' => true,
      'rewrite' => array('with_front' => false, 'slug' => 'stories')
    )
  );
}

// REGISTER TAXONOMIES
add_action( 'init', 'stories_region', 0 );
function stories_region() {
  register_taxonomy(
    'stories_region',
    'stories',
    array(
      'labels' => array(
        'name' => 'Stories Region',
        'menu_name' => 'Region',
        'add_new_item' => 'Add New Region',
        'new_item_name' => "New Region"
      ),
      'show_ui' => true,
      'show_tagcloud' => false,
      'hierarchical' => true,
      'sort' => true,      
      'args' => array( 'orderby' => 'term_order' ),
      'show_admin_column' => true,
      'rewrite' => array('with_front' => false, 'slug' => 'stories-region')
    )
  );
}

add_action( 'init', 'stories_type', 0 );
function stories_type() {
  register_taxonomy(
    'stories_type',
    'stories',
    array(
      'labels' => array(
        'name' => 'Stories Type',
        'menu_name' => 'Type',
        'add_new_item' => 'Add New Type',
        'new_item_name' => "New Type"
      ),
      'show_ui' => true,
      'show_tagcloud' => false,
      'hierarchical' => true,
      'sort' => true,      
      'args' => array( 'orderby' => 'term_order' ),
      'show_admin_column' => true,
      'rewrite' => array('with_front' => false, 'slug' => 'stories-type')
    )
  );
}

add_action( 'init', 'stories_product', 0 );
function stories_product() {
  register_taxonomy(
    'stories_product',
    'stories',
    array(
      'labels' => array(
        'name' => 'Stories Product',
        'menu_name' => 'Product',
        'add_new_item' => 'Add New Product',
        'new_item_name' => "New Product"
      ),
      'show_ui' => true,
      'show_tagcloud' => false,
      'hierarchical' => true,
      'sort' => true,      
      'args' => array( 'orderby' => 'term_order' ),
      'show_admin_column' => true,
      'rewrite' => array('with_front' => false, 'slug' => 'stories-product')
    )
  );
}
