<?php
/**
 * Template Name: Product
 */


$intro_headline = get_field('intro_headline');
$intro_subhead = get_field('intro_subhead');
$intro_body = get_field('intro_body');

$features_headline = get_field('features_headline');
$features_body = get_field('features_body');
$features_video_thumbnail = get_field('features_video_thumbnail');

?>

<section class="product-intro">
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
          <ul>

          <?php
            if( have_rows('intro_features') ):
              while ( have_rows('intro_features') ) : the_row();

                $item = get_sub_field('item');
                echo '<li>' . $item . '</li>';

              endwhile;
            endif;
          ?>

          </ul>
        </div>

      </div>
      <div class="col-md-4">
        <div class="intro-playButton">
          <a href="#">
            <i class="fa fa-play-circle"></i>
          </a>
        </div>
      </div>
    </div>
  </div>

</section>

<section class="product-features">
  <div class="container">
    <div class="features-hero">

      <div class="row">
        <div class="col-md-6">
          <div class="hero-thumbnail">
            <img src="<?php echo $features_video_thumbnail; ?>" alt="" class="img-responsive">
            <div class="thumbnail-playButton">
              <a href="#">
                <i class="fa fa-play-circle"></i>
              </a>
            </div>
          </div>

        </div>
        <div class="col-md-6">
          <div class="hero-headline">
            <h2><?php echo $features_headline; ?></h2>
          </div>
          <div class="hero-body">
            <p><?php echo $features_body; ?></p>
          </div>

          <div class="hero-features">

            <ul>

            <?php
              if( have_rows('features_list') ):
                while ( have_rows('features_list') ) : the_row();

                  $item = get_sub_field('item');
                  echo '<li>' . $item . '</li>';

                endwhile;
              endif;
            ?>

            </ul>
          </div>

        </div>
      </div>
    </div>

    <div class="features-tiles">
      <div class="row">

      <?php
        if( have_rows('feature_tiles') ):
          while ( have_rows('feature_tiles') ) : the_row();

            $tile_image = get_sub_field('tile_image');
            $tile_body = get_sub_field('tile_body');
            echo '<div class="col-md-3">
                    <div class="features-tile">
                      <div class="tile-image">
                        <img src="' . $tile_image . '" alt="feature tile">
                      </div>
                      <div class="tile-text">
                        <p>' . $tile_body . '</p>
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

<section class="cta-links">
  <div class="container">
    <div class="row">

    <?php
      if( have_rows('cta_tiles') ):
        while ( have_rows('cta_tiles') ) : the_row();

          $tile_icon = get_sub_field('tile_icon');
          $tile_headline = get_sub_field('tile_headline');
          $tile_body = get_sub_field('tile_body');
          $tile_button_text = get_sub_field('tile_button_text');
          $tile_button_link = get_sub_field('tile_button_link');
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
