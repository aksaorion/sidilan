<?php
include 'koneksi.php';

if (isset($_GET['act']) && $_GET['act'] === 'tambah-jadwal') {

    $guru = $_POST['guru'];
    $mapel = $_POST['mapel'];
    $kelas = $_POST['kelas'];
    $hari = $_POST['hari'];
    $mulai = $_POST['mulai'];
    $selesai = $_POST['selesai'];

    

    // Insert data ke dalam tabel jadwal_mengajar
    $insert_query = "INSERT INTO jadwal_mengajar (id_tp, id_mapel, id_kelas, id_hari, id_jammulai, id_jamselesai) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("iiiiii", $guru, $mapel, $kelas, $hari, $mulai, $selesai);

    if ($stmt->execute()) {
        echo "<script>
        alert('Data berhasil disimpan');
        window.location.href = 'https://sidilan.smpunggulanzaha.sch.id/admin/jadwal-mengajar';
        </script>";
        exit;
    } else {
        echo "Terjadi kesalahan saat registrasi: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

if (isset($_GET['act']) && $_GET['act'] === 'update-jadwal') {
    $id_jadwal = $_POST['id_jadwal']; // ID dari mata pelajaran yang akan di-update
    $guru = $_POST['guru'];
    $mapel = $_POST['mapel'];
    $kelas = $_POST['kelas'];
    $hari = $_POST['hari'];
    $mulai = $_POST['mulai'];
    $selesai = $_POST['selesai'];
    

    // Query untuk update data
    $sql = "UPDATE jadwal_mengajar SET id_tp = ?,id_mapel = ?,id_kelas = ?,id_hari = ?,id_jammulai = ?,id_jamselesai = ? WHERE id_jadwal = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiiissi",$guru, $mapel,$kelas,$hari, $mulai,$selesai,$id_jadwal);

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
    $id_jadwal = $_POST['id_jadwal']; // Misalnya, diambil dari URL dengan metode GET

    // Query untuk menghapus data
    $sql = "DELETE FROM jadwal_mengajar WHERE id_jadwal = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_jadwal);

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