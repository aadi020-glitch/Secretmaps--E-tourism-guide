<?php
session_start();

// Redirect logged-in users
if (isset($_SESSION['user']) && !empty($_SESSION['user']['id'])) {
    header("Location: user/index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SecretMaps – Login</title>
  <link rel="stylesheet" href="css/login.css">
</head>
<body>
  <div class="login-container">
    <h1 class="logo"><img src="admin/assets/img/logo.png" width="90%"></h1>
    <form action="login-insert.php" method="POST" class="login-form" target="_self">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <p class="extra-username">
        <a href="forgot-username.php">Forgot username?</a>
      </p>
      <p class="extra">
        <a href="forgot-password.php">Forgot password?</a>
      </p>
      <button type="submit">Log In</button>
      <p class="login-link">
        Don't have an account? <a href="signup-form.php">Sign-Up here</a>
      </p>
    </form>
  </div>
</body>
</html>
