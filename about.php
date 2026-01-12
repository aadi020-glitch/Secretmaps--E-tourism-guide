<?php
$page = 'about';
include('header.php');
?>
<div class="hero-wrap js-fullheight" style="background-image: url('images/about_.jpg');">
  <div class="overlay"></div>
  <div class="container">
    <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center" data-scrollax-parent="true">
      <div class="col-md-9 text-center ftco-animate" data-scrollax=" properties: { translateY: '70%' }">
        <p class="breadcrumbs" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }"><span class="mr-2"><a href="index.php">Home</a></span> <span><a href="about.php">About</a></span></p>
        <h1 class="mb-3 bread" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">About Us</h1>
      </div>
    </div>
  </div>
</div>

<section class="ftco-section">
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <div class="intro">
          <h3><span>01</span> Discover</h3>
          <p>Uncover Maharashtra’s iconic landmarks and hidden gems with carefully curated routes that reveal the state’s rich culture and breathtaking nature</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="intro">
          <h3><span>02</span> Explore</h3>
          <p>Immerse yourself in authentic experiences—trek rugged forts, wander vibrant bazaars, or follow serene forest trails guided by local insights.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="intro">
          <h3><span>03</span> Cherish</h3>
          <p>Create memories that last a lifetime as SecretMaps helps you capture the beauty, history, and spirit of every destination you visit.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="ftco-about d-md-flex">
  <div class="one-half img" style="background-image: url(images/about.jpg);"></div>
  <div class="one-half ftco-animate">
    <div class="heading-section ftco-animate ">
      <h2 class="mb-4">About SecretMaps</h2>
    </div>
    <div>
      <p>Planning a trip can be overwhelming—endless searches, scattered details, and the fear of missing something special. SecretMaps makes it simple.
        We bring together Maharashtra’s most iconic landmarks and least-known gems in one easy-to-use guide, so you can explore with confidence and excitement..</p>
      <p>Why travelers love us:
      <ul>
        <li><b>Handpicked Spots:</b> Only the best destinations, from famous forts to secret waterfalls.</li>

        <li><b>Insights: </b>Local tips and stories you won’t find in generic travel blogs.</li>

        <li><b>Ready-to-Use Info:</b> Maps, highlights, and categories (Heritage, Nature, Adventure) for quick planning.</li>
      </ul>
      </p>
    </div>
</section>
<section class="ftco-section testimony-section">
  <div class="container">
    <div class="row justify-content-center mb-5 pb-3">
      <div class="col-md-7 text-center heading-section heading-section-white ftco-animate">
        <h2 class="mb-4" style="color:#000;">What Our Explorers Say</h2>
        <p style="color:#000;">
          From famous forts to hidden waterfalls, SecretMaps helps travelers uncover Maharashtra’s true essence—
          guiding every journey with insider tips and curated destinations.
        </p>
      </div>
    </div>
    <div class="row ftco-animate">
      <div class="col-md-12">
        <div class="carousel-testimony owl-carousel ftco-owl">
          <?php
          include('config/db.php'); // adjust the path if needed

          // Fetch contact messages (latest first)
          $query = "SELECT id, name, email, subject, message, created_at FROM contact_messages ORDER BY id DESC";
          $result = mysqli_query($conn, $query);

          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
          ?>
              <div class="item">
                <div class="testimony-wrap p-4 pb-5"
                  style="box-shadow: 0 4px 12px rgba(0,0,0,0.2); border-radius: 10px; background: #fff;">
                  <div class="text text-center">
                    <h5 class="mb-2" style="color:#007bff;">
                      <?= htmlspecialchars($row['subject']) ?>
                    </h5>
                    <p class="mb-4">
                      <?= nl2br(htmlspecialchars($row['message'])) ?>
                    </p>
                    <p class="name" style="font-weight: bold;">
                      <?= htmlspecialchars($row['name']) ?>
                    </p>
                    <span class="position" style="font-size: 13px; color: #888;">
                      <?= htmlspecialchars($row['created_at']) ?>
                    </span>
                  </div>
                </div>
              </div>
          <?php
            }
          } else {
            echo '<p class="text-center">No messages yet.</p>';
          }
          ?>
        </div>
      </div>

    </div>


  </div>
  </div>
  </div>
  </div>
</section>



<?php
include('footer.php');
?>