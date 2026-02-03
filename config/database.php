<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');  // Change this to your database username
define('DB_PASS', '');      // Change this to your database password
define('DB_NAME', 'e-sas-care');

// Create connection
$koneksi = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if (!$koneksi) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set charset to UTF-8
mysqli_set_charset($koneksi, "utf8");

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>