<?php
include('../config/db.php');
session_start();

// Check login
if (!isset($_SESSION['user'])) {
    echo json_encode(['success'=>false,'message'=>'Login required']);
    exit;
}

$userId = $_SESSION['user']['id'];
$destId = $_POST['destination_id'] ?? 0;
if(!$destId) {
    echo json_encode(['success'=>false,'message'=>'Invalid destination']);
    exit;
}

// Prevent duplicate entries
$stmt = $conn->prepare("SELECT * FROM user_trips WHERE user_id=? AND destination_id=?");
$stmt->bind_param("ii",$userId,$destId);
$stmt->execute();
if($stmt->get_result()->num_rows > 0) {
    echo json_encode(['success'=>false,'message'=>'Already in your trip']);
    exit;
}

// Insert into user_trips
$stmt = $conn->prepare("INSERT INTO user_trips(user_id,destination_id) VALUES(?,?)");
$stmt->bind_param("ii",$userId,$destId);
$stmt->execute();

echo json_encode(['success'=>true,'message'=>'Added to your trip']);
