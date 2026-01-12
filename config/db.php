<?php
// config/db.php
$host     = "localhost";    // usually "localhost"
$username = "root";         // your MySQL username
$password = "";             // your MySQL password (XAMPP default is empty)
$database = "secretmaps";   // the database you created in phpMyAdmin

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
