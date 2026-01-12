<?php
$page = 'places';
include('header.php');
session_start();
include('../config/db.php');

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

// Refresh session from DB to get latest info
$userId = $_SESSION['user']['id'];
$stmt = $conn->prepare("SELECT id, full_name, avatar, role FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$latestUser = $result->fetch_assoc();

if ($latestUser) {
    $_SESSION['user'] = $latestUser;
} else {
    session_unset();
    session_destroy();
    header("Location: ../login.php");
    exit;
}

$user = $_SESSION['user'];
$role = strtolower(trim($user['role']));

// Role-based access: Only Super Admin or Admin
if ($role !== 'super admin' && $role !== 'admin') {
    echo "<script>
        alert('Access denied! Only admins can view this page.');
        window.location.href = '../user/index.php';
    </script>";
    exit;
}

// Fetch destinations
if ($role === 'super admin') {
    $sql = "SELECT d.*, u.full_name AS added_by_name 
            FROM destinations d 
            LEFT JOIN users u ON d.added_by = u.id
            ORDER BY d.id DESC";
    $result = $conn->query($sql);
} else { // admin sees only their own
    $sql = "SELECT d.*, u.full_name AS added_by_name 
            FROM destinations d 
            LEFT JOIN users u ON d.added_by = u.id
            WHERE d.added_by = ? 
            ORDER BY d.id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<button class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></button>
<main class="main-content">
  <div class="header">
    <h1 id="pageTitle">Destinations</h1>
    <div class="user-info">
      <a href="profile.php"><img src="<?= htmlspecialchars($user['avatar']); ?>" alt="User" id="logo"></a>
      <a href="profile.php"><span><?= htmlspecialchars($user['full_name']); ?> (<?= htmlspecialchars($user['role']); ?>)</span></a>
    </div>
  </div>

  <div class="page-content" id="details">
    <div class="add-btn-container">
      <button class="add-btn">
        <a href="destination_form.php">Add New Destination</a>
      </button>
    </div>

    <div class="table-container">
      <table class="destination-table">
        <thead>
          <tr>
            <th>Sr</th>
            <th>Name</th>
            <th>Description</th>
            <th>Location</th>
            <th>Category</th>
            <th>Rating</th>
            <th>Tags</th>
            <th>Submitted At</th>
            <th>Added By</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if (!$result) {
              echo "<tr><td colspan='10'>SQL Error: " . htmlspecialchars($conn->error) . "</td></tr>";
          } elseif ($result->num_rows > 0) {
              $sr = 1;
              while ($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>{$sr}</td>";
                  echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['location']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['category']) . "</td>";
                  echo "<td>" . number_format((float)$row['rating'], 1) . "</td>";
                  echo "<td>" . htmlspecialchars($row['tags']) . "</td>";
                  echo "<td>" . (isset($row['created_at']) ? htmlspecialchars($row['created_at']) : '-') . "</td>";
                  echo "<td>" . htmlspecialchars($row['added_by_name'] ?? 'Unknown') . "</td>";

                  // Edit/Delete buttons only for Super Admin or the admin who added
                  $canEditDelete = ($role === 'super admin' || $row['added_by'] == $userId);
                  echo "<td>";
                  if ($canEditDelete) {
                      echo "<button class='edit-btn' onclick=\"location.href='destination-update-form.php?id={$row['id']}'\">Edit</button>";
                      echo "<button class='delete-btn' onclick=\"return confirmDelete({$row['id']})\">Delete</button>";
                  }
                  echo "</td>";

                  echo "</tr>";
                  $sr++;
              }
          } else {
              echo "<tr><td colspan='10'>No destinations found.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <script>
    function confirmDelete(id) {
      if (confirm("Are you sure you want to delete this destination?")) {
        window.location.href = "destination-delete.php?id=" + id;
        return true;
      }
      return false;
    }
  </script>

<?php include('footer.php'); ?>
