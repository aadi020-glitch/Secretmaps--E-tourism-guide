<?php
include('../config/db.php');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $conn->prepare("SELECT * FROM destinations WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$dest = $result->fetch_assoc();
if (!$dest) die("Destination not found");

$tags = array_map('trim', explode(',', $dest['tags'] ?? ''));
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}
$user = $_SESSION['user'];  // must create $conn
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Destination</title>
    <link rel="stylesheet" href="assets/css/destination.css">
    <link rel="stylesheet" href="assets/css/destination_form.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="container">
        <!-- <button class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></button>-->

        <main class="main-content">
            <div class="header">
                <h1 id="pageTitle">Edit Destination</h1>
                <div class="user-info">
                    <a href="profile.php"> <img src="<?php echo htmlspecialchars($user['avatar']); ?>" alt="User" id="logo"></a>
                    <a href="profile.php"><span><?php echo htmlspecialchars($user['full_name']); ?></span></a>
                </div>
            </div>

            <div class="card">
                <h2><i class="fas fa-edit"></i> Update Destination</h2>
                <form action="destination-update.php" method="POST" enctype="multipart/form-data">

                    <input type="hidden" name="id" value="<?= $dest['id'] ?>">

                    <label for="name">Destination Name</label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($dest['name']) ?>" required>

                    <label for="category">Category</label>
                    <select id="category" name="category" required>
                        <?php
                        $categories = [
                            "(Heritage)",
                            "(Nature)",
                            "(Adventure)",
                        ];
                        foreach ($categories as $cat) {
                            $selected = ($dest['category'] == $cat) ? 'selected' : '';
                            echo "<option value=\"$cat\" $selected>$cat</option>";
                        }
                        ?>
                    </select>

                    <label for="description">Short Description</label>
                    <textarea id="description" name="description" rows="3" required><?= htmlspecialchars($dest['description']) ?></textarea>

                    <label for="extra_description">Extra Description</label>
                    <textarea id="extra_description" name="extra_description" rows="5"><?= htmlspecialchars($dest['extra_description']) ?></textarea>

                    <label for="highlights">Highlights</label>
                    <textarea id="highlights" name="highlights" rows="3"><?= htmlspecialchars($dest['highlights']) ?></textarea>

                    <label for="services">Services</label>
                    <textarea id="services" name="services" rows="3"><?= htmlspecialchars($dest['services']) ?></textarea>

                    <label for="location">Location</label>
                    <input type="text" id="location" name="location" value="<?= htmlspecialchars($dest['location']) ?>" required>

                    <label for="slug">Destination Slug</label>
                    <input type="text" id="slug" name="slug" value="<?= htmlspecialchars($dest['slug']) ?>" required>

                    <label for="best_time">Best Time to Visit</label>
                    <input type="text" id="best_time" name="best_time" value="<?= htmlspecialchars($dest['best_time']) ?>">

                    <label for="official_link">Official Link</label>
                    <input type="url" id="official_link" name="official_link" value="<?= htmlspecialchars($dest['official_link']) ?>">

                    <label for="iframe_map">Google Map Embed Code</label>
                    <textarea id="iframe_map" name="iframe_map" rows="3"><?= htmlspecialchars($dest['iframe_map']) ?></textarea>

                    <label for="rating">Rating</label>
                    <input type="number" id="rating" name="rating" min="1" max="5" step="0.1" value="<?= $dest['rating'] ?>">

                    <label>Tags</label>
                    <div class="checkbox-group">
                        <input type="checkbox" id="popular" name="tags[]" value="Popular" <?= in_array('Popular', $tags) ? 'checked' : '' ?>>
                        <label for="popular">Popular</label>

                        <input type="checkbox" id="hidden_gem" name="tags[]" value="Hidden Gem" <?= in_array('Hidden Gem', $tags) ? 'checked' : '' ?>>
                        <label for="hidden_gem">Hidden Gem</label>
                    </div>

                    <label for="image">Destination Image</label>
                    <input type="file" id="image" name="image" accept="image/*" onchange="previewImage(this)">
                    <?php if (!empty($dest['image_path'])): ?>
                        <img id="imagePreview" src="../<?= $dest['image_path'] ?>" alt="Current Image" height="150px" width="200px">
                    <?php else: ?>
                        <img id="imagePreview" src="#" style="display:none;">
                    <?php endif; ?>
                    <br>
                    <button type="submit" class="btn"><i class="fas fa-save"></i> Update</button>
                    <button type="button" class="btn-d" onclick="window.location='places.php'"><i class="fa fa-close"></i> Cancel</button>
                </form>
            </div>
        </main>
    </div>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    <?php include('footer.php'); ?>
</body>

</html>