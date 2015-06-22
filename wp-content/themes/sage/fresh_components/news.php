<?php

function get_news($i) {

	$args = array(
		'post_type' => array( 'tech_blog', 'post' ),
		'post_status' => 'publish',
		'order' => 'DESC',
		'posts_per_page' => 4
	);

	$news_loop = new WP_Query( $args );

	if ( $news_loop->have_posts() ) :
		$news  = '<div class="row news-list">';
		while ( $news_loop->have_posts() ) : $news_loop->the_post();
			// get vars
			$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
			$featured_image = $featured_image[0];
			$name = get_the_title();
			$link = get_the_permalink();
			$date = get_the_date();
			$news .= '<div class="col-sm-3"><div class="post">';
			$news .= '<div class="img-container"><a href="'.$link.'"><img src="'.$featured_image.'" alt="'.$name.'" class="img-responsive"></a></div>';
			$news .= '<span class="sup-header">Published on '.$date.'</span><h3><a href="'.$link.'">'.$name.'</a></h3>';
			$news .= '</div></div>';
		endwhile;
		$news .= '</div>';

	endif;

	$args = array(
		'post_type' => array( 'post' ),
		'post_status' => 'publish',
		'order' => 'DESC',
		'posts_per_page' => 1
	);

	// $case_loop = new WP_Query( $args );
	// if ( $case_loop->have_posts() ) :
	// 	$news .= '<div class="row featured">';
	// 	while ( $case_loop->have_posts() ) : $case_loop->the_post();
	// 		// get vars
	// 		$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
	// 		$featured_image = $featured_image[0];
	// 		$name = get_the_title();
	// 		$link = get_the_permalink();
	// 		$date = get_the_date();
	// 		$news .= '<div class="col-sm-6">';
	// 		$news .= '<h3>'.$name.'</h3><p>'.$excerpt.'</p>';
	// 		$news .= '</div>';
	// 		$news .= '<div class="col-sm-6">';
	// 		$news .= '<div class="img-container"><a href="'.$link.'"><img src="'.$featured_image.'" alt="'.$name.'" class="img-responsive"></a></div>';
	// 		$news .= '</div>';
	// 	endwhile;
	// 	$news .= '</div>';

	// endif;

	$result  = '<div class="section news news-'.$i.'">';
	$result .= '<div class="container">';
	$result .= $news;
	$result .= '</div>';
	$result .= '</div>';

	return $result;

}

?>