<?php
include '../koneksi.php';

if (isset($_GET['act']) && $_GET['act'] === 'tambah-modul') {

    $id_tp = $_POST['id_tp'];
    $mapel = $_POST['mapel'];
    $kelas_induk = $_POST['kelas_induk'];
    $tanggal = $_POST['tanggal'];
    $tahun = $_POST['tahun'];
    $materi = $_POST['materi'];

    // Cek apakah file ada yang diupload
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $file = $_FILES['file'];
        $file_name = $file['name'];
        $file_tmp = $file['tmp_name'];
        $file_size = $file['size'];
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

        // Ekstensi file yang diperbolehkan
        $allowed_exts = ['pdf', 'doc', 'docx', 'ppt', 'pptx'];

        // Cek ekstensi dan ukuran file
        if (in_array($file_ext, $allowed_exts) && $file_size <= 10000000) { // Max 10MB
            $upload_dir = '../public/modul/';  // Pastikan path relatif benar

            // Buat nama file baru: modul_idtp_nomorunik.ext
            $new_file_name = 'modul_' . $id_tp . '_' . uniqid() . '.' . $file_ext;
            $file_path = $upload_dir . $new_file_name;

            // Pindahkan file ke direktori tujuan
            if (move_uploaded_file($file_tmp, $file_path)) {
                // Insert ke database hanya dengan nama file, bukan path lengkap
                $sql = "INSERT INTO modul (id_tp, id_kelasinduk, tanggal, id_tahunajar, materi, file, id_mapel, status) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $status = 'Pending';  // Atur status default
                $stmt->bind_param('iissssis', $id_tp, $kelas_induk, $tanggal, $tahun, $materi, $new_file_name, $mapel, $status);

                if ($stmt->execute()) {
                    echo "<script>
                            alert('Data berhasil disimpan');
                            window.location.href = '../tenaga-pendidik/modul';
                        </script>";
                } else {
                    echo "<script>
                    alert('Gagal menyimpan data');
                    window.location.href = '../tenaga-pendidik/modul';
                </script>";
                }

                $stmt->close();
            } else {
                echo "<script>
                            alert('Gagal Upload File');
                            window.location.href = '../tenaga-pendidik/modul';
                        </script>";
            }
        } else {
            echo "<script>
            alert('Extensi file salah atau file lebih dari 10MB');
            window.location.href = '../tenaga-pendidik/modul';
        </script>";
        }
    } else {
        echo "<script>
        alert('Gagal Menyimpan Data');
        window.location.href = '../tenaga-pendidik/modul';
    </script>";
    }

    $conn->close();
}
if (isset($_GET['act']) && $_GET['act'] === 'hapus-modul') {

    $id_modul = $_GET['id']; // Ambil ID modul dari parameter URL

    // Ambil nama file dari database berdasarkan ID modul
    $sql = "SELECT file FROM modul WHERE id_modul = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_modul);
    $stmt->execute();
    $stmt->bind_result($file_name);
    $stmt->fetch();
    $stmt->close();

    // Cek apakah file ditemukan
    if ($file_name) {
        $file_path = '../public/modul/' . $file_name;

        // Coba hapus file fisik dari folder
        if (file_exists($file_path)) {
            if (unlink($file_path)) {
                // Jika file berhasil dihapus, hapus data dari database
                $sql = "DELETE FROM modul WHERE id_modul = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('i', $id_modul);

                if ($stmt->execute()) {
                    echo "<script>
                    alert('File Berhasil Dihapus');
                    window.location.href = '../tenaga-pendidik/modul';
                </script>";
                } else {

                    echo "<script>
                            alert('Terjadi kesalahan saat menghapus data');
                            window.location.href = '../tenaga-pendidik/modul';
                        </script>";
                }

                $stmt->close();
            } else {

                echo "<script>
                alert('Gagal menghapus file');
                window.location.href = '../tenaga-pendidik/modul';
            </script>";
            }
        } else {
            echo "<script>
            alert('File Tidak Ditemukan');
            window.location.href = '../tenaga-pendidik/modul';
        </script>";
        }
    } else {
        echo "<script>
        alert('Modul Tidak Ditemukan');
        window.location.href = '../tenaga-pendidik/modul';
    </script>";
    }

    $conn->close();
}
