<?php
    $page='index';
    include('header.php');
?>
 
    <div class="hero-wrap js-fullheight" style="background-image: url('images/dash.jpg');">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-start" data-scrollax-parent="true">
          <div class="col-md-9 ftco-animate mb-5 pb-5 text-center text-md-left" data-scrollax=" properties: { translateY: '70%' }">
            <h1 class="mb-4" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">From <br>Icons to Secrets</h1>
            <p data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">Discover Maharashtra Your Way.</p>
          </div>
        </div>
      </div>
    </div>
    <section class="ftco-section bg-light">
    	<div class="container">
    		<div class="row">
    			<div class="col-md-4">
    				<div class="intro ftco-animate">
    					<h3><span>01</span> Discover</h3>
    					<p>Trace iconic landmarks and tucked-away villages alike. From Ajanta’s ancient caves to quiet hill stations, start every journey with fresh curiosity.</p>
    				</div>
    			</div>
    			<div class="col-md-4">
    				<div class="intro ftco-animate">
    					<h3><span>02</span> Immerse</h3>
    					<p>Meet the culture up close—festivals, street food, local art, and stories that bring Maharashtra’s traditions to life.</p>
    				</div>
    			</div>
    			<div class="col-md-4">
    				<div class="intro ftco-animate">
    					<h3><span>03</span> Unwind</h3>
    					<p>Find your perfect pause: beaches at sunset, serene lakes, or a cool mountain breeze after a long trek.</p>
    				</div>
    			</div>
    		</div>
    	</div>
    </section>

    <section class="ftco-section">
    	<div class="container">
    		<div class="row justify-content-center mb-5 pb-3">
          <div class="col-md-7 heading-section text-center ftco-animate">
            <h2 class="mb-4">See our latest destination</h2>
          </div>
        </div>
        <div class="row">
        	<div class="col-md-4 ftco-animate">
        		<a href="destination.php" class="destination-entry img" style="background-image: url(images/kaas-plateau.jpg);">
        			<div class="text text-center">
        				<h3>Nature</h3>
        			</div>
        		</a>
        	</div>
        	<div class="col-md-4 ftco-animate">
        		<a href="destination.php" class="destination-entry img" style="background-image: url(images/ajanta.jpg);">
        			<div class="text text-center">
        				<h3>Heritage</h3>
        			</div>
        		</a>
        	</div>
        	<div class="col-md-4 ftco-animate">
        		<a href="destination.php" class="destination-entry img" style="background-image: url(images/kalsubai.jpg);">
        			<div class="text text-center">
        				<h3>Adventure</h3>
        			</div>
        		</a>
        	</div>
        </div>
    	</div>
    </section>
		
		<section class="ftco-about d-md-flex">
    	<div class="one-half img" style="background-image: url(images/about.jpg);height:400;width:300;"></div>
    	<div class="one-half ftco-animate">
        <div class="heading-section ftco-animate ">
          <h2 class="mb-4">✨ Discover Maharashtra with SecretMaps</h2>
        </div>
        <div>
  			<p>
            At SecretMaps, we believe travel is more than checking destinations off a list—it’s about uncovering stories, cultures, and moments that stay with you forever. From iconic forts and vibrant cities to tucked-away waterfalls and serene trails, we curate journeys that reveal Maharashtra’s best-kept secrets.
            Whether you’re after adventure, heritage, or a quiet escape, SecretMaps is your trusted guide to experiences you’ll never forget.
        </p>
        </div>
      </div>
    </section>

    <section class="ftco-section services-section bg-light">
      <div class="container">
        <div class="row d-flex">
          <div class="col-md-3 d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services d-block">
              <div class="icon"><span class="flaticon-yatch"></span></div>
              <div class="media-body">
                <h3 class="heading mb-3">Curated Experiences</h3>
                <p>Handpicked routes and activities that blend Maharashtra’s famous sights with hidden gems.</p>
              </div>
            </div>      
          </div>
          <div class="col-md-3 d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services d-block">
              <div class="icon"><span class="flaticon-around"></span></div>
              <div class="media-body">
                <h3 class="heading mb-3">Seamless Planning</h3>
                <p>From transport to timings, we help you plan every step so you can just explore.</p>
              </div>
            </div>    
          </div>
          <div class="col-md-3 d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services d-block">
              <div class="icon"><span class="flaticon-compass"></span></div>
              <div class="media-body">
                <h3 class="heading mb-3">Local Expert Guides</h3>
                <p>Trusted guides who share insider stories, culture, and history along the way.</p>
              </div>
            </div>      
          </div>
          <div class="col-md-3 d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services d-block">
              <div class="icon"><span class="flaticon-map-of-roads"></span></div>
              <div class="media-body">
                <h3 class="heading mb-3">Hidden-Spot Finder</h3>
                <p>Get precise directions to offbeat waterfalls, forts, and trails most travelers miss.</p>
              </div>
            </div>      
          </div>
        </div>
      </div>
    </section>
   

<?php
    include('footer.php');
?>