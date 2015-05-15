<?php
/**
 * Template Name: Product
 */
$intro_headline = get_field('intro_headline');
$intro_subhead = get_field('intro_subhead');
$intro_body = get_field('intro_body');
$intro_image = get_field('intro_image');
$intro_background = get_field('intro_background');
$external_video = get_field('external_video_link');

?>

<section class="product-intro">
  <?php
  if( have_rows('intro_background') ):
    while ( have_rows('intro_background') ) : the_row();
      $background = '';
      if( get_row_layout() == 'background_contained' ):

        $background = get_sub_field('background_image');
        echo '<div class="feature-container contain" style="background-image: url(' . $background . ')">';

      elseif( get_row_layout() == 'background_full_width' ):

        $background = get_sub_field('background_image');
        echo '<div class="feature-container cover" style="background-image: url(' . $background . ')">';
      endif;
    endwhile;
  else :

    echo '<div class="feature-container">';

  endif;
  ?>
  <div class="container intro-background">
    <div class="row">
      <div class="col-md-6 col-md-offset-1">

        <div class="intro-headline">
          <h1><?php echo $intro_headline; ?></h1>
        </div>
        <div class="intro-subhead">
          <p><?php echo $intro_subhead; ?></p>
        </div>
        <div class="intro-body">
          <p><?php echo $intro_body; ?></p>

          <?php if ($external_video) {
            echo '<a href="'.$external_video.'" target="_blank" class="button">See a Quick Demo</a>&nbsp;';
          } ?>

          <?php
            $video = get_field('intro_video');
            if($video) {
              preg_match('/src="(.+?)"/', $video, $matches);
              $src = $matches[1];
              $params_mobile = array(
                  'enablejsapi'   => 1,
                  'rel'   => 0,
                  'controls'  => 0,
                  'html5'     => 1,
                  'showinfo'  =>0,
                  'playsinline' => 1
              );
              $params_desktop = $params_mobile;
              $params_desktop['autoplay'] = 1;

              $desktop_src = add_query_arg($params_desktop, $src);
              $mobile_src = add_query_arg($params_mobile, $src);
              ?>
              <a href="#" class="hidden-xs hidden-sm button" id="play-button" data-toggle="modal" data-target="#videoModal" data-content="<?php echo $desktop_src; ?>">
                Learn About Financial Transparency
              </a>

              <?php
                $video = str_replace($src, $mobile_src, $video);
                $attributes = 'id="player2"';
                $video = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $video);
              ?>

              <div class="embed-container visible-xs visible-sm">
                <?php echo $video; ?>
              </div>
          <?php } // end if $video ?>
        </div>

      </div>
    </div>
  </div>
</section>

<section class="product-pillars">
  <div class="container">
      <?php
        $pillar_1_image = get_field('pillar_1_image');
        $pillar_1_headline = get_field('pillar_1_headline');
        $pillar_1_features = get_field('pillar_1_features');

        $pillar_2_image = get_field('pillar_2_image');
        $pillar_2_headline = get_field('pillar_2_headline');
        $pillar_2_features = get_field('pillar_2_features');

        if ($pillar_1_features) {
          echo '<div class="row pillar"><div class="col-md-6 col-sm-12">';
            echo '<img src="'.$pillar_1_image['url'].'" alt="'.$pillar_1_image['title'].'" class="img-responsive">';
          echo '</div>';
          echo '<div class="col-md-6 col-sm-12">';
            echo '<h2>'.$pillar_1_headline.'</h2>';
            echo $pillar_1_features;
          echo '</div></div>';
        }
        if ($pillar_2_features) {
          echo '<div class="row pillar"><div class="col-md-6 col-md-push-6 col-sm-12">';
            echo '<img src="'.$pillar_2_image['url'].'" alt="'.$pillar_2_image['title'].'" class="img-responsive">';
          echo '</div>';
          echo '<div class="col-md-6 col-md-pull-6 col-sm-12">';
            echo '<h2>'.$pillar_2_headline.'</h2>';
            echo $pillar_2_features;
          echo '</div></div>';
        }
      ?>
    </div>
  </div>
</section>

<section class="product-features">
  <div class="container">
    <div class="features-grid">
      <div class="row">

      <?php
        $tileNum = count(get_field('feature_tiles'));

        if( have_rows('feature_tiles') ):

          // count number of tiles
          $tileNum = count(get_field('feature_tiles'));

          while ( have_rows('feature_tiles') ) : the_row();

            $tile_image = get_sub_field('tile_image');
            $tile_body = get_sub_field('tile_body');


            if ($tileNum <= 2) {
              echo '<div class="col-sm-6">
                      <div class="grid-tile">
                        <div class="tile-image">
                          <img src="' . $tile_image . '" alt="feature tile" class="img-responsive">
                        </div>
                        <div class="tile-text">
                          <p>' . $tile_body . '</p>
                        </div>
                      </div>
                    </div>';
            }else if ($tileNum === 3) {
              echo '<div class="col-sm-4">
                      <div class="grid-tile">
                        <div class="tile-image">
                          <img src="' . $tile_image . '" alt="feature tile" class="img-responsive">
                        </div>
                        <div class="tile-text">
                          <p>' . $tile_body . '</p>
                        </div>
                      </div>
                    </div>';
            }else if ($tileNum === 4) {
            echo '<div class="col-sm-6 col-md-3">
                    <div class="grid-tile">
                      <div class="tile-image">
                        <img src="' . $tile_image . '" alt="feature tile" class="img-responsive">
                      </div>
                      <div class="tile-text">
                        <p>' . $tile_body . '</p>
                      </div>
                    </div>
                  </div>';
            }


          endwhile;
        endif;
      ?>

      </div>
    </div>
  </div>
</section>

<section class="pain-points">
  <div class="container">
    <?php
    if( have_rows('pain_points_slider', 'option') ): ?>
      <div class="row pain-points-slider">
        <?php while ( have_rows('pain_points_slider', 'option') ) : the_row();
          $subhead = get_sub_field('subhead');
          $header = get_sub_field('header');
          $content = get_sub_field('content');
          $background_image = get_sub_field('background_image');

          if($background_image) {
          ?>
          <div class="col-sm-12 slide" style="background-image: url(<?php echo $background_image['url']; ?>);">
            <div class="row">
              <div class="col-lg-offset-1 col-md-5 slide-content">
                <h4><?php if($subhead) { echo $subhead; }?></h4>
                <h3><?php if($header) { echo $header; }?></h3>
                <?php if($content) { echo $content; }?>
              </div>
            </div>
          </div>

        <?php }
        endwhile; ?>
      </div>
      <script>
      document.addEventListener('DOMContentLoaded', function() {
        $('.pain-points-slider').slick({
          arrows: true,
          prevArrow: '<i class="fa slick-prev fa-chevron-left"></i>',
          nextArrow: '<i class="fa slick-next fa-chevron-right"></i>',
          autoplay: true,
          autoplaySpeed: 8000,
          speed: 800,
          slidesToShow: 1,
          slidesToScroll: 1
        });
      }, false);
      </script>
    <?php endif; ?>
  </div>
</section>

<section id="cta-links">
  <div class="container">
    <div class="row">

    <?php
      if( have_rows('cta_tiles') ):
        while ( have_rows('cta_tiles') ) : the_row();
          $rtp_id = get_sub_field('rtp_id');
          $tile_icon = get_sub_field('tile_icon');
          $tile_headline = get_sub_field('tile_headline');
          $tile_body = get_sub_field('tile_body');

          if( have_rows('tile_button_link') ):
            while ( have_rows('tile_button_link') ) : the_row();
              $link = '';
              $link_text = '';
              if( get_row_layout() == 'internal_link' ):
                $link = get_sub_field('link_url');
                $link_text = get_sub_field('link_text');
              elseif( get_row_layout() == 'external_link' ):
                $link = get_sub_field('link_url');
                $link_text = get_sub_field('link_text');
              endif;
            endwhile;
          endif;

          echo '<div class="col-md-4">
                  <div class="features-tile" id="'.$rtp_id.'">
                    <div class="tile-icon">
                      <i class="fa ' . $tile_icon . ' blue"></i>
                    </div>
                    <div class="tile-content">
                      <div class="content-text">
                        <div class="text-headline">
                          <h3>' . $tile_headline . '</h3>
                        </div>
                        <div class="text-body">
                          <p>' . $tile_body . '</p>
                        </div>
                      </div>
                      <div class="content-button">
                        <a href="' . $link . '" class="btn btn-primary">' . $link_text . '</a>
                      </div>
                    </div>
                  </div>
                </div>';
        endwhile;
      endif;
    ?>

    </div>
  </div>
</section>

<div class="modal fade videoModal" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="videoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button id="close-button" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">

        <div class="embed-container">
          <iframe width="200" height="113" frameborder="0" allowfullscreen="" id="player"></iframe>
        </div>

      </div>
    </div>
  </div>
</div>
