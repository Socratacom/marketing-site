<div class="container search-container">
    <div class="col-sm-3">
        <div class="facet-wrapper">
            <h3>Found In...</h3>
            <?php echo do_shortcode('[facetwp facet="post_types"]'); ?>
        </div>
        <div class="facet-wrapper">
            <h4>Categories</h4>
            <?php echo do_shortcode('[facetwp facet="categories"]'); ?>
        </div>
        <div class="facet-wrapper">
            <h4>Socrata News</h4>
            <?php echo do_shortcode('[facetwp facet="socrata_news"]'); ?>
        </div>
        <div class="facet-wrapper">
            <h4>Case Studies</h4>
            <?php echo do_shortcode('[facetwp facet="case_studies"]'); ?>
        </div>
        <div class="facet-wrapper">
            <h4>Tech Blog</h4>
            <?php echo do_shortcode('[facetwp facet="tech_blog"]'); ?>
        </div>
    </div>
    <div class="col-sm-9">
        <?php //not sure if this is wanted or not
        //get_template_part('templates/page', 'header'); ?>
        <div style="padding-bottom:1em; margin-bottom:1em;">

            <form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>" class="mobile-hide">
                <input type="search" class="search-field" placeholder="Search …" value="<?php printf( __( '%s'), get_search_query() ); ?>" name="s" title="Search for:" style="font-size:1em; border:#d1d1d1 solid 1px; width:60%; padding:.6em; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px;" />
                <a href="javascript:void(0)" id="searchsubmit" class="search-button button ss-icon">search</a>
            </form>
        </div>
        <div class="clearfix">
            <?php echo do_shortcode( '[facetwp counts="true"]' ) . ' RESULTS'; ?>
        </div>
        <?php echo do_shortcode( '[facetwp template="site_search"]' ); ?>
        <?php echo do_shortcode('[facetwp pager="true"]'); ?>

    </div>
</div>
