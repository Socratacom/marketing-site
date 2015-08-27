<div class="feature-image" style="background-image: url(<?php echo tuts_custom_img('full', 1600, 400); ?>);">
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
<div class="container blog-content-wrapper">
	<div class="row">
		<div class="col-sm-8 col-md-7 col-md-offset-1 article-content">
			<small class="category-name">Case Study: <?php case_study_the_categories(); ?></small>
			<h1><?php the_title(); ?></h1>
			<ul class="article-meta">
				<?php $meta = get_case_study_meta(); if ($meta[0]) echo "<li>$meta[0]</li>"; ?>
				<?php $meta = get_case_study_meta();
				if ($meta[2]) {echo "<li><a href='$meta[2]' target='_blank'>$meta[1]</a></li>";}
				elseif ($meta[1]) {echo "<li>$meta[1]</li>";}
				?>
			</ul>
			<div class="marketo-share">
				<?php echo do_shortcode( '[marketo-share]' ); ?>
			</div>	
			<?php thesis_content_column(); ?>
		</div>
		<div class="col-sm-4 col-md-3">	
			<?php $meta = get_case_study_meta(); if ($meta[4]) {echo "
			<div class='quote-wrapper'>
				<p class='quote'>&quot;$meta[3]&quot;</p>
				<p class='author'>- $meta[4]</p>
			</div>";} elseif ($meta[3]) {echo "
			<div class='quote-wrapper'>
				<p class='quote'>&quot;$meta[3]&quot;</p>
			</div>";} ?>
			<?php $meta = get_case_study_meta(); if ($meta[5]) echo "<div class='highlights'>$meta[5]</div>"; ?>
			<?php echo do_shortcode('[newsletter-sidebar]'); ?>	
		</div>	
	</div>
</div>