<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Config;

/**
 * Add <body> classes
 */
function body_class($classes) {
  // Add page slug if it doesn't exist
  if (is_single() || is_page() && !is_front_page()) {
    if (!in_array(basename(get_permalink()), $classes)) {
      $classes[] = basename(get_permalink());
    }
  }

  // Add class if sidebar is active
  if (Config\display_sidebar()) {
    $classes[] = 'sidebar-primary';
  }

  return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');

/**
 * Clean up the_excerpt()
 */
function excerpt_more() {
  return '';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');

/**
 * Adds category name to blog
 */
function blog_the_categories() {
  // get all categories for this post
  global $cats;
  $cats = get_the_category();
  // echo the first category
  echo $cats[0]->cat_name;
  // echo the remaining categories, appending separator
  for ($i = 1; $i < count($cats); $i++) {echo ', ' . $cats[$i]->cat_name ;}
}

/** SHORTCODES **/

/**
 * Open Data Sub Nav
 */
function open_data_subnav ($atts, $content = null) {
  ob_start();
  ?>
  <section class="product-subnav">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <h3><a href="/products/open-data">Open Data</a></h3>
          <?php wp_nav_menu( array( 
              'theme_location' => 'product_nav_open_data',
              'container'       => '',
              'menu_class' => 'subnav' 
            ) ); ?>
        </div>
      </div>
    </div>
  </section>
  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('open-data-subnav', __NAMESPACE__ . '\\open_data_subnav');

/**
 * Marketo Social Sharing
 */
function marketo_share($atts, $content = null) {
  ob_start();
  ?>
  <div class="cf_widgetLoader cf_w_e136d060830c4c6c86672c9eb0182397"></div>
  <script type="text/javascript" src="//b2c-msm.marketo.com/jsloader/54782eb9-758c-41a0-baac-4a7ead980cba/loader.php.js"></script>
  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('marketo-share', __NAMESPACE__ . '\\marketo_share');


/**
 * Carousel Script. This temporary till I can figure out the frick'n plugin
 */
function carousel_script( $atts ) {
  extract( shortcode_atts( array(
    'id' => '',
  ), $atts ) );
  ob_start(); 
  ?>
  <script>
  jQuery(function ($){
          $(<?php echo $id; ?>).slick({
            arrows: true,
            dots: true,
            appendArrows: $('.carousel'),
            prevArrow: '<div class="toggle-left"><i class="fa slick-prev fa-chevron-left"></i></div>',
            nextArrow: '<div class="toggle-right"><i class="fa slick-next fa-chevron-right"></i></div>',
            autoplay: true,
            autoplaySpeed: 8000,
            speed: 800,
            slidesToShow: 1,
            slidesToScroll: 1,
            accessibility:false
          });
          $(<?php echo $id; ?>).show();
        });
  </script>
  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('carousel-script', __NAMESPACE__ . '\\carousel_script');

/**
 * YouTube Modal
 */
function youtube_modal( $atts ) {
  ob_start(); 
  ?>



<!-- Video / Generic Modal -->
<div class="modal video-modal" id="mediaModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <button type="button" data-dismiss="modal"><i class="fa fa-times"></i></button>
      <div class="modal-body">
        <!-- content dynamically inserted -->
      </div>
    </div>
  </div>
</div>

<script>
// REQUIRED: Include "jQuery Query Parser" plugin here or before this point: 
// https://github.com/mattsnider/jquery-plugin-query-parser
 (function($){var pl=/\+/g,searchStrict=/([^&=]+)=+([^&]*)/g,searchTolerant=/([^&=]+)=?([^&]*)/g,decode=function(s){return decodeURIComponent(s.replace(pl," "));};$.parseQuery=function(query,options){var match,o={},opts=options||{},search=opts.tolerant?searchTolerant:searchStrict;if('?'===query.substring(0,1)){query=query.substring(1);}while(match=search.exec(query)){o[decode(match[1])]=decode(match[2]);}return o;};$.getQuery=function(options){return $.parseQuery(window.location.search,options);};$.fn.parseQuery=function(options){return $.parseQuery($(this).serialize(),options);};}(jQuery));

// YOUTUBE VIDEO CODE
jQuery(document).ready(function($){
  
// BOOTSTRAP 3.0 - Open YouTube Video Dynamicaly in Modal Window
// Modal Window for dynamically opening videos
$('a[href^="https://www.youtube.com"]').on('click', function(e){
  // Store the query string variables and values
  // Uses "jQuery Query Parser" plugin, to allow for various URL formats (could have extra parameters)
  var queryString = $(this).attr('href').slice( $(this).attr('href').indexOf('?') + 1);
  var queryVars = $.parseQuery( queryString );
 
  // if GET variable "v" exists. This is the Youtube Video ID
  if ( 'v' in queryVars )
  {
    // Prevent opening of external page
    e.preventDefault();
 
    // Variables for iFrame code. Width and height from data attributes, else use default.
    var vidWidth = 1280; // default
    var vidHeight = 720; // default
    if ( $(this).attr('data-width') ) { vidWidth = parseInt($(this).attr('data-width')); }
    if ( $(this).attr('data-height') ) { vidHeight =  parseInt($(this).attr('data-height')); }
    var iFrameCode = '<div class="video-container"><iframe width="' + vidWidth + '" height="'+ vidHeight +'" scrolling="no" allowtransparency="true" allowfullscreen="true" src="https://www.youtube.com/embed/'+  queryVars['v'] +'?rel=0&wmode=transparent&showinfo=0&autoplay=1" frameborder="0"></iframe></div>';
 
    // Replace Modal HTML with iFrame Embed
    $('#mediaModal .modal-body').html(iFrameCode);

 
    // Open Modal
    $('#mediaModal').modal();
  }
});
 
// Clear modal contents on close. 
// There was mention of videos that kept playing in the background.
$('#mediaModal').on('hidden.bs.modal', function () {
  $('#mediaModal .modal-body').html('');
});
 
}); 
</script>


  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('youtube-modal', __NAMESPACE__ . '\\youtube_modal');




















/**
 * Author Description
 */
function author_description($atts, $content = null) {
  ob_start();
  ?>
  <div class="author-description">
    <div class="row">
      <div class="col-sm-3">
        <p class="text-center"><?php echo get_avatar( get_the_author_meta('ID'), 100 ); ?></p>
      </div>
      <div class="col-sm-9">
        <h3>About the Author</h3>
        <?php the_author_description(); ?>
      </div>
    </div>
  </div>
  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('author-description', __NAMESPACE__ . '\\author_description');

/**
 * Newsletter Signup Forms
 */
function newsletter_sidebar ($atts, $content = null) {
  ob_start();
  ?>
  <div class="newsletter-sidebar newsletter-form marketo-form">
    <p><img src="/wp-content/themes/sage/dist/images/transform.jpg" class="img-responsive"></p>
    <h4>Subscribe to the Socrata newsletter</h4>
    <p>T R A N S F O R M, Socrata’s Newsletter, brings you essential news about open data, best practices for data-driven governments, and resources for successful implementation.</p>
    <script src="//app-abk.marketo.com/js/forms2/js/forms2.min.js"></script>
    <form id="mktoForm_2306"></form>
    <script>MktoForms2.loadForm("//app-abk.marketo.com", "851-SII-641", 2306);</script>
  </div>
  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('newsletter-sidebar', __NAMESPACE__ . '\\newsletter_sidebar');

function newsletter_footer ($atts, $content = null) {
  ob_start();
  ?>
  <div class="marketo-form">
    <p><img src="/wp-content/themes/sage/dist/images/transform.jpg" class="img-responsive"></p>
    <h4>Subscribe to the Socrata newsletter</h4>
    <script src="//app-abk.marketo.com/js/forms2/js/forms2.min.js"></script>
    <form id="mktoForm_2306"></form>
    <script>MktoForms2.loadForm("//app-abk.marketo.com", "851-SII-641", 2306);</script>
  </div>
  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('newsletter-footer', __NAMESPACE__ . '\\newsletter_footer');

/**
 * Marketo Form
 */
function marketo_form($atts) {
extract(shortcode_atts(array(
    "id" => '',
  ), $atts));
  return '
    <div class="marketo-form">
    <script src="//app-abk.marketo.com/js/forms2/js/forms2.min.js"></script>
    <form id="mktoForm_'.$id.'"></form>
    <script>MktoForms2.loadForm("//app-abk.marketo.com", "851-SII-641", '.$id.');</script>
    </div>
  ';
}
add_shortcode('marketo-form', __NAMESPACE__ . '\\marketo_form');

/**
 * Marketo Form with Labels
 */
function marketo_form_labels($atts) {
extract(shortcode_atts(array(
    "id" => '',
  ), $atts));
  return '
    <div class="marketo-form-labels">
    <script src="//app-abk.marketo.com/js/forms2/js/forms2.min.js"></script>
    <form id="mktoForm_'.$id.'"></form>
    <script>MktoForms2.loadForm("//app-abk.marketo.com", "851-SII-641", '.$id.');</script>
    </div>
  ';
}
add_shortcode('marketo-form-labels', __NAMESPACE__ . '\\marketo_form_labels');

/**
 * Query for logos on Solutions Pages
 */
function solutions_logos( $atts ) {
  extract( shortcode_atts( array(
    'query' => ''
  ), $atts ) );
  $query = html_entity_decode( $query );
  ob_start(); 
  $the_query = new \WP_Query( $query );
  while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
  <?php 
    $meta = get_socrata_stories_meta(); 
    $thumb = wp_get_attachment_image_src( $meta[6], 'full' ); 
    $url = $thumb['0']; ?>
  <div class="col-sm-2 solutions-logos">
    <div class="logo-frame text-center">
    <?php $meta = get_socrata_stories_meta(); 
      if ($meta[2]) { ?>      
        <a href="<?php echo $meta[2]; ?>" target="_blank"><img src="<?=$url?>" class="img-responsive" style="max-height:100px;"></a>
      <?php
      }
      else { ?>
        <img src="<?=$url?>" class="img-responsive ">
      <?php
      }
    ?>
    </div>
    <?php $meta = get_socrata_stories_meta(); 
      if ($meta[2]) { ?>
        <p class="text-center"><a href="<?php echo $meta[2]; ?>" target="_blank"><small><?php the_title();?></small></a></p>
      <?php
      }
      else { ?>
        <p class="text-center"><small><?php the_title();?></small></p>
      <?php
      }
    ?>    
  </div>
  <?php
  endwhile;
  wp_reset_postdata();
  $list = ob_get_clean();
  return $list;
}

add_shortcode( 'solutions-logos', __NAMESPACE__ . '\\solutions_logos' );

/**
 * Query for logos and abstract. Used on the homepage and product pages
 */
function customer_logos_abstract( $atts ) {
  extract( shortcode_atts( array(
    'query' => '',
    'class' => '',
  ), $atts ) );
  $query = html_entity_decode( $query );
  ob_start(); 
  $the_query = new \WP_Query( $query );
  while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
  <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'post-thumbnail' ); $url = $thumb['0']; ?>

  <div class="<?php echo $class; ?>">
    <article>
      <p><img src="<?=$url?>" class="img-responsive"></p>
      <div class="customer-text truncate">
        <h5><?php the_title(); ?></h5>
        <?php the_excerpt(); ?>
      </div>
      <ul>
        <li><a href="<?php the_permalink() ?>">Read More</a></li>
        <?php $meta = get_socrata_stories_meta(); if ($meta[2]) {echo "<li><a href='$meta[2]' target='_blank'>Visit Site</a></li>";} ?>
      </ul>
    </article>
  </div>

  <?php
  endwhile;
  wp_reset_postdata();
  $list = ob_get_clean();
  return $list;
}

add_shortcode( 'customer-logos-abstract', __NAMESPACE__ . '\\customer_logos_abstract' );


