<?php
include '../koneksi.php';

if (isset($_GET['act']) && $_GET['act'] === 'tambah-kelas') {

    $kelas = $_POST['kelas'];
    $kelasinduk = $_POST['kelas_induk'];
    $id_sekolah = $_POST['id_sekolah'];

    $kelas_check_query = "SELECT * FROM kelas WHERE kelas = ?";
    $stmt = $conn->prepare($kelas_check_query);
    $stmt->bind_param("s", $kelas);
    $stmt->execute();
    $kelas_check_result = $stmt->get_result();

    if ($kelas_check_result && $kelas_check_result->num_rows > 0) {
        echo "kelas sudah ada.";
        exit;
    }
    $insert_query = "INSERT INTO kelas (id_sekolah,id_kelasinduk,kelas) VALUES (?, ?,?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("iis", $id_sekolah,$kelasinduk, $kelas);

    if ($stmt->execute()) {
        // Ambil id_sekolah yang baru saja dimasukkan
        $id_sekolah = $conn->insert_id;

        // Redirect ke halaman registrasi admin dengan id_sekolah di URL
        header("Location: ../admin/kelas");
        exit;
    } else {
        echo "Terjadi kesalahan saat registrasi: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();


}

?>