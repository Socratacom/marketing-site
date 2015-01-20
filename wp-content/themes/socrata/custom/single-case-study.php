<div class="feature-image" style="background-image: url(<?php echo tuts_custom_img('full', 1600, 400); ?>);"></div>
<?php
  $meta = get_attribution_meta(); 
  if ($meta[1]) {
    echo "<div class='image-attribution'>Photo: <a href='$meta[1]' target='_blank'>$meta[0]</a></div>";
  } elseif ($meta[0]) {
    echo "<div class='image-attribution'>Photo: $meta[0]</div>";
  } 
?>
<div class="content-wrapper format_text">
	<div class="two_third">
		<div class="left-gutter">
			<div class="blog-title">
				<!-- AddThis Button BEGIN -->
				<div class="addthis_toolbox addthis_32x32_style" style="float:right; margin-left:30px;">
					<a class="addthis_button_facebook"></a>
					<a class="addthis_button_twitter"></a>
					<a class="addthis_button_google_plusone_share"></a>
					<a class="addthis_button_compact"></a>
				</div>
				<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4e590fc12e22e79e"></script>
				<!-- AddThis Button END -->
				<h1><?php the_title(); ?></h1>
				<div class="blog-date">
					<?php $meta = get_case_study_meta(); if ($meta[0]) echo "<strong>$meta[0]</strong>"; ?>
					<?php $meta = get_case_study_meta();
					if ($meta[2]) {echo " | <a href='$meta[2]' target='_blank'>$meta[1]</a>";}
					elseif ($meta[1]) {echo " | $meta[1]";}
					?>
				</div>
			</div>
			<?php thesis_content_column(); ?>
		</div>
	</div>
	<div class="one_third last">
		<div class="lead-gen">
			<h3 align="center">Download<br />All Case Studies</h3>
			<p>Read all of Socrata's stories of customer success, and receive any updates.</p>
			<iframe src="http://discover.socrata.com/Open-Data-Case-Study-Bundle.html" width="247" height="315" frameborder=”0” scrolling="no" style="border:none;"></iframe>
		</div>		
		<?php $meta = get_case_study_meta(); if ($meta[5]) echo "<div class='highlights'>$meta[5]</div>"; ?>
		
	</div>
	<div class="clearboth"></div>
</div>
<?php wp_enqueue_style( 'case_study_styles' ); ?>