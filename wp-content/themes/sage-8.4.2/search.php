<section class="section-padding">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-8 col-md-offset-2">

				<?php if (!have_posts()) : ?>
					<div class="alert alert-warning">
						<?php _e('Sorry, no results were found.', 'sage'); ?>
					</div>
				<?php endif; ?>
				<?php get_search_form(); ?>


<?php while (have_posts()) : the_post(); {

	if ( get_post_type() == 'case_study' ) { ?>

	<article>
	<h4 class="entry-title margin-bottom-0"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
	<p>Case Study</p>
	</article>

	<?php }

	elseif ( get_post_type() == 'page' ) { ?>

	<article>
	<h4 class="entry-title margin-bottom-0"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
	<p>Page</p>
	</article>

	<?php }

	elseif ( get_post_type() == 'news' ) { 
		$news_link = rwmb_meta( 'news_url' );
		if ( has_term( 'press-releases','news_category' ) ) { ?>
			<article>
			<h4 class="entry-title margin-bottom-0"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
			<?php news_the_categories(); ?>
			<p><?php echo news_excerpt(); ?></p>
			</article>
		<?php } else { ?>
			<article>
			<h4 class="entry-title margin-bottom-0"><a href="<?php echo $news_link;?>"><?php the_title(); ?></a></h4>
			<p>News Article</p>
			</article>
		<?php }
	



	

	}

	elseif ( get_post_type() == 'socrata_videos' ) { ?>

	<article>
	<h4 class="entry-title margin-bottom-0"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
	<p>Video</p>
	</article>

	<?php }

	elseif ( get_post_type() == 'socrata_webinars' ) { ?>

	<article>
	<h4 class="entry-title margin-bottom-0"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
	<p>Webinar</p>
	</article>

	<?php }

	else { ?>


	<article>

	<h4 class="entry-title margin-bottom-0"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
	<p>I'm a blog article</p>
	<!--<?php if (get_post_type() === 'post') { get_template_part('templates/entry-meta'); } ?>-->

	<div class="entry-summary">
	<?php the_excerpt(); ?>
	</div>
	</article>	

	<?php }





} ?>

<?php endwhile; ?>

				<?php the_posts_navigation(); ?>
				


			</div>
		</div>
	</div>
</section>


