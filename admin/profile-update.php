<?php
include('../config/db.php'); // adjust path

// Get user ID to update
$userId = $_POST['id'] ?? 0; // make sure this is set from the form
if (!$userId) die("User ID not provided");

// Collect form data
$full_name = $_POST['full_name'] ?? '';
$position  = $_POST['position'] ?? '';
$email     = $_POST['email'] ?? '';
$phone     = $_POST['phone'] ?? '';
$location  = $_POST['location'] ?? '';
$username  = $_POST['username'] ?? '';
$password  = $_POST['password'] ?? '';

// Handle avatar upload
$avatarPath = ''; // default empty or keep old avatar logic
if (!empty($_FILES['avatar']['name'])) {
    $fileName = time() . '_' . basename($_FILES['avatar']['name']);
    $uploadDir = __DIR__ . '/uploads/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
    $target = $uploadDir . $fileName;
    if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target)) {
        $avatarPath = 'uploads/' . $fileName;
    }
} else {
    // Keep existing avatar
    $stmt = $conn->prepare("SELECT avatar FROM users WHERE id=?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $avatarPath = $result['avatar'] ?? '';
}

// Hash password if needed (optional, recommended)
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Prepare update query
$update = $conn->prepare("
    UPDATE users 
    SET full_name=?, position=?, email=?, phone=?, location=?, avatar=?, username=?, password=? 
    WHERE id=?
");
if (!$update) die("Prepare failed: " . $conn->error);

// Bind parameters
$update->bind_param(
    "ssssssssi",
    $full_name,
    $position,
    $email,
    $phone,
    $location,
    $avatarPath,
    $username,
    $hashedPassword,
    $userId
);

// Execute update
$update->execute() or die("Update failed: " . $update->error);

echo "✅ User updated successfully!";
header("Location: profile.php"); // Redirect back to profile page
exit;   