<?php
include 'koneksi.php'; // Pastikan koneksi ke database

if (isset($_GET['id_kota'])) {
    $id_kota = $_GET['id_kota'];

    // Query untuk mendapatkan data kecamatan berdasarkan id_kota
    $query = "SELECT * FROM kecamatan WHERE id_kota = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_kota);
    $stmt->execute();
    $result = $stmt->get_result();

    echo '<option value="">Choose...</option>'; // Tambahkan opsi default
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . $row['id_kecamatan'] . '">' . $row['kecamatan'] . '</option>';
    }

    $stmt->close();
}
?>
