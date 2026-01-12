<?php
include('../config/db.php');
session_start();

// Only logged-in users
if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
    exit;
}

$userId = $_SESSION['user']['id'];

// Fetch user's wishlist with destination info
$stmt = $conn->prepare("
    SELECT d.* FROM user_wishlist uw
    JOIN destinations d ON uw.destination_id = d.id
    WHERE uw.user_id=?
    ORDER BY uw.id DESC
");
$stmt->bind_param("i", $userId);
$stmt->execute();
$wishlist = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Wishlist</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="assets/css/wishlist.css">
</head>
<body>

<h2>My Wishlist</h2>

<?php if(!$wishlist): ?>
    <p class="text-center text-muted">You haven't added any destinations to your wishlist yet.</p>
<?php else: ?>
<div class="wishlist-container">
    <?php foreach($wishlist as $item): ?>
    <div class="wishlist-card">
        <img src="../<?= htmlspecialchars($item['image_path']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
        <div class="wishlist-card-body">
            <h3><?= htmlspecialchars($item['name']) ?></h3>
            <p><?= htmlspecialchars($item['location']) ?></p>
            <p class="small text-muted"><?= htmlspecialchars(substr($item['description'], 0, 80)) ?>...</p>
            <div class="action-buttons">
                <a href="../details.php#<?= htmlspecialchars($item['slug']) ?>" class="btn btn-sm btn-primary">View</a>
                <form method="POST" action="remove_from_wishlist.php">
                    <input type="hidden" name="destination_id" value="<?= $item['id'] ?>">
                    <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- Add button always shown -->
<div class="add-button-container">
    <form method="POST" action="../destination.php">
        <button type="submit">Add New Destination</button>
    </form>
</div>

</body>
</html>
