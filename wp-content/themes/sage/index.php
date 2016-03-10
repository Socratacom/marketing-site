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
			<?php $my_query = new WP_Query( 'post_type=post&posts_per_page=1' );
			while ( $my_query->have_posts() ) : $my_query->the_post(); ?>
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
			<?php wp_reset_postdata(); ?>
			<div id="boobs">
			<?php get_template_part('templates/content', get_post_type() != 'post' ? get_post_type() : get_post_format()); ?>
			</div>
			<script>
			function cat_ajax_get(catID) {
			    jQuery("a.ajax").removeClass("current");
			    jQuery("a.ajax").addClass("current"); //adds class current to the category menu item being displayed so you can style it with css
			    var ajaxurl = '<?php echo admin_url( 'admin-ajax.php' ); //must echo it ?>';
			    jQuery.ajax({
			        type: 'POST',
			        url: ajaxurl,
			        data: {"action": "load-filter", cat: catID },
			        success: function(response) {
			            jQuery("#boobs").html(response);
			            return false;
			        }
			    });
			}
			</script>
		</div>
		<div class="col-sm-3 hidden-xs">
		
<?php $categories = get_categories(); ?>
<ul id="category-menu">
    <?php foreach ( $categories as $cat ) { ?>
    <li id="cat-<?php echo $cat->term_id; ?>"><a class="<?php echo $cat->slug; ?> ajax" onclick="cat_ajax_get('<?php echo $cat->term_id; ?>');" href="#"><?php echo $cat->name; ?></a></li>
    <?php } ?>
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





