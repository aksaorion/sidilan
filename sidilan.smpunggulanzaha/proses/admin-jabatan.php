<?php
include '../koneksi.php';

if (isset($_GET['act']) && $_GET['act'] === 'tambah-jabatan') {
    $jabatan = $_POST['jabatan'];
    $sekolah = $_POST['id_sekolah'];

    $jabatan_check_query = "SELECT * FROM jabatan WHERE jabatan = ?";
    $stmt = $conn->prepare($jabatan_check_query);
    $stmt->bind_param("s", $jabatan);
    $stmt->execute();
    $jabatan_check_result = $stmt->get_result();

    if ($jabatan_check_result && $jabatan_check_result->num_rows > 0) {
        echo "jabatan sudah ada.";
        exit;
    }
    $insert_query = "INSERT INTO jabatan (id_sekolah,jabatan) VALUES (?, ?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("ss", $sekolah, $jabatan);

    if ($stmt->execute()) {
        // Ambil id_sekolah yang baru saja dimasukkan
        $id_sekolah = $conn->insert_id;

        // Redirect ke halaman registrasi admin dengan id_sekolah di URL
        echo "<script>
            alert('Data berhasil disimpan');
            window.location.href = '../admin/jabatan';
        </script>";
    } else {
        echo "Terjadi kesalahan saat registrasi: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
if (isset($_GET['act']) && $_GET['act'] === 'update-jabatan') {
    $id_jabatan = $_POST['id_jabatan']; // ID dari mata pelajaran yang akan di-update
    $jabatan = $_POST['jabatan'];



    // Query untuk update data
    $sql = "UPDATE jabatan SET jabatan = ? WHERE id_jabatan = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $jabatan, $id_jabatan);

    if ($stmt->execute()) {
        echo "<script>
            alert('Data berhasil diupdate');
            window.location.href = '../admin/jabatan';
        </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Menutup koneksi
    $conn->close();
}
if (isset($_GET['act']) && $_GET['act'] === 'delete-jabatan') {
    $id_jabatan = $_POST['id_jabatan']; // Misalnya, diambil dari URL dengan metode GET

    // Query untuk menghapus data
    $sql = "DELETE FROM jabatan WHERE id_jabatan = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_jabatan);

    if ($stmt->execute()) {
        echo "<script>
            alert('Data berhasil dihapus');
            window.location.href = '../admin/jabatan';
        </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Menutup koneksi
    $conn->close();
}
