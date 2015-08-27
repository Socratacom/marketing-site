<div class="container">
	<div class="row">
		<div class="col-sm-8 guide-content">
			<?php echo do_shortcode( '[marketo-share]' ); ?>
			<h1 class="title"><?php the_title(); ?></h1>
			<?php thesis_content_column(); ?>
			<hr/>
			 <div>
		        <?php if( get_posts() ) {
		        previous_post_link('<p><strong><small>NEXT CHAPTER:</small><br>%link</strong></p>');
		        next_post_link('<p><strong><small>PREVIOUS CHAPTER:</small><br>%link</strong></p>');
		        }?>
		    </div>
		</div>
		<div class="col-sm-4">
			<div class="chapters">
				<h3>Chapters</h3>
				<?php wp_nav_menu( array( 'theme_location' => 'field_guide' ) ); ?>
			</div>
			<?php echo do_shortcode('[newsletter-sidebar]'); ?> 
		</div>
	</div>
</div>
<?php echo do_shortcode('[cta-group category="open-data-field-guide"]') ?>
