<?php
include('config/db.php'); // database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);

    $stmt = $conn->prepare("SELECT username FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($username);
        $stmt->fetch();

        // Show username in alert and redirect
        echo "<script>
                alert('Your username is: $username');
                window.location.href = 'login.php';
              </script>";
    } else {
        echo "<script>
                alert('No account found with this email.');
                window.location.href = 'forgot-username.php';
              </script>";
    }

    $stmt->close();
}
$conn->close();
?>
