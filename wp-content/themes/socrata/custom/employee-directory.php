<div class="one_fourth profile-image">
	<div class="format_text">
  	<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'case-study-thumb' ); $url = $thumb['0']; ?>
 	<div style="margin-bottom:.8em;"><img src="<?=$url?>" style="width:100%"></div>
 	<ul>
 	<?php $meta = get_employee_directory_meta(); if ($meta[2]) echo "<li><span class='ss-icon'>phone</span>$meta[2]</li>"; ?>
 	<?php $meta = get_employee_directory_meta(); if ($meta[1]) 
 		echo "<li><span class='ss-icon'>email</span><a href='mailto:$meta[1]'>Email ";
 		echo the_title();
 		echo "</a></li>"; 
 	?>
 	<?php $meta = get_employee_directory_meta(); if ($meta[3]) echo "<li><span class='icon-twitter'></span><a href='$meta[3]' target='_blank'>Follow</a></li>"; ?>
 	<?php $meta = get_employee_directory_meta(); if ($meta[4]) echo "<li><span class='icon-linkedin'></span><a href='$meta[4]' target='_blank'>Linked In Profile</a></li>"; ?>
 	</ul>
 	</div>
</div>
<div class="one_half">
	<div class="format_text">
  	<h1><?php the_title(); ?></h1>
  	<?php $meta = get_employee_directory_meta(); if ($meta[0]) echo "<h3 style='font-weight:300; margin-top:-.8em;'>$meta[0]</h3>"; ?>
  	</div>
  	<?php thesis_content_column(); ?>
</div>
<div class="one_fourth last employee-sidebar">
	<div class="clearfix" style="margin-bottom:3em;">
  <?php
  $team_query = new WP_Query('post_type=employee_directory&orderby=rand&showposts=1000');
  while ($team_query->have_posts()) : $team_query->the_post(); ?>
  <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail' ); $url = $thumb['0']; ?>  
      <a href="<?php the_permalink() ?>"><img src="<?=$url?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"></a>      
  <?php endwhile; ?>
  <?php wp_reset_query(); ?>
	</div>

  <p><a href="/careers/" class="button">Join The Team</a></p>
</div>
<div class="clearboth"></div>