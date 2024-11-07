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
if (isset($_GET['act']) && $_GET['act'] === 'update-kepegawaian-divisi') {
    $id_kepegawaian = $_POST['id_kepegawaian']; // ID dari mata pelajaran yang akan di-update
    $guru = $_POST['guru'];
    $divisi = $_POST['divisi'];
    $roledivisi = $_POST['roledivisi'];
   

    // Query untuk update data
    $sql = "UPDATE kepegawaian SET id_tp = ?,id_mapel = ?,id_kelas = ?,id_hari = ?,jam_mulai = ?,jam_selesai = ? WHERE id_kepegawaian = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiiissi",$guru, $mapel,$kelas,$hari, $mulai,$selesai,$id_kepegawaian);

    if ($stmt->execute()) {
        echo "<script>
            alert('Data berhasil diupdate');
            window.location.href = '../admin/jadwal-mengajar';
        </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Menutup koneksi
    $conn->close();
}
if (isset($_GET['act']) && $_GET['act'] === 'delete-jadwal') {
    $id_kepegawaian = $_POST['id_kepegawaian']; // Misalnya, diambil dari URL dengan metode GET

    // Query untuk menghapus data
    $sql = "DELETE FROM jadwal_mengajar WHERE id_kepegawaian = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_kepegawaian);

    if ($stmt->execute()) {
        echo "<script>
            alert('Data berhasil dihapus');
            window.location.href = '../admin/jadwal-mengajar';
        </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Menutup koneksi
    $conn->close();

}
?>