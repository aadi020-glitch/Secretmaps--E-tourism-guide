<?php
include('../config/db.php');
session_start();

// Only logged-in users
if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
    exit;
}

$userId = $_SESSION['user']['id'];

// Fetch user's trips with destination info
$stmt = $conn->prepare("
    SELECT d.* FROM user_trips ut
    JOIN destinations d ON ut.destination_id = d.id
    WHERE ut.user_id=?
    ORDER BY ut.id DESC
");
$stmt->bind_param("i", $userId);
$stmt->execute();
$trips = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Trip Planner</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="assets/css/trip.css">
</head>
<body>

<h2>My Trip Planner</h2>

<?php if(!$trips): ?>
    <p class="text-center text-muted">No destinations added to your trip yet.</p>
<?php else: ?>
<div class="trip-container">
    <?php foreach($trips as $trip): ?>
    <div class="trip-card">
        <img src="../<?= htmlspecialchars($trip['image_path']) ?>" alt="<?= htmlspecialchars($trip['name']) ?>">
        <div class="trip-card-body">
            <h3><?= htmlspecialchars($trip['name']) ?></h3>
            <p><?= htmlspecialchars($trip['location']) ?></p>
            <p class="small text-muted"><?= htmlspecialchars(substr($trip['description'], 0, 80)) ?>...</p>
            <div class="action-buttons">
                <a href="../details.php#<?= htmlspecialchars($trip['slug']) ?>" class="btn btn-sm btn-primary">View</a>

                <form method="POST" action="remove_from_trip.php">
                    <input type="hidden" name="destination_id" value="<?= $trip['id'] ?>">
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
