<?php
$conn = mysqli_connect("localhost","root","","secretmaps");
if (!$conn) die("Connection failed: " . mysqli_connect_error());

$full_name = $_POST['full_name'];
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];
$confirm = $_POST['confirm_password'];

// Check password match
if ($password !== $confirm) {
    die("<script>alert('Passwords do not match.'); window.history.back();</script>");
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Assign default role as 'user'
$role = 'user';

// Insert user with role
$sql = "INSERT INTO users (full_name, email, username, password, role) VALUES (?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    die("Prepare failed: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "sssss", $full_name, $email, $username, $hashed_password, $role);

if (mysqli_stmt_execute($stmt)) {
    $user_id = mysqli_insert_id($conn);
    echo "<script>
        alert('User Registered Successfully');
        window.location='login.php';
    </script>";
    exit();
} else {
    echo "Execute failed: " . mysqli_stmt_error($stmt);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
