<?php 
$cat = get_category( get_query_var( 'cat' ) );
$category = $cat->slug;
echo do_shortcode('[ajax_load_more category="'.$category.'" posts_per_page="6"]');
?>