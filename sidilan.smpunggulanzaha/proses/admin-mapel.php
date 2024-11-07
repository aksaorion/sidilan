<?php
include '../koneksi.php';

if (isset($_GET['act']) && $_GET['act'] === 'tambah-mapel') {

    $mapel = $_POST['mapel'];
    $id_sekolah = $_POST['id_sekolah'];

    $mapel_check_query = "SELECT * FROM mapel WHERE mapel = ?";
    $stmt = $conn->prepare($mapel_check_query);
    $stmt->bind_param("s", $mapel);
    $stmt->execute();
    $mapel_check_result = $stmt->get_result();

    if ($mapel_check_result && $mapel_check_result->num_rows > 0) {
        echo "Mata pelajaran sudah ada.";
        exit;
    }
    $insert_query = "INSERT INTO mapel (id_sekolah,mapel) VALUES (?,?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("is", $id_sekolah, $mapel);

    if ($stmt->execute()) {
        // Ambil id_sekolah yang baru saja dimasukkan
        $id_sekolah = $conn->insert_id;

        // Redirect ke halaman registrasi admin dengan id_sekolah di URL
        echo "<script>
        alert('Data berhasil disimpan');
        window.location.href = '../admin/mata-pelajaran';
        </script>";
        exit;
    } else {
        echo "Terjadi kesalahan saat registrasi: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();


}
if (isset($_GET['act']) && $_GET['act'] === 'update-mapel') {
    $id_mapel = $_POST['id_mapel']; // ID dari mata pelajaran yang akan di-update
    $mapel = $_POST['mapel'];
    

    // Query untuk update data
    $sql = "UPDATE mapel SET mapel = ? WHERE id_mapel = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $mapel, $id_mapel);

    if ($stmt->execute()) {
        echo "<script>
            alert('Data berhasil diupdate');
            window.location.href = '../admin/mata-pelajaran';
        </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Menutup koneksi
    $conn->close();
}
if (isset($_GET['act']) && $_GET['act'] === 'delete-mapel') {
    $id_mapel = $_POST['id_mapel']; // Misalnya, diambil dari URL dengan metode GET

    // Query untuk menghapus data
    $sql = "DELETE FROM mapel WHERE id_mapel = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_mapel);

    if ($stmt->execute()) {
        echo "<script>
            alert('Data berhasil dihapus');
            window.location.href = '../admin/mata-pelajaran';
        </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Menutup koneksi
    $conn->close();

}

?>