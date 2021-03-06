<?php
/*
Plugin Name: Socrata Videos
Plugin URI: http://socrata.com/
Description: This plugin manages Socrata Videos.
Version: 1.0
Author: Michael Church
Author URI: http://socrata.com/
License: GPLv2
*/
include_once('metaboxes/meta_box.php');
include_once('inc/fields.php');


// REGISTER POST TYPE
add_action( 'init', 'create_socrata_videos' );

function create_socrata_videos() {
  register_post_type( 'socrata_videos',
    array(
      'labels' => array(
        'name' => 'Videos',
        'singular_name' => 'Videos',
        'add_new' => 'Add New Video',
        'add_new_item' => 'Add New Video',
        'edit' => 'Edit Videos',
        'edit_item' => 'Edit Videos',
        'new_item' => 'New Video',
        'view' => 'View',
        'view_item' => 'View Video',
        'search_items' => 'Search Videos',
        'not_found' => 'Not found',
        'not_found_in_trash' => 'Not found in Trash',
        'parent' => 'Socrata'
      ),
      'public' => true,
      'menu_position' => 5,
      'supports' => array( 'title', 'revisions' ),
      'taxonomies' => array( 'post_tag' ),
      'menu_icon' => '',
      'has_archive' => true,
      'rewrite' => array('with_front' => false, 'slug' => 'video')
    )
  );
}

// MENU ICON
//Using Dashicon Font http://melchoyce.github.io/dashicons/
add_action( 'admin_head', 'add_socrata_videos_icon' );
function add_socrata_videos_icon() { ?>
  <style>
    #adminmenu .menu-icon-socrata_videos div.wp-menu-image:before {
      content: '\f236';
    }
  </style>
  <?php
}

// TAXONOMIES
add_action( 'init', 'socrata_videos_segment', 0 );
function socrata_videos_segment() {
  register_taxonomy(
    'socrata_videos_segment',
    'socrata_videos',
    array(
      'labels' => array(
        'name' => 'Videos Segment',
        'menu_name' => 'Videos Segment',
        'add_new_item' => 'Add New Segment',
        'new_item_name' => "New Segment"
      ),
      'show_ui' => true,
      'show_tagcloud' => false,
      'hierarchical' => true,
      'sort' => true,      
      'args' => array( 'orderby' => 'term_order' ),
      'show_admin_column' => true,
      'rewrite' => array('with_front' => false, 'slug' => 'videos-segment'),
    )
  );
}

add_action( 'init', 'socrata_videos_product', 0 );
function socrata_videos_product() {
  register_taxonomy(
    'socrata_videos_product',
    'socrata_videos',
    array(
      'labels' => array(
        'name' => 'Videos Product',
        'menu_name' => 'Videos Product',
        'add_new_item' => 'Add New Product',
        'new_item_name' => "New Product"
      ),
      'show_ui' => true,
      'show_tagcloud' => false,
      'hierarchical' => true,
      'sort' => true,      
      'args' => array( 'orderby' => 'term_order' ),
      'show_admin_column' => true,
      'rewrite' => array('with_front' => false, 'slug' => 'videos-product'),
    )
  );
}

add_action( 'init', 'socrata_videos_categories', 0 );
function socrata_videos_categories() {
  register_taxonomy(
    'socrata_videos_category',
    'socrata_videos',
    array(
      'labels' => array(
        'name' => 'Category',
        'menu_name' => 'Category',
        'add_new_item' => 'Add New Category',
        'new_item_name' => "New Category"
      ),
      'show_ui' => true,
      'show_tagcloud' => false,
      'hierarchical' => true,
      'sort' => true,      
      'args' => array( 'orderby' => 'term_order' ),
      'show_admin_column' => true,
      'rewrite' => array('with_front' => false, 'slug' => 'videos-category'),
    )
  );
}


