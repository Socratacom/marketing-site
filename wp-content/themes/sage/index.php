<div class="container page-padding">
	
	<div class="row">
		<div class="col-sm-9">
			<div class="row">
				<?php 
		if (is_category()){ ?>
			<div class="col-sm-12">
				<h3 class="archive-title"><?php single_cat_title('Open Data Blog: '); ?></h3>
				<hr/>
			</div>
		<?php
		}
	?>
				<?php $my_query = new WP_Query( 'post_type=post&posts_per_page=1' );
				while ( $my_query->have_posts() ) : $my_query->the_post();
				$do_not_duplicate = $post->ID; ?>
				<div class="col-sm-12">
					<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'post-image' ); $url = $thumb['0']; ?>
					<div class="featured-post overlay-black" style="background-image: url(<?=$url?>);">				
						<div class="text truncate">
							<div class="post-category background-peter-river">Open Data Blog</div>
							<h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>	
						</div>				
						<?php get_template_part('templates/entry-meta'); ?>
						<a href="<?php the_permalink() ?>" class="link"></a>
					</div>
				</div>
				<?php endwhile; ?>
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
				if ( $post->ID == $do_not_duplicate ) continue; ?>
					<?php get_template_part('templates/content', get_post_type() != 'post' ? get_post_type() : get_post_format()); ?>
				<?php endwhile; endif; ?>
			</div>
			
					<?php if (function_exists("pagination")) {pagination($additional_loop->max_num_pages);} ?>

		</div>
		<div class="col-sm-3 hidden-xs">			
			<?php
	          //list terms in a given taxonomy using wp_list_categories  (also useful as a widget)
	          $orderby = 'name';
	          $show_count = 0; // 1 for yes, 0 for no
	          $pad_counts = 0; // 1 for yes, 0 for no
	          $hide_empty = 1;
	          $hierarchical = 1; // 1 for yes, 0 for no
	          $taxonomy = 'category';
	          $title = 'Blog Categories';

	          $args = array(
	            'orderby' => $orderby,
	            'show_count' => $show_count,
	            'pad_counts' => $pad_counts,
	            'hide_empty' => $hide_empty,
	            'hierarchical' => $hierarchical,
	            'taxonomy' => $taxonomy,
	            'title_li' => '<h5>'. $title .'</h5>'
	          );
	        ?>
			
	        <ul class="category-nav blog-nav">
	          <?php wp_list_categories($args); ?>
	        </ul>
			<?php echo do_shortcode('[newsletter-sidebar]'); ?>
			<div class="subscribe">
	           	<ul>	           		
	           		<li><a class="twitter-follow-button" href="https://twitter.com/socrata" data-size="large">Follow @Socrata</a></li>
	           		<li><a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS'); ?>" target="_blank" class="btn btn-warning"><i class="fa fa-rss"></i> <?php _e('FEED'); ?></a></li>
	           	</ul>
				<script>window.twttr = (function(d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0],
				t = window.twttr || {};
				if (d.getElementById(id)) return t;
				js = d.createElement(s);
				js.id = id;
				js.src = "https://platform.twitter.com/widgets.js";
				fjs.parentNode.insertBefore(js, fjs);

				t._e = [];
				t.ready = function(f) {
				t._e.push(f);
				};

				return t;
				}(document, "script", "twitter-wjs"));</script>
           </div>
		</div>
	</div>
</div>





