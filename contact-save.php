<?php
include('config/db.php'); // adjust path to your DB connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize & collect inputs
    $name    = mysqli_real_escape_string($conn, $_POST['name']);
    $email   = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Insert into database
    $sql = "INSERT INTO contact_messages (name, email, subject, message) VALUES (?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $subject, $message);

    if ($stmt->execute()) {
        header("Location: contact.php?success=1");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
