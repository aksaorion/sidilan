<?php
// Database configuration
$host = 'localhost';  // Server database
$user = 'smpw2144_user';       // Username database
$password = 'Genggong@39';       // Password database
$database = 'smpw2144_sidilan';  // Nama database

// Create connection
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Set character set to UTF-8
$conn->set_charset("utf8");

// Gunakan variabel $conn untuk query ke database
?>
