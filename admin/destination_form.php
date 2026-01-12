<?php
include('../config/db.php'); // your database connection      
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SecretMaps - Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/destination.css">
    <link rel="stylesheet" href="assets/css/destination_form.css">
</head>

<body>
    <div class="container">
        <!--<button class="menu-toggle" id="menuToggle">
            <i class="fas fa-bars"></i>
        </button>-->

        <main class="main-content">
            <div class="header">
                <h1 id="pageTitle">Add Destination</h1>
                <div class="user-info">
                    <a href="profile.php"> <img src="<?php echo htmlspecialchars($user['avatar']); ?>" alt="User" id="logo"></a>
                    <a href="profile.php"><span><?php echo htmlspecialchars($user['full_name']); ?></span></a>
                </div>
            </div>

            <div class="card">
                <h2><i class="fas fa-edit"></i> Add Destination</h2>

                <form action="destination-insert.php" method="POST" enctype="multipart/form-data">

                    <!-- Destination Name -->
                    <label for="name"><i class="fas fa-signature"></i> Destination Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter destination name" required>

                    <!-- Category -->
                    <label for="category"><i class="fas fa-tag"></i> Category</label>
                    <select id="category" name="category" required>
                        <option value="">--Select Category--</option>
                        <option value="(nature)">(Nature)</option>
                        <option value="(adventure)">(Adventure)</option>
                        <option value="(heritage)">(Heritage)</option>
                    </select>

                    <!-- Description -->
                    <label for="description"><i class="fas fa-align-left"></i> Short Description</label>
                    <textarea id="description" name="description" rows="3" placeholder="Short description" required></textarea>

                    <!-- Extra Description -->
                    <label for="extra_description">Extra Description</label>
                    <textarea id="extra_description" name="extra_description" rows="5" placeholder="Extra description"></textarea>

                    <!-- Highlights -->
                    <label for="highlights">Highlights <small>(comma-separated)</small></label>
                    <textarea id="highlights" name="highlights" rows="3" placeholder="Highlights"></textarea>

                    <!-- Services -->
                    <label for="services">Services <small>(comma-separated)</small></label>
                    <textarea id="services" name="services" rows="3" placeholder="Services"></textarea>

                    <!-- Location -->
                    <label for="location"><i class="fas fa-map-marker-alt"></i> Location</label>
                    <input type="text" id="location" name="location" placeholder="Enter location" required>

                    <!-- Slug -->
                    <label for="slug"><i class="fas fa-link"></i> Destination Slug</label>
                    <input type="text" id="slug" name="slug" placeholder="Enter URL slug" required>

                    <!-- Best Time -->
                    <label for="best_time">Best Time to Visit</label>
                    <input type="text" id="best_time" name="best_time" placeholder="Best time to visit">

                    <!-- Official Link -->
                    <label for="official_link">Official Link</label>
                    <input type="url" id="official_link" name="official_link" placeholder="Official website link">

                    <!-- Google Map Embed -->
                    <label for="iframe_map">Google Map Embed Code</label>
                    <textarea id="iframe_map" name="iframe_map" rows="3" placeholder="Paste the full iframe embed code here"></textarea>

                    <!-- Rating -->
                    <label for="rating"><i class="fas fa-star"></i> Rating</label>
                    <input type="number" id="rating" name="rating" min="1" max="5" step="0.1" value="">
                    <div class="rating-stars">★★★☆☆</div>

                    <!-- Tags -->
                    <label><i class="fas fa-tags"></i> Tags</label>
                    <div class="checkbox-group">
                        <div class="checkbox-item">
                            <input type="checkbox" id="popular" name="tags[]" value="Popular">
                            <label for="popular">Popular</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="hidden_gem" name="tags[]" value="Hidden Gem">
                            <label for="hidden_gem">Hidden Gem</label>
                        </div>
                    </div>
                    <!-- In PHP, you can do: $tags = implode(',', $_POST['tags']); to store in DB -->

                    <!-- Destination Image -->
                    <label for="image_path"><i class="fas fa-image"></i> Destination Image</label>
                    <input type="file" id="image_path" name="image_path" accept="image/*" required onchange="previewImage(this)">
                    <img id="imagePreview" src="#" alt="Image Preview" style="display:none; max-width: 200px; margin-top: 10px;">
                    <!-- In PHP: move_uploaded_file($_FILES['image_path']['tmp_name'], 'uploads/'.$filename) -->

                    <button type="submit" class="btn">
                        <i class="fas fa-save"></i> Save
                    </button>
                    <button type="button" class="btn-d" onClick="window.location='places.php'">
                        <i class="fa fa-close"></i> Cancel
                    </button>
                </form>

            </div>
        </main>
    </div>
    <?php include('footer.php'); ?>
</body>

</html>