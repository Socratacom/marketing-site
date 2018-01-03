<section class="section-padding">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 margin-bottom-60">

				<?php if ( have_posts() ) : ?>
					
				<h3 class="margin-bottom-15">Search Results for <?php $allsearch = new WP_Query("s=$s&showposts=-1"); $key = wp_specialchars($s, 1); $count = $allsearch->post_count; _e('<strong>'); echo $key; _e('</strong>'); ?></h3>
				<p class="font-semi-bold color-grey" style="font-size: 14px;"><?php echo $count . ' '; _e('results'); wp_reset_query(); ?></p>
				<?php get_search_form(); ?>

				<?php while (have_posts()) : the_post(); {

					if ( get_post_type() == 'case_study' ) { ?>

					<article class="search-result">
					<h4 class="entry-title margin-bottom-0"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
					<p class="margin-bottom-5 font-normal"><small><span class="text-uppercase">Case Study</span> <a href="<?php the_permalink(); ?>"><?php the_permalink(); ?></a></small></p>
					<p><?php echo case_studies_excerpt(); ?></p>
					</article>

					<?php }

					elseif ( get_post_type() == 'page' ) { ?>

					<article class="search-result">
					<h4 class="entry-title margin-bottom-0"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
					<p class="margin-bottom-5 font-normal"><small><span class="text-uppercase">Page</span> <a href="<?php the_permalink(); ?>"><?php the_permalink(); ?></a></small></p>
					<?php the_excerpt(); ?> 
					</article>

					<?php }

					elseif ( get_post_type() == 'news' ) { 
						$news_link = rwmb_meta( 'news_url' );
						if ( has_term( 'press-releases','news_category' ) ) { ?>
							<article class="search-result">
							<h4 class="entry-title margin-bottom-0"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
							<p class="margin-bottom-5 font-normal"><small><span class="text-uppercase"><?php news_the_categories(); ?></span> <a href="<?php the_permalink(); ?>"><?php the_permalink(); ?></a></small></p>			
							<p><?php echo news_excerpt(); ?></p>
							</article>
						<?php } else { ?>
							<article class="search-result">
							<h4 class="entry-title margin-bottom-0"><a href="<?php echo $news_link;?>" target="_blank"><?php the_title(); ?></a></h4>
							<p class="margin-bottom-5 font-normal"><small><span class="text-uppercase">News Article</span> <a href="<?php echo $news_link;?>" target="_blank"><?php echo $news_link;?></a></small></p>
							</article>
						<?php }
					}

					elseif ( get_post_type() == 'socrata_videos' ) { ?>

					<article class="search-result">
					<h4 class="entry-title margin-bottom-0"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
					<p class="margin-bottom-5 font-normal"><small><span class="text-uppercase">Video</span> <a href="<?php the_permalink(); ?>"><?php the_permalink(); ?></a></small></p>
					<p><?php echo videos_excerpt(); ?></p>
					</article>

					<?php }

					elseif ( get_post_type() == 'socrata_webinars' ) { ?>

					<article class="search-result">
					<h4 class="entry-title margin-bottom-0"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
					<p class="margin-bottom-5 font-normal"><small><span class="text-uppercase">Webinar</span> <a href="<?php the_permalink(); ?>"><?php the_permalink(); ?></a></small></p>
					<p><?php echo webinars_excerpt(); ?></p>
					</article>

					<?php }

					else { ?>

					<article class="search-result">
					<h4 class="entry-title margin-bottom-0"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>	
					<p class="margin-bottom-5 font-normal"><small><span class="text-uppercase">Blog</span> <a href="<?php the_permalink(); ?>"><?php the_permalink(); ?></a></small></p>
					<?php the_excerpt(); ?>
					</article>	

					<?php }

				} ?>

				<?php endwhile; ?>

				<?php the_posts_pagination( array(
					'mid_size'  => 2,
					'prev_text' => __( 'Back', 'textdomain' ),
					'next_text' => __( 'Next', 'textdomain' ),
				)); ?>

				<?php else : ?>

				<h3 class="margin-bottom-15">Sorry, no results were found</h3>
				<?php get_search_form(); ?>

				<?php endif; ?>

			</div>
			<div class="col-sm-12">
				<h3>Can't find what you're looking for?</h3>
				<p><strong>Search tips:</strong> Make sure all words are spelled correctly or try different keywords. If you are still having trouble, <a href="/contact-us">contact us</a></p>
			</div>
		</div>
	</div>
</section>


