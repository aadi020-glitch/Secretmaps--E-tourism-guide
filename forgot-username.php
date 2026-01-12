<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot Username</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: "Poppins", Arial, sans-serif;
      background: linear-gradient(135deg, #4f46e5, #9333ea);
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      color: #111827;
    }

    .form-box {
      background: #ffffff;
      padding: 2.5rem 2rem;
      border-radius: 1rem;
      width: 100%;
      max-width: 380px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
      animation: fadeIn 0.6s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .form-box h2 {
      text-align: center;
      margin-bottom: 1.5rem;
      color: #1e1e2f;
      font-weight: 700;
    }

    label {
      display: block;
      margin-bottom: 0.4rem;
      font-weight: 600;
      color: #374151;
      font-size: 0.95rem;
    }

    input[type="email"] {
      width: 100%;
      padding: 0.8rem;
      border: 1px solid #d1d5db;
      border-radius: 0.5rem;
      font-size: 1rem;
      outline: none;
      transition: border-color 0.3s, box-shadow 0.3s;
    }

    input[type="email"]:focus {
      border-color: #6366f1;
      box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.3);
    }

    button {
      margin-top: 1.5rem;
      width: 100%;
      padding: 0.9rem;
      background: #4f46e5;
      color: #fff;
      border: none;
      border-radius: 0.5rem;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.3s, transform 0.1s;
    }

    button:hover {
      background: #4338ca;
      transform: translateY(-2px);
    }

    button:active {
      transform: translateY(0);
    }

    .note {
      text-align: center;
      margin-top: 1rem;
      font-size: 0.9rem;
      color: #6b7280;
    }
  </style>
</head>
<body>
  <div class="form-box">
    <h2>Forgot Username</h2>
    <form action="forgot-username-update.php" method="POST">
      <label for="email">Enter your registered email:</label>
      <input type="email" name="email" placeholder="you@example.com" required>
      <button type="submit">Retrieve Username</button>
    </form>
    <div class="note">You’ll see your username if your email is found.</div>
  </div>
</body>
</html>
