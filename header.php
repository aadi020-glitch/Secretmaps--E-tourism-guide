<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

$loggedIn = isset($_SESSION['user']) && !empty($_SESSION['user']['id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>SecretMaps</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Abril+Fatface" rel="stylesheet">

  <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
  <link rel="stylesheet" href="css/animate.css">

  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">
  <link rel="stylesheet" href="css/magnific-popup.css">

  <link rel="stylesheet" href="css/aos.css">

  <link rel="stylesheet" href="css/ionicons.min.css">

  <link rel="stylesheet" href="css/bootstrap-datepicker.css">
  <link rel="stylesheet" href="css/jquery.timepicker.css">


  <link rel="stylesheet" href="css/flaticon.css">
  <link rel="stylesheet" href="css/icomoon.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />

</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
      <a class="navbar-brand" href="index.php"><img src="images/logo.png" style="width: 50px; margin-left:10px;"> SecretMaps</a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="oi oi-menu"></span>Menu
      </button>

      <div class="collapse navbar-collapse" id="ftco-nav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item <?php echo $page == 'index' ? 'active' : ''; ?>"><a href="index.php" class="nav-link">Home</a></li>
          <li class="nav-item <?php echo $page == 'about' ? 'active' : ''; ?>"><a href="about.php" class="nav-link">About</a></li>
          <li class="nav-item <?php echo $page == 'destination' ? 'active' : ''; ?>"><a href="destination.php" class="nav-link">Destination</a></li>
          <li class="nav-item <?php echo $page == 'details' ? 'active' : ''; ?>"><a href="details.php" class="nav-link">Details</a></li>

          <li class="nav-item <?php echo $page == 'login' ? 'active' : ''; ?>">
            <?php
            // Check if user is logged in
            if (isset($_SESSION['user'])) {
              $role = strtolower(trim($_SESSION['user']['role']));
              if ($role === 'super admin' || $role === 'admin') {
                $dashboardLink = 'admin/index.php';
              } else {
                $dashboardLink = 'user/index.php';
              }
              $linkText = 'Dashboard';
            } else {
              $dashboardLink = 'login.php';
              $linkText = 'Login';
            }
            ?>
            <a href="<?php echo $dashboardLink; ?>" class="nav-link"><?php echo $linkText; ?></a>
          </li>


          <li class="nav-item <?php echo $page == 'contact' ? 'active' : ''; ?>"><a href="contact.php" class="nav-link">Contact</a></li>
          <!--  <li class="nav-item <?php echo $page == 'Gallery' ? 'active' : ''; ?>"><a href="Gallery.php" class="nav-link">Gallery</a></li>-->

        </ul>
      </div>
    </div>
  </nav>