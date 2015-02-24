<div class="one_fourth sidebar">
	<h4>Chapters</h4>
	<?php wp_nav_menu( array( 'theme_location' => 'field_guide' ) ); ?>
</div>
<div class="three_fourth last">
	<?php $guide_meta = get_guide_meta(); echo "<p class='chapter'>$guide_meta[0]</p>"; ?>
	<h1><?php the_title(); ?></h1>
	<!-- AddThis Button BEGIN -->
	<div class="addthis_sharing_toolbox"></div>
	<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4e590fc12e22e79e" async="async"></script>
	<!-- AddThis Button END -->
	<?php thesis_content_column(); ?>
	<hr/>
	<ul class="chapter-nav">
		<li><?php next_post('%', '<strong>Previous Chapter:</strong> ', 'yes'); ?></li>
		<li><?php previous_post('%', '<strong>Next Chapter:</strong> ', 'yes'); ?></li>
	</ul>
</div>
<div class="clearboth"></div>
<hr/>
<div class="format_text">
<?php echo do_shortcode('[cta-group category="open-data-field-guide"]') ?>
</div>



<!--		
<nav>
<ul id="nav" class="fade-in"><?php thesis_default_widget('open-data-guide-menu'); ?></ul>
</nav>
<hr/>
<section class="next-previous clearfix">
<?php next_post('%', 'Previous Chapter: ', 'yes'); ?>
<?php previous_post('%', 'Next Chapter: ', 'yes'); ?>
</section>
<hr/>
<?php echo do_shortcode('[guide-cta-buttons]') ?>
<?php echo do_shortcode('[guide-cta-buttons]') ?>
-->