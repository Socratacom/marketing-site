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

        $('.header-search-btn').click(function(e) {
          $('.navbar-header .search-form').slideToggle(250);
          $('#search').focus();
          e.preventDefault();
          //return false;
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

// Slick Slider
function slider(container, arrows, speed, slides1, slides2, slides3, scrollNum1, scrollNum2, arrowContainer) {
  if (speed === '') {
    speed = 4000;
  }
  if (slides1 === '') {
    slides1 = 1;
  }
  if (slides2 === '') {
    slides2 = slides1;
  }
  if (slides3 === '') {
    slides3 = slides1;
  }
  if (scrollNum1 === '') {
    scrollNum1 = 1;
  }
  if (scrollNum2 === '') {
    scrollNum2 = scrollNum1;
  }
  if (arrowContainer === '') {
    arrowContainer = container;
  } else {
    //arrowContainer = arrowContainer;
  }

  $(container).slick({
    arrows: arrows,
    appendArrows: arrowContainer,
    prevArrow: '<i class="fa slick-prev fa-chevron-left"></i>',
    nextArrow: '<i class="fa slick-next fa-chevron-right"></i>',
    draggable: false,
    autoplay: true,
    autoplaySpeed: speed,
    slidesToShow: slides1,
    slidesToScroll: scrollNum1,
    speed: 500,
    responsive: [
      {
        breakpoint: 992,
        settings: {
          slidesToShow: slides2,
          slidesToScroll: scrollNum2
        }
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: slides3,
          slidesToScroll: 1
        }
      }
    ]
  });
}