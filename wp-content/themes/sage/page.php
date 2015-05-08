<?php while (have_posts()) : the_post(); ?>
<?php
if( have_rows('hero') ):
  echo '<section>
  <div class="jumbotron">';
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
  echo '</div>
  </section>';
else :
  // no hero found
endif;
?>

<?php
if( have_rows('sections') ):
  while ( have_rows('sections') ) : the_row();

    if( get_row_layout() == 'text_and_image' ):
      $color = get_sub_field('color');
      $alignment = get_sub_field('alignment');
      $image = get_sub_field('image');
      $content = get_sub_field('text');
      echo '<section style="background-color:'.$color.'">';
      echo '<div class="container"><div class="row">';
      $push = '';
      $pull = '';
      if ('right' == $alignment) {
        $push = 'col-sm-push-8';
        $pull = 'col-sm-pull-4';
      }
      echo '<div class="col-sm-4 '.$push.'">';
        echo '<img src="'.$image['url'].'" alt="'.$image['title'].'" class="img-responsive">';
      echo '</div><div class="col-sm-8 '.$pull.'">';
        echo $content;
      echo '</div></div></div>';
      echo '</section>';

    elseif( get_row_layout() == 'carousel' ):
      $headline = get_sub_field('headline');
      $color = get_sub_field('color');
      echo '<section style="background-color:'.$color.'">';
      echo '<div class="container"><div class="row">';
        echo '<h2>'.$headline.'</h2>';
        echo '<div class="column-slider">';
        if( have_rows('column') ):
          while ( have_rows('column') ) : the_row();
          $content = get_sub_field('column_content');
            echo '<div class="slide col-sm-4">';
              echo $content;
            echo '</div>';
          endwhile;
        endif;
      echo '</div></div></div>';
      echo '</section>';
    endif;

  endwhile;
endif;
?>

<div class="container">
  <?php get_template_part('templates/content', 'page'); ?>
</div>
<?php endwhile; ?>
