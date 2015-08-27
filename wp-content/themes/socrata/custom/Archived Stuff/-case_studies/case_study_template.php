<div class="hero format_text">
	<?php $meta = get_case_study_meta();
		if ($meta[0]) echo "<div class='banner-title'> $meta[0]</div>"; ?>
	<h1><?php the_title(); ?></h1>
	<div class="overlay"></div>
	<?php $bigimage = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'feature-image' ); $url = $bigimage['0']; ?>
    <img src="<?=$url?>" style="width:100%">
</div>
<div class="two_third">
	<?php thesis_content_column(); ?>
</div>
<div class="one_third last format_text case-study-sidebar">
	<section>
	<div class="social">
		<!-- AddThis Button BEGIN -->
		<div class="addthis_toolbox addthis_default_style ">
			<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
			<a class="addthis_button_tweet"></a>
			<a class="addthis_counter addthis_pill_style"></a>
		</div>
		<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4e590fc12e22e79e"></script>
		<!-- AddThis Button END -->
	</div>
	<?php $meta = get_case_study_meta(); if ($meta[7]) echo "<div class='lead-gen'>$meta[7]</div>"; ?>
	<?php $logo = MultiPostThumbnails::get_post_thumbnail_url('case_study','secondary-image', NULL, 'medium-square'); if ($logo) echo "<img src='$logo' style='width:100%' class='logo'>"; ?>		
	<ul class="sidebar-meta">
	<?php $meta = get_case_study_meta();
		if ($meta[2]) {echo "<li><h3>Site</h3><p><a href='$meta[2]' target='_blank'>$meta[1]</a></p></li>";}
		elseif ($meta[1]) {echo "<li><h3>Site</h3><p>$meta[1]</p></hr>";}
	?>
	<?php $meta = get_case_study_meta();
		if ($meta[4]) {echo "<li><p class='quote'>&quot;$meta[3]&quot;</p><p class='author'>- $meta[4]</p></li>";}
		elseif ($meta[3]) {echo "<li><p class='quote'>&quot;$meta[3]&quot;</p></li>";}
	?>
	<?php $meta = get_case_study_meta(); if ($meta[5]) echo "<li><h3>Press</h3>$meta[5]</li>"; ?>
	<?php $meta = get_case_study_meta(); if ($meta[6]) echo "<li>$meta[6]</li>"; ?>

    </ul>      
       
	</section>
</div>
<div class="clearboth"></div>
        




    
