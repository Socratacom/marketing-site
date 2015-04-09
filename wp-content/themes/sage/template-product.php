<?php
/**
 * Template Name: Product
 */


$intro_headline = get_field('intro_headline');
$intro_subhead = get_field('intro_subhead');
$intro_body = get_field('intro_body');
$intro_image = get_field('intro_image');
$intro_background = get_field('intro_background');

$features_headline = get_field('features_headline');
$features_body = get_field('features_body');
$features_video_thumbnail = get_field('features_video_thumbnail');

?>

<section class="product-intro">
  <?php

    if( have_rows('intro_background') ):
      while ( have_rows('intro_background') ) : the_row();
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

      echo '<div class="feature-container">';

    endif;

  ?>
  <div class="container intro-background">
    <div class="row">
      <div class="col-md-6 col-md-offset-1">

        <div class="intro-headline">
          <h1><?php echo $intro_headline; ?></h1>
        </div>
        <div class="intro-subhead">
          <p><?php echo $intro_subhead; ?></p>
        </div>
        <div class="intro-body">
          <p><?php echo $intro_body; ?></p>
        </div>
        <div class="intro-features">

          <?php
            if( have_rows('intro_features') ):
              echo '<ul>';
              while ( have_rows('intro_features') ) : the_row();

                $item = get_sub_field('item');
                echo '<li>' . $item . '</li>';

              endwhile;
              echo '</ul>';
            endif;
          ?>

        </div>

      </div>
      <div class="col-md-4">
        <div class="intro-playButton">
          <?php

          $video = get_field('intro_video');
          preg_match('/src="(.+?)"/', $video, $matches);
          $src = $matches[1];
          $params = array(
              'enablejsapi'   => 1,
              'rel'   => 0,
              'controls'  => 0,
              'html5'     => 1,
              'showinfo'  =>0,
              'playsinline' => 1,
              'autoplay' => 1
          );
          $new_src = add_query_arg($params, $src);

          ?>
          <a href="#" class="hidden-xs hidden-sm" id="play-button" data-toggle="modal" data-target="#videoModal" data-content="<?php echo $new_src; ?>">
            <i class="fa fa-play-circle"></i>
          </a>
          <?php

          $video = get_field('intro_video');
          preg_match('/src="(.+?)"/', $video, $matches);
          $src = $matches[1];
          $params = array(
              'enablejsapi'   => 1,
              'rel'   => 0,
              'controls'  => 0,
              'html5'     => 1,
              'showinfo'  =>0,
              'playsinline' => 1
          );
          $new_src = add_query_arg($params, $src);
          $video = str_replace($src, $new_src, $video);
          $attributes = 'id="player2"';
          $video = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $video);

          ?>
          <div class="embed-container visible-xs visible-sm">
            <?php echo $video; ?>
          </div>
        </div>
      </div>
    </div>
  </div>

</section>

<section class="product-features">
  <div class="container">
    <div class="features-hero">

      <div class="row">
        <?php
          if( have_rows('features_video') ):
        ?>
        <div class="col-md-6">
          <div class="hero-thumbnail">
            <img src="<?php echo $features_video_thumbnail; ?>" alt="" class="img-responsive">
            <div class="thumbnail-playButton">
              <?php

              if( have_rows('features_video') ):
                while ( have_rows('features_video') ) : the_row();

                  if( get_row_layout() == 'embedded_video' ):

                    $video = get_sub_field('embedded_video_link');
                    preg_match('/src="(.+?)"/', $video, $matches);
                    $src = $matches[1];
                    $params = array(
                        'enablejsapi'   => 1,
                        'rel'   => 0,
                        'controls'  => 0,
                        'html5'     => 1,
                        'showinfo'  =>0,
                        'playsinline' => 1
                    );
                    $new_src = add_query_arg($params, $src);
                    $video = str_replace($src, $new_src, $video);
                    $attributes = 'id="player"';
                    $video = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $video);
                    $video_id = get_field('video_id');


                    echo '<a href="#" data-toggle="modal" data-target="#videoModal" data-content="' . $new_src . '">
                            <i class="fa fa-play-circle"></i>
                          </a>';
                  elseif( get_row_layout() == 'video_link' ):

                    $link = get_sub_field('video_link_url');

                    echo '<a href="'. $link .'">
                            <i class="fa fa-play-circle"></i>
                          </a>';
                  endif;
                endwhile;
              else :
                // no layouts found
              endif;

              ?>

            </div>
          </div>
        </div>
        <?php
          endif;
        ?>
        <div class="col-md-6">
          <div class="hero-headline">
            <h2><?php echo $features_headline; ?></h2>
          </div>
          <div class="hero-body">
            <p><?php echo $features_body; ?></p>
          </div>

          <div class="hero-features">

            <?php
              if( have_rows('features_list') ):
                echo '<ul>';
                while ( have_rows('features_list') ) : the_row();

                  $item = get_sub_field('item');
                  echo '<li>' . $item . '</li>';

                endwhile;
                echo '</ul>';
              endif;
            ?>

          </div>

        </div>
      </div>
    </div>

    <div class="features-grid">
      <div class="row">

      <?php
        $tileNum = count(get_field('feature_tiles'));

        if( have_rows('feature_tiles') ):

          // count number of tiles
          $tileNum = count(get_field('feature_tiles'));

          while ( have_rows('feature_tiles') ) : the_row();

            $tile_image = get_sub_field('tile_image');
            $tile_body = get_sub_field('tile_body');


            if ($tileNum <= 2) {
              echo '<div class="col-sm-6">
                      <div class="grid-tile">
                        <div class="tile-image">
                          <img src="' . $tile_image . '" alt="feature tile" class="img-responsive">
                        </div>
                        <div class="tile-text">
                          <p>' . $tile_body . '</p>
                        </div>
                      </div>
                    </div>';
            }else if ($tileNum === 3) {
              echo '<div class="col-sm-4">
                      <div class="grid-tile">
                        <div class="tile-image">
                          <img src="' . $tile_image . '" alt="feature tile" class="img-responsive">
                        </div>
                        <div class="tile-text">
                          <p>' . $tile_body . '</p>
                        </div>
                      </div>
                    </div>';
            }else if ($tileNum === 4) {
            echo '<div class="col-sm-6 col-md-3">
                    <div class="grid-tile">
                      <div class="tile-image">
                        <img src="' . $tile_image . '" alt="feature tile" class="img-responsive">
                      </div>
                      <div class="tile-text">
                        <p>' . $tile_body . '</p>
                      </div>
                    </div>
                  </div>';
            }


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

<div class="modal fade videoModal" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="videoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button id="close-button" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">

        <div class="embed-container" data-video="<?php echo $video_id; ?>">
          <iframe width="200" height="113" frameborder="0" allowfullscreen="" id="player"></iframe>
        </div>

      </div>
    </div>
  </div>
</div>
