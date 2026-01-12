<?php
// destination-delete.php
include('../config/db.php');
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

$userId = $_SESSION['user']['id'];
$role   = strtolower(trim($_SESSION['user']['role']));

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid request.");
}

$id = (int) $_GET['id'];

// 1️⃣ Check permission
if ($role !== 'super admin') {
    $stmt = $conn->prepare("SELECT added_by FROM destinations WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    if (!$row || $row['added_by'] != $userId) {
        die("You do not have permission to delete this destination.");
    }
}

// 2️⃣ Get current image path so we can delete the file
$stmt = $conn->prepare("SELECT image_path FROM destinations WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($imagePath);
$stmt->fetch();
$stmt->close();

// 3️⃣ Delete DB row
$stmt = $conn->prepare("DELETE FROM destinations WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    // Delete image file if it exists
    if (!empty($imagePath) && file_exists("../" . $imagePath)) {
        unlink("../" . $imagePath);
    }
    header("Location: places.php?deleted=1");
    exit;
} else {
    echo "Error deleting record: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
