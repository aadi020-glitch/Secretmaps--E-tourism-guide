<?php
session_start();
include('../config/db.php');

// Only logged-in users
if (!isset($_SESSION['user'])) {
    echo json_encode(['status'=>'error', 'message'=>'Login required']);
    exit;
}

$userId = $_SESSION['user']['id'];
$destinationId = $_POST['destination_id'] ?? 0;

if (!$destinationId) {
    echo json_encode(['status'=>'error', 'message'=>'Destination ID missing']);
    exit;
}

// Remove from user_trips
$stmt = $conn->prepare("DELETE FROM user_trips WHERE user_id=? AND destination_id=?");
$stmt->bind_param("ii", $userId, $destinationId);

if($stmt->execute()){
    echo "<script>
        alert('Removed from trip');
        window.location.href = 'my_trips.php';
    </script>";
} else {
    echo "<script>
        alert('Failed to remove');
        window.location.href = 'my_trips.php';
    </script>";
}
?>