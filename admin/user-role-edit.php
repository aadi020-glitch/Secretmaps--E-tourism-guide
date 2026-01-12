<?php
session_start();
include('../config/db.php');

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

$currentUser = $_SESSION['user'];

// Get user ID to edit
if (!isset($_GET['id'])) {
    header("Location: user.php");
    exit;
}

$userIdToUpdate = (int)$_GET['id'];

// Fetch user to edit
$stmt = $conn->prepare("SELECT id, username, role FROM users WHERE id = ?");
$stmt->bind_param("i", $userIdToUpdate);
$stmt->execute();
$userResult = $stmt->get_result();
$user = $userResult->fetch_assoc();

if (!$user) {
    echo "<script>alert('User not found!'); window.location.href='user.php';</script>";
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newRole = trim($_POST['role']);

    // Only Super Admin can change the role of another admin
    if ($user['role'] === 'admin' && $currentUser['role'] !== 'super admin') {
        echo "<script>alert('Only Super Admin can change the role of an Admin!'); window.location.href='user.php';</script>";
        exit;
    }

    // Only Super Admin can assign Super Admin
    if ($newRole === 'super admin' && $currentUser['role'] !== 'super admin') {
        echo "<script>alert('Only Super Admin can assign Super Admin role!'); window.location.href='user.php';</script>";
        exit;
    }

    // Prevent user from changing their own role
    if ($currentUser['id'] === $userIdToUpdate && $newRole !== $currentUser['role']) {
        echo "<script>alert('You cannot change your own role!'); window.location.href='user.php';</script>";
        exit;
    }

    // Update role
    $stmt = $conn->prepare("UPDATE users SET role = ? WHERE id = ?");
    $stmt->bind_param("si", $newRole, $userIdToUpdate);

    if ($stmt->execute()) {
        echo "<script>alert('Role updated successfully!'); window.location.href='user.php';</script>";
        exit;
    } else {
        echo "<script>alert('Failed to update role!'); window.location.href='user.php';</script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit User Role</title>
    <style>
/* ===== Base Layout ===== */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f7f8;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding: 50px 20px;
    margin: 0;
    min-height: 100vh;
    box-sizing: border-box;
}

/* ===== Card Styling ===== */
.card {
    background: #fff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
    text-align: center;
    box-sizing: border-box;
    transition: all 0.3s ease;
}

/* ===== Avatar ===== */
.avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 15px;
    border: 2px solid #007BFF;
}

/* ===== Headings and Text ===== */
h2 {
    margin-bottom: 5px;
    font-size: clamp(20px, 2vw, 24px);
    color: #333;
}

.username {
    font-size: clamp(14px, 1.5vw, 16px);
    color: #555;
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    color: #555;
    text-align: left;
}

/* ===== Responsive Option Menu ===== */
select {
    width: 100%;
    padding: 12px;
    border-radius: 6px;
    border: 1px solid #ccc;
    margin-bottom: 20px;
    font-size: clamp(14px, 1.5vw, 16px);
    box-sizing: border-box;
    background-color: #fff;
    color: #333;
    transition: all 0.2s ease;
    appearance: none; /* Removes default arrow for custom styling */
    background-image: url("data:image/svg+xml;utf8,<svg fill='%23007BFF' height='20' viewBox='0 0 24 24' width='20' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/></svg>");
    background-repeat: no-repeat;
    background-position: right 10px center;
    background-size: 16px;
}

select:focus {
    border-color: #007BFF;
    box-shadow: 0 0 4px rgba(0, 123, 255, 0.3);
    outline: none;
}

/* ===== Buttons ===== */
button {
    background-color: #007BFF;
    color: #fff;
    padding: 12px 20px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: clamp(14px, 1.5vw, 16px);
    width: 100%;
    transition: background 0.3s ease;
}

button:hover {
    background-color: #0056b3;
}

/* ===== Message Box ===== */
.message {
    margin-bottom: 15px;
    padding: 10px;
    background-color: #d4edda;
    color: #155724;
    border-radius: 6px;
}

/* ===== Responsive Design ===== */

/* 📱 Small Devices (Phones, <600px) */
@media (max-width: 600px) {
    body {
        padding: 20px 10px;
    }

    .card {
        padding: 20px;
        max-width: 100%;
        width: 100%;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    h2 {
        font-size: 20px;
    }

    .username {
        font-size: 14px;
    }

    select {
        font-size: 10px;
        padding: 12px;
        background-position: right 12px center;
    }

    button {
        font-size: 15px;
        padding: 12px;
    }
}

/* 💻 Medium Devices (Tablets, 600px–1024px) */
@media (min-width: 601px) and (max-width: 1024px) {
    body {
        padding: 40px;
    }

    .card {
        max-width: 500px;
    }

    select {
        font-size: 15px;
    }
}

/* 🖥️ Large Devices (Desktops, >1024px) */
@media (min-width: 1025px) {
    .card {
        max-width: 400px;
    }
}

    </style>
</head>

<body>
    <div class="card">
        <h2><?php echo htmlspecialchars($user['username']); ?></h2>
        <div class="username">Current Role: <?php echo htmlspecialchars(ucfirst($user['role'])); ?></div>

        <form method="post">
            <label for="role">Select Role:</label>
            <select name="role" id="role">
                <option value="user" <?php if ($user['role'] === 'user') echo 'selected'; ?>>User</option>
                <option value="admin" <?php if ($user['role'] === 'admin') echo 'selected'; ?>>Admin</option>
            </select>
            <button type="submit">Update Role</button>
        </form>
    </div>
</body>

</html>