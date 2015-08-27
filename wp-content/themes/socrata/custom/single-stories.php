<div class="feature-image" style="background-image: url(<?php echo tuts_custom_img('full', 1600, 400 ); ?>);">
	<div class="pattern-overlay"></div>
</div>

<?php
  $meta = get_attribution_meta(); 
  if ($meta[1]) {
    echo "<div class='image-attribution'>Photo: <a href='$meta[1]' target='_blank'>$meta[0]</a></div>";
  } elseif ($meta[0]) {
    echo "<div class='image-attribution'>Photo: $meta[0]</div>";
  } 
?>
<div class="blog-content-wrapper container">
	<div class="row">
		<div class="col-sm-2 hidden-xs">
			<?php $meta = get_socrata_stories_meta(); if ($meta[6]) echo wp_get_attachment_image($meta[6], 'small', false, array('class' => 'img-responsive')); ?>
		</div>	
		<div class="col-sm-7 article-content">
		<small class="category-name"><?php stories_the_categories(); ?></small>
			<h1><?php the_title(); ?></h1>				
			<ul class="article-meta">
				<?php $meta = get_socrata_stories_meta();
					if ($meta[2]) {echo "<li><a href='$meta[2]' target='_blank'>$meta[1]</a></li>";}
					elseif ($meta[1]) {echo "<li>$meta[1]</li>";}
				?>
				<?php $meta = get_socrata_stories_meta(); if ($meta[3]) {echo "<li><i>Live Since</i> $meta[3]</li>";} ?>
				<?php $meta = get_socrata_stories_meta(); if ($meta[4]) {echo "<li><a href='$meta[5]' target='_blank'>$meta[4]</a></li>";} ?>
			</ul>
			<div class="marketo-share">
				<?php echo do_shortcode( '[marketo-share]' ); ?>
			</div>			
			<?php thesis_content_column(); ?>
			<div>
				<?php $meta = get_socrata_stories_meta(); if ($meta[13]) { ?>			
					<hr/>
					<h4>Press</h4>
					<ul class="press">         
					<?php $meta = get_socrata_stories_meta(); if ($meta[13]) {echo "<li><a href='$meta[14]' target='_blank'>$meta[13]</a><small>- $meta[20]</small></li>";} ?>
					<?php $meta = get_socrata_stories_meta(); if ($meta[15]) {echo "<li><a href='$meta[16]' target='_blank'>$meta[15]</a><small>- $meta[21]</small></li>";} ?>
					<?php $meta = get_socrata_stories_meta(); if ($meta[17]) {echo "<li><a href='$meta[18]' target='_blank'>$meta[17]</a><small>- $meta[22]</small></li>";} ?>
					</ul>			    
				<?php } ?>
			<hr/>
			<ul class="additional-links">
				<li><?php echo get_the_term_list( $post->ID, array('stories_region', 'stories_type', 'stories_product'), '<small>FOUND IN:</small> ', ', ', '' ); ?></li>
				<?php if( 'stories' == get_post_type() ) {
				previous_post_link('<li><small>NEXT STORY:</small>%link</li>');
				next_post_link('<li><small>PREVIOUS STORY:</small>%link</li>');
				}?>
			</ul>
	  		</div>

		</div>
		<div class="col-sm-3">
			<?php $meta = get_socrata_stories_meta();
			if ($meta[12]) {
				echo "<div class='quote-block'><p class='quote-text'>&quot;$meta[10]&quot;</p>";
				echo "<div class='author-block'>";
				echo wp_get_attachment_image($meta[12], 'thumbnail', false, array('class' => 'img-circle'));
				echo "<p class='quote-author'>$meta[11]</p>";
				echo "</div></div>";
			}
			elseif ($meta[11]) {echo "<div class='quote-block'><p class='quote-text'>&quot;$meta[10]&quot;</p><p class='quote-author'>$meta[11]</p></div>";}		
			elseif ($meta[10]) {echo "<div class='quote-block'><p class='quote-text'>&quot;$meta[10]&quot;</p></div>";}
			?>

			<?php $meta = get_socrata_stories_meta(); if ($meta[7]) { ?>
				<div class="screen">              
					<?php echo wp_get_attachment_image($meta[7], 'medium-thumb', false, array('class' => 'img-responsive')); ?>
				</div>    
			<?php } ?>
			<?php $meta = get_socrata_stories_meta(); if ($meta[8]) { ?>
				<div class="screen">                 
					<?php echo wp_get_attachment_image($meta[8], 'medium-thumb', false, array('class' => 'img-responsive')); ?>
				</div>     
			<?php } ?>
			<?php $meta = get_socrata_stories_meta(); if ($meta[9]) { ?>
				<div class="screen">                 
					<?php echo wp_get_attachment_image($meta[9], 'medium-thumb', false, array('class' => 'img-responsive')); ?>
				</div>     
			<?php } ?>
		</div>
	</div>	
</div>