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
        <?php //get_template_part('templates/page', 'header'); ?>
        <div style="padding-bottom:1em; margin-bottom:1em;">

            <form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>" class="mobile-hide">
                <input type="search" class="search-field" placeholder="Search …" value="<?php printf( __( '%s'), get_search_query() ); ?>" name="s" title="Search for:" style="font-size:1em; border:#d1d1d1 solid 1px; width:60%; padding:.6em; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px;" />
                <a href="javascript:void(0)" id="searchsubmit" class="search-button button ss-icon">search</a>
            </form>
            <script>
                $(document).on("click",".search-button",function(){
                    var form = $(this).closest("form");
                    console.log(form);
                    form.submit();
                });
            </script>
        </div>
        <?php echo do_shortcode( '[facetwp counts="true"]' ); ?>
        <?php echo do_shortcode( '[facetwp template="site_search"]' ); ?>
        <?php echo do_shortcode('[facetwp pager="true"]'); ?>

    </div>
</div>

<script>
(function($) {
    $(document).on('facetwp-loaded', function() {
        // Scroll to the top of the page after the page is refreshed
        $('html, body').animate({ scrollTop: 0 }, 500);
     });
})(jQuery);
</script>
<script>
(function($) {
    $(function() {
        $(document).on('facetwp-loaded', function() {
            if ('site_search' == FWP.template) {
                $('.facetwp-facet').each(function() {
                    $(this).closest('.facet-wrapper').show();
                    if ('' == $(this).html()) {
                        $(this).closest('.facet-wrapper').hide();
                    }
                });
            }
        });
    });
})(jQuery);
</script>