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

        echo '<div id="' . $rtp_id . '">
                <div class="slide" style="background-image: url(' . $background . ');">
                  <div class="container">
                    <div class="col-sm-8 col-md-8 col-lg-6">';
                echo '<div class="jumbotron-textContainer">
                        <h1>' . $large_text . '</h1>
                        <h2>' . $small_text . '</h2>
                        <a href="' . $link . '" class="button">' . $link_text . '</a>
                      </div>
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
              $infographic = get_sub_field('infographic', 'option');

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
                  if ($infographic) {
                    echo '<img src="'.$infographic.'" class="img-responsive">';
                  }
                echo '</div>
                      <div class="col-sm-12 logos">';

                        if( have_rows('logos') ):
                          while( have_rows('logos') ): the_row();
                          $logo = get_sub_field('logo_image');
                          $logolink = '';
                          $linkstart = '';
                          $linkend = '';
                          if( have_rows('logo_link') ):
                            while( have_rows('logo_link') ): the_row();
                              if( get_row_layout() == 'internal_link' ):
                                $logolink = get_sub_field('link_url');
                                $linkstart = '<a href="'.$logolink.'">';
                                $linkend = '</a>';
                              elseif( get_row_layout() == 'external_link' ):
                                $logolink = get_sub_field('link_url');
                                $linkstart = '<a href="'.$logolink.'" target="_blank">';
                                $linkend = '</a>';
                              endif;
                            endwhile;
                          endif;

                          if ($logo) {
                            echo '<div class="slide col-sm-2">'.$linkstart.'<img src="'.$logo['url'].'" alt="'.$logo['title'].'" class="grayscale">'.$linkend.'</div>';
                          }
                          endwhile;
                        endif;
                  echo '</div>
                      </div>';
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

<section class="template-featureBlocks">

  <header>
    <div class="container">
      <div class="row">
        <div class="featureBlocks-headline">
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
          $image = get_sub_field('image');

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
          echo '<div class="featureBlocks-feature text-left">';
                if( have_rows('background') ):
                  while ( have_rows('background') ) : the_row();
                    $background = '';
                    if( get_row_layout() == 'background_contained' ):
                      $background = get_sub_field('background_image');

                      echo '<div class="feature-container contain" style="background-image: url(' . $background . ')">';

                    elseif( get_row_layout() == 'background_full_width' ):
                      $background = get_sub_field('background_image');

                      echo '<div class="feature-container cover" style="background-image: url(' . $background . ')">';
                    endif;
                  endwhile;
                else :
                  // no layouts found
                endif;
            echo '  <div class="container">
                      <div class="row">
                        <div class="col-sm-8 col-md-6 col-md-offset-1">
                          <div class="container-headline">
                            <h3>' . $headline . '</h3>
                          </div>
                          <div class="container-body">
                            <p>' . $body . '</p>
                          </div>
                          <div class="container-link">
                            <a href="' . $link . '" class="btn btn-primary">' . $link_text . '</a>
                          </div>
                        </div>
                        <div class="col-sm-4 col-md-4 hidden-xs">';

                  if($image) {
                    echo '<img src="' . $image . '" class="img-responsive">';
                    }

              echo '    </div>
                      </div>
                    </div>
                  </div>
                </div>';
          }else if ( true == $oddeven ) {
          echo '<div class="featureBlocks-feature text-right">';
                if( have_rows('background') ):
                  while ( have_rows('background') ) : the_row();
                    $background = '';
                    if( get_row_layout() == 'background_contained' ):
                      $background = get_sub_field('background_image');

                      echo '<div class="feature-container contain" style="background-image: url(' . $background . ')">';

                    elseif( get_row_layout() == 'background_full_width' ):
                      $background = get_sub_field('background_image');

                      echo '<div class="feature-container cover" style="background-image: url(' . $background . ')">';

                    endif;
                  endwhile;
                else :
                  echo '<div class="feature-container cover">';
                endif;
            echo '  <div class="container">
                      <div class="row">
                        <div class="col-sm-4 col-md-4 col-md-offset-1 hidden-xs">
                          ';
                      if($image) {
                        echo ' <img src="' . $image . '" class="img-responsive">';
                      }
                  echo '</div>
                        <div class="col-sm-8 col-md-6">
                          <div class="container-headline">
                            <h3>' . $headline . '</h3>
                          </div>
                          <div class="container-body">
                            <p>' . $body . '</p>
                          </div>
                          <div class="container-link">
                            <a href="' . $link . '" class="btn btn-primary">' . $link_text . '</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>';
          }

        endwhile;
      endif;
  ?>

</section>

<section class="template-listTiles successServices">
  <div class="container">
    <div class="row">
      <div class="col-md-1">
      </div>
      <div class="col-md-10">
        <div class="listTiles-headline">
          <h3>Success Services</h3>
        </div>
      <?php

        if( have_rows('successful_services') ):
          while ( have_rows('successful_services') ) : the_row();

            // get vars
            $tile_icon = get_sub_field('icon');
            $tile_headline = get_sub_field('headline');
            $tile_body = get_sub_field('body');

            echo '<div class="col-md-6">
                    <div class="listTiles-tile">
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

<section class="template-listTiles addons">
  <div class="container">
    <div class="row">
      <div class="col-md-1">
      </div>
      <div class="col-md-10">
        <div class="listTiles-headline">
          <h3>Add-Ons</h3>
        </div>
      <?php

        if( have_rows('add-ons') ):
          while ( have_rows('add-ons') ) : the_row();

            // get vars
            $tile_icon = get_sub_field('icon');
            $tile_headline = get_sub_field('headline');
            $tile_body = get_sub_field('body');

            echo '<div class="col-md-6">
                    <div class="listTiles-tile">
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

<section class="template-twoColumn">
  <div class="container">
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
      <?php

        if( have_rows('2col') ):
          while ( have_rows('2col') ) : the_row();

            // get vars
            $tile_headline = get_sub_field('headline');

          echo '<div class="twoColumn-section">';

            echo '<div class="row">
                    <div class="col-md-12">
                      <div class="section-headline">
                        <h3>' . $tile_headline . '</h3>
                      </div>
                    </div>
                  </div>
                  <div class="row">';

            if( have_rows('item') ):
              while ( have_rows('item') ) : the_row();
                $image = '';
                $item_headline = '';
                $item_body = '';
                if( get_row_layout() == 'text_block' ):
                  $item_headline = get_sub_field('headline');
                  $item_body = get_sub_field('body');

                  echo '
                        <div class="col-md-6">
                          <div class="section-tile">
                            <div class="tile-content">
                              <div class="content-headline">
                                <h4>' . $item_headline . '</h4>
                              </div>
                              <div class="content-body">
                                <p>' . $item_body . '</p>
                              </div>
                            </div>
                          </div>
                        </div>';


                elseif( get_row_layout() == 'image' ):
                  $image = get_sub_field('image_url');
                  echo '
                        <div class="col-md-6">
                          <div class="section-tile">
                            <div class="tile-content">
                              <div class="content-image">
                                <img src="' . $image . '" class="img-responsive">
                              </div>
                            </div>
                          </div>
                        </div>';

                endif;
              endwhile;
            else :
              // no layouts found
            endif;

            echo '</div></div>';

          endwhile;
        endif;

      ?>
      </div>
    </div>
  </div>
</section>

<?php endwhile; ?>
