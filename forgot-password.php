<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SecretMaps – Change Password</title>
<style>
  body{
    font-family: Arial, sans-serif;
    background: linear-gradient(135deg,#4f46e5,#9333ea);
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
  }
  .form-box{
    background: #fff;
    padding: 2rem;
    border-radius: 1rem;
    width: 100%;
    max-width: 350px;
    box-shadow: 0 6px 16px rgba(0,0,0,0.15);
  }
  h2{
    text-align: center;
    margin-bottom: 1rem;
    color: #1f2937;
  }
  label{
    display: block;
    margin-top: 1rem;
    margin-bottom: .3rem;
    font-weight: 600;
  }
  input{
    width: 100%;
    padding: .7rem;
    border: 1px solid #d1d5db;
    border-radius: .5rem;
    font-size: 1rem;
  }
  button{
    margin-top: 1.5rem;
    width: 100%;
    padding: .8rem;
    background: #4f46e5;
    color: #fff;
    border: none;
    border-radius: .5rem;
    font-size: 1rem;
    cursor: pointer;
    transition: background .3s;
  }
  button:hover{ background:#4338ca; }
</style>
</head>
<body>

  <form class="form-box" action="forgot-password-update.php" method="POST">
    <h2>Change Password</h2>

    <label for="username">Username</label>
    <input type="text" id="username" name="username" placeholder="Enter your username" required>

    <label for="newpass">New Password</label>
    <input type="password" id="newpass" name="newpass" placeholder="Enter new password" required minlength="8">

    <label for="confirmpass">Confirm Password</label>
    <input type="password" id="confirmpass" name="confirmpass" placeholder="Re-enter new password" required minlength="8">

    <button type="submit">Update Password</button>
  </form>

</body>
</html>
