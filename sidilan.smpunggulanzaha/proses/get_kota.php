<?php
require 'koneksi.php'; // Ganti dengan path koneksi database Anda

// Ambil id_provinsi dari query string
$id_provinsi = intval($_GET['id_provinsi']);

// Query untuk mengambil data kota berdasarkan id_provinsi
$query = "SELECT * FROM kota WHERE id_provinsi = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_provinsi);
$stmt->execute();
$result = $stmt->get_result();

// Menghasilkan HTML untuk dropdown kota
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['id_kota'] . "'>" . $row['kota'] . "</option>";
    }
} else {
    echo "<option value=''>No cities available</option>";
}

$stmt->close();
$conn->close();
?>
