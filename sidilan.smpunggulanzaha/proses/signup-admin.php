<?php
require '../koneksi.php'; // Pastikan ini adalah file koneksi database

// Ambil data dari form
$id_sekolah = $_POST['id_sekolah'];
$nama = $_POST['nama'];
$jabatan = $_POST['jabatan'];
$telepon = $_POST['telepon'];
$email = $_POST['email'];
$password = $_POST['password'];

// Validasi email sudah digunakan atau belum
$email_check_query = "SELECT * FROM admin WHERE email = '$email'";
$email_check_result = $conn->query($email_check_query);

if ($email_check_result && $email_check_result->num_rows > 0) {
    echo "Email sudah terdaftar. Silakan gunakan email lain.";
    exit;
}

// Hashing password sebelum disimpan ke database
$hashed_password = md5($password);

// Insert data ke tabel admin
$insert_query = "INSERT INTO admin (id_sekolah, nama, jabatan, telepon, email, pass) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($insert_query);
$stmt->bind_param("isssss", $id_sekolah, $nama, $jabatan, $telepon, $email, $hashed_password);

if ($stmt->execute()) {
    echo "Registrasi admin berhasil!";
    // Redirect ke halaman lain jika perlu
    header("Location: ../admin/login"); // Ganti dengan halaman dashboard admin
    exit;
} else {
    echo "Terjadi kesalahan saat registrasi: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
