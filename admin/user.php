<?php
$page = 'users';
include('header.php');
include('../config/db.php');
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

$user = $_SESSION['user'];
$isSuperAdmin = strtolower(trim($user['role'])) === 'super admin';
?>

<button class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></button>
<main class="main-content">
    <div class="header">
        <h1 id="pageTitle">Users</h1>
        <div class="user-info">
            <a href="profile.php"><img src="<?= htmlspecialchars($user['avatar']); ?>" alt="User" id="logo"></a>
            <a href="profile.php"><span><?= htmlspecialchars($user['full_name']); ?></span></a>
        </div>
    </div>

    <div class="page-content" id="details">
        <div class="table-container">
            <table class="users-table">
                <thead>
                    <tr>
                        <th>Sr</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Role</th>
                        
                        <th>Location</th>
                        <th>Created At</th>
                        <?php if ($isSuperAdmin): ?>
                            <th>Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT `id`, `full_name`, `username`, `role`, `avatar`, `location`, `created_at` FROM `users` ORDER BY id ASC";
                    $result = $conn->query($sql);

                    if (!$result) {
                        echo "<tr><td colspan='8'>SQL Error: " . htmlspecialchars($conn->error) . "</td></tr>";
                    } elseif ($result->num_rows > 0) {
                        $sr = 1;
                        while ($row = $result->fetch_assoc()) {

                            
                            echo "<tr>";
                            echo "<td>{$sr}</td>";
                            echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['role']) . "</td>";

                            echo "<td>" . htmlspecialchars($row['location'] ?: '-') . "</td>";
                            echo "<td>" . (!empty($row['created_at']) ? htmlspecialchars($row['created_at']) : '-') . "</td>";

                            if ($isSuperAdmin) {
                                echo "<td>
                                        <button class='edit-btn' onclick=\"location.href='user-role-edit.php?id={$row['id']}'\">Edit</button>
                                        <button class='delete-btn' onclick=\"return confirmDelete({$row['id']})\">Delete</button>
                                      </td>";
                            }

                            echo "</tr>";
                            $sr++;
                        }
                    } else {
                        $colspan = $isSuperAdmin ? 8 : 7;
                        echo "<tr><td colspan='{$colspan}'>No users found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

<script>
function confirmDelete(id) {
    if (confirm("Are you sure you want to delete this user?")) {
        window.location.href = "user-delete.php?id=" + id;
        return true;
    }
    return false;
}
</script>

<?php include('footer.php'); ?>
