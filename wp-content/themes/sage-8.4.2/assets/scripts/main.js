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
 * ======================================================================== */

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
        // JavaScript to be fired after the init JS

$('p:empty').remove();

        jQuery(function($) {
          $(function() {
            $.fn.matchHeight._throttle = 80;
              $('.match-height').matchHeight();
          });
          $( document ).ajaxComplete(function() {
            $('.match-height')
            .matchHeight('remove')
            .matchHeight();
          });
        });
               
        //Smooth Jumplink Scrolling
        var target, scroll;
        $("a[href*=\\#]:not([href=\\#])").on("click", function(e) {
          if (location.pathname.replace(/^\//,'') === this.pathname.replace(/^\//,'') && location.hostname === this.hostname) {
          target = $(this.hash);
          target = target.length ? target : $("[id=" + this.hash.slice(1) + "]");

          if (target.length) {
          if (typeof document.body.style.transitionProperty === 'string') {
          e.preventDefault();

          var avail = $(document).height() - $(window).height();

          scroll = target.offset().top - 60;

          if (scroll > avail) {
          scroll = avail;
        }
        $("html").css({
          "margin-top" : ( $(window).scrollTop() - scroll ) + "px",
          "transition" : "1s ease-in-out"
          }).data("transitioning", true);
          } else {
            $("html, body").animate({
              scrollTop: scroll
              }, 1000);
              return;
              }
            }
          }
        });
        $("html").on("transitionend webkitTransitionEnd msTransitionEnd oTransitionEnd", function (e) {
          if (e.target === e.currentTarget && $(this).data("transitioning") === true) {
            $(this).removeAttr("style").data("transitioning", false);
            $("html, body").scrollTop(scroll);
            return;
          }
        });

        //Header Dropdown Menu
        $('[data-submenu]').submenupicker();

        //Mobile Menu
        $('#menuToggle').on('click', function () {
            $(this).toggleClass('active')
        });

        // Initialize Slidebars
        var controller = new slidebars();
        controller.init();

        // Toggle Slidebars
        $( '.toggle-id-1' ).on( 'click', function ( event ) {
          // Stop default action and bubbling
          event.stopPropagation();
          event.preventDefault();
          controller.toggle( 'id-1' );
        });
      }
    },
    // Home page
    'home': {
      init: function() {
        // JavaScript to be fired on the home page
      },
      finalize: function() {
        // JavaScript to be fired after the init JS        
      }
    },
    // About us page, note the change from about-us to about_us.
    'no_page': {
      init: function() {
        jQuery(document).ready(function($){
          var $timeline_block = $('.timeline-block');

          $timeline_block.each(function(){
            if($(this).offset().top > $(window).scrollTop()+$(window).height()*0.75) {
              $(this).find('.timeline-dot, .timeline-image, .timeline-content').addClass('is-hidden');
            }
          });

          $(window).on('scroll', function(){
            $timeline_block.each(function(){
              if( $(this).offset().top <= $(window).scrollTop()+$(window).height()*0.75 && $(this).find('.timeline-dot, .timeline-image').hasClass('is-hidden') ) {
                $(this).find('.timeline-dot, .timeline-image, .timeline-content').removeClass('is-hidden').addClass('bounce-in');
              }
            });
          });
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
