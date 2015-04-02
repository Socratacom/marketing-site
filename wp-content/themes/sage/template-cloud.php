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

<section>
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

</section>


<section class="clouds">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <?php

        // get current URL to check against related page URL
        $current_page = get_the_permalink();

        if( have_rows('cloud', 'option') ):
          $c = true;
          while ( have_rows('cloud', 'option') ) : the_row();

            $related_page = get_sub_field('related_page', 'option');

            // display only the cloud tile with related page link that matches current URL
            if ($current_page === $related_page) {

              // Get vars
              $oddeven = $c = !$c;
              $title = get_sub_field('title', 'option');
              $icon = get_sub_field('cloud_icon', 'option');
              $headline = get_sub_field('headline', 'option');
              $content = get_sub_field('content', 'option');

                echo '<div class="col-sm-12 cloud" id="'.$icon.'"><div class="col-sm-4">';
                  if ($icon) {
                    echo '<span class="cloud-icon '.$icon.'"></span>';
                  }
                  if ($title) {
                    echo '<h2>'.$title.'</h2>';
                  }
                echo '</div>
                      <div class="col-sm-7 col-sm-offset-1">';
                  if ($headline) {
                    echo '<h3>'.$headline.'</h3>';
                  }
                  if ($content) {
                    echo $content;
                  }
                  if ($link) {
                    echo '<a href="'.$link.'" class="button">';
                    if ($link_text) {
                      echo $link_text;
                    } else {
                      echo 'Learn More';
                    }
                    echo '</a>';
                  }
                echo '</div>
                      <div class="col-sm-12 logos">';

                        if( have_rows('logos') ):
                          while( have_rows('logos') ): the_row();
                          $logo = get_sub_field('logo_image');
                            echo '<div class="slide col-sm-2"><img src="'.$logo['url'].'" alt="'.$logo['title'].'" class="img-responsive" id="js-image"></div>';
                          endwhile;
                        endif;

                  echo '</div>
                      </div>
                    ';
              }
          endwhile;
        else :
          // no rows found
        endif;
        ?>
      </div>
    </div>
  </div>
</section>

<section class="features-list">

  <header>
    <div class="container">
      <div class="row">
        <div class="header-headline">
          <h2>Financial Transparency Suite</h2>
        </div>
      </div>
    </div>
  </header>
  <?php

      if( have_rows('suite_features') ):
        $c = true;
        while ( have_rows('suite_features') ) : the_row();

          //vars
          $oddeven = $c = !$c;
          $headline = get_sub_field('headline');
          $body = get_sub_field('body');

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

          if ( false == $oddeven ) {
          echo '<div class="suite-features text-left">
                  <div class="container">
                    <div class="row">
                      <div class="col-md-6 col-md-offset-1">
                        <div class="features-headline">
                          <h3>' . $headline . '</h3>
                        </div>
                        <div class="features-body">
                          <p>' . $body . '</p>
                        </div>
                        <div class="features-link">
                          <a href="' . $link . '" class="btn btn-primary">' . $link_text . '</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>';
          }else if ( true == $oddeven ) {
          echo '<div class="suite-features text-right">
                  <div class="container">
                    <div class="row">
                      <div class="col-md-6 col-md-offset-5">
                        <div class="features-headline">
                          <h3>' . $headline . '</h3>
                        </div>
                        <div class="features-body">
                          <p>' . $body . '</p>
                        </div>
                        <div class="features-link">
                          <a href="' . $link . '" class="btn btn-primary">' . $link_text . '</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>';
          }

        endwhile;
      endif;
  ?>
  </div>

</section>

<section>
  <div class="container">
    <div class="row">
      <div class="col-md-1">
      </div>
      <div class="col-md-10">
      <?php

        if( have_rows('successful_services') ):
          while ( have_rows('successful_services') ) : the_row();

            // get vars
            $tile_icon = get_sub_field('icon');
            $tile_headline = get_sub_field('headline');
            $tile_body = get_sub_field('body');

            echo '<div class="col-md-6">
                    <div class="features-tile">
                      <div class="tile-icon">
                        <i class="fa fa-' . $tile_icon . ' blue"></i>
                      </div>
                      <div class="tile-content">
                        <div class="content-text">
                          <div class="text-headline">
                            <h4>' . $tile_headline . '</h4>
                          </div>
                          <div class="text-body">
                            <p>' . $tile_body . '</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>';

          endwhile;
        endif;

      ?>
      </div>
    </div>
  </div>
</section>

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
