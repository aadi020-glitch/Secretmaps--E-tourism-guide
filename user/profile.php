<?php
$page = 'profile';
include('../config/db.php'); // DB connection
include('header.php');

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

$userId = $_SESSION['user']['id'];

// --- FETCH CURRENT USER DATA ---
$sql = "SELECT * FROM users WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
if (!$user) die("User not found!");

// --- HANDLE FORM SUBMISSION ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $full_name = $_POST['full_name'] ?? '';
    $email     = $_POST['email'] ?? '';
    $phone     = $_POST['phone'] ?? '';
    $location  = $_POST['location'] ?? '';
    $username  = $_POST['username'] ?? '';
    $password  = $_POST['password'] ?? '';

    $avatarPath = $user['avatar']; // keep old avatar

    // --- Handle avatar upload ---
    if (!empty($_FILES['avatar']['name'])) {
        $fileName = time() . '_' . basename($_FILES['avatar']['name']);
        $uploadDir = __DIR__ . '/uploads/'; // admin/uploads folder
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $target = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target)) {
            // Delete old avatar if exists
            if ($user['avatar'] && file_exists(__DIR__ . '/' . $user['avatar'])) {
                unlink(__DIR__ . '/' . $user['avatar']);
            }
            $avatarPath = 'uploads/' . $fileName; // relative path for browser & DB
        }
    }

    // --- Hash password if new password entered ---
    $hashedPassword = $password ? password_hash($password, PASSWORD_DEFAULT) : $user['password'];

    // --- Update user in DB ---
    $update = $conn->prepare("
        UPDATE users SET full_name=?, email=?, phone=?, location=?, avatar=?, username=?, password=? WHERE id=?
    ");
    $update->bind_param(
        "sssssssi",
        $full_name,
        $email,
        $phone,
        $location,
        $avatarPath,
        $username,
        $hashedPassword,
        $userId
    );
    $update->execute();

    // --- Refresh $user array ---
    $user['full_name'] = $full_name;
    $user['email']     = $email;
    $user['phone']     = $phone;
    $user['location']  = $location;
    $user['username']  = $username;
    $user['password']  = $hashedPassword;
    $user['avatar']    = $avatarPath;

    echo "<script>alert('Profile updated successfully!');</script>";
}
?>
<button class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></button>
<main class="main-content">
    <div class="header">
        <h1 id="pageTitle">Profile</h1>
        <div class="user-info">
            <a href="profile.php">
                <img src="<?= htmlspecialchars($user['avatar'] ?: 'uploads/default.png'); ?>" alt="User" id="logo">
            </a>
            <a href="profile.php"><span><?= htmlspecialchars($user['full_name']); ?></span></a>
        </div>
    </div>

    <header>
        <div class="profile-header">
            <div class="avatar-container">
                <img src="<?= htmlspecialchars($user['avatar'] ?: 'uploads/default.png'); ?>" alt="Avatar" class="avatar" id="avatarPreview">
                <div class="avatar-overlay" onclick="document.getElementById('avatar').click()">
                    <i class="fas fa-camera"></i>
                </div>
            </div>
            <div class="admin-info">
                <h1 id="profileName"><?= htmlspecialchars($user['full_name']); ?></h1>
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

                <input type="file" name="avatar" id="avatar" accept="image/*" style="display:none;" onchange="previewImage(this)">

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
