<?php
include '../config/db.php';
session_start();

// ✅ Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

// Get current user ID
$userId = $_SESSION['user']['id'];

// 1️⃣ Collect POST data safely
$name           = $_POST['name'] ?? '';
$cat            = $_POST['category'] ?? '';
$desc           = $_POST['description'] ?? '';
$extra_desc     = $_POST['extra_description'] ?? '';
$highlights     = $_POST['highlights'] ?? '';
$services       = $_POST['services'] ?? '';
$loc            = $_POST['location'] ?? '';
$slug           = $_POST['slug'] ?? '';
$best_time      = $_POST['best_time'] ?? '';
$official_link  = $_POST['official_link'] ?? '';
$iframe_map     = $_POST['iframe_map'] ?? '';
$rate           = floatval($_POST['rating'] ?? 0);
$tags           = implode(',', $_POST['tags'] ?? []);

// 2️⃣ Handle image upload
$imagePath = null;
if (!empty($_FILES['image_path']['name'])) {
    $targetDir = "../uploads/";
    if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

    $fileName   = time() . '_' . basename($_FILES["image_path"]["name"]);
    $targetFile = $targetDir . $fileName;

    if (move_uploaded_file($_FILES["image_path"]["tmp_name"], $targetFile)) {
        $imagePath = "uploads/" . $fileName;
    } else {
        die("Failed to upload image.");
    }
}

// 3️⃣ Prepare SQL insert
$sql = "INSERT INTO destinations 
        (added_by, name, category, description, extra_description, highlights, services, location, slug, best_time, official_link, iframe_map, rating, tags, image_path, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

$stmt = $conn->prepare($sql);
if (!$stmt) die("Prepare failed: " . $conn->error);

// 4️⃣ Bind parameters
// i = integer (added_by), s = string, d = double (rating)
$stmt->bind_param(
    "isssssssssssdss",
    $userId, $name, $cat, $desc, $extra_desc, $highlights, $services, $loc, $slug, $best_time, $official_link, $iframe_map, $rate, $tags, $imagePath
);

// 5️⃣ Execute
if (!$stmt->execute()) {
    die("Execute failed: " . $stmt->error);
}

// 6️⃣ Redirect with success
echo "<script>
        alert('Destination added successfully!');
        window.location.href='places.php';
      </script>";
exit;
?>
