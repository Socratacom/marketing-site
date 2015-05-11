<?php while (have_posts()) : the_post();

if ( have_rows('hero') ):
  echo '<section>
  <div class="jumbotron">';
  while ( have_rows('hero') ) : the_row();
    // get vars
    $rtp_id = get_sub_field('rtp_id');
    $background = get_sub_field('slider_bg_image');
    $slide_image = get_sub_field('slider_image');
    $small_text = get_sub_field('header_small_text');
    $large_text = get_sub_field('header_large_text');
    $italic_text = get_sub_field('header_italic_text');
    $header_text_alignment = get_sub_field('header_text_alignment');
    $hero_content_vertical_alignment = get_sub_field('hero_content_vertical_alignment');

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
            <div class="slide'. ($hero_content_vertical_alignment ? ' ' . $hero_content_vertical_alignment : null) .'" style="background-image: url(' . $background . ');">
              <div class="container vertical-alignment">
              <div class="vertical-alignment-inner">
                <div class="col-xs-12">';
            echo '<div class="jumbotron-textContainer" style="text-align:'. $header_text_alignment.'">
                      <h1 class="headline">' . $large_text . '</h1>
                      <h2 class="headline">' . $small_text . '</h2>';
                      if ($link) {
                        echo '<a href="' . $link . '" class="button">' . $link_text . '</a>';
                      }
                      if ($slide_image) {
                        echo '<img class="slide-image" src="' . $slide_image . '">';
                      }
            echo '</div>
                </div>
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
if( have_rows('sections') ): $i = 0;
  while ( have_rows('sections') ) : the_row();

    /* ------------------------------------ */
    //
    // SECTION: Text/image
    //
    /* ------------------------------------ */
    if( get_row_layout() == 'text_and_image' ):
      $color = get_sub_field('color');
      $alignment = get_sub_field('alignment');
      $image = get_sub_field('image');
      $content = get_sub_field('text');

      echo '<section id="section-'. $i .'" class="section-textimage" style="background-color:'.$color.'">';
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


    /* ------------------------------------ */
    //
    // SECTION: Carousel
    //
    /* ------------------------------------ */
    elseif( get_row_layout() == 'carousel' ):

      $headline = get_sub_field('headline');
      $headline_text_alignment = get_sub_field('headline_text_alignment');
      $color = get_sub_field('color');
      $items_per_slide = (get_sub_field('items_per_slide') ? get_sub_field('items_per_slide') : 1);

      echo '<section id="section-'. $i .'" class="section-carousel" style="background-color:'.$color.'; padding: 50px 0;">';
      echo '<div class="container"><div class="row ' . $headline_text_alignment .'">';
        if ($headline) {
          echo '<div class="col-xs-12"><h2>'.$headline.'</h2></div>';
        }
        echo '<div class="column-slider">';
        if( have_rows('column') ):
          while ( have_rows('column') ) : the_row();
          $content = get_sub_field('column_content');
            echo '<div class="slide col-sm-'. (12 / $items_per_slide) .'">';
              echo $content;
            echo '</div>';
          endwhile;
        endif;
      echo '</div></div></div>';
      echo '</section>';
      ?>

      <script>
      $(function(){
        $('#section-<?php echo $i; ?> .column-slider').slick({
          arrows: true,
          prevArrow: '<i class="fa slick-prev fa-chevron-left"></i>',
          nextArrow: '<i class="fa slick-next fa-chevron-right"></i>',
          autoplay: true,
          autoplaySpeed: 5000,
          speed: 800,
          slidesToShow: <?php echo $items_per_slide; ?>,
          slidesToScroll: 1,
          responsive: [
            {
              breakpoint: 992,
              settings: {
                slidesToShow: 2
              }
            },
            {
              breakpoint: 768,
              settings: {
                slidesToShow: 1
              }
            }
          ]
        });
      });
      </script>

      <?php

    /* ------------------------------------ */
    //
    // SECTION: Blog
    //
    /* ------------------------------------ */

    elseif( get_row_layout() == 'blog' ):

      $headline = get_sub_field('headline');
      $headline_text_alignment = get_sub_field('headline_text_alignment');
      $color = get_sub_field('color');

      $items_per_slide = (get_sub_field('items_per_slide') ? get_sub_field('items_per_slide') : 1);

      $args = array(
        'post_type' => array( 'tech_blog', 'post' ),
        'post_status' => 'publish',
          'order' => 'DESC',
          'posts_per_page' => $items_per_slide
      );
      $news_loop = new WP_Query( $args );

      echo '<section id="section-'. $i .'" class="section-blog" style="background-color:'.$color.'; padding: 50px 0;">';
      echo '<div class="container"><div class="row">';
      if ($headline) {
        echo '<div class="col-xs-12" style="text-align:' . $headline_text_alignment .'"><h2>'.$headline.'</h2></div>';
      }

      if ( $news_loop->have_posts() ) :

        echo '<div class="row news-list">';
          while ( $news_loop->have_posts() ) : $news_loop->the_post();
            
            // get vars
            $post_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
            $post_image = $post_image[0];
            $name = get_the_title();
            $link = get_the_permalink();
            $date = get_the_date();

            echo '<div class="col-xs-12 col-sm-'. (12 / $items_per_slide) .'"><div class="post">';
            if ($link) { echo '<a style="display:block;" href="'.$link.'">'; }
            echo '<span class="img-container" style="background-image:url('.$post_image.')"></span>';
            echo '<span style="display:block; padding: 16px 20px; background:#fff; ">';
            echo '<span class="sup-header" style="font-size:12px; color:#ccc;">Published on '.$date.'</span><h3 style="margin:0; font-size: 18px;">'.$name.'</h3>';
            if ($link) { echo '</a>'; }
            echo '</span>';
            echo '</div></div>';
          endwhile;
        echo '</div>';

        wp_reset_postdata();

      endif;

      echo '</section>';

    /* ------------------------------------ */
    //
    // SECTION: Case Studies
    //
    /* ------------------------------------ */
    elseif( get_row_layout() == 'case_studies' ):
      $number_of_case_studies = get_sub_field('number_of_case_studies');
      $categories = get_sub_field('categories');
      //var_dump($categories);

      echo '<section id="section-'. $i .'" class="section-case-studies" style="background-color:'.$color.'; padding: 50px 0;">';
      echo '<div class="container"><div class="row ' . $headline_text_alignment .'">';
        if ($headline) {
          echo '<div class="col-xs-12"><h2>'.$headline.'</h2></div>';
        }
        echo '<div class="case-study-slider">';

        $args = array(
            'post_type' => 'case_study',
            'post_status' => 'publish',
            'order' => 'DESC',
            'cat' => '',
            'posts_per_page' => $number_of_case_studies
        );
        $case_loop = new WP_Query( $args );
        if ( $case_loop->have_posts() ) :
          echo '<div class="col-sm-10 col-sm-offset-1 post-list">';
          while ( $case_loop->have_posts() ) : $case_loop->the_post();
            // get vars
            $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
              $featured_image = $featured_image[0];
            $name = get_the_title();
              $link = get_the_permalink();
              $excerpt = get_the_excerpt();
            echo '<div class="slide"><div class="col-sm-7">';
            echo '<h3>'.$name.'</h3><p>'.$excerpt.'</p>';
            echo '</div>';
            echo '<div class="col-sm-5">';
            echo '<div class="img-container"><a href="'.$link.'"><img src="'.$featured_image.'" alt="'.$name.'" class="img-responsive"></a></div>';
            echo '</div></div>';
          endwhile;
          echo '</div>';
          wp_reset_postdata();
        endif;

      echo '</div></div></div>';
      echo '</section>';
      ?>

      <script>
      $(function() {
        $('#section-<?php echo $i;?> .post-list').slick({
          arrows: true,
          prevArrow: '<i class="fa slick-prev fa-chevron-left"></i>',
          nextArrow: '<i class="fa slick-next fa-chevron-right"></i>',
          autoplay: true,
          autoplaySpeed: 5000,
          speed: 800,
          slidesToShow: 1,
          slidesToScroll: 1
        });
      })();
      </script>

    <?php

    endif;

    $i++;

  endwhile;
endif;
?>

<div class="container">
  <?php get_template_part('templates/content', 'page'); ?>
</div>
<?php endwhile; ?>
