/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 *
 * Google CDN, Latest jQuery
 * To use the default WordPress version of jQuery, go to lib/config.php and
 * remove or comment out: add_theme_support('jquery-cdn');
 * ======================================================================== */

 // convert images to black and white

 // Youtube Control
 var tag = document.createElement('script');
 tag.src = "//www.youtube.com/player_api";
 var firstScriptTag = document.getElementsByTagName('script')[0];
 firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

 var player;

 function onPlayerReady(event) {
   var closeButton = document.getElementById('close-button');
   closeButton.addEventListener("click", function() {
     player.stopVideo();
   });
 }

 function onYouTubeIframeAPIReady() {
   player = new YT.Player('player', {
     events: {
       'onReady': onPlayerReady
     }
   });
 }

(function($) {

  // Use this variable to set up the common and page specific functions. If you
  // rename this variable, you will also need to rename the namespace below.
  var Sage = {
    // All pages
    'common': {
      init: function() {
        // JavaScript to be fired on all pages
        $('.navbar-nav > li > a').removeAttr('data-toggle');
        $('li.nav-header > a').removeAttr('href');


        $('#videoModal').on('hidden.bs.modal', function (e) {
          player.stopVideo();
        });

        $('#videoModal').on('show.bs.modal', function (event) {

          var button = $(event.relatedTarget); // Button that triggered the modal
          var content = button.data('content'); // Extract info from data-* attributes
          var modal = $(this);
          modal.find('.modal-title').html('&nbsp;');
          modal.find('.modal-body .embed-container iframe').attr('src', content);
          setTimeout(function(){player.playVideo();}, 500);
        });
      },
      finalize: function() {
        // JavaScript to be fired on all pages, after page specific JS is fired
      }
    },
    // Home page
    'home': {
      init: function() {
        // JavaScript to be fired on the home page
        $('.jumbotron').slick({
          arrows: true,
          prevArrow: '<i class="fa slick-prev fa-chevron-left"></i>',
          nextArrow: '<i class="fa slick-next fa-chevron-right"></i>',
          autoplay: true,
          autoplaySpeed: 5000,
          speed: 800
        });

        $('.vid-slider').slick({
          arrows: true,
          prevArrow: '<i class="fa slick-prev fa-chevron-left"></i>',
          nextArrow: '<i class="fa slick-next fa-chevron-right"></i>',
          autoplay: true,
          autoplaySpeed: 6500,
          slidesToShow: 3,
          slidesToScroll: 1,
          speed: 500,
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

        $('.post-list').slick({
          arrows: true,
          prevArrow: '<i class="fa slick-prev fa-chevron-left"></i>',
          nextArrow: '<i class="fa slick-next fa-chevron-right"></i>',
          dots: true,
          autoplay: true,
          autoplaySpeed: 6000,
          slidesToShow: 1,
          slidesToScroll: 1,
          speed: 500
        });

        $('.logos').slick({
          arrows: false,
          draggable: false,
          autoplay: true,
          autoplaySpeed: 4000,
          slidesToShow: 6,
          slidesToScroll: 1,
          speed: 500,
          responsive: [
            {
              breakpoint: 992,
              settings: {
                slidesToShow: 5
              }
            },
            {
              breakpoint: 768,
              settings: {
                slidesToShow: 3
              }
            }
          ]
        });

        $('.awards-slide').slick({
          arrows: true,
          prevArrow: '<i class="fa slick-prev fa-chevron-left"></i>',
          nextArrow: '<i class="fa slick-next fa-chevron-right"></i>',
          autoplay: true,
          autoplaySpeed: 4000,
          slidesToShow: 6,
          slidesToScroll: 1,
          speed: 500,
          responsive: [
            {
              breakpoint: 992,
              settings: {
                slidesToShow: 5
              }
            },
            {
              breakpoint: 768,
              settings: {
                slidesToShow: 3
              }
            }
          ]
        });
      },
      finalize: function() {
        // JavaScript to be fired on the home page, after the init JS
      }
    },
    // About us page, note the change from about-us to about_us.
    'about_us': {
      init: function() {
        // JavaScript to be fired on the about us page
      }
    },
    'page_template_template_cloud': {
      init: function() {
        $('.jumbotron').slick({
          arrows: true,
          prevArrow: '<i class="fa slick-prev fa-chevron-left"></i>',
          nextArrow: '<i class="fa slick-next fa-chevron-right"></i>',
          autoplay: true,
          autoplaySpeed: 5000,
          speed: 800
        });

        $('.logos').slick({
          arrows: false,
          draggable: false,
          autoplay: true,
          autoplaySpeed: 4000,
          slidesToShow: 6,
          slidesToScroll: 1,
          speed: 500,
          responsive: [
            {
              breakpoint: 992,
              settings: {
                slidesToShow: 5
              }
            },
            {
              breakpoint: 768,
              settings: {
                slidesToShow: 3
              }
            }
          ]
        });
      }
    }
  };

  // The routing fires all common scripts, followed by the page specific scripts.
  // Add additional events for more control over timing e.g. a finalize event
  var UTIL = {
    fire: function(func, funcname, args) {
      var fire;
      var namespace = Sage;
      funcname = (funcname === undefined) ? 'init' : funcname;
      fire = func !== '';
      fire = fire && namespace[func];
      fire = fire && typeof namespace[func][funcname] === 'function';

      if (fire) {
        namespace[func][funcname](args);
      }
    },
    loadEvents: function() {
      // Fire common init JS
      UTIL.fire('common');

      // Fire page-specific init JS, and then finalize JS
      $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function(i, classnm) {
        UTIL.fire(classnm);
        UTIL.fire(classnm, 'finalize');
      });

      // Fire common finalize JS
      UTIL.fire('common', 'finalize');
    }
  };

  // Load Events
  $(document).ready(UTIL.loadEvents);

})(jQuery); // Fully reference jQuery after this point.
