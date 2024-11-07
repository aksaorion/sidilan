<?php
include '../koneksi.php';

if (isset($_GET['act']) && $_GET['act'] === 'tambah-divisi') {
    $divisi = $_POST['divisi'];
    $sekolah = $_POST['id_sekolah'];

    $divisi_check_query = "SELECT * FROM divisi WHERE divisi = ?";
    $stmt = $conn->prepare($divisi_check_query);
    $stmt->bind_param("s", $divisi);
    $stmt->execute();
    $divisi_check_result = $stmt->get_result();

    if ($divisi_check_result && $divisi_check_result->num_rows > 0) {
        echo "Divisi sudah ada.";
        exit;
    }
    $insert_query = "INSERT INTO divisi (id_sekolah,divisi) VALUES (?, ?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("ss", $sekolah, $divisi);

    if ($stmt->execute()) {
        // Ambil id_sekolah yang baru saja dimasukkan
        $id_sekolah = $conn->insert_id;

        // Redirect ke halaman registrasi admin dengan id_sekolah di URL
        header("Location: ../admin/divisi");
        exit;
    } else {
        echo "Terjadi kesalahan saat registrasi: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
if (isset($_GET['act']) && $_GET['act'] === 'update-divisi') {
    $id_divisi = $_POST['id_divisi']; // ID dari mata pelajaran yang akan di-update
    $divisi = $_POST['divisi'];



    // Query untuk update data
    $sql = "UPDATE divisi SET divisi = ? WHERE id_divisi = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $divisi, $id_divisi);

    if ($stmt->execute()) {
        echo "<script>
            alert('Data berhasil diupdate');
            window.location.href = '../admin/divisi';
        </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Menutup koneksi
    $conn->close();
}
if (isset($_GET['act']) && $_GET['act'] === 'delete-divisi') {
    $id_divisi = $_POST['id_divisi']; // Misalnya, diambil dari URL dengan metode GET

    // Query untuk menghapus data
    $sql = "DELETE FROM divisi WHERE id_divisi = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_divisi);

    if ($stmt->execute()) {
        echo "<script>
            alert('Data berhasil dihapus');
            window.location.href = '../admin/divisi';
        </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Menutup koneksi
    $conn->close();
}
