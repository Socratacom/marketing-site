<?php

function get_slider($i) {

	$slide_number = 0;
	$slider_fixed_height = get_sub_field('slider_fixed_height') === '' ? 460 : get_sub_field('slider_fixed_height');
	$slide = '';

	if (have_rows('slide')) {
		while (have_rows('slide')) { the_row();

			$rows = '';
			$rtp_id = get_sub_field('rtp_id');
			$slide_background_color = get_sub_field('slide_background_color') !== '' ? get_sub_field('slide_background_color') : 'white';
			$slide_background_array = get_sub_field('slide_background_image');
			$slide_background_image_url = '';
			if ($slide_background_array) {
				$slide_background_image_url = $slide_background_array['url'];
			}
			$slide_background_image_size = get_sub_field('slide_background_image_size') !== '' && !is_array(get_sub_field('slide_background_image_size')) ? get_sub_field('slide_background_image_size') : 'cover';
			$slide_background_image_position = get_sub_field('slide_background_image_position') !== ''  && !is_array(get_sub_field('slide_background_image_position')) ? get_sub_field('slide_background_image_position') : 'center center';

			$slide_background_style = '';
			if ($slide_background_array) {
				$slide_background_style .= 'background-image: url('. $slide_background_image_url .');';
			}

			$slide_background_style .= 'background-color: '. $slide_background_color .';
									    background-position: '. $slide_background_image_position .';
									    background-size: '. $slide_background_image_size .';
									    background-repeat: no-repeat;';

			if (get_sub_field('slide_top')) {
				$rows .= '<div class="row">';
				$rows .= '<div class="col-md-12">';
				$rows .= get_sub_field('slide_top');
				$rows .= '</div>';
				$rows .= '</div>';
			}

			if (have_rows('rows')) {
				$rows .= '<div class="row">';
				while (have_rows('rows')) { the_row();

					if (get_sub_field('columns')) {
						$columns_count = count(get_sub_field('columns'));
						while(have_rows('columns')) { the_row();
							$column_rtp_id = get_sub_field('rtp_id');
							$rows .= '<div id="'.$column_rtp_id.'" class="col-sm-'. ( 12 / $columns_count ) .'">';
							$rows .= get_sub_field('column');
							$rows .= '</div>';
						}
					}

				}
				$rows .= '</div>';
			}

			if (get_sub_field('slide_bottom')) {
				$rows .= '<div class="row">';
				$rows .= '<div class="col-md-12">';
				$rows .= get_sub_field('slide_bottom');
				$rows .= '</div>';
				$rows .= '</div>';
			}

			$slide .= '<div id="'.$rtp_id.'" class="slide slide-'. $slide_number .'" style="'. $slide_background_style .'">';
			$slide .= '<div class="container">';
			$slide .= '<div class="align-helper '. ( $slider_fixed_height ? 'vertical-center' : null ) .'">';
			$slide .= $rows;
			$slide .= '</div>';
			$slide .= '</div>';
			$slide .= '</div>';

			$slide_number++;

		}

	} else {
		return false;
	}

	$script = "<script>
	$(function(){
        $('.slider-$i .slide-list').slick({
			arrows: true,
			prevArrow: '<i class=\"fa slick-prev fa-chevron-left\"></i>',
			nextArrow: '<i class=\"fa slick-next fa-chevron-right\"></i>',
			autoplay: true,
			autoplaySpeed: 5000,
			speed: 800,
			slidesToShow: 1,
			slidesToScroll: 1
        });
    });
	</script>";

	echo '<div class="section slider slider-'. $i .'" style="margin:0 -15px; '. ( $slider_fixed_height ? 'height:'. $slider_fixed_height .'px;' : null ) .'">';
	echo '<div class="slide-list">';
	echo $slide;
	echo '</div>';
	echo '</div>';

	echo "<script>
	var adjustSectionHeight = debounce(function() {
		$('.slider').each(function(){
			if ( $('.align-helper', this).height() > $slider_fixed_height ) {
				$('.align-helper', this).removeClass('vertical-center');
				$(this).css({height : 'auto'});
			} else {
				$('.align-helper', this).addClass('vertical-center');
				$(this).css({height : $slider_fixed_height + 'px'});
			}
		});
	}, 250);
	window.addEventListener('resize', adjustSectionHeight);
	adjustSectionHeight();
	</script>";

	if ($slide_number > 1) {
		echo $script;
	}

}
