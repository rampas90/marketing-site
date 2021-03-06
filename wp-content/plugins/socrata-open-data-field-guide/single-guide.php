<section class="section-padding">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 col-md-7 col-md-offset-1">
        <h1 class="margin-bottom-15"><?php the_title(); ?></h1>
        <div class="margin-bottom-30"><?php echo do_shortcode('[addthis]');?></div>
        <?php the_content(); ?>
        <hr/>
        <div><?php next_post_link( '%link', 'PREVIOUS CHAPTER: %title', TRUE, '1283,1282,1562,1563', 'guide_category' ); ?></div>
        <div><?php previous_post_link( '%link', 'NEXT CHAPTER: %title', TRUE, '1283,1282,1562,1563', 'guide_category' ); ?></div>
        <!--<?php if( get_posts() ) {
        previous_post_link('<p><strong><small>NEXT CHAPTER:</small><br>%link</strong></p>');
        next_post_link('<p><strong><small>PREVIOUS CHAPTER:</small><br>%link</strong></p>');
        }?>-->
      </div>
      <div class="col-md-3 hidden-sm hidden-xs">
        <div class="category-nav">
          <h5>Guide Chapters</h5>
          <?php wp_nav_menu( array( 'theme_location' => 'field_guide' ) ); ?>
        </div>
        <div class="padding-15 background-clouds">
          <h4>Request a demo of Open Data</h4>
          <p>Interested in establishing an open data portal for your community? Send us your contact information to get started with a personalized demo and pricing.</p>
          <?php echo do_shortcode('[marketo-form id="2846"]');?>
        </div>
      </div>
    </div>
  </div>
</section>