<?php
session_start();
$page = 'dashboard';
include('header.php');
include('../config/db.php');
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

$user = $_SESSION['user'];

// ✅ Only allow regular users here
if (strtolower(trim($user['role'])) !== 'user') {
    echo "<script>
        alert('Access denied! Only users can view this page.');
        window.location.href = '../admin/index.php';
    </script>";
    exit;
}

$userId = $_SESSION['user']['id'];

// ✅ Secure query for fetching logged-in user info
$query = "SELECT id, full_name, username, email, avatar, created_at FROM users WHERE id = ?";
$stmt = $conn->prepare($query);

if (!$stmt) {
    die("Database query failed: " . $conn->error);
}

$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();
?>
<button class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></button>
<main class="main-content">
    <div class="header">
        <h1>User Dashboard</h1>
        <div class="user-info">
            <img src="<?= htmlspecialchars($userData['avatar']); ?>" alt="Avatar" id="logo">
            <span><?= htmlspecialchars($userData['full_name']); ?></span>
        </div>
    </div>

    <!-- ✅ User Dashboard Overview -->
    <section class="dashboard" style="max-width:1000px;margin:30px auto;padding:25px;background:#fff;border-radius:10px;box-shadow:0 4px 12px rgba(0,0,0,0.08);">
        <h2>Welcome, <?= htmlspecialchars($userData['full_name']); ?> 👋</h2>
        <p>Here’s an overview of your account and trip activities.</p>

        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:20px;margin-top:30px;">

            <!-- Account Summary -->
            <div style="background:#f8f9fa;padding:20px;border-radius:8px;">
                <h3>Account Info</h3>
                <p><strong>Username:</strong> <?= htmlspecialchars($userData['username']); ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($userData['email']); ?></p>
                <p><strong>Member Since:</strong> <?= date('d M Y', strtotime($userData['created_at'])); ?></p>
            </div>

            <!-- Trip Planner -->
            <div style="background:#f8f9fa;padding:20px;border-radius:8px;">
                <h3>My Trips 🗺️</h3>
                <p>Plan your next adventure by adding destinations to your trip list.</p>
                <a href="my_trips.php" style="display:inline-block;background:#007bff;color:white;padding:8px 16px;border-radius:6px;text-decoration:none;margin-top:10px;">Go to Trip Planner</a>
            </div>

            <!-- Wishlist -->
            <div style="background:#f8f9fa;padding:20px;border-radius:8px;">
                <h3>My Wishlist ❤️</h3>
                <p>View the destinations you’ve added to your wishlist.</p>
                <a href="wishlist.php" style="display:inline-block;background:#28a745;color:white;padding:8px 16px;border-radius:6px;text-decoration:none;margin-top:10px;">View Wishlist</a>
            </div>
        </div>

        
    </section>


<?php include('footer.php'); ?>
