<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SecretMaps - Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="assets/css/details.css">
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

    <script>
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        const container = document.querySelector('.container');

        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('closed');
            container.classList.toggle('sidebar-closed'); // optional, if you want to adjust main content slightly
        });
    </script>

</head>

<body>
    <div class="container">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <img src="assets/img/logo.png" style="width:200px">
            </div>
            <nav class="sidebar-menu">
                <ul>
                    <li><a href="index.php" <?php echo $page == 'index' ? 'class="active"' : ''; ?>><i class="fa-solid fa-grip"></i> Dashboard</a></li>
                    <li><a href="profile.php" <?php echo $page == 'profile' ? 'class="active"' : ''; ?>><i class="fas fa-user"></i> Profile</a></li>
                    <li><a href="places.php" <?php echo $page == 'places' ? 'class="active"' : ''; ?>><i class="fa-solid fa-earth-americas"></i> Destination</a></li>
                    <li><a href="user.php" <?php echo $page == 'user' ? 'class="active"' : ''; ?>><i class="fa-solid fa-ranking-star"></i>Users</a></li>
                    <li><a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </nav>
        </aside>