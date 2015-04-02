<?php
/**
 * Template Name: Cloud
 */


$intro_headline = get_field('intro_headline');
$intro_subhead = get_field('intro_subhead');
$intro_body = get_field('intro_body');

$features_headline = get_field('features_headline');
$features_body = get_field('features_body');
$features_video_thumbnail = get_field('features_video_thumbnail');

?>


<?php while (have_posts()) : the_post(); ?>
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
        else :
          // no layouts found
        endif;

        echo '<div id="'.$rtp_id.'"><div class="slide" style="background-image: url('.$background.');"><div class="container"><div class="col-sm-10 col-sm-offset-1">';
          echo '<h1>';
          if ($small_text) {
            echo '<span class="smaller-text">'.$small_text.'</span>';
          }
          if ($large_text) {
            echo $large_text;
          }
          echo '</h1>';
          if ($italic_text) {
            echo '<h2>'.$italic_text.'</h2>';
          }
          if ($link) {
            echo '<a href="'.$link.'" class="button">'.$link_text.'</a>';
          }
        echo '</div></div></div></div>';
      endwhile;
    else :
      // no hero found
    endif;
    ?>
  </div>
<section id="cta-links">
  <div class="container">
    <div class="row">

    <?php
      if( have_rows('cta_tiles', 'option') ):
        while ( have_rows('cta_tiles', 'option') ) : the_row();

          $tile_icon = get_sub_field('tile_icon', 'option');
          $tile_headline = get_sub_field('tile_headline', 'option');
          $tile_body = get_sub_field('tile_body', 'option');
          $tile_button_text = get_sub_field('tile_button_text', 'option');
          $tile_button_link = get_sub_field('tile_button_link', 'option');
          echo '<div class="col-md-4">
                  <div class="features-tile">
                    <div class="tile-icon">
                      <i class="fa ' . $tile_icon . ' blue"></i>
                    </div>
                    <div class="tile-content">
                      <div class="content-text">
                        <div class="text-headline">
                          <h3>' . $tile_headline . '</h3>
                        </div>
                        <div class="text-body">
                          <p>' . $tile_body . '</p>
                        </div>
                      </div>
                      <div class="content-button">
                        <a href="' . $tile_button_link . '" class="btn btn-primary">' . $tile_button_text . '</a>
                      </div>
                    </div>
                  </div>
                </div>';
        endwhile;
      endif;
    ?>

    </div>
  </div>
</section>
<?php endwhile; ?>
