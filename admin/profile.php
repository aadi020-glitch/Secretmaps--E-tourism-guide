<?php
session_start();
include('../config/db.php');
$page = 'profile';
include('header.php');

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

// Refresh session from DB to get latest info
$userId = $_SESSION['user']['id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// If user not found, logout
if (!$user) {
    session_unset();
    session_destroy();
    header("Location: ../login.php");
    exit;
}

// Determine if current user is super admin
$isSuperAdmin = strtolower(trim($user['role'])) === 'super admin';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'] ?? '';
    $email     = $_POST['email'] ?? '';
    $phone     = $_POST['phone'] ?? '';
    $location  = $_POST['location'] ?? '';
    $username  = $_POST['username'] ?? '';
    $password  = $_POST['password'] ?? '';
    $experience = $_POST['experience'] ?? $user['experience'];

    // Only super admin can update role
    $role = $isSuperAdmin && isset($_POST['role']) ? $_POST['role'] : $user['role'];

    // Handle avatar upload
    $avatarPath = $user['avatar'];
    if (!empty($_FILES['avatar']['name'])) {
        $fileName = time() . '_' . basename($_FILES['avatar']['name']);
        $uploadDir = __DIR__ . '/uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $target = $uploadDir . $fileName;
        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target)) {
            $avatarPath = 'uploads/' . $fileName;
        }
    }

    // Hash password if entered
    $hashedPassword = $password ? password_hash($password, PASSWORD_DEFAULT) : $user['password'];

    $update = $conn->prepare("
        UPDATE users SET full_name=?, role=?, email=?, phone=?, location=?, avatar=?, username=?, password=?, experience=? WHERE id=?
    ");
    $update->bind_param(
        "sssssssssi",
        $full_name,
        $role,
        $email,
        $phone,
        $location,
        $avatarPath,
        $username,
        $hashedPassword,
        $experience,
        $userId
    );
    $update->execute();

    // Refresh session data
    $user['full_name'] = $full_name;
    $user['email'] = $email;
    $user['phone'] = $phone;
    $user['location'] = $location;
    $user['avatar'] = $avatarPath;
    $user['username'] = $username;
    $user['password'] = $hashedPassword;
    $user['experience'] = $experience;
    $user['role'] = $role;

    $_SESSION['user'] = [
        'id' => $user['id'],
        'full_name' => $full_name,
        'avatar' => $avatarPath,
        'role' => $role
    ];

    echo "<script>alert('Profile updated successfully!');</script>";
}
?>

<button class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></button>
<main class="main-content">
    <div class="header">
        <h1 id="pageTitle">Profile</h1>
        <div class="user-info">
            <a href="profile.php"><img src="<?= htmlspecialchars($user['avatar']); ?>" alt="User" id="logo"></a>
            <a href="profile.php"><span><?= htmlspecialchars($user['full_name']); ?></span></a>
        </div>
    </div>

    <header>
        <div class="profile-header">
            <div class="avatar-container">
                <img src="<?= htmlspecialchars($user['avatar']); ?>" alt="Avatar" class="avatar" id="avatarPreview">
                <div class="avatar-overlay" onclick="document.getElementById('avatar').click()">
                    <i class="fas fa-camera"></i>
                </div>
            </div>
            <div class="admin-info">
                <h1 id="profileName"><?= htmlspecialchars($user['full_name']); ?></h1>
                <p><?= htmlspecialchars($user['role']); ?></p>
                <div class="admin-details">
                    <div class="detail-item">
                        <i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($user['location']); ?>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-briefcase"></i> <?= htmlspecialchars($user['experience']); ?> experience
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-certificate"></i> Certified Admin
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="page-content" id="profile">
        <div class="table-container">
            <h2>User Profile</h2>
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="full_name"><i class="fas fa-user"></i> Full Name</label>
                    <input type="text" name="full_name" id="full_name" value="<?= htmlspecialchars($user['full_name']); ?>">
                </div>

                <div class="form-group">
                    <label for="experience"><i class="fas fa-briefcase"></i> Experience</label>
                    <input type="text" name="experience" id="experience" value="<?= htmlspecialchars($user['experience']); ?>" placeholder="e.g., 5 years">
                </div>

                <div class="form-group">
                    <label for="role"><i class="fas fa-briefcase"></i> Role</label>
                    <?php if ($isSuperAdmin): ?>
                        <input type="text" name="role" id="role" value="<?= htmlspecialchars($user['role']); ?>">
                    <?php else: ?>
                        <input type="text" id="role" value="<?= htmlspecialchars($user['role']); ?>" readonly style="background-color:#f0f0f0;">
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']); ?>">
                </div>

                <div class="form-group">
                    <label for="phone"><i class="fas fa-phone"></i> Phone</label>
                    <input type="tel" name="phone" id="phone" value="<?= htmlspecialchars($user['phone']); ?>">
                </div>

                <div class="form-group">
                    <label for="location"><i class="fas fa-map-marker-alt"></i> Location</label>
                    <input type="text" name="location" id="location" value="<?= htmlspecialchars($user['location']); ?>">
                </div>

                <div class="form-group">
                    <label for="username"><i class="fas fa-user-circle"></i> Username</label>
                    <input type="text" name="username" id="username" value="<?= htmlspecialchars($user['username']); ?>">
                </div>

                <div class="form-group">
                    <label for="password"><i class="fas fa-lock"></i> Password</label>
                    <input type="password" name="password" id="password" placeholder="Leave blank to keep current password">
                </div>

                <div class="form-group">
                    <label for="avatar"><i class="fas fa-camera"></i> Avatar</label>
                    <input type="file" name="avatar" id="avatar" accept="image/*" style="display:none;" onchange="previewImage(this)">
                </div>

                <div class="action-buttons">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-sync-alt"></i> Update Profile</button>
                    <button type="reset" class="btn btn-secondary"><i class="fas fa-times"></i> Reset</button>
                </div>
            </form>
        </div>
    </div>

    <?php include('footer.php'); ?>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('avatarPreview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => preview.src = e.target.result;
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
