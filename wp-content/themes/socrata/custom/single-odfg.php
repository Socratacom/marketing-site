<div class="container">
	<div class="row">
		<?php $meta = get_guide_meta(); if ($meta[2]) {echo "
		<div class='col-md-3 hidden-xs hidden-sm quick-links'>
			<div class='quick-links-wrapper'>
				<h4>Quick Links</h4>
				<div class='chapter-contents'>$meta[2]</div>
			</div>
		</div>";} ?>
		<div class=" <?php $meta = get_guide_meta(); if ($meta[2]) {echo "col-md-6";} else {echo "col-sm-9";} ?> guide-content">	
			<h1><?php the_title(); ?></h1>
			<?php echo do_shortcode( '[marketo-share]' ); ?>
			<?php thesis_content_column(); ?>
			<hr/>
			 <div>
		        <?php if( get_posts() ) {
		        previous_post_link('<p><strong><small>NEXT CHAPTER:</small><br>%link</strong></p>');
		        next_post_link('<p><strong><small>PREVIOUS CHAPTER:</small><br>%link</strong></p>');
		        }?>
		    </div>
		</div>
		<div class="col-sm-3 hidden-xs">
			<div class="chapters">
				<h3>Chapters</h3>
				<?php wp_nav_menu( array( 'theme_location' => 'field_guide' ) ); ?>
			</div>
			<?php echo do_shortcode('[newsletter-sidebar]'); ?> 
		</div>
	</div>
</div>
<hr/>
<?php echo do_shortcode('[cta-group category="open-data-field-guide"]') ?>