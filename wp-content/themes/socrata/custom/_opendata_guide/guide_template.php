<div id="content top" style="position:relative;">
<div class="format_text">
<a href="/open-data-field-guide/" class="button"><span class="ss-icon">book</span></a>
<label class="button" for="toggle">Chapters</label>
<input id="toggle" type="checkbox" />
<nav>
  <ul id="nav" class="fade-in"><?php thesis_default_widget('open-data-guide-menu'); ?></ul>
</nav>
<?php $guide_meta = get_guide_meta();
  echo "<p class='chapter-name center'>$guide_meta[0]</p>";
?>
<h1 class="headline"><?php the_title(); ?></h1>
<!--<?php echo do_shortcode('[guide-cta-buttons]') ?>-->
<hr/>
</div>
<?php thesis_content_column(); ?>
<hr/>
<section class="next-previous clearfix">
<?php next_post('%', 'Previous Chapter: ', 'yes'); ?>
<?php previous_post('%', 'Next Chapter: ', 'yes'); ?>
</section>
<hr/>
<?php echo do_shortcode('[guide-cta-buttons]') ?>
</div>