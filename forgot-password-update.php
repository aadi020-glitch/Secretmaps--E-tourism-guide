<?php
// Connect to DB
$conn = mysqli_connect("localhost","root","","secretmaps");
if (!$conn) die("Connection failed: " . mysqli_connect_error());

// Get form data
$username  = trim($_POST['username']);
$newpass  = $_POST['newpass'];
$confirmpass  = $_POST['confirmpass'];

// Validate passwords
if ($newpass !== $confirmpass) {
    die("Passwords do not match.");
}
if (strlen($newpass) < 8) {
    die("Password must be at least 8 characters.");
}

// Check if user exists
$stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE username=?");
if (!$stmt) die("Prepare failed: " . mysqli_error($conn));
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) === 1) {
    // Hash the new password
    $hash = password_hash($newpass, PASSWORD_DEFAULT);

    // Update password in DB
    mysqli_stmt_close($stmt);
    $update = mysqli_prepare($conn, "UPDATE users SET password=? WHERE username=?");
    mysqli_stmt_bind_param($update, "ss", $hash, $username);

    if (mysqli_stmt_execute($update)) {
        echo "<script>alert('Password Updated Successfully');
            	window.location='login.php';</script>";
    } else {
        echo "Error updating password: " . mysqli_stmt_error($update);
    }
    mysqli_stmt_close($update);
} else {
    echo "<p style='color:red;text-align:center;'>Username not found.</p>";
}

mysqli_close($conn);
?>
