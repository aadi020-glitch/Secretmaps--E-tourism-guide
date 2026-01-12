<?php
session_start();
include('../config/db.php'); // database connection

if(isset($_GET['id'])){
    $user_id = $_GET['id'];

    // Fetch the user's details
    $stmt = $conn->prepare("SELECT role, id FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if(!$user){
        echo "<script>alert('User not found'); window.location.href='user.php';</script>";
        exit;
    }

    // Prevent deleting the original admin (id = 1)
    if($user['id'] == 1){
        echo "<script>alert('Cannot delete the original admin!'); window.location.href='user.php';</script>";
        exit;
    }

    // Delete user
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);

    if($stmt->execute()){
        echo "<script>alert('User deleted successfully'); window.location.href='user.php';</script>";
    } else {
        echo "<script>alert('Failed to delete user'); window.location.href='user.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request'); window.location.href='user.php';</script>";
}
?>
