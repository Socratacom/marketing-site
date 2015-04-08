<?php
/**
 * Template Name: Homepage
 */
?>
<?php while (have_posts()) : the_post(); ?>
	<div class="jumbotron">
		<?php
		if( have_rows('hero') ):
			while ( have_rows('hero') ) : the_row();
				// get vars
				$rtp_id = get_sub_field('rtp_id');
				$background = get_sub_field('slider_image');
				$small_text = get_sub_field('header_small_text');
				$large_text = get_sub_field('header_large_text');
				$italic_text = get_sub_field('header_italic_text');
				if( have_rows('cta') ):
					while ( have_rows('cta') ) : the_row();
						$link = '';
						$link_text = '';
            			$target = '';
						if( get_row_layout() == 'internal_link' ):
							$link = get_sub_field('internal_link');
							$link_text = get_sub_field('internal_link_text');
						elseif( get_row_layout() == 'external_link' ):
							$link = get_sub_field('external_link');
							$link_text = get_sub_field('external_link_text');
              				$target = 'target="_blank"';
						endif;
					endwhile;
				else :
					// no layouts found
				endif;

				echo '<div id="'.$rtp_id.'"><div class="slide" style="background-image: url('.$background.');"><div class="container"><div class="col-sm-10 col-sm-offset-1">';
					echo '<h1>';
					if ($small_text) {
						echo '<span class="smaller-text">'.$small_text.'</span>';
					}
					if ($large_text) {
						echo $large_text;
					}
					echo '</h1>';
					if ($italic_text) {
						echo '<h2>'.$italic_text.'</h2>';
					}
					if ($link) {
						echo '<a href="'.$link.'" class="button" '.$target.'>'.$link_text.'</a>';
					}
				echo '</div></div></div></div>';
			endwhile;
		else :
			// no hero found
		endif;
		?>
	</div>
	<section class="featured-videos">
		<div class="container">
			<div class="vid-slider">
				<?php
				if( have_rows('videos') ):
					while ( have_rows('videos') ) : the_row();
						// get vars
						$header = get_sub_field('header');
						$summary = get_sub_field('summary');
						$image = get_sub_field('image');
						$rtp_id = get_sub_field('rtp_id');

				        $video = get_sub_field('link');
				        preg_match('/src="(.+?)"/', $video, $matches);
				        $src = $matches[1];
				        $params = array(
				            'enablejsapi'   => 1,
				            'rel'   => 0,
				            'controls'  => 0,
				            'html5'     => 1,
				            'showinfo'  =>0,
				            'playsinline' => 1
				        );
				        $new_src = add_query_arg($params, $src);

						echo '<div class="slide col-sm-4" id="'.$rtp_id.'">';
						echo '<a href="#" data-toggle="modal" data-target="#videoModal" data-content="'.$new_src.'">';
						echo '<div class="play-btn"></div>';
						echo '<div class="video-content"><h3>'.$headline.'</h3><p>'.$summary.'</p></div>';
						echo '<img src="'.$image['url'].'" alt="'.$image['title'].'">';
						echo '</a>';
						echo '</div>';
					endwhile;
				endif;
				?>
			</div>
		</div>
	</section>
	<section class="featured-ctas">
		<div class="container">
			<div class="row cta-slider">
              <?php
                if( have_rows('ctas') ):
                  while ( have_rows('ctas') ) : the_row();
                    // get vars
              		$icon = get_sub_field('icon');
              		$icon_color = get_sub_field('icon_color');
              		$title = get_sub_field('title');
              		$content = get_sub_field('content');
              		if( have_rows('link') ):
                      while ( have_rows('link') ) : the_row();
                        $link = '';
                        $link_text = '';
                        $target = '';
                        if( get_row_layout() == 'internal_link' ):
                          $link = get_sub_field('link_url');
                          $link_text = get_sub_field('link_text');
                        elseif( get_row_layout() == 'external_link' ):
                          $link = get_sub_field('link_url');
                          $link_text = get_sub_field('link_text');
                          $target = 'target="_blank"';
                        endif;
                      endwhile;
                    else :
                      // no layouts found
                    endif;
                	$rtp_id = get_sub_field('rtp_id');

                    echo '<div class="slide col-sm-4" id="'.$rtp_id.'">';
                    if ($icon) {
                    	echo '<i class="fa fa-'.$icon.' '.$icon_color.'"></i>';
                    }
                    if ($title) {
                    	echo '<h3>'.$title.'</h3>';
                    }
                    if ($content) {
                    	echo $content;
                    }
                    if ($link) {
                    	echo '<a href="'.$link.'" class="button" '.$target.'>'.$link_text.'</a>';
                    }
                    echo '</div>';
                  endwhile;
                endif;
                ?>
			</div>
		</div>
	</section>
	<section class="cloud-overview hidden-xs">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<?php echo the_field('content'); ?>
				</div>
				<?php
					if( have_rows('cloud', 'option') ):
						$count = 0;
						while ( have_rows('cloud', 'option') ) : the_row();
							// Get vars
							$title = get_sub_field('title');
							$icon = get_sub_field('cloud_icon');
							$offset = '';
							if ($count == 0 ) {
								$offset = 'col-sm-offset-1';
							}

							echo '<div class="col-sm-2 col-xs-6 '.$offset.'">';
								echo '<a href="#'.$icon.'"><span class="'.$icon.'"></span></a>';
								echo '<h3>'.$title.'</h3>';
							echo '</div>';
							$count++;
						endwhile;
					else :
						// no rows found
					endif;
				?>
			</div>
		</div>
	</section>
	<section class="clouds">
		<div class="container">
			<div class="row">
				<div class="col-sm-12"><div class="row">
					<?php
					if( have_rows('cloud', 'option') ):
						$c = true;
						while ( have_rows('cloud', 'option') ) : the_row();
							// Get vars
							$oddeven = $c = !$c;
							$title = get_sub_field('title');
							$icon = get_sub_field('cloud_icon');
							$headline = get_sub_field('headline');
							$content = get_sub_field('content');
							$link_text = get_sub_field('link_text');
							$link = get_sub_field('link');

							if ( false == $oddeven ) {
								echo '<div class="col-sm-12 cloud" id="'.$icon.'"><div class="col-sm-4">';
									if ($icon) {
										echo '<span class="cloud-icon '.$icon.'"></span>';
									}
									if ($title) {
										echo '<h2>'.$title.'</h2>';
									}
								echo '</div>';
								echo '<div class="col-md-7 col-sm-8 col-md-offset-1">';
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
								echo '</div>';
								echo '<div class="col-sm-12 logos hidden-xs">';
									if( have_rows('logos') ):
										while( have_rows('logos') ): the_row();
                    						$logo = get_sub_field('logo_image');
                    						$logolink = '';
                							$linkstart = '';
                							$linkend = '';
                							if( have_rows('logo_link') ):
												while( have_rows('logo_link') ): the_row();
													if( get_row_layout() == 'internal_link' ):
														$logolink = get_sub_field('link_url');
														$linkstart = '<a href="'.$logolink.'">';
														$linkend = '</a>';
													elseif( get_row_layout() == 'external_link' ):
														$logolink = get_sub_field('link_url');
														$linkstart = '<a href="'.$logolink.'" target="_blank">';
														$linkend = '</a>';
													endif;
												endwhile;
											endif;

                    						if ($logo) {
											echo '<div class="slide col-sm-2">'.$linkstart.'<img src="'.$logo['url'].'" alt="'.$logo['title'].'" class="grayscale">'.$linkend.'</div>';
										}
										endwhile;
									endif;
								echo '</div></div>';
							} else if ( true == $oddeven ) {
								echo '<div class="col-sm-12 cloud" id="'.$icon.'"><div class="col-sm-4 col-sm-push-8">';
									if ($icon) {
										echo '<span class="cloud-icon '.$icon.'"></span>';
									}
									if ($title) {
										echo '<h2>'.$title.'</h2>';
									}
								echo '</div>';
								echo '<div class="col-md-7 col-sm-8 col-sm-pull-4">';
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
								echo '</div>';
								echo '<div class="col-sm-12 logos hidden-xs">';
				                  	if( have_rows('logos') ):
				                    	while( have_rows('logos') ): the_row();
				                    		$logo = get_sub_field('logo_image');
				                      		$logolink = '';
                							$linkstart = '';
                							$linkend = '';
                							if( have_rows('logo_link') ):
												while( have_rows('logo_link') ): the_row();
													if( get_row_layout() == 'internal_link' ):
														$logolink = get_sub_field('link_url');
														$linkstart = '<a href="'.$logolink.'">';
														$linkend = '</a>';
													elseif( get_row_layout() == 'external_link' ):
														$logolink = get_sub_field('link_url');
														$linkstart = '<a href="'.$logolink.'" target="_blank">';
														$linkend = '</a>';
													endif;
												endwhile;
											endif;

                    						if ($logo) {
											echo '<div class="slide col-sm-2">'.$linkstart.'<img src="'.$logo['url'].'" alt="'.$logo['title'].'" class="grayscale">'.$linkend.'</div>';
											}
				                    	endwhile;
				                  	endif;
								echo '</div></div>';
							}
						endwhile;
					else :
						// no rows found
					endif;
					?>
				</div></div>
			</div>
		</div>
	</section>
	<section class="case-studies">
		<div class="container">
			<div class="row">
				<?php
					$args = array(
						'post_type' => 'case_study',
						'post_status' => 'publish',
	    				'order' => 'DESC',
	    				'posts_per_page' => 9
					);
					$case_loop = new WP_Query( $args );
					if ( $case_loop->have_posts() ) :
						echo '<div class="col-sm-10 col-sm-offset-1 post-list">';
	    				while ( $case_loop->have_posts() ) : $case_loop->the_post();
	    					// get vars
	    					$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
        					$featured_image = $featured_image[0];
		    				$name = get_the_title();
        					$link = get_the_permalink();
        					$excerpt = get_the_excerpt();
	    					echo '<div class="slide"><div class="col-sm-7">';
	    					echo '<span class="sup-header">Case Studies</span><h2>'.$name.'</h2><p>'.$excerpt.'</p>';
	    					echo '</div>';
	    					echo '<div class="col-sm-5">';
	    					echo '<div class="img-container"><a href="'.$link.'"><img src="'.$featured_image.'" alt="'.$name.'" class="img-responsive"></a></div>';
	    					echo '</div></div>';
	    				endwhile;
		    			echo '</div>';
		    			wp_reset_postdata();
		    		endif;
				?>
			</div>
		</div>
	</section>
	<section class="news">
		<div class="container">
			<div class="row">
				<h2>Latest News</h2>
				<?php
					$args = array(
						'post_type' => array( 'tech_blog', 'post' ),
						'post_status' => 'publish',
	    				'order' => 'DESC',
	    				'posts_per_page' => 4
					);
					$news_loop = new WP_Query( $args );
					if ( $news_loop->have_posts() ) :
						echo '<div class="row news-list">';
	    				while ( $news_loop->have_posts() ) : $news_loop->the_post();
	    					// get vars
	    					$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
        					$featured_image = $featured_image[0];
		    				$name = get_the_title();
        					$link = get_the_permalink();
        					$date = get_the_date();
	    					echo '<div class="col-sm-3"><div class="post">';
	    					echo '<div class="img-container"><a href="'.$link.'"><img src="'.$featured_image.'" alt="'.$name.'" class="img-responsive"></a></div>';
	    					echo '<span class="sup-header">Published on '.$date.'</span><h3><a href="'.$link.'">'.$name.'</a></h3>';
	    					echo '</div></div>';
	    				endwhile;
		    			echo '</div>';
		    			wp_reset_postdata();
		    		endif;

		    		$args = array(
						'post_type' => array( 'post' ),
						'post_status' => 'publish',
	    				'order' => 'DESC',
	    				'posts_per_page' => 1
					);
					$case_loop = new WP_Query( $args );
					if ( $case_loop->have_posts() ) :
						echo '<div class="row featured">';
	    				while ( $case_loop->have_posts() ) : $case_loop->the_post();
	    					// get vars
	    					$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
        					$featured_image = $featured_image[0];
		    				$name = get_the_title();
        					$link = get_the_permalink();
        					$date = get_the_date();
        					echo '<div class="col-sm-6">';
	    					echo '<h3>'.$name.'</h3><p>'.$excerpt.'</p>';
	    					echo '</div>';
	    					echo '<div class="col-sm-6">';
	    					echo '<div class="img-container"><a href="'.$link.'"><img src="'.$featured_image.'" alt="'.$name.'" class="img-responsive"></a></div>';
	    					echo '</div>';
	    				endwhile;
		    			echo '</div>';
		    			wp_reset_postdata();
		    		endif;
				?>
			</div>
		</div>
	</section>
	<section class="newsletter">
		<div class="container">
			<div class="row">
				<div class="col-sm-5 col-sm-offset-1">
					<?php the_field('newsletter_content'); ?>
				</div>
				<div class="col-sm-5">
					<script src="//app-abk.marketo.com/js/forms2/js/forms2.min.js"></script>
<form id="mktoForm_2306"></form>
<script>MktoForms2.loadForm("//app-abk.marketo.com", "851-SII-641", 2306);</script>
				</div>
			</div>
		</div>
	</section>
	<section class="awards">
		<div class="container">
			<div class="row awards-slide">
        <?php
        if( have_rows('awards') ):
        	while ( have_rows('awards') ) : the_row();
            // get vars
            $image = get_sub_field('image');
            $title = get_sub_field('title');
            if( have_rows('link') ):
              while ( have_rows('link') ) : the_row();
                $link = '';
                $target = '';
                if( get_row_layout() == 'internal_link' ):
                  $link = get_sub_field('link_url');
                elseif( get_row_layout() == 'external_link' ):
                  $link = get_sub_field('link_url');
                  $target = 'target="_blank"';
                endif;
              endwhile;
            else :
              // no layouts found
            endif;
            $href_start = '';
            $href_end = '';
            if ($link) {
              $href_start = '<a href="'.$link.'" '.$target.'>';
              $href_end = '</a>';
              }

            echo '<div class="col-sm-2">';

              if ($image) {
                echo $href_start.'<img src="'.$image['url'].'" alt="'.$image['title'].'" class="img-responsive">';
              }
              if ($title) {
                echo '<p>'.$title.'</p>';
              }
            echo $href_end.'</div>';
          endwhile;
        endif;
        ?>
				<!-- <div class="col-sm-2 col-sm-offset-4">
					<img src="wp-content/themes/sage/assets/images/fedramp.gif" alt="FedRAMP" class="img-responsive">
				</div>
				<div class="col-sm-2">
					<img src="wp-content/themes/sage/assets/images/addy.gif" alt="Addy Award Winner" class="img-responsive">
				</div> -->
			</div>
		</div>
	</section>
	<?php get_template_part('templates/content', 'page'); ?>
<?php endwhile; ?>

<div class="modal fade videoModal" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="videoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button id="close-button" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body">
        <div class="embed-container">
          <iframe width="200" height="113" frameborder="0" allowfullscreen="" id="player"></iframe>
        </div>
      </div>
    </div>
  </div>
</div>
