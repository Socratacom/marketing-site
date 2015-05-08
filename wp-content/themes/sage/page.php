<?php while (have_posts()) : the_post(); ?>
<section>
  <div class="jumbotron">
    <?php
    if( have_rows('hero') ):
      while ( have_rows('hero') ) : the_row();
        // get vars
        $rtp_id = get_sub_field('rtp_id');
        $background = get_sub_field('slider_image');
        $small_text = get_sub_field('header_small_text');
        $large_text = get_sub_field('header_large_text');
        $italic_text = get_sub_field('header_italic_text');
        if( have_rows('cta') ):
          while ( have_rows('cta') ) : the_row();
            $link = '';
            $link_text = '';
            if( get_row_layout() == 'internal_link' ):
              $link = get_sub_field('internal_link');
              $link_text = get_sub_field('internal_link_text');
            elseif( get_row_layout() == 'external_link' ):
              $link = get_sub_field('external_link');
              $link_text = get_sub_field('external_link_text');
            endif;
          endwhile;
        endif;

        echo '<div id="' . $rtp_id . '">
                <div class="slide" style="background-image: url(' . $background . ');">
                  <div class="container">
                    <div class="col-sm-8 col-md-8 col-lg-6">';
                echo '<div class="jumbotron-textContainer">
                        <h1>' . $large_text . '</h1>
                        <h2>' . $small_text . '</h2>';
                        if ($link) {
                          echo '<a href="' . $link . '" class="button">' . $link_text . '</a>';
                        }
                      echo '</div>
                    </div>
                  </div>
                </div>
              </div>';
      endwhile;
    else :
      // no hero found
    endif;
    ?>
  </div>

</section>
<div class="container">
  <?php get_template_part('templates/content', 'page'); ?>
</div>
<?php endwhile; ?>
