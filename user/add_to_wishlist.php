<?php
include('../config/db.php');
session_start();
header('Content-Type: application/json');

if(!isset($_SESSION['user'])){
    echo json_encode(['success'=>false,'message'=>'Login first']);
    exit;
}

$userId = $_SESSION['user']['id'];
$destId = $_POST['destination_id'] ?? 0;

if(!$destId){
    echo json_encode(['success'=>false,'message'=>'Invalid destination']);
    exit;
}

// Check if already in wishlist
$stmt = $conn->prepare("SELECT id FROM user_wishlist WHERE user_id=? AND destination_id=?");
$stmt->bind_param("ii", $userId, $destId);
$stmt->execute();
if($stmt->get_result()->num_rows > 0){
    echo json_encode(['success'=>false,'message'=>'Already in wishlist']);
    exit;
}

// Insert into wishlist
$stmt = $conn->prepare("INSERT INTO user_wishlist (user_id,destination_id) VALUES (?,?)");
$stmt->bind_param("ii", $userId, $destId);
if($stmt->execute()){
    echo json_encode(['success'=>true,'message'=>'Added to wishlist']);
} else {
    echo json_encode(['success'=>false,'message'=>'Failed to add']);
}
?>
