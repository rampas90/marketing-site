<section class="section-padding hero-opg-single img-background" style="background-image:url(/wp-content/uploads/opg-hero.jpg);">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 col-md-8 col-lg-6">
        <h1 class="margin-bottom-15"><?php the_title(); ?></h1>
        <div class="margin-bottom-30"><?php echo do_shortcode('[addthis]');?></div>
      </div>
    </div>
  </div>
  <div class="bar"></div>
</section>
<?php the_content(); ?>
<section class="background-peter-river opg-nav">
  <div class="container">
    <div class="row no-gutters">
      <div class="col-sm-6">
        

            <?php if(get_adjacent_post(false, '', true)) { }
            else { ?>
            <a href="/open-performance-guide" class="previous-post-button">Open Performance Guide Intro</a>
            <?php
            } ; ?>

          <?php previous_post_link( '%link', '%title', TRUE, '', 'socrata_opg_cat' ); ?>
      
      </div>
      <div class="col-sm-6">
      
          <?php next_post_link( '%link', '%title', TRUE, '', 'socrata_opg_cat' ); ?>

      </div>
    </div>
  </div>
</section>
<section class="background-clouds section-padding opg-footer">
    <div class="container">
      <div class="row">        
        <div class="col-sm-5 col-sm-offset-1">
          <h2 class="margin-bottom-15">Request a Demo of Open Performance</h2>            
          <p>Interested in seeing how your Government performs? Send us your contact information to get started with a personalized demo and pricing.</p>
          <?php echo do_shortcode('[marketo-form id="2845"]');?>
        </div>
        <div class="col-sm-4 col-sm-offset-1">
          <?php echo do_shortcode('[opg-table-of-contents]');?>
        </div>   
      </div>
    </div>
</section>