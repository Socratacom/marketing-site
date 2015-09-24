<div class="feature-image hidden-xs" style="background-image: url(<?php echo Roots\Sage\Extras\custom_feature_image('full', 1600, 400); ?>);">
  <div class="pattern-overlay"></div>
</div>
<?php echo do_shortcode('[image-attribution]'); ?>
<?php
  $meta = get_attribution_meta(); 
  if ($meta[1]) {
    echo "<div class='image-attribution'>Photo: <a href='$meta[1]' target='_blank'>$meta[0]</a></div>";
  } elseif ($meta[0]) {
    echo "<div class='image-attribution'>Photo: $meta[0]</div>";
  } 
?>
<div class="container">
	<div class="row">
		<div class="col-sm-2">
		<?php $meta = get_socrata_stories_meta(); 
		  if ($meta[6]) { ?>
		    <img src="<?php echo stories_custom_logo( 'full', 200 ); ?>" class="img-responsive" >
		  <?php
		  } 
		?>
		</div>
		<div class="col-sm-6">
			<h1><?php the_title(); ?></h1>
			<ul class="meta">
				<?php $meta = get_socrata_stories_meta();
				if ($meta[2]) {echo "<li><a href='$meta[2]' target='_blank'>$meta[1]</a></li>";}
				elseif ($meta[1]) {echo "<li>$meta[1]</li>";}
				?>
				<?php $meta = get_socrata_stories_meta(); if ($meta[3]) {echo "<li><span>Live Since</span> $meta[3]</li>";} ?>
				<?php $meta = get_socrata_stories_meta(); if ($meta[4]) {echo "<li><a href='$meta[5]' target='_blank'>$meta[4]</a></li>";} ?>
			</ul>
			<?php the_content(); ?>
			<?php $meta = get_socrata_stories_meta(); if ($meta[13]) { ?>			
				<hr/>
				<h4>Press</h4>
				<ul class="press">         
				<?php $meta = get_socrata_stories_meta(); if ($meta[13]) {echo "<li><a href='$meta[14]' target='_blank'>$meta[13]</a><small>- $meta[20]</small></li>";} ?>
				<?php $meta = get_socrata_stories_meta(); if ($meta[15]) {echo "<li><a href='$meta[16]' target='_blank'>$meta[15]</a><small>- $meta[21]</small></li>";} ?>
				<?php $meta = get_socrata_stories_meta(); if ($meta[17]) {echo "<li><a href='$meta[18]' target='_blank'>$meta[17]</a><small>- $meta[22]</small></li>";} ?>
				</ul>			    
			<?php } ?>
		</div>
		<div class="col-sm-4">
			d
		</div>
	</div>
</div>