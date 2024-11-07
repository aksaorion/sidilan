<?php
require '../koneksi.php'; // Pastikan ini adalah file koneksi database

// Ambil data dari form
$sekolah = $_POST['nama_sekolah'];
$npsn = $_POST['npsn'];
$alamat = $_POST['alamat'];

// Validasi NPSN sudah digunakan atau belum
$email_check_query = "SELECT * FROM sekolah WHERE npsn = ?";
$stmt = $conn->prepare($email_check_query);
$stmt->bind_param("s", $npsn);
$stmt->execute();
$email_check_result = $stmt->get_result();

if ($email_check_result && $email_check_result->num_rows > 0) {
    echo "Sekolah sudah terdaftar.";
    exit;
}

// Insert data ke tabel sekolah
$insert_query = "INSERT INTO sekolah (nama_sekolah, npsn, alamat) VALUES (?, ?, ?)";
$stmt = $conn->prepare($insert_query);
$stmt->bind_param("sss", $sekolah, $npsn, $alamat);

if ($stmt->execute()) {
    // Ambil id_sekolah yang baru saja dimasukkan
    $id_sekolah = $conn->insert_id;

    // Redirect ke halaman registrasi admin dengan id_sekolah di URL
    header("Location: ../admin/signup-admin?id_sekolah=$id_sekolah");
    exit;
} else {
    echo "Terjadi kesalahan saat registrasi: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
