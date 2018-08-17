<section class="section-padding">
  <div class="container">
    <div class="row">
      <div class="col-sm-8">
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
      <div class="col-sm-4 hidden-sm hidden-xs">
        <div class="category-nav">
          <h5>Guide Chapters</h5>
          <?php wp_nav_menu( array( 'theme_location' => 'field_guide' ) ); ?>
        </div>
        <div class="padding-30 background-clouds">
          <h4 class="margin-bottom-15">Request more information</h4>
          <p>Want to know more about what Socrata can do for Open Data &amp; Citizen Engagement? We’d love to show you what we can do. Fill out the form and a qualified Socrata representative will set up a no obligation meeting to assess your needs.</p>
					<script src="//app-ab26.marketo.com/js/forms2/js/forms2.min.js"></script>
					<form id="mktoForm_2833"></form>
					<script>MktoForms2.loadForm("//app-ab26.marketo.com", "015-NUU-525", 2833);</script>
        </div>
      </div>
    </div>
  </div>
</section>