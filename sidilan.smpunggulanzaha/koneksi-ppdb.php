<?php
// Database configuration
$host = 'localhost';  // Server database
$user = 'smpw2144_user';       // Username database
$password = 'Genggong@39';       // Password database
$database = 'smpw2144_smpunggulanzaha';  // Nama database

// Create connection
$ppdb = new mysqli($host, $user, $password, $database);

// Check connection
if ($ppdb->connect_error) {
    die("Koneksi gagal: " . $ppdb->connect_error);
}

// Set character set to UTF-8
$ppdb->set_charset("utf8");

// Gunakan variabel $conn untuk query ke database
?>
