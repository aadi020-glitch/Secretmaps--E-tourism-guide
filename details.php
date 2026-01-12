<?php
$page = 'details';
include('header.php');
include('config/db.php');

// Fetch all destinations
$destinations = [];
$sql = "SELECT * FROM destinations ORDER BY id ASC";
$result = mysqli_query($conn, $sql);

if ($result) {
  while ($row = mysqli_fetch_assoc($result)) {
    $highlights = !empty($row['highlights']) ? explode(',', $row['highlights']) : [];
    $services   = !empty($row['services']) ? explode(',', $row['services']) : [];

    $destinations[] = [
      'id'                => $row['id'],
      'slug'              => $row['slug'], // Use slug for anchor
      'name'              => $row['name'],
      'image'             => $row['image_path'],
      'type'              => $row['category'],
      'description'       => $row['description'],
      'extra_description' => $row['extra_description'],
      'highlights'        => $highlights,
      'services'          => $services,
      'location'          => $row['location'],
      'best_time'         => $row['best_time'],
      'official_link'     => $row['official_link'],
      'iframe_map'        => $row['iframe_map'],
      'tags'              => $row['tags'] ? explode(',', $row['tags']) : []
    ];
  }
} else {
  die("Database Error: " . mysqli_error($conn));
}
?>

<div class="hero-wrap js-fullheight" style="background-image: url('images/details.jpg');">
  <div class="overlay"></div>
  <div class="container">
    <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center">
      <div class="col-md-9 text-center ftco-animate">
        <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>Destinations</span></p>
        <h1 class="mb-3 bread">Destination Details</h1>
      </div>
    </div>
  </div>
</div>

<section class="ftco-section">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="destination-details">

          <?php foreach ($destinations as $d): ?>

            <?php
            // Reviews
            $stmt = $conn->prepare("SELECT AVG(rating) as avg_rating, COUNT(*) as total_reviews FROM reviews WHERE dest_id=?");
            $stmt->bind_param('i', $d['id']);
            $stmt->execute();
            $ratingData = $stmt->get_result()->fetch_assoc();
            $avg   = round($ratingData['avg_rating'] ?? 0, 1);
            $total = $ratingData['total_reviews'] ?? 0;
            $stmt->close();

            $rstmt = $conn->prepare("SELECT * FROM reviews WHERE dest_id=? ORDER BY created_at DESC");
            $rstmt->bind_param('i', $d['id']);
            $rstmt->execute();
            $reviews = $rstmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $rstmt->close();
            ?>

            <!-- Destination Block with slug ID -->
            <div class="destination-block mb-5" id="<?= htmlspecialchars($d['slug']); ?>">

              <!-- Top Image Full Width -->
              <div class="destination-img-top" style="background-image: url(<?= htmlspecialchars($d['image']); ?>);"></div>

              <!-- Bottom Section -->
              <div class="row mt-4">
                <!-- Left Column -->
                <div class="col-md-6">
                  <div class="destination-text p-4">
                    <span class="badge badge-<?php echo in_array('Popular', $d['tags']) ? 'warning' : 'info'; ?> mb-2">
                      <?= implode(', ', $d['tags']) . ' ' . htmlspecialchars($d['type']); ?>
                    </span>
                    <h2 class="mb-3"><?= htmlspecialchars($d['name']); ?></h2>
                    <p><?= htmlspecialchars($d['description']); ?></p>
                    <p class="text-muted"><?= htmlspecialchars($d['extra_description']); ?></p>

                    <h4 class="mt-4">Highlights</h4>
                    <ul class="list-check">
                      <?php foreach ($d['highlights'] as $h): ?>
                        <li><span class="icon icon-check"></span> <?= htmlspecialchars($h); ?></li>
                      <?php endforeach; ?>
                    </ul>

                    <h4 class="mt-4">Services Available</h4>
                    <ul class="list-check">
                      <?php foreach ($d['services'] as $s): ?>
                        <li><span class="icon icon-star"></span> <?= htmlspecialchars($s); ?></li>
                      <?php endforeach; ?>
                    </ul>

                    <div class="d-flex mt-3">
                      <div class="info mr-4"><span class="icon icon-map-marker"></span> <?= htmlspecialchars($d['location']); ?></div>
                      <div class="info"><span class="icon icon-calendar"></span> Best Time: <?= htmlspecialchars($d['best_time']); ?></div>
                    </div>

                    <p class="mt-4">
                      <?php if (!empty($d['official_link']) && $d['official_link'] != '0'): ?>
                        <a href="<?= htmlspecialchars($d['official_link']); ?>" target="_blank" class="btn btn-primary">Official Info</a>
                      <?php else: ?>
                        <button class="btn btn-secondary" disabled>Official Info Not Available</button>
                      <?php endif; ?>
                    </p>
                  </div>
                </div>

                <!-- Right Column: Reviews + Map -->
                <div class="col-md-6">
                  <div class="destination-text p-4">
                    <div class="map-responsive mb-4">
                      <?= $d['iframe_map']; ?>
                    </div>

                    <hr>
                    <h4>User Reviews</h4>
                    <p>⭐ <?= $avg ?>/5 (<?= $total ?> reviews)</p>
                    <ul class="list-unstyled">
                      <?php if ($reviews): foreach ($reviews as $rv): ?>
                          <li class="mb-2">
                            <strong><?= htmlspecialchars($rv['name']) ?></strong> — <?= str_repeat("⭐", $rv['rating']) ?>
                            <br><small><?= htmlspecialchars($rv['comment']) ?></small>
                          </li>
                        <?php endforeach;
                      else: ?>
                        <li>No reviews yet. Be the first to review!</li>
                      <?php endif; ?>
                    </ul>

                    <h5 class="mt-3">Leave a Review</h5>
                    <form method="post" action="review_submit.php" class="mb-3">
                      <input type="hidden" name="dest_id" value="<?= $d['id'] ?>">
                      <input type="text" name="name" placeholder="Your name" class="form-control mb-2" required>
                      <label>Rating:</label>
                      <select name="rating" class="form-control mb-2" required>
                        <option value="5">5 - Excellent</option>
                        <option value="4">4 - Very Good</option>
                        <option value="3">3 - Good</option>
                        <option value="2">2 - Fair</option>
                        <option value="1">1 - Poor</option>
                      </select>
                      <textarea name="comment" placeholder="Your review" class="form-control mb-2" required></textarea>
                      <button type="submit" class="btn btn-sm btn-primary">Submit Review</button>
                    </form>
                  </div>
                </div>
              </div>

            </div>

          <?php endforeach; ?>

        </div>
      </div>
    </div>
  </div>
</section>

<style>
  .destination-img-top {
    width: 100%;
    height: 400px;
    background-size: cover;
    background-position: center;
    border-radius: 5px;
  }

  .destination-text {
    background: #fff;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    height: 100%;
  }

  html {
    scroll-behavior: smooth;
  }

  .list-check {
    list-style: none;
    padding: 0;
  }

  .list-check li {
    margin-bottom: 10px;
    position: relative;
    padding-left: 30px;
  }

  .list-check .icon-check {
    position: absolute;
    left: 0;
    top: 3px;
    color: #fd5f00;
  }

  .info {
    display: flex;
    align-items: center;
  }

  .info .icon {
    margin-right: 10px;
    color: #fd5f00;
  }

  .map-responsive {
    overflow: hidden;
    padding-bottom: 56.25%;
    position: relative;
    height: 0;
  }

  .map-responsive iframe {
    left: 0;
    top: 0;
    height: 400px;
    width: 100%;
    position: absolute;
  }

  @media (max-width: 767px) {
    .destination-img-top {
      height: 250px;
    }

    .destination-text {
      padding: 20px !important;
    }
  }
</style>

<?php include('footer.php'); ?>