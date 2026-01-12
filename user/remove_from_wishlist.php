<?php
include('../config/db.php');
session_start();

if(!isset($_SESSION['user'])){
    echo json_encode(['success'=>false,'message'=>'Please login first']);
    exit;
}

$userId = $_SESSION['user']['id'];
$destinationId = $_POST['destination_id'] ?? 0;

if(!$destinationId){
    echo json_encode(['success'=>false,'message'=>'Invalid destination']);
    exit;
}

$stmt = $conn->prepare("DELETE FROM user_wishlist WHERE user_id=? AND destination_id=?");
$stmt->bind_param("ii", $userId, $destinationId);

if($stmt->execute()){
    echo "<script>
        alert('Removed from wishlist');
        window.location.href = 'wishlist.php';
    </script>";
} else {
    echo "<script>
        alert('Failed to remove');
        window.location.href = 'wishlist.php';
    </script>";
}
$stmt->close();
?>
