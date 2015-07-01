<?php

add_action('thesis_hook_custom_template', 'custom_homepage');
function custom_homepage() {
	if (is_page('home')) { ?>	
    <?php echo do_shortcode('[hero-image]'); ?>
    <section class="format_text home-ctas">
        <div class="wrapper">
            <?php echo do_shortcode('[cta-group category="homepage"]'); ?>
        </div>       
    </section>
	<section class="format_text home-sector-content">
		<div class="wrapper">
			<div class="one_fourth">
                <div class="home-post-wrapper">
                    <a href="/industries/open-data-state-local-government/" class="home-post-link"></a>
                    <h4 style="position:absolute; z-index: 10; text-align: center; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; padding:10%; width:100%; line-height: 1em; margin:0; ">State and Local Government</h4>                     
                    <div class="home-post-overlay" style="height:97%;"></div>
                    <img src="/wp-content/themes/socrata/custom/images/cities-local.jpg" style="width:100%;">
                </div>                
            </div>            
            <div class="one_fourth">
                <div class="home-post-wrapper">
                    <a href="/industries/open-data-federal-governments/" class="home-post-link"></a>
                    <h4 style="position:absolute; z-index: 10; text-align: center; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; padding:10%; width:100%; line-height: 1em; margin:0; color:#fff; text-shadow: 0 0 3px black; ">Federal Government</h4>                     
                    <div class="home-post-overlay" style="height:97%;"></div>
                    <img src="/wp-content/themes/socrata/custom/images/federal.jpg" style="width:100%;">
                </div>
            </div>
			<div class="one_fourth">
                <div class="home-post-wrapper">
                    <a href="/industries/open-data-multilateral-ngo/" class="home-post-link"></a>
                    <h4 style="position:absolute; z-index: 10; text-align: center; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; padding:10%; width:100%; line-height: 1em; margin:0; color:#fff; text-shadow: 0 0 3px black;">Multilateral &amp; Non-Governmental Organizations</h4>        
                    <div class="home-post-overlay" style="height:97%;"></div>
                    <img src="/wp-content/themes/socrata/custom/images/ngo.jpg" style="width:100%;">
                </div>
            </div>
            <div class="one_fourth last">
                <div class="home-post-wrapper">
                    <a href="/industries/health-data-access-management/" class="home-post-link"></a>
                    <h4 style="position:absolute; z-index: 10; text-align: center; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; padding:10%; width:100%; line-height: 1em; margin:0; ">Public Health</h4>                     
                    <div class="home-post-overlay" style="height:97%;"></div>
                    <img src="/wp-content/themes/socrata/custom/images/healthcare.jpg" style="width:100%;">
                </div>
            </div>
			<div class="clearboth"></div>
		</div>
	</section>	
    <section class="format_text home-posts">
		<div class="wrapper">
    		<div class="one_half">
    		<?php $blog_query = new WP_Query('post_type=post&orderby=desc&showposts=1'); while ($blog_query->have_posts()) : $blog_query->the_post(); ?>
    			<div class="home-post-wrapper">
    				<a href="<?php the_permalink() ?>" class="home-post-link"></a>
    				<div class="home-post-meta">
    					<h3><?php the_title(); ?></h3>
    					<div class="home-post-author">
    						<div style="float:left; width:54px;">
    							<?php echo get_avatar( get_the_author_id(), 64 ); ?>    						
    						</div>
    						<div style="float:left; padding-left:20px; padding-top:5px;">
    							<strong>By</strong> <?php the_author(); ?><br><strong>Posted</strong> <?php the_time('F jS, Y') ?>
    						</div>
    						<div class="clearboth"></div>
    					</div>
    				</div>
    				<div class="home-post-overlay"></div>
    				<img src="<?php echo tuts_custom_img('full', 614, 614);?>" style="width:100%;" />
    			</div>    				
    		<?php endwhile; wp_reset_query(); ?>
    		</div>
    		<div class="one_fourth">
    			<ul>
    			<?php $blog_one_query = new WP_Query('post_type=post&orderby=desc&showposts=2&offset=1'); while ($blog_one_query->have_posts()) : $blog_one_query->the_post(); ?>
    				<li>
    					<div class="home-post-wrapper">
    						<a href="<?php the_permalink() ?>" class="home-post-link"></a>
                            <div class="home-post-meta-one">
                                <h4><?php the_title(); ?></h4>
                                <p style="margin:0;"><small><strong>By</strong> <?php the_author(); ?><br><strong>Posted</strong> <?php the_time('F jS, Y') ?></small></p>
                            </div>
    						<div class="home-post-overlay"></div>
    						<img src="<?php echo tuts_custom_img('full', 282, 282);?>" style="width:100%;" />
    					</div>    					
    				</li>
    			<?php endwhile; wp_reset_query(); ?>
    			</ul>
    		</div>
    		<div class="one_fourth last">
    			<ul>
    			<?php $blog_two_query = new WP_Query('post_type=post&orderby=desc&showposts=2&offset=3'); while ($blog_two_query->have_posts()) : $blog_two_query->the_post(); ?>
    				<li>
                        <div class="home-post-wrapper">
                            <a href="<?php the_permalink() ?>" class="home-post-link"></a>
                            <div class="home-post-meta-one">
                                <h4><?php the_title(); ?></h4>
                                <p style="margin:0;"><small><strong>By</strong> <?php the_author(); ?><br><strong>Posted</strong> <?php the_time('F jS, Y') ?></small></p>
                            </div>
                            <div class="home-post-overlay"></div>
                            <img src="<?php echo tuts_custom_img('full', 282, 282);?>" style="width:100%;" />
                        </div>                      
                    </li>
    			<?php endwhile; wp_reset_query(); ?>
    			</ul>
    		</div>
    		<div class="clearboth"></div>
    	</div>
    </section>
    <section class="format_text home-other-stuff">

		<div class="wrapper">

    		<div class="one_third">
    			<ul>
    			<?php $news_query = new WP_Query('post_type=news&orderby=desc&showposts=4'); while ($news_query->have_posts()) : $news_query->the_post(); ?>
    				<li><p><small>SOCRATA NEWS</small><a href="<?php the_permalink() ?>"><?php the_title(); ?></a><small><strong>By</strong> <?php the_author(); ?> &bull; <strong>Posted</strong> <?php the_time('F jS, Y') ?></p></small></li>
    			<?php endwhile; wp_reset_query(); ?>
    			</ul>
    		</div>

    		<div class="one_third">    			
    			<ul>
    			<?php $case_study_query = new WP_Query('post_type=case_study&orderby=desc&showposts=4'); 
    			while ($case_study_query->have_posts()) : $case_study_query->the_post(); ?>
    				<li>
    					<div class="one_third" style="padding-top:3px;">
    						<a href="<?php the_permalink() ?>"><img src="<?php echo tuts_custom_img('full', 80, 80);?>" style="width:90%; margin-bottom:15px" /></a>
    					</div>
    					<div class="two_third last">
    						<p><small>CASE STUDY</small><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></p>
    					</div>
    					<div class="clearboth"></div>
    				</li>
    			<?php endwhile; wp_reset_query(); ?>    		
    			</ul>
    		</div>    		

    		<div class="one_third last"><a class="twitter-timeline" href="https://twitter.com/socrata" data-widget-id="435899899599532032" data-chrome="nofooter transparent" data-tweet-limit="4">Tweets by @socrata</a><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
            </div>

    		<div class="clearboth"></div>

    	</div>

    </section>
    <!--<section  class="format_text home-mobile-stuff">
        <div class="wrapper">
        Mobile Queries here
        </div>
    </section>-->
	<?php }
}




