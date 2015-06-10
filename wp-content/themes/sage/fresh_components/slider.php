<?php

function get_slider($i) {

	$slide_number = 0;
	$slider_fixed_height = get_sub_field('slider_fixed_height');

	if (have_rows('slide')) {
		while (have_rows('slide')) { the_row();

			$slide_background_array = get_sub_field('slide_background_image');
			$rows = '';

			if (get_sub_field('slide_top')) {
				$rows .= '<div class="row">';
				$rows .= '<div class="col-md-12">';
				$rows .= get_sub_field('slide_top');
				$rows .= '</div>';
				$rows .= '</div>';
			}
			
			if (get_sub_field('rows')) {
				$columns_count = count(get_sub_field('rows'));
				$rows .= '<div class="row">';
				while (have_rows('rows')) { the_row();

					if (get_sub_field('columns')) {
						while(have_rows('columns')) { the_row();
							$rows .= '<div class="col-sm-'. ( 12 / $columns_count ) .'">';
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

			$slide .= '<div class="slide slide-'.$slide_number.'" style="background:url('. $slide_background_array['url'] .') no-repeat; background-size:cover">';
			$slide .= '<div class="container">';
			$slide .= '<div style="'. ( $slider_fixed_height ? 'top:50%; -webkit-transform:translateY(-50%); transform:translateY(-50%); position:relative;' : null) .'">';
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
	document.addEventListener('DOMContentLoaded', function() {
        $('.slider-$i').slick({
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

	echo '<div class="section slider slider-'.$i.'" style="margin:0 -15px; '.( $slider_fixed_height ? 'height:'.$slider_fixed_height.'px;' : null ).'">';
	echo $slide;
	echo '</div>';

	if ($slide_number > 0) {
		echo $script;
	}

}
