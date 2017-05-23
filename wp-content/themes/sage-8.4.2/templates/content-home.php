<section class="home-masthead">
<div class="slider">
	<div class="slide" style="background-image:url(/wp-content/uploads/hero-virginia-beach.jpg)">
		<div class="text">
			<div class="vertical-center">
				<div class="container">
					<div class="row">
						<div class="col-sm-8 col-md-6">
							<h1 class="color-white margin-bottom-15" style="line-height:1.1em;">A Future Fueled by Data</h1>
							<h4 class="color-white text-normal hidden-xs margin-bottom-0">What Works City Virginia Beach has set a new standard for transparency and performance measurement with open data</h4>
							<ul class="cta-list">
								<li><a href="/case-study/future-fueled-data-virginia-beach/" class="btn btn-default outline">Read More <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="slide" style="background-image:url(/wp-content/uploads/firefighter-hero.jpg)">
		<div class="text">
			<div class="vertical-center">
				<div class="container">
					<div class="row">
						<div class="col-sm-8 col-md-6">
							<h1 class="color-white margin-bottom-15">First Due Size-Up is Transforming Emergency Response</h1>
							<h4 class="color-white text-normal hidden-xs margin-bottom-0">Their mission is simple: harness and deploy the power of data to help end the thousands of first responder and civilian injuries and fatalities that are caused each year by a lack of critical up-front information</h4>
							<ul class="cta-list">
								<li><a href="/blog/firefighters-can-save-lives-data/" class="btn btn-default outline">Read <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a></li>
								<li><a href="http://firstduesizeup.com/" class="btn btn-default outline" target="_blank">Learn More <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</section>
<script>
jQuery(function ($){
      $('.slider').slick({
        arrows: false,
        dots: true,
        autoplay: true,
        autoplaySpeed:5000,
        speed: 500,
        infinite:true,
        fade:true,
        cssEase: 'linear',
        pauseOnHover:true,
        pauseOnDotsHover:true,
      });
      $('.slider').show();
    });
</script>
<section class="section-padding">
	<div class="container">
		<div class="row margin-bottom-30">
			<div class="col-sm-12">
				<h2 class="text-center section-title">Trusted by over 1,000 government organizations</h2>
			</div>
			<div class="col-sm-6 col-md-3 match-height margin-bottom-30">
				<p><a href="/solutions/federal-government"><img src="/wp-content/uploads/thumb-federal.jpg" class="img-responsive"></a></p>
				<h5 class="text-center">Federal Government</h5>
			</div>
			<div class="col-sm-6 col-md-3 match-height margin-bottom-30">
				<p><a href="/solutions/state-government"><img src="/wp-content/uploads/thumb-state.jpg" class="img-responsive"></a></p>
				<h5 class="text-center">State Government</h5>
			</div>
			<div class="col-sm-6 col-md-3 match-height margin-bottom-30">
				<p><a href="/solutions/county-government"><img src="/wp-content/uploads/thumb-county.jpg" class="img-responsive"></a></p>
				<h5 class="text-center">County Government</h5>
			</div>
			<div class="col-sm-6 col-md-3 match-height margin-bottom-30">
				<p><a href="/solutions/city-government"><img src="/wp-content/uploads/thumb-city.jpg" class="img-responsive"></a></p>
				<h5 class="text-center">City Government</h5>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1">
				<p class="text-center">Socrata customer sites are powered by: <a href="https://aws.amazon.com/" target="_blank"><img src="/wp-content/uploads/logo-aws-small.png"></a></p>
			</div>
		</div>
	</div>
</section>
<section class="background-video">
	<div class="text">
		<div class="vertical-center">
			<div class="container">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<h2 class="section-title color-white">Why Socrata</h2>
						<p class="lead color-white">Socrata's cloud-based solutions allow government organizations to put their data online, make data-driven decisions, operate more efficiently, and share insights with citizens.</p>
						<p><a href="https://www.youtube.com/watch?v=yH4RnuPijZA" role="button"><i class="fa fa-play-circle-o"></i></a></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="myvideo" class="image" style="background-image:url(https://img.youtube.com/vi/yH4RnuPijZA/maxresdefault.jpg)"></div>
	<div id="video" class="player" data-property="{videoURL:'yH4RnuPijZA',containment:'#myvideo', showControls:false, autoPlay:true, loop:true, mute:true, startAt:9, stopAt:19, opacity:1, addRaster:true, quality:'default'}"></div>
	<script>jQuery(function(e){e("#video").YTPlayer()});</script>
</section>
<?php echo do_shortcode("[youtube-modal]"); ?>