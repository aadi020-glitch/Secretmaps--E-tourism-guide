<?php
$page = 'contact';
include('header.php');
include('config/db.php'); // DB connection

// Fetch all admins and super admins dynamically
$adminQuery = "SELECT `full_name`, `email`, `phone`, `location`, `avatar`, `username`, `role` 
               FROM `users` WHERE `role` IN ('admin','super admin')";
$adminResult = $conn->query($adminQuery);
$admins = [];
if ($adminResult->num_rows > 0) {
    while ($row = $adminResult->fetch_assoc()) {
        $admins[] = $row;
    }
}
?>

<div class="hero-wrap js-fullheight" style="background-image: url('images/contact.jpg');">
  <div class="overlay"></div>
  <div class="container">
    <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center">
      <div class="col-md-9 text-center ftco-animate">
        <p class="breadcrumbs">
          <span class="mr-2"><a href="index.php">Home</a></span>
          <span><a href="about.php">About</a></span>
        </p>
        <h1 class="mb-3 bread">Contact</h1>
      </div>
    </div>
  </div>
</div>

<section class="ftco-section contact-section ftco-degree-bg">
  <div class="container">

    <!-- Contact Info -->
    <div>
      <div class="col-md-12 mb-4">
        <h2 class="h4">Contact Information</h2>
      </div>
      <!-- Admin Cards Grid -->
      <div class="admin-cards-grid mb-5">
        <?php if (count($admins) > 0): ?>
          <?php foreach ($admins as $admin): ?>
            <div class="admin-card">
              <div class="avatar">
                <img src="admin/<?= htmlspecialchars($admin['avatar']); ?>"
                     alt="<?= htmlspecialchars($admin['full_name']); ?>">
              </div>
              <div class="info">
                <h4><?= htmlspecialchars($admin['full_name']); ?></h4>
                <p><strong>Role:</strong> <?= htmlspecialchars(ucwords($admin['role'])); ?></p>
                <p>📞 <?= htmlspecialchars($admin['phone']); ?></p>
                <p>✉️ <?= htmlspecialchars($admin['email']); ?></p>
                <p>📍 <?= htmlspecialchars($admin['location']); ?></p>

                <div class="socials mt-2">
                  <a href="#"><i class="fab fa-twitter"></i></a>
                  <a href="#"><i class="fab fa-facebook"></i></a>
                  <a href="#"><i class="fab fa-linkedin"></i></a>
                  <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p>No admins or super admins found.</p>
        <?php endif; ?>
      </div>
    </div>

    <!-- Contact Form & Map -->
    <div class="row block-9">
      <div class="col-md-6 order-md-last pr-md-5">
        <form action="contact-save.php" method="POST" class="contact-form">
          <div class="form-group">
            <input type="text" name="name" class="form-control" placeholder="Your Name" required>
          </div>
          <div class="form-group">
            <input type="email" name="email" class="form-control" placeholder="Your Email" required>
          </div>
          <div class="form-group">
            <input type="text" name="subject" class="form-control" placeholder="Subject" required>
          </div>
          <div class="form-group">
            <textarea name="message" cols="30" rows="7" class="form-control" placeholder="Message" required></textarea>
          </div>
          <div class="form-group">
            <input type="submit" value="Send Message" class="btn btn-primary py-3 px-5">
          </div>
        </form>
      </div>

      <div class="col-md-6">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d62564.271804354714!2d75.52944920262233!3d20.99876561032649!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bd90fbc518b5319%3A0xa456e6c4bbd7bb57!2sShastri%20Nagar!5e0!3m2!1sen!2sin!4v1757002659682!5m2!1sen!2sin"
          width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
      </div>
    </div>

  </div>
</section>

<style>
  /* Grid for admin cards */
  .admin-cards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 20px;
    margin-bottom: 40px;
  }

  /* Individual admin card */
  .admin-card {
    display: flex;
    background: #fff;
    border-radius: 15px;
    padding: 20px;
    align-items: center;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  }

  .admin-card .avatar img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #eee;
  }

  .admin-card .info {
    margin-left: 20px;
  }

  .admin-card .info h4 {
    margin-bottom: 5px;
    font-size: 22px;
  }

  .admin-card .info p {
    margin: 3px 0;
    font-size: 14px;
    color: #555;
  }

  .admin-card .socials a {
    margin-right: 10px;
    font-size: 18px;
    color: #555;
    text-decoration: none;
  }

  .admin-card .socials a:hover {
    color: #1da1f2;
  }

  /* Responsive: stack cards on small screens */
  @media (max-width: 767px) {
    .admin-card {
      flex-direction: column;
      text-align: center;
    }

    .admin-card .info {
      margin-left: 0;
      margin-top: 15px;
    }
  }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<?php include('footer.php'); ?>
