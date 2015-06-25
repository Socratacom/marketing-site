<?php

function get_news($i) {
	$label = '';
	if ( '' != get_sub_field('label') ) {
		$label = '<h2>'.get_sub_field('label').'</h2>';
	}

	$news_args = array(
		'post_type' => array( 'tech_blog', 'post' ),
		'post_status' => 'publish',
		'order' => 'DESC',
		'posts_per_page' => 4
	);
	$news = output_posts( $news_args, 'news' );

	$case_args = array(
		'post_type' => array( 'post' ),
		'order' => 'DESC',
		'posts_per_page' => 1
	);
	$news .= output_posts( $case_args, 'case' );

	$result  = '<div class="section news news-'.$i.'">';
	$result .= '<div class="container">';
	$result .= $label;
	$result .= $news;
	$result .= '</div>';
	$result .= '</div>';

	return $result;

}

function output_posts( $args, $type ) {
	$the_loop = get_posts( $args );
	if ( $the_loop ) {
		$posts  = '<div class="row news-list">';
		foreach( $the_loop as $loop ) { setup_postdata($loop);
			$post_id = $loop->ID;
			$vars_array = array(
				'featured_image' => wp_get_attachment_image_src(  get_post_thumbnail_id($post_id), 'full' ),
				'name' => $loop->post_title,
				'link' => get_permalink($post_id),
				'date' => get_the_date('F j, Y', $post_id),
				'excerpt' => wp_trim_words ( strip_shortcodes( $loop->post_content, 55 ) )
				);

			if ( 'news' == $type ) {
				$posts .= get_news_layout($vars_array);
			} else if ( 'case' == $type ) {
				$posts .= get_case_layout($vars_array);
			}
		}
		$posts .= '</div>';
	}
	return $posts;
}

function get_news_layout($vars_array) {
	$news = '<div class="col-sm-3"><div class="post">';
	$news .= '<div class="img-container"><a href="'.$vars_array['link'].'"><img src="'.$vars_array['featured_image'][0].'" alt="'.$vars_array['name'].'" class="img-responsive"></a></div>';
	$news .= '<span class="sup-header">Published on '.$vars_array['date'].'</span><h3><a href="'.$vars_array['link'].'">'.$vars_array['name'].'</a></h3>';
	$news .= '</div></div>';

	return $news;
}
function get_case_layout($vars_array) {
	$news = '<div class="col-sm-6">';
	$news .= '<h3>'.$vars_array['name'].'</h3><p>'.$vars_array['excerpt'].' <a href="'.$vars_array['link'].'">Continued</a></p>';
	$news .= '</div>';
	$news .= '<div class="col-sm-6">';
	$news .= '<div class="img-container"><a href="'.$vars_array['link'].'"><img src="'.$vars_array['featured_image'][0].'" alt="'.$vars_array['name'].'" class="img-responsive"></a></div>';
	$news .= '</div>';

	return $news;
}
