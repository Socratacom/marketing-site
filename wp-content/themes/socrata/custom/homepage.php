<?php

add_action('thesis_hook_custom_template', 'custom_homepage');
function custom_homepage() {
	if (is_page('home')) { ?>	
    <?php echo do_shortcode('[hero-image]'); ?>
    <?php echo do_shortcode('[cta-group category="homepage"]'); ?>
    <section class="section-padding industries">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="industry cities">
                        <div class="industry-text">
                            <h5>Socrata for State and Local Government</h5>
                            <p><a href="">Read More <i class="fa fa-chevron-right"></i></a></p>
                        </div>
                    </div>                    
                </div>
                <div class="col-sm-3">
                    <div class="industry federal">                        
                        <div class="industry-text">
                            <h5>Socrata for Federal Government</h5>
                            <p><a href="">Read More <i class="fa fa-chevron-right"></i></a></p>
                        </div>
                    </div>  
                </div>
                <div class="col-sm-3">
                    <div class="industry ngo">                        
                        <div class="industry-text">
                            <h5>Socrata for Multilateral &amp; Non-Governmental Organizations</h5>
                            <p><a href="">Read More <i class="fa fa-chevron-right"></i></a></p>
                        </div>
                    </div>  
                </div>
                <div class="col-sm-3">
                    <div class="industry healthcare">                        
                        <div class="industry-text">
                            <h5>Socrata for Public Health</h5>
                            <p><a href="">Read More <i class="fa fa-chevron-right"></i></a></p>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </section>
    <section class="home-posts section-padding">
        <div class="container ">
            <div class="row">
                <div class="col-sm-12">
                    <h2 class="text-center">Latest News</h2>
                </div>
                <?php $blog_query = new WP_Query('post_type=post&orderby=desc&showposts=4'); while ($blog_query->have_posts()) : $blog_query->the_post(); ?>
                <div class="col-sm-6 col-md-3">
                    <article>
                        <a href="<?php the_permalink() ?>"><img src="<?php echo tuts_custom_img('full', 320, 240); ?>" class="img-responsive"></a>
                        <div class="avatar-wrapper hidden-sm hidden-xs">
                            <?php echo get_avatar( get_the_author_id(), 60 ); ?>
                        </div>
                        <div class="article-text">
                            <small class="categories"><?php blog_the_categories(); ?></small>
                            <h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
                            <small>By <?php the_author(); ?>, <?php the_time('F jS, Y') ?></small>
                        </div>
                    </article>
                </div>                  
                <?php endwhile; wp_reset_query(); ?>
            </div>
            <div class="row additional-news">
                <div class="col-sm-3">
                    <h4>Tech Blog</h4>
                    <ul>
                        <?php $case_study_query = new WP_Query('post_type=tech_blog&orderby=desc&showposts=4'); 
                        while ($case_study_query->have_posts()) : $case_study_query->the_post(); ?>
                        <li><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></li>
                        <?php endwhile; wp_reset_query(); ?>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h4>Press Releases</h4>
                    <ul>
                        <?php $case_study_query = new WP_Query('post_type=news&orderby=desc&showposts=4'); 
                        while ($case_study_query->have_posts()) : $case_study_query->the_post(); ?>
                        <li><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></li>
                        <?php endwhile; wp_reset_query(); ?>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h4>Case Studies</h4>
                    <ul>
                        <?php $case_study_query = new WP_Query('post_type=case_study&orderby=desc&showposts=4'); 
                        while ($case_study_query->have_posts()) : $case_study_query->the_post(); ?>
                        <li><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></li>
                        <?php endwhile; wp_reset_query(); ?>
                    </ul>
                </div>
                <div class="col-sm-3 hidden-xs">
                    <h4>Follow us on Twitter</h4>
                    <a class="twitter-timeline" href="https://twitter.com/socrata" data-widget-id="435899899599532032" data-chrome="noheader nofooter transparent" data-tweet-limit="2">Tweets by @socrata</a><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                </div>
            </div>
        </div>
    </section>
    <?php echo do_shortcode('[newsletter-footer]'); ?>
	<?php }
}




