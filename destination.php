<?php
$page = 'destination';
include('header.php');
include('config/db.php');
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

// ----------------- Handle Search & Filters -----------------
$filter_tag      = $_GET['filter_tag']      ?? 'all';
$filter_category = $_GET['filter_category'] ?? 'all';
$search          = $_GET['search']          ?? '';

// ----------------- Build SQL ----------------------
$sql = "SELECT d.*, IFNULL(AVG(r.rating),0) as avg_rating 
        FROM destinations d
        LEFT JOIN reviews r ON d.id = r.dest_id
        WHERE 1";

// Search
if (!empty($search)) {
  $safeSearch = mysqli_real_escape_string($conn, $search);
  $sql .= " AND d.name LIKE '%$safeSearch%'";
}

// Filter by Tag
if ($filter_tag !== 'all') {
  $tagSafe = mysqli_real_escape_string($conn, $filter_tag);
  $sql .= " AND FIND_IN_SET('$tagSafe', d.tags)";
}

// Filter by Category
if ($filter_category !== 'all') {
  $catSafe = mysqli_real_escape_string($conn, $filter_category);
  $sql .= " AND d.category = '$catSafe'";
}

// Group by destination to calculate avg rating
$sql .= " GROUP BY d.id ORDER BY d.id DESC";

// ----------------- Fetch Filtered Data ---------------------
$destinations = [];
$res = $conn->query($sql);
if ($res) {
  while ($row = $res->fetch_assoc()) {
    $highlights = !empty($row['highlights']) ? explode(',', $row['highlights']) : [];
    $services   = !empty($row['services']) ? explode(',', $row['services']) : [];

    $destinations[] = [
      'id'          => $row['id'],
      'slug'        => $row['slug'],
      'name'        => $row['name'],
      'image'       => $row['image_path'],
      'type'        => $row['category'],
      'description' => $row['description'],
      'highlights'  => $highlights,
      'services'    => $services,
      'location'    => $row['location'],
      'tags'        => $row['tags'] ? explode(',', $row['tags']) : [],
      'avg_rating'  => round($row['avg_rating'], 1)
    ];
  }
} else {
  die("Database Error: " . $conn->error);
}
?>

<div class="hero-wrap js-fullheight" style="background-image: url('images/destinations.jpg');">
  <div class="overlay"></div>
  <div class="container">
    <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center">
      <div class="col-md-9 text-center ftco-animate">
        <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>Destinations</span></p>
        <h1 class="mb-3 bread">Explore Destinations</h1>
      </div>
    </div>
  </div>
</div>

<section class="ftco-section">
  <div class="container">
    <!-- ====== Search Bar & Filter Toggle ====== -->
    <form method="get" class="mb-3 d-flex align-items-center">
      <input type="text"
        class="form-control me-2"
        name="search"
        placeholder="   Search destination..."
        value="<?= htmlspecialchars($search) ?>"
        style="width: 500px;border-radius: 20px; padding: 5px;margin-top: -100px;">
      <button type="submit" class="btn btn-primary btn-sm me-2" style="margin-top: -100px; margin-left:10px;">Search</button>

      <button type="button" class="btn btn-outline-secondary btn-sm"
        onclick="document.getElementById('filterPanel').classList.toggle('d-none')"
        style="margin-top: -100px; margin-left:45%;">Filters
      </button>

      <?php if (!empty($search) || $filter_tag !== 'all' || $filter_category !== 'all'): ?>
        <a href="destination.php" class="btn btn-outline-danger btn-sm ms-2"
          style="margin-top: -100px;margin-left:2px;">Clear</a>
      <?php endif; ?>
    </form>

    <!-- ====== Filter Panel ====== -->
    <div id="filterPanel" class="d-none border p-3 rounded mb-4 bg-light">
      <div class="row">

        <!-- Filter by Tag -->
        <div class="col-md-6 mb-3">
          <h6 class="fw-bold mb-2">Filter by Tag</h6>
          <form method="get">
            <input type="hidden" name="search" value="<?= htmlspecialchars($search) ?>">
            <input type="hidden" name="filter_category" value="<?= htmlspecialchars($filter_category) ?>">
            <?php
            $tags = ['all' => 'all', 'Popular' => 'popular', 'Hidden Gem' => 'hidden gem'];
            foreach ($tags as $label => $key) {
              $active = $filter_tag === $key ? 'btn-primary' : 'btn-outline-primary';
              echo "<button type='submit' name='filter_tag' value='$key' class='btn btn-sm $active me-2 mb-2'>$label</button>";
            }
            ?>
          </form>
        </div>

        <!-- Filter by Category -->
        <div class="col-md-6 mb-3">
          <h6 class="fw-bold mb-2">Filter by Category</h6>
          <form method="get">
            <input type="hidden" name="search" value="<?= htmlspecialchars($search) ?>">
            <input type="hidden" name="filter_tag" value="<?= htmlspecialchars($filter_tag) ?>">
            <?php
            $cats = ['all' => 'All', '(Nature)' => 'Nature', '(Adventure)' => 'Adventure', '(Heritage)' => 'Heritage'];
            foreach ($cats as $key => $label) {
              $active = $filter_category === $key ? 'btn-success' : 'btn-outline-success';
              echo "<button type='submit' name='filter_category' value='$key' class='btn btn-sm $active me-2 mb-2'>$label</button>";
            }
            ?>
          </form>
        </div>

      </div>

      <!-- Count Info -->
      <div class="row mb-4">
        <div class="col-md-12">
          <div class="alert alert-info">
            Showing <?= count($destinations) ?> destination(s)
            <?php if ($filter_tag !== 'all') echo "- Tag: " . htmlspecialchars($filter_tag); ?>
            <?php if ($filter_category !== 'all') echo "- Category: " . htmlspecialchars($filter_category); ?>
            <?php if (!empty($search)) echo "- Search: " . htmlspecialchars($search); ?>
          </div>
        </div>
      </div>
    </div>

    <!-- ====== Destination Cards ====== -->
    <div class="row">
      <?php if ($destinations): foreach ($destinations as $d): ?>

          <?php
          // Latest 2 Reviews
          $rstmt = $conn->prepare("SELECT * FROM reviews WHERE dest_id=? ORDER BY created_at DESC LIMIT 2");
          $rstmt->bind_param('i', $d['id']);
          $rstmt->execute();
          $reviews = $rstmt->get_result()->fetch_all(MYSQLI_ASSOC);
          $rstmt->close();
          ?>

          <div class="col-md-4 ftco-animate mb-4">
            <div class="destination card h-100 shadow-sm">
              <a href="details.php#<?= htmlspecialchars($d['slug']); ?>" class="img img-2 d-flex justify-content-center align-items-center"
                style="background-image: url(<?= htmlspecialchars($d['image']); ?>);">
                <div class="icon d-flex justify-content-center align-items-center">
                  <span class="icon-search2"></span>
                </div>
              </a>

              <div class="card-body">
               <span class="badge mb-2 <?php echo in_array('Popular', $d['tags']) ? 'bg-warning text-dark' : 'bg-info text-white'; ?>">
    <?= implode(', ', $d['tags']) . ' ' . htmlspecialchars($d['type']); ?>
</span>



                <h3><a href="details.php#<?= htmlspecialchars($d['slug']); ?>"><?= htmlspecialchars($d['name']); ?></a></h3>
                <p><?= nl2br(htmlspecialchars($d['description'])); ?></p>
                <p class="mb-1">⭐ <?= $d['avg_rating'] ?>/5</p>

                <?php if ($reviews): ?>
                  <?php foreach ($reviews as $rv): ?>
                    <blockquote class="small text-muted mb-2">
                      “<?= htmlspecialchars(substr($rv['comment'], 0, 100)); ?>...” — <strong><?= htmlspecialchars($rv['name']); ?></strong>
                    </blockquote>
                  <?php endforeach; ?>
                <?php else: ?>
                  <p class="text-muted small">No reviews yet</p>
                <?php endif; ?>

                <a href="details.php#<?= htmlspecialchars($d['slug']); ?>" class="btn btn-sm btn-primary mt-2">View Details</a><br><br>

                <button class="btn btn-success btn-sm trip-btn mb-2" data-id="<?= $d['id'] ?>" style="margin-right:-5px;">
                  <?= $loggedIn ? 'Add to My Trip' : 'Login to Add' ?>
                </button>

                <button class="btn btn-sm wishlist-btn mb-2" data-id="<?= $d['id'] ?>" style="margin-left:5px;background-color:#023e8A;color:#fff;border:none;">
                  <?= $loggedIn ? 'Add to Wishlist' : 'Login to Add' ?>
                </button>
              </div>
            </div>
          </div>

        <?php endforeach;
      else: ?>
        <div class="col-md-12 text-center">
          <div class="alert alert-warning">
            <h4>No destinations found</h4>
            <p>Try different filters or search terms.</p>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<script>
  document.querySelectorAll('.trip-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const destId = this.dataset.id;
      <?php if (!isset($_SESSION['user'])): ?>
        alert('Please login first');
        window.location.href = 'login.php';
      <?php else: ?>
        fetch('user/add_to_trip.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: 'destination_id=' + destId
        }).then(res => res.json()).then(data => alert(data.message));
      <?php endif; ?>
    });
  });

  document.querySelectorAll('.wishlist-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const destId = this.dataset.id;
      <?php if (!isset($_SESSION['user'])): ?>
        alert('Please login first');
        window.location.href = 'login.php';
      <?php else: ?>
        fetch('user/add_to_wishlist.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: 'destination_id=' + destId
        }).then(res => res.json()).then(data => alert(data.message));
      <?php endif; ?>
    });
  });
</script>

<?php include('footer.php'); ?>