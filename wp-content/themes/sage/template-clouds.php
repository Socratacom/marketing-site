<?php
/**
 * Template Name: Cloud Overview
 */
?>
<?php while (have_posts()) : the_post(); ?>
	<div class="jumbotron hidden-xs">
		<?php
		if( have_rows('hero') ):
			while ( have_rows('hero') ) : the_row();
				// get vars
				$background = get_sub_field('slider_image');
				$large_text = get_sub_field('header_large_text');
				$italic_text = get_sub_field('header_italic_text');

				echo '<div class="slide" style="background-image: url('.$background.');"><div class="container"><div class="col-sm-10 col-sm-offset-1">';
					echo '<h1>';
					if ($large_text) {
						echo $large_text;
					}
					echo '</h1>';
					if ($italic_text) {
						echo '<h2>'.$italic_text.'</h2>';
					}
				echo '</div></div></div>';
			endwhile;
		else :
			// no hero found
		endif;
		?>
	</div>
	<section class="clouds">
		<div class="container">
			<div class="row">
				<div class="col-sm-12"><div class="row">
					<?php
					if( have_rows('cloud', 'option') ):
						while ( have_rows('cloud', 'option') ) : the_row();
							// Get vars
							$oddeven = $c = !$c;
							$title = get_sub_field('title');
							$icon = get_sub_field('cloud_icon');
							$headline = get_sub_field('headline');
							$content = get_sub_field('content');
							$link_text = get_sub_field('link_text');
							$link = get_sub_field('link');

							echo '<div class="col-sm-12 cloud" id="'.$icon.'"><div class="col-sm-5">';
								if ($icon) {
									echo '<span class="cloud-icon '.$icon.'"></span>';
								}
								if ($title) {
									echo '<h2>'.$title.'</h2>';
								}
							echo '</div>';
							echo '<div class="col-sm-7 cloud-detail">';
								if ($headline) {
									echo '<h3>'.$headline.'</h3>';
								}
								if ($content) {
									echo $content;
								}
								if ($link) {
									echo '<a href="'.$link.'" class="button">';
									if ($link_text) {
										echo $link_text;
									} else {
										echo 'Learn More';
									}
									echo '</a>';
								}
							echo '</div></div>';
						endwhile;
					else :
						// no rows found
					endif;
					?>
				</div></div>
			</div>
		</div>
	</section>
	<?php get_template_part('templates/content', 'page'); ?>
<?php endwhile; ?>