// CUSTOM COLUMS FOR ADMIN
add_filter( 'manage_edit-socrata_videos_columns', 'socrata_videos_edit_columns' ) ;
function socrata_videos_edit_columns( $columns ) {
  $columns = array(
    'cb'              => '<input type="checkbox" />',    
    'title'           => __( 'Name' ),
    'segment'         => __( 'Segment' ),
    'product'         => __( 'Product' ),
    'featured'        => __( 'Featured' ),
    'date'            => __( 'Date' ),
    'wpseo-score'     => __( 'SEO' ),

  );
  return $columns;
}
// Get Content for Custom Colums
add_action("manage_socrata_videos_posts_custom_column",  "socrata_videos_columns");
function socrata_videos_columns($column){
  global $post;

  switch ($column) {    
    case 'featured':
      $meta = get_socrata_videos_meta(); if ($meta[0]) echo "Yes";
      break;
    case 'segment':
      $segment = get_the_terms($post->ID , 'socrata_videos_segment');
      echo $segment[0]->name;
      for ($i = 1; $i < count($segment); $i++) {echo ', ' . $segment[$i]->name ;}
      break;
    case 'product':
      $product = get_the_terms($post->ID , 'socrata_videos_product');
      echo $product[0]->name;
      for ($i = 1; $i < count($product); $i++) {echo ', ' . $product[$i]->name ;}
      break;
  }
}
// Make these columns sortable
add_filter( "manage_edit-socrata_videos_sortable_columns", "socrata_videos_sortable_columns" );
function socrata_videos_sortable_columns() {
  return array(
    'title'       => 'title',
    'segment'     => 'segment',
    'product'     => 'product',
    'featured'    => 'featured'
  );
}

// Template Paths
add_filter( 'template_include', 'socrata_videos_single_template', 1 );
function socrata_videos_single_template( $template_path ) {
  if ( get_post_type() == 'socrata_videos' ) {
    if ( is_single() ) {
      // checks if the file exists in the theme first,
      // otherwise serve the file from the plugin
      if ( $theme_file = locate_template( array ( 'single-videos.php' ) ) ) {
        $template_path = $theme_file;
      } else {
        $template_path = plugin_dir_path( __FILE__ ) . 'single-videos.php';
      }
    }
    if ( is_archive() || is_tag() ) {
      // checks if the file exists in the theme first,
      // otherwise serve the file from the plugin
      if ( $theme_file = locate_template( array ( 'archive-videos.php' ) ) ) {
        $template_path = $theme_file;
      } else {
        $template_path = plugin_dir_path( __FILE__ ) . 'archive-videos.php';
      }
    }
  }
  return $template_path;
}

// Print Taxonomy Categories
function videos_the_categories() {
  // get all categories for this post
  global $terms;
  $terms = get_the_terms($post->ID , 'socrata_videos_segment');
  // echo the first category
  echo $terms[0]->name;
  // echo the remaining categories, appending separator
  for ($i = 1; $i < count($terms); $i++) {echo ', ' . $terms[$i]->name ;}
}

// Custom Body Class
add_action( 'body_class', 'socrata_videos_body_class');
function socrata_videos_body_class( $classes ) {
  if ( get_post_type() == 'socrata_videos' && is_single() || get_post_type() == 'socrata_videos' && is_archive() )
    $classes[] = 'socrata-videos';
  return $classes;
}


// CUSTOM EXCERPT
function videos_excerpt() {
  global $post;
  $text = get_post_meta($post->ID, 'editorField', true);
  if ( '' != $text ) {
    $text = strip_shortcodes( $text );
    $text = apply_filters('the_content', $text);
    $text = str_replace(']]>', ']]>', $text);
    $excerpt_length = 20; // 20 words
    $excerpt_more = apply_filters('excerpt_more', ' ' . ' ...');
    $text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
  }
  return apply_filters('get_the_excerpt', $text);
}

// ENQEUE SCRIPTS
add_action( 'wp_enqueue_scripts', 'register_socrata_videos_script' );
function register_socrata_videos_script() {
wp_register_script( 'video-slider', plugins_url( '/js/video-slider.js' , __FILE__ ), array(), '1.0.0', true );

// YouTube Button and Shorcode for TinyMCE
add_shortcode("youtube", "cwc_youtube");
function cwc_youtube($atts) {
  extract(shortcode_atts(array(
    "id" => '',
  ), $atts));
  return '<div class="video-container">
  <iframe src="https://www.youtube.com/embed/'.$id.'?rel=0" frameborder="0" allowfullscreen></iframe>
  </div>'
  ;
}

add_action('init', 'add_youtube_button');
function add_youtube_button() {
   if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )
   {
     add_filter('mce_external_plugins', 'add_youtube_plugin');
     add_filter('mce_buttons', 'register_youtube_button');
   }
}

function register_youtube_button($buttons) {
   array_push($buttons, "youtube");
   return $buttons;
}

function add_youtube_plugin($plugin_array) {
   $plugin_array['youtube'] = plugins_url( '/js/youtube.js' , __FILE__ );
   return $plugin_array;
}
}


//Shortcode [video-cards]
function video_cards( $atts ) {
  extract( shortcode_atts( array(
    'query' => '',
    'class' => '',
  ), $atts ) );
  $query = html_entity_decode( $query );
  ob_start(); 
  $the_query = new WP_Query( $query );
  while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

  <div class="<?php echo $class; ?>">
    <article class="card-depriciated card-video">
      <div class="card-image">
        <img src="https://img.youtube.com/vi/<?php $meta = get_socrata_videos_meta(); echo $meta[1]; ?>/mqdefault.jpg" class="img-responsive">
        <a class="link" href="<?php the_permalink() ?>"></a>
      </div>
      <div class="card-text truncate">
        <p class="categories"><?php videos_the_categories(); ?></p>
        <h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
        <?php $meta = get_socrata_videos_meta(); if ($meta[2]) {echo "$meta[2]";} ?>
      </div>      
    </article>
  </div>

  <?php
  endwhile;
  wp_reset_postdata();
  $list = ob_get_clean();
  return $list;
}
add_shortcode( 'video-cards', 'video_cards' );


//Shortcode [video-slider]
function video_slider( $atts ) { 
  extract( shortcode_atts( array(
    'query' => ''
  ), $atts ) );
  $query = html_entity_decode( $query );
  ob_start(); ?>
<div id="slider-one">
  <div class="container">
    <div class="row">    
      <div id="video-slider">
        <?php
        $the_query = new WP_Query( $query );
        while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

        <div class="col-sm-6 col-md-3 slide">
        <article class="card-depriciated card-video">
        <div class="card-image">
        <img src="https://img.youtube.com/vi/<?php $meta = get_socrata_videos_meta(); echo $meta[1]; ?>/mqdefault.jpg" class="img-responsive">
        <a class="link" href="<?php the_permalink() ?>"></a>
        </div>
        <div class="card-text truncate">
        <h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
        <?php $meta = get_socrata_videos_meta(); if ($meta[2]) {echo "$meta[2]";} ?>
        </div>      
        </article>
        </div>

        <?php
        endwhile;
        wp_reset_postdata(); ?>
        <?php { ?>

      </div>
    </div>
  </div>
</div>

<?php
}; ?>

  <?php
  wp_enqueue_script( 'video-slider' );
  $list = ob_get_clean();
  return $list;
}
add_shortcode( 'video-slider', 'video_slider' );



