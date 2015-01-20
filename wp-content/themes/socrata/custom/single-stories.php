<div class="feature-image" style="background-image: url(<?php echo tuts_custom_img('full', 1600, 400 ); ?>);"></div>

<?php
  $meta = get_attribution_meta(); 
  if ($meta[1]) {
    echo "<div class='image-attribution'>Photo: <a href='$meta[1]' target='_blank'>$meta[0]</a></div>";
  } elseif ($meta[0]) {
    echo "<div class='image-attribution'>Photo: $meta[0]</div>";
  } 
?>
<div class="blog-content-wrapper format_text">
	<!-- Left Column -->
	<div class="one_sixth format_text">
		<div class="mobile-thumb-wrapper">
			<?php $meta = get_socrata_stories_meta(); if ($meta[6]) echo wp_get_attachment_image($meta[6], 'small', false, array('class' => 'img-responsive mobile-thumb')); ?>
		</div>
	</div>
	<div class="one_half">
		<div class="title-block">
			<!-- AddThis Button BEGIN -->
			<div class="addthis_toolbox addthis_32x32_style">
				<a class="addthis_button_facebook"></a>
				<a class="addthis_button_twitter"></a>
				<a class="addthis_button_google_plusone_share"></a>
				<a class="addthis_button_compact"></a>
			</div>
			<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4e590fc12e22e79e"></script>
			<!-- AddThis Button END -->
			<h1><?php the_title(); ?></h1>				
			<ul class="meta">
				<?php $meta = get_socrata_stories_meta();
				if ($meta[2]) {echo "<li><a href='$meta[2]' target='_blank'>$meta[1]</a></li>";}
				elseif ($meta[1]) {echo "<li>$meta[1]</li>";}
				?>
				<?php $meta = get_socrata_stories_meta(); if ($meta[3]) {echo "<li><span>Live Since</span> $meta[3]</li>";} ?>
				<?php $meta = get_socrata_stories_meta(); if ($meta[4]) {echo "<li><a href='$meta[5]' target='_blank'>$meta[4]</a></li>";} ?>
			</ul>
		</div>
		<?php thesis_content_column(); ?>
		<div class="format_text">
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
	<div class="one_third last">
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
	<div class="clearboth"></div>
</div>