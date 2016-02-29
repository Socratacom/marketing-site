<div class="container page-padding">
	<div class="row">
		<div class="col-sm-12">
			<div class="background-clouds padding-15 margin-bottom-30">
				cheese
			</div>
		</div>
	</div>	
	<div class="row">
		<div class="col-sm-9">
			<?php get_template_part('templates/content', get_post_type() != 'post' ? get_post_type() : get_post_format()); ?>
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