// Shortcode [socrata-videos-posts]
function socrata_videos_posts($atts, $content = null) {
  ob_start();
  ?>
<?php $query = new WP_Query();
$query->query('post_type=socrata_videos&meta_key=socrata_videos_featured&orderby=desc&showposts=1');
while ($query->have_posts()) : $query->the_post(); ?>
<section class="img-background overlay-black-stripes video-hero" 
style="background-image:url(https://img.youtube.com/vi/<?php $meta = get_socrata_videos_meta(); echo $meta[1]; ?>/maxresdefault.jpg);">
<div class="video-subnav hidden-xs hidden-sm">
<div class="container">


<ul class="nav nav-pills navbar-right">

<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Segment <span class="caret"></span></a>
<ul class="dropdown-menu">
<li><a href="/videos-segment/federal">Federal</a></li>
<li><a href="/videos-segment/state">State</a></li>
<li><a href="/videos-segment/city">City</a></li>
<li><a href="/videos-segment/county">County</a></li>
<li><a href="/videos-segment/non-profit">Non-Profit</a></li>
<li><a href="/videos-segment/international">International</a></li>
</ul>
</li>

<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Product <span class="caret"></span></a>
<ul class="dropdown-menu">
<li><a href="/videos-product/open-data">Open Data</a></li>
<li><a href="/videos-product/open-performance">Open Performance</a></li>
<li><a href="/videos-product/socrata-for-finance">Socrata for Finance</a></li>
<li><a href="/videos-product/socrata-for-public-safety">Socrata for Public Safety</a></li>
</ul>
</li>

<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Series <span class="caret"></span></a>
<ul class="dropdown-menu">
<li><a href="/videos-category/open-data-tv">Open Data TV</a></li>
<li><a href="/videos-category/customer-summit-2015">Socrata Customer Summit</a></li>
</ul>
</li>

</ul>

</div>
</div>

  <div class="container">
    <div class="row">      
      <div class="col-sm-4 padding-30">
        <div class="text truncate">
          <h2 class="text-reverse margin-bottom-15"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>        
          <?php $meta = get_socrata_videos_meta(); if ($meta[2]) {echo "$meta[2]";} ?>
        </div>
        <p class="meta text-reverse"><small><strong>Posted</strong>, <?php the_time('F jS, Y') ?></small></p>
      </div>
    </div>
  </div>
  <div class="vertical-center text-center hidden-xs">
    <a href="<?php the_permalink() ?>"><i class="fa fa-play-circle-o"></i></a>
  </div>
</section>
<?php endwhile; ?>
<?php wp_reset_query(); ?>

<section class="padding-15 background-midnight-blue">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <h5 class="text-center text-reverse" style="margin:0;">Over <span class="color-sun-flower" style="font-weight: 900;">100+</span> Open Data Videos Available</h5>
      </div>
    </div>
  </div>
</section>

<section class="section-padding background-clouds">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <h3 class="color-concrete">New and Noteworthy</h3>
      </div>
    </div>
  </div>
  <div id="noteworthy" class="slider-arrows">
    <div class="container">
      <div id="noteworthy-slides" class="row">    

        <?php $query = new WP_Query();
        $query->query('post_type=socrata_videos&meta_key=socrata_videos_featured&orderby=desc&showposts=8&offset=1');
        while ($query->have_posts()) : $query->the_post(); ?>
        <div class="col-sm-6 col-md-3 slide">
          <article class="card-depriciated card-video">
            <div class="card-image">
              <img src="https://img.youtube.com/vi/<?php $meta = get_socrata_videos_meta(); echo $meta[1]; ?>/mqdefault.jpg" class="img-responsive">
              <a class="link" href="<?php the_permalink() ?>"></a>
            </div>
            <div class="card-text truncate">
              <h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
              <?php $meta = get_socrata_videos_meta(); if ($meta[2]) {echo "$meta[2]";} ?>
            </div>      
          </article>
        </div>
        <?php endwhile; ?>
        <?php wp_reset_query(); ?>

      </div>
    </div>
  </div>
</section>
<?php echo do_shortcode('[responsive-carousel id="noteworthy" slide_id="noteworthy-slides"]'); ?>

<section id="videos-segment" class="section-padding">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <h3 class="color-concrete">Videos by Segment</h3>
      </div>
    </div>
  </div>
  <div id="segments" class="slider-arrows" style="min-height:200px;">
    <div class="container">
      <div id="segment-slides" class="row">

        <div class="col-sm-6 col-md-3 slide">
          <div class="segment-tile background-peter-river">
            <div class="vertical-center">
              <div class="text-center text-reverse margin-bottom-15"><i class="icon-capital icon-50"></i><br>FEDERAL</div>
            </div>
            <a href="/videos-segment/federal/"></a>
          </div>
        </div>
        <div class="col-sm-6 col-md-3 slide">
          <div class="segment-tile background-green-sea">
            <div class="vertical-center">
              <div class="text-center text-reverse margin-bottom-15"><i class="icon-state icon-50"></i><br>STATE</div>
            </div>
            <a href="/videos-segment/state/"></a>
          </div>
        </div>
        <div class="col-sm-6 col-md-3 slide">
          <div class="segment-tile background-pumpkin">
            <div class="vertical-center">
              <div class="text-center text-reverse margin-bottom-15"><i class="icon-city icon-50"></i><br>CITY</div>
            </div>
            <a href="/videos-segment/city/"></a>
          </div>
        </div>
        <div class="col-sm-6 col-md-3 slide">
          <div class="segment-tile background-amethyst">
            <div class="vertical-center">
              <div class="text-center text-reverse margin-bottom-15"><i class="icon-map icon-50"></i><br>COUNTY</div>
            </div>
            <a href="/videos-segment/county/"></a>
          </div>
        </div>
        <div class="col-sm-6 col-md-3 slide">
          <div class="segment-tile background-orange">
            <div class="vertical-center">
              <div class="text-center text-reverse margin-bottom-15"><i class="icon-people icon-50"></i><br>NON-PROFIT</div>
            </div>
            <a href="/videos-segment/non-profit/"></a>
          </div>
        </div>
        <div class="col-sm-6 col-md-3 slide">
          <div class="segment-tile background-nephritis">
            <div class="vertical-center">
              <div class="text-center text-reverse margin-bottom-15"><i class="icon-geography icon-50"></i><br>INTERNATIONAL</div>
            </div>
            <a href="/videos-segment/international/"></a>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>
<?php echo do_shortcode('[responsive-carousel id="segments" slide_id="segment-slides"]'); ?>

<section id="videos-product" class="section-padding background-clouds">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <h3 class="color-concrete">Videos by Product</h3>
      </div>
    </div>
  </div>
  <div id="products" class="slider-arrows" style="min-height:200px;">    
    <div class="container">
      <div id="product-slides" class="row">
        <div class="col-sm-6 col-md-3 slide">
          <div class="segment-tile img-background channel-open-data overlay-black">
            <div class="vertical-center padding-30">
              <div class="text-center text-reverse margin-bottom-15">OPEN DATA</div>
            </div>
            <a href="/videos-product/open-data/"></a>
          </div>
        </div>
        <div class="col-sm-6 col-md-3 slide">
          <div class="segment-tile img-background channel-open-performance  overlay-black">
            <div class="vertical-center padding-30">
              <div class="text-center text-reverse margin-bottom-15">OPEN PERFORMANCE</div>
            </div>
            <a href="/videos-product/open-performance/"></a>
          </div>
        </div>
        <div class="col-sm-6 col-md-3 slide">
          <div class="segment-tile img-background channel-socrata-for-finance overlay-black">
            <div class="vertical-center padding-30">
              <div class="text-center text-reverse margin-bottom-15">SOCRATA FOR FINANCE</div>
            </div>
            <a href="/videos-product/socrata-for-finance/"></a>
          </div>
        </div>
        <div class="col-sm-6 col-md-3 slide">
          <div class="segment-tile img-background channel-socrata-for-public-safety overlay-black">
            <div class="vertical-center padding-30">
              <div class="text-center text-reverse margin-bottom-15">SOCRATA FOR PUBLIC SAFETY</div>
            </div>
            <a href="/videos-product/socrata-for-public-safety/"></a>
          </div>
        </div>
      </div>
    </div>
  </div>  
</section>
<?php echo do_shortcode('[responsive-carousel id="products" slide_id="product-slides"]'); ?>

<section id="videos-series" class="section-padding">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <h3 class="color-concrete">Videos by Series</h3>
      </div>
    </div>
  </div>
  <div id="series" class="slider-arrows" style="min-height:200px;">
    <div class="container">
      <div id="series-slides" class="row">              
        <div class="col-sm-6 col-md-3">
          <div class="segment-tile img-background channel-odtv overlay-black">
            <div class="vertical-center padding-30">
              <div class="text-center text-reverse margin-bottom-15">OPEN DATA TV</div>
            </div>
            <a href="/videos-category/open-data-tv/"></a>
          </div>
        </div>
        <div class="col-sm-6 col-md-3">
          <div class="segment-tile img-background channel-customer-summit overlay-black">
            <div class="vertical-center padding-30">
              <div class="text-center text-reverse margin-bottom-15">SOCRATA CUSTOMER SUMMIT</div>
            </div>
            <a href="/videos-category/customer-summit-2015/"></a>
          </div>
        </div>          
      </div>
    </div>
  </div>
</section>
<?php echo do_shortcode('[responsive-carousel id="series" slide_id="series-slides"]'); ?>



  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('socrata-videos-posts', 'socrata_videos_posts');



