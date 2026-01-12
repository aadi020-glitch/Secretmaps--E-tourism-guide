<?php
include '../config/db.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

$userId = $_SESSION['user']['id'];
$role   = strtolower(trim($_SESSION['user']['role']));

// 1️⃣ Collect POST data safely
$id             = (int)($_POST['id'] ?? 0);
$name           = $_POST['name'] ?? '';
$desc           = $_POST['description'] ?? '';
$extra_desc     = $_POST['extra_description'] ?? '';
$highlights     = $_POST['highlights'] ?? '';
$services       = $_POST['services'] ?? '';
$loc            = $_POST['location'] ?? '';
$slug           = $_POST['slug'] ?? '';
$cat            = $_POST['category'] ?? '';
$best_time      = $_POST['best_time'] ?? '';
$official_link  = $_POST['official_link'] ?? '';
$iframe_map     = $_POST['iframe_map'] ?? '';
$rate           = floatval($_POST['rating'] ?? 0);
$tags           = implode(',', $_POST['tags'] ?? []);

// 2️⃣ Permission check: Admins can only update their own destinations
if ($role !== 'super admin') {
    $stmt = $conn->prepare("SELECT added_by FROM destinations WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    if (!$row || $row['added_by'] != $userId) {
        die("You are not allowed to edit this destination.");
    }
}

// 3️⃣ Handle image upload if exists
$imagePath = null;
if (!empty($_FILES['image']['name'])) {
    $targetDir = "../uploads/";
    if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

    $fileName   = time() . '_' . basename($_FILES["image"]["name"]);
    $targetFile = $targetDir . $fileName;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        $imagePath = "uploads/" . $fileName;
    } else {
        die("Failed to upload image.");
    }
}

// 4️⃣ Build SQL dynamically
$sql = "UPDATE destinations SET 
        name=?, description=?, extra_description=?, highlights=?, services=?,
        location=?, slug=?, category=?, best_time=?, official_link=?,
        iframe_map=?, rating=?, tags=?";
$params = [
    $name, $desc, $extra_desc, $highlights, $services,
    $loc, $slug, $cat, $best_time, $official_link,
    $iframe_map, $rate, $tags
];

// Dynamic types
$types = str_repeat("s", 11) . "d" . "s"; // 11 strings + double + tags

// Add image if uploaded
if ($imagePath) {
    $sql .= ", image_path=?";
    $params[] = $imagePath;
    $types .= "s";
}

// Add WHERE id
$sql .= " WHERE id=?";
$params[] = $id;
$types .= "i";

// 5️⃣ Prepare statement
$stmt = $conn->prepare($sql);
if (!$stmt) die("Prepare failed: " . $conn->error);

// 6️⃣ Bind and execute
$stmt->bind_param($types, ...$params);
if (!$stmt->execute()) {
    die("Execute failed: " . $stmt->error);
}

// 7️⃣ Redirect with success
echo "<script>
        alert('Destination updated successfully!');
        window.location.href='places.php';
      </script>";
exit;
?>
