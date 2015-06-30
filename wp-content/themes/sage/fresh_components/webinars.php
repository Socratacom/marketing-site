<?php

function get_webinars($i) {

	$args = array(
		'post_type' => 'webinars',
		'post_status' => 'publish',
		'order' => 'DESC',
		'posts_per_page' => 10
	);

	$bg_color = get_sub_field('background_color');
	$theme = get_sub_field('color_theme') && !is_array(get_sub_field('color_theme')) ? get_sub_field('color_theme') : null;

	$webinars_loop = get_posts( $args );
	if ($webinars_loop) {
		$webinars  = '<div class="col-sm-10 col-sm-offset-1 post-list">';
		foreach( $webinars_loop as $loop ) { setup_postdata($loop);
			$post_id = $loop->ID;
			$featured_image = wp_get_attachment_image_src(  get_post_thumbnail_id($post_id), 'full' );
			$name = $loop->post_title;
			$link = get_permalink($post_id);
			$excerpt = wp_trim_words ( strip_shortcodes( $loop->post_content, 55 ) );

			$webinars .= '<div class="slide row">';
			$webinars .= '<div class="col-sm-5">';
			$webinars .= '<a class="img-container" style="background-image:url('.$featured_image[0].')" href="'.$link.'"></a>';
			$webinars .= '</div><div class="col-sm-7">';
			$webinars .= '<h4>Webinars</h4><h3><a href="'.$link.'">'.$name.'</a></h3><p>'.$excerpt.'</p>';
			$webinars .= '</div></div>';
		}
		$webinars .= '</div>';
	}

	$script = "<script>
	document.addEventListener('DOMContentLoaded', function() {
        $('.case-studies-$i .post-list').slick({
			arrows: true,
			prevArrow: '<i class=\"fa slick-prev fa-chevron-left\"></i>',
			nextArrow: '<i class=\"fa slick-next fa-chevron-right\"></i>',
			autoplay: true,
			autoplaySpeed: 5000,
			speed: 800,
			slidesToShow: 1,
			slidesToScroll: 1,
			dots: true
        });
    }, false);
	</script>";

	$result  = '<div class="section '. $theme .' case-studies case-studies-'. $i .'" style="background-color: '. $bg_color .';">';
	$result .= '<div class="container">';
	$result .= '<div class="row"><div class="col-xs-12 col-sm-10 col-sm-offset-1"></div></div>';
	$result .= '<div class="row">';
	$result .= $webinars;
	$result .= '</div>';
	$result .= '</div>';
	$result .= '</div>';
	$result .= $script;

	return $result;

}
