<?php

function get_case_studies($i) {

	$args = array(
		'post_type' => 'case_study',
		'post_status' => 'publish',
		'order' => 'DESC',
		'posts_per_page' => 10
	);

	$case_studies_category = get_sub_field('case_studies_category');

	if($case_studies_category && count($case_studies_category) !== 0) {
	    $args['tax_query'] = array();

	    $args['tax_query'][] = array(
	        'taxonomy' => 'case_study_category',
	        'terms' => $case_studies_category
	    );
	}

	$case_loop = get_posts( $args );
	if ($case_loop) {
		$case_studies  = '<div class="col-sm-10 col-sm-offset-1 post-list">';
		foreach( $case_loop as $loop ) { setup_postdata($loop);
			$post_id = $loop->ID;
			$featured_image = wp_get_attachment_image_src(  get_post_thumbnail_id($post_id), 'full' );
			$name = $loop->post_title;
			$link = get_permalink($post_id);
			$excerpt = wp_trim_words ( strip_shortcodes( $loop->post_content, 55 ) );

			$case_studies .= '<div class="slide row"><div class="col-sm-7">';
			$case_studies .= '<h3>'.$name.'</h3><p>'.$excerpt.'</p>';
			$case_studies .= '</div>';
			$case_studies .= '<div class="col-sm-5">';
			$case_studies .= '<a class="img-container" style="background-image:url('.$featured_image[0].')" href="'.$link.'"></a>';
			$case_studies .= '</div></div>';
		}
		$case_studies .= '</div>';
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
			slidesToScroll: 1
        });
    }, false);
	</script>";

	$result  = '<div class="section case-studies case-studies-'.$i.'">';
	$result .= '<div class="container">';
	$result .= '<div class="row"><div class="col-xs-12 col-sm-10 col-sm-offset-1"><h4>Case Studies</h4></div></div>';
	$result .= '<div class="row">';
	$result .= $case_studies;
	$result .= '</div>';
	$result .= '</div>';
	$result .= '</div>';
	$result .= $script;

	return $result;

}
