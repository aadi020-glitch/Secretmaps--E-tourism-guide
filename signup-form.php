<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SecretMaps – Sign Up</title>
  <link rel="stylesheet" href="css/signup.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

  <div class="signup-container">
    <form action="signup-insert.php" method="POST" class="signup-card">
      <h1>Create an Account</h1>
      <p class="subtitle">Join SecretMaps to explore and share hidden gems.</p>

      <!-- Name -->
      <label for="name"><i class="fa fa-user"></i> Full Name</label>
      <input type="text" id="full_name" name="full_name" placeholder="Your Name" required>

      <!-- Email -->
      <label for="email"><i class="fa fa-envelope"></i> Email</label>
      <input type="email" id="email" name="email" placeholder="you@example.com" required>

      <!-- Username -->
      <label for="username"><i class="fa fa-id-card"></i> Username</label>
      <input type="text" id="username" name="username" placeholder="Choose a username" required>

      <!-- Password -->
      <label for="password"><i class="fa fa-lock"></i> Password</label>
      <input type="password" id="password" name="password" placeholder="Enter password" required>

      <!-- Confirm Password -->
      <label for="confirm_password"><i class="fa fa-lock"></i> Confirm Password</label>
      <input type="password" id="confirm_password" name="confirm_password" placeholder="Re-enter password" required>

      <!-- Terms -->
      <div class="checkbox">
        <input type="checkbox" id="terms" name="terms" required>
        <label for="terms">I agree to the <a href="#">Terms & Conditions</a></label>
      </div>

      <!-- Submit -->
      <button type="submit" class="btn-submit">Sign Up</button>

      <p class="login-link">
        Already have an account? <a href="login.php">Log in here</a>
      </p>
    </form>
  </div>

</body>
</html>
