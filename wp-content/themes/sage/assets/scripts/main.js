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

(function($) {

  // Use this variable to set up the common and page specific functions. If you
  // rename this variable, you will also need to rename the namespace below.
  var Sage = {
    // All pages
    'common': {
      init: function() {
        // JavaScript to be fired on all pages
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
          autoplay: true,
          autoplaySpeed: 4000,
          slidesToShow: 6,
          slidesToScroll: 1,
          speed: 500
        });

        $('.awards-slide').slick({
          arrows: true,
          prevArrow: '<i class="fa slick-prev fa-chevron-left"></i>',
          nextArrow: '<i class="fa slick-next fa-chevron-right"></i>',
          autoplay: true,
          autoplaySpeed: 4000,
          slidesToShow: 6,
          slidesToScroll: 1,
          speed: 500
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
    'cloud': {
      init: function() {
        $('.jumbotron').slick({
          arrows: true,
          prevArrow: '<i class="fa slick-prev fa-chevron-left"></i>',
          nextArrow: '<i class="fa slick-next fa-chevron-right"></i>',
          autoplay: true,
          autoplaySpeed: 5000,
          speed: 800
        });
        $('.logos img').each(function() {
          var obj = $(this)[0];
          obj.src = gray(obj);
          $(this).css({ 'height': '85px', 'visibility': 'visible' });
        });
        setTimeout(function(){
          $('.logos').slick({
            arrows: false,
            autoplay: true,
            autoplaySpeed: 4000,
            slidesToShow: 6,
            slidesToScroll: 1,
            speed: 500
          });
        }, 1000);
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
