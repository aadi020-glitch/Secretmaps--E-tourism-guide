<?php
session_start();
include('../config/db.php');
$page = 'index';
include('header.php');

// Check login
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

// Refresh user info from DB
$userId = $_SESSION['user']['id'];
$stmt = $conn->prepare("SELECT id, full_name, avatar, role FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$latestUser = $result->fetch_assoc();

if (!$latestUser) {
    session_unset();
    session_destroy();
    header("Location: ../login.php");
    exit;
}
$_SESSION['user'] = $latestUser;
$user = $_SESSION['user'];

// Only Admin / Super Admin can access
$role = strtolower(trim($user['role']));
if ($role !== 'super admin' && $role !== 'admin') {
    echo "<script>
        alert('Access denied! Only admins can view this page.');
        window.location.href = '../user/index.php';
    </script>";
    exit;
}

// Super Admin sees all destinations; Admin sees only their own
$isSuperAdmin = $role === 'super admin';
$whereClause = $isSuperAdmin ? "" : "WHERE added_by = $userId";

// ------------------ Cards Data ------------------
// Total Destinations
$totalDestQuery = "SELECT COUNT(*) as total FROM destinations $whereClause";
$totalDestResult = $conn->query($totalDestQuery);
$totalDest = $totalDestResult->fetch_assoc()['total'];

// Nature Destinations
$natureQuery = "SELECT COUNT(*) as count FROM destinations $whereClause " . ($whereClause ? "AND" : "WHERE") . " category='(Nature)'";
$natureCount = $conn->query($natureQuery)->fetch_assoc()['count'];

// Adventure Spots
$adventureQuery = "SELECT COUNT(*) as count FROM destinations $whereClause " . ($whereClause ? "AND" : "WHERE") . " category='(Adventure)'";
$adventureCount = $conn->query($adventureQuery)->fetch_assoc()['count'];

// Heritage Sites
$heritageQuery = "SELECT COUNT(*) as count FROM destinations $whereClause " . ($whereClause ? "AND" : "WHERE") . " category='(Heritage)'";
$heritageCount = $conn->query($heritageQuery)->fetch_assoc()['count'];

// Contact Queries (all admins see all)
$contactQuery = "SELECT COUNT(*) as count FROM contact_messages";
$contactCount = $conn->query($contactQuery)->fetch_assoc()['count'];

// Cards array
$cards = [
    ['title' => 'Total Destinations', 'icon' => 'fas fa-map', 'value' => $totalDest, 'desc' => '+ recently added'],
    ['title' => 'Nature Destinations', 'icon' => 'fas fa-tree', 'value' => $natureCount, 'desc' => 'Eco-tourism trend'],
    ['title' => 'Adventure Spots', 'icon' => 'fas fa-hiking', 'value' => $adventureCount, 'desc' => '+ new this month'],
    ['title' => 'Heritage Sites', 'icon' => 'fas fa-landmark', 'value' => $heritageCount, 'desc' => 'Preserving culture'],
    ['title' => 'Contact Queries', 'icon' => 'fas fa-envelope', 'value' => $contactCount, 'desc' => '+ new messages'],
];
?>

<!-- Dashboard HTML -->
<button class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></button>
<main class="main-content">
    <div class="header">
        <h1 id="pageTitle">Dashboard</h1>
        <div class="user-info">
            <a href="profile.php"><img src="<?= htmlspecialchars($user['avatar']); ?>" alt="User" id="logo"></a>
            <a href="profile.php"><span><?= htmlspecialchars($user['full_name']); ?> (<?= htmlspecialchars($user['role']); ?>)</span></a>
        </div>
    </div>

    <div class="card-grid">
        <?php foreach ($cards as $card): ?>
            <div class="card">
                <div class="card-header">
                    <h3><?= htmlspecialchars($card['title']); ?></h3>
                    <i class="<?= htmlspecialchars($card['icon']); ?>"></i>
                </div>
                <div class="card-value"><?= number_format($card['value']); ?></div>
                <div class="card-desc"><?= htmlspecialchars($card['desc']); ?></div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Chart Section -->
    <?php
    $categoryQuery = "SELECT category, COUNT(*) as count FROM destinations $whereClause GROUP BY category";
    $result = $conn->query($categoryQuery);
    $chartCategories = [];
    $chartCounts = [];
    while ($row = $result->fetch_assoc()) {
        $chartCategories[] = $row['category'];
        $chartCounts[] = $row['count'];
    }
    $categoriesJSON = json_encode($chartCategories);
    $countsJSON = json_encode($chartCounts);
    ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const chartCategories = <?= $categoriesJSON ?>;
        const chartCounts = <?= $countsJSON ?>;
    </script>
    <script src="js/dashboard.js"></script>

    <!-- Map Section -->
    <div class="chart-map-container">
        <div class="chart-container">
            <h2>Destinations Count</h2>
            <canvas id="myChart" style="width:80%;max-width:600px;height:70%;"></canvas>
        </div>
        <div class="map-container">
            <h2>Famous Destinations</h2>
            <input type="text" id="searchBox" placeholder="Search destination..." style="margin-top:0px; padding:5px; width:50%;">
            <button id="searchBtn" style="padding:5px;">Go</button>
            <div class="map-placeholder" id="map" style="height:300px; width:100%; margin-top:10px;"></div>
        </div>
    </div>

    <!-- Contact Messages Table -->
    <?php
    $sql = "SELECT * FROM contact_messages ORDER BY id DESC";
    $result = $conn->query($sql);
    ?>
    <h2 style="color:#000;text-align:center;">Contact Messages</h2>
    <hr>
    <table class="table table-bordered table-striped" id="contactMessagesTable">
        <thead>
            <tr>
                <th>sr</th>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Submitted At</th>
            </tr>
        </thead>
        <tbody style="background-color: aliceblue;">
            <?php
            $sr_no = 1;
            while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $sr_no++ ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['subject']) ?></td>
                    <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
                    <td><?= isset($row['created_at']) ? htmlspecialchars($row['created_at']) : '-' ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Leaflet + Routing JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
    <script>
        const map = L.map('map').setView([19.0760, 72.8777], 5);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        const destinations = [
            {name:"Ajanta Caves", lat:20.5520, lng:75.7033},
            {name:"Lonar Lake", lat:19.9722, lng:76.5236},
            {name:"Kaas Plateau", lat:17.9524, lng:73.8936},
            {name:"Amboli", lat:15.9189, lng:74.0033}
        ];
        destinations.forEach(d => L.marker([d.lat,d.lng]).addTo(map).bindPopup(d.name));

        let routingControl;
        async function searchAndRoute() {
            const query = document.getElementById('searchBox').value;
            if (!query) return alert("Enter a location!");

            const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`);
            const data = await res.json();
            if (!data || data.length === 0) return alert("Location not found!");

            const destLat = parseFloat(data[0].lat);
            const destLon = parseFloat(data[0].lon);

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(position => {
                    const userLat = position.coords.latitude;
                    const userLon = position.coords.longitude;

                    if (routingControl) map.removeControl(routingControl);

                    routingControl = L.Routing.control({
                        waypoints: [L.latLng(userLat,userLon), L.latLng(destLat,destLon)],
                        routeWhileDragging: true,
                        router: L.Routing.osrmv1({serviceUrl:'https://router.project-osrm.org/route/v1'}),
                        showAlternatives: true
                    }).addTo(map);
                }, err => alert("Unable to get your location."));
            } else alert("Geolocation not supported!");
        }
        document.getElementById('searchBtn').addEventListener('click', searchAndRoute);
    </script>

<?php include('footer.php'); ?>
