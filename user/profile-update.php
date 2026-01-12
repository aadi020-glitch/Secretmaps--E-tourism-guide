<?php
session_start();
include('../config/db.php'); // adjust path

// ✅ Allow only logged-in user
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

$userId = $_SESSION['user']['id']; // logged-in user ID

// Collect form data
$full_name = $_POST['full_name'] ?? '';
$email     = $_POST['email'] ?? '';
$phone     = $_POST['phone'] ?? '';
$location  = $_POST['location'] ?? '';
$username  = $_POST['username'] ?? '';
$password  = $_POST['password'] ?? '';

// Handle avatar upload
$avatarPath = ''; // default
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

// Hash password only if not empty, otherwise keep current
if (!empty($password)) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
} else {
    $stmt = $conn->prepare("SELECT password FROM users WHERE id=?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $hashedPassword = $result['password'] ?? '';
}

// Prepare update query
$update = $conn->prepare("
    UPDATE users 
    SET full_name=?, email=?, phone=?, location=?, avatar=?, username=?, password=? 
    WHERE id=?
");
if (!$update) die("Prepare failed: " . $conn->error);

// Bind parameters
$update->bind_param(
    "sssssssi",
    $full_name,
    $email,
    $phone,
    $location,
    $avatarPath,
    $username,
    $hashedPassword,
    $userId
);

// Execute update
if (!$update->execute()) {
    die("Update failed: " . $update->error);
}

// Update session so header reflects new info
$_SESSION['user']['full_name'] = $full_name;
$_SESSION['user']['avatar']    = $avatarPath;

// Redirect back to profile page
header("Location: profile.php");
exit;
