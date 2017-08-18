<?php 
  $about_content = rwmb_meta( 'media_kit_about_socrata_content' );
?>
<style>
.essential-links ul li {font-size:14px; border-bottom:#d1d1d1 solid 1px; margin:0; padding:10px 0;}
</style>
<div class="container">
  <div class="row">
    <div class="col-sm-3 hidden-xs" style="padding-top:80px;">
      <div id="sidebar" class="background-light-grey-4">
        <ul>
          <li><a href="index.html">jQuery (animated)</a></li>
          <li><a href="#section-2">CSS (fixed)</a></li>
          <li><a href="reveal.html">CSS (reveal)</a></li>
        </ul>
      </div>        
    </div>
    <div class="col-sm-9">
      <!-- Section 1 -->
      <section class="section-padding">
        <div class="row">
          <div class="col-sm-7 col-md-8">
            <h1 class="font-light"><?php the_title(); ?></h1>
            <?php echo $about_content;?>          
          </div>
          <div class="col-sm-5 col-md-4">
            <div class="essential-links">
              <h5 class="text-uppercase">Essential Links</h5>
              <ul class="no-bullets">
                <li><span class="text-uppercase font-semi-bold">Press Contact</span><br><a href="mailto:press@socrata.com" class="font-normal">press@socrata.com</a></li>
                <li><span class="text-uppercase font-semi-bold">Twitter</span><br><a href="https://twitter.com/socrata" target="_blank" class="font-normal">@socrata</a></li>
                <li><span class="text-uppercase font-semi-bold">CEO Twitter</span><br><a href="https://twitter.com/kmerritt" target="_blank" class="font-normal">@kmerritt</a></li>
                <li><span class="text-uppercase font-semi-bold">Linked In</span><br><a href="https://www.linkedin.com/company-beta/428169/" target="_blank" class="font-normal">View Profile</a></li>
                <li><span class="text-uppercase font-semi-bold">YouTube</span><br><a href="https://www.youtube.com/user/socratavideos" target="_blank" class="font-normal">Watch Videos</a></li>
              </ul>
            </div>
          </div>         
        </div>
      </section>
      <!-- Section 2 -->
      <section id="section-2" class="section-padding background-light-grey-4">
        <div class="row">
          <div class="col-sm-8">
            <p>Etiam porta sem malesuada magna mollis euismod. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies vehicula ut id elit. Maecenas sed diam eget risus varius blandit sit amet non magna. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Maecenas sed diam eget risus varius blandit sit amet non magna. Etiam porta sem malesuada magna mollis euismod. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies vehicula ut id elit. Maecenas sed diam eget risus varius blandit sit amet non magna. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Maecenas sed diam eget risus varius blandit sit amet non magna. Etiam porta sem malesuada magna mollis euismod. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies vehicula ut id elit. Maecenas sed diam eget risus varius blandit sit amet non magna. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Maecenas sed diam eget risus varius blandit sit amet non magna.</p>            
          </div>
          <div class="col-sm-4">
            <p>Etiam porta sem malesuada magna mollis euismod. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies vehicula ut id elit. Maecenas sed diam eget risus varius blandit sit amet non magna. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Maecenas sed diam eget risus varius blandit sit amet non magna.</p>            
          </div>
        </div>
      </section>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(function() {
    var offset = $("#sidebar").offset();
    var topPadding = 140;
    $(window).scroll(function() {
      if ($(window).scrollTop() > offset.top) {
        $("#sidebar").stop().animate({
          marginTop: $(window).scrollTop() - offset.top + topPadding
        });
        } else {
        $("#sidebar").stop().animate({
          marginTop: 0
        });
      };
    });
  });
</script>