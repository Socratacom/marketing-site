<div id="top" style="position:relative;">
<div class="home-btn"><a href="/government-performance-management-playbook/" class="ir">The Government Perfomance Management Playbook</a></div>
<label class="btn" for="toggle"><span class="ir icon">Chapters</span></label>
<input id="toggle" type="checkbox" />
<nav>
  <ul id="nav" class="fade-in"><?php thesis_default_widget('gpmp-menu'); ?></ul>
</nav>
<?php $guide_meta = get_gpmp_meta();
  echo "<p class='chapter-name center'>$guide_meta[0]</p>";
?>
<h1 class="headline" style="max-width:500px; margin-bottom:50px;"><?php the_title(); ?></h1>
<?php the_content(); ?>
<hr/>
<section class="next-previous clearfix">
<?php next_post('%', 'Previous Chapter: ', 'yes'); ?>
<?php previous_post('%', 'Next Chapter: ', 'yes'); ?>
</section>
</div>
