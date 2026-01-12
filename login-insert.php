<?php
session_start();
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Check for empty fields
    if (empty($username) || empty($password)) {
        echo "<script>
            alert('Please enter both username and password!');
            window.location.href='login.php';
        </script>";
        exit;
    }

    // Fetch user by username
    $stmt = $conn->prepare("SELECT id, full_name, avatar, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        // User doesn't exist → redirect to signup
        echo "<script>
            alert('User does not exist. Please sign up first.');
            window.location.href='signup.php';
        </script>";
        exit;
    }

    $user = $result->fetch_assoc();

    // Verify password
    if (!password_verify($password, $user['password'])) {
        echo "<script>
            alert('Incorrect password! Please try again.');
            window.location.href='login.php';
        </script>";
        exit;
    }

    // ✅ Destroy previous session and start new
    session_unset();
    session_destroy();
    session_start();

    $_SESSION['user'] = [
        'id'        => $user['id'],
        'full_name' => $user['full_name'],
        'avatar'    => $user['avatar'],
        'role'      => $user['role']
    ];

    // Role-based alerts and redirects
    $role = strtolower(trim($user['role']));

    switch ($role) {
        case 'super admin':
            echo "<script>
                alert('Super Admin login successful!');
                window.location.href='admin/index.php';
            </script>";
            break;

        case 'admin':
            echo "<script>
                alert('Admin login successful!');
                window.location.href='admin/index.php';
            </script>";
            break;

        case 'user':
            echo "<script>
                alert('User login successful!');
                window.location.href='user/index.php';
            </script>";
            break;

        default:
            // Unknown role → log out
            session_unset();
            session_destroy();
            echo "<script>
                alert('Invalid role assigned. Contact the system administrator.');
                window.location.href='login.php';
            </script>";
            break;
    }
}
?>
