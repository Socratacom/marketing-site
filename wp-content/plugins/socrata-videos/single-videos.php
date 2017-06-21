<section class="background-black">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="embed-responsive embed-responsive-16by9">
      <div id="ytplayer"></div>
    </div>        
      </div>
    </div>
  </div>
</section>
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
<section class="section-padding">
  <div class="container">
    <div class="row">
      <div class="col-sm-8">
        <h1 class="margin-bottom-15"><?php the_title(); ?></h1>
        <div class="margin-bottom-30"><?php echo do_shortcode('[addthis]');?></div>
        <?php $meta = get_socrata_videos_meta(); if ($meta[2]) {echo "$meta[2]";} ?>
      </div>
      <div class="col-sm-4 hidden-xs">
        <?php echo do_shortcode('[newsletter-sidebar]'); ?>   
      </div>
    </div>
  </div>
</section>