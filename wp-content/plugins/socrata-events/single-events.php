<div class="container page-padding">
  <div class="row">   
    <div class="col-sm-12">
      <?php while (have_posts()) : the_post(); ?>
      <article <?php post_class(); ?>>
        <div class="video-container">
          <div id="ytplayer"></div>
        </div>
        <div class="row">
          <div class="col-sm-10 col-sm-offset-1">
            <h1 class="entry-title"><?php the_title(); ?></h1>
            <div class="marketo-share">
              <?php echo do_shortcode( '[marketo-share]' ); ?>
            </div>
            <?php $meta = get_socrata_videos_meta(); if ($meta[2]) {echo "$meta[2]";} ?>
          </div>
        </div>
      </article>      
      <?php endwhile; ?>
    </div>
  </div>    
</div>  
<script>
 // Load the IFrame Player API code asynchronously.
    setTimeout(function() {
        player.playVideo();
    }, 3000);
      var tag = document.createElement('script');
      tag.src = "https://www.youtube.com/player_api";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

  // Replace the 'ytplayer' element with an <iframe> and
  // YouTube player after the API code downloads.
    var player;
    function onYouTubePlayerAPIReady() {    
        player = new YT.Player('ytplayer', {
          height: '480',
          width: '853',
          videoId: <?php $meta = get_socrata_videos_meta(); echo "'$meta[1]'"; ?>,
          playerVars: {
                 'rel' : 0,
                 'showinfo' : 0,
          }
        }); 
    }
</script>