<?php
include 'conn.php';

if (isset($_GET['act']) && $_GET['act'] === 'tambah-tenagapendidik') {
    $conn->begin_transaction();

    try {
        // Ambil data dari form
        $id_sekolah = $_POST['id_sekolah'];
        $nama = $_POST['nama'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $gelar = $_POST['gelar'];
        $telepon = $_POST['telepon'];
        $j_identitas = $_POST['jenis_identitas'];
        $tgl_lahir = $_POST['tgl_lahir'];
        $no_identitas = $_POST['no_identitas'];
        $jk = $_POST['jk'];
        $agama = $_POST['agama'];
        $tempat_lahir = $_POST['tempat_lahir'];
        $alamat = $_POST['alamat'];
        $provinsi = $_POST['provinsi'];
        $kota = $_POST['kota'];
        $kecamatan = $_POST['kecamatan'];
        $password = md5($_POST['password']); // Hash password

        // Cek apakah email atau no_identitas sudah terdaftar
        $cek_query = "SELECT id_tp FROM tenaga_pendidik WHERE email = ? OR no_identitas = ?";
        $stmt_cek = $conn->prepare($cek_query);
        $stmt_cek->bind_param("ss", $email, $no_identitas);
        $stmt_cek->execute();
        $stmt_cek->store_result();

        if ($stmt_cek->num_rows > 0) {
            // Jika sudah terdaftar, lakukan update
            $stmt_cek->bind_result($id_tp);
            $stmt_cek->fetch();

            $update_tp = "UPDATE tenaga_pendidik 
                          SET id_sekolah = ?, nama = ?, email = ?, role = ?, gelar = ?, telepon = ?, jenis_identitas = ?, no_identitas = ?, jk = ?, agama = ?, tempat_lahir = ?, tgl_lahir = ?, alamat = ?, pass = ?, provinsi = ?, kota = ?, kecamatan = ?
                          WHERE id_tp = ?";
            $stmt_update = $conn->prepare($update_tp);
            $stmt_update->bind_param("issssssssssssssssi", $id_sekolah, $nama, $email, $role, $gelar, $telepon, $j_identitas, $no_identitas, $jk, $agama, $tempat_lahir, $tgl_lahir, $alamat, $password, $provinsi, $kota, $kecamatan, $id_tp);

            if (!$stmt_update->execute()) {
                throw new Exception("Error executing tenaga_pendidik update: " . $stmt_update->error);
            }
        } else {
            // Jika belum terdaftar, lakukan insert
            $insert_tp = "INSERT INTO tenaga_pendidik (id_sekolah, nama, email, role, gelar, telepon, jenis_identitas, no_identitas, jk, agama, tempat_lahir, tgl_lahir, alamat, pass, provinsi, kota, kecamatan) 
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt_tp = $conn->prepare($insert_tp);
            $stmt_tp->bind_param("issssssssssssssss", $id_sekolah, $nama, $email, $role, $gelar, $telepon, $j_identitas, $no_identitas, $jk, $agama, $tempat_lahir, $tgl_lahir, $alamat, $password, $provinsi, $kota, $kecamatan);

            if (!$stmt_tp->execute()) {
                throw new Exception("Error executing tenaga_pendidik insert: " . $stmt_tp->error);
            }

            // Dapatkan id dari tenaga_pendidik yang baru dimasukkan
            $id_tp = $conn->insert_id;
        }

        // Insert ke tabel riwayat_pendidikan
        $jenjang = $_POST['jenjang'];
        $tahun = $_POST['tahun'];
        $institusi = $_POST['institusi'];
        $jurusan = $_POST['jurusan'];

        $insert_riwayat = "INSERT INTO riwayat_pendidikan (id_tp, jenjang, tahun, institusi, jurusan) VALUES (?, ?, ?, ?, ?)";
        $stmt_riwayat = $conn->prepare($insert_riwayat);
        $stmt_riwayat->bind_param("issss", $id_tp, $jenjang, $tahun, $institusi, $jurusan);

        if (!$stmt_riwayat->execute()) {
            throw new Exception("Error executing riwayat_pendidikan insert: " . $stmt_riwayat->error);
        }

        // Commit transaksi jika semua berhasil
        $conn->commit();

        echo "TERIMAKASIH SUDAH MENGISI! ANDA BISA MENINGGALKAN HALAMAN INI.";
    } catch (Exception $e) {
        // Rollback transaksi jika ada kesalahan
        $conn->rollback();

        echo "Terjadi kesalahan: " . $e->getMessage();
    }

    // Tutup statement dan koneksi
    $stmt_cek->close();
    if (isset($stmt_tp)) $stmt_tp->close();
    if (isset($stmt_update)) $stmt_update->close();
    $stmt_riwayat->close();

    $conn->close();
}

if (isset($_GET['act']) && $_GET['act'] === 'update-tenagapendidik') {
    $conn->begin_transaction();

    try {
        // Ambil data dari form
        $id_tp = $_POST['id_tp'];

        $nama = $_POST['nama'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $gelar = $_POST['gelar'];
        $telepon = $_POST['telepon'];
        $j_identitas = $_POST['jenis_identitas'];
        $tgl_lahir = $_POST['tgl_lahir'];
        $no_identitas = $_POST['no_identitas'];
        $jk = $_POST['jk'];
        $agama = $_POST['agama'];
        $tempat_lahir = $_POST['tempat_lahir'];
        $alamat = $_POST['alamat'];
        $provinsi = $_POST['provinsi'];
        $kota = $_POST['kota'];
        $kecamatan = $_POST['kecamatan'];

        // Update tabel tenaga_pendidik
        $update_tp = "UPDATE tenaga_pendidik 
                      SET nama = ?, email = ?, role = ?, gelar = ?, telepon = ?, jenis_identitas = ?, no_identitas = ?, jk = ?, agama = ?, tempat_lahir = ?, tgl_lahir = ?, alamat = ?, provinsi = ?, kota = ?, kecamatan = ? 
                      WHERE id_tp = ?";
        $stmt_tp = $conn->prepare($update_tp);
        $stmt_tp->bind_param("sssssssssssssssi", $nama, $email, $role, $gelar, $telepon, $j_identitas, $no_identitas, $jk, $agama, $tempat_lahir, $tgl_lahir, $alamat, $provinsi, $kota, $kecamatan, $id_tp);

        if (!$stmt_tp->execute()) {
            throw new Exception("Error executing tenaga_pendidik update: " . $stmt_tp->error);
        }

        // Update tabel riwayat_pendidikan
        $jenjang = $_POST['jenjang'];
        $tahun = $_POST['tahun'];
        $institusi = $_POST['institusi'];
        $jurusan = $_POST['jurusan'];

        $update_riwayat = "UPDATE riwayat_pendidikan 
                           SET jenjang = ?, tahun = ?, institusi = ?, jurusan = ? 
                           WHERE id_tp = ?";
        $stmt_riwayat = $conn->prepare($update_riwayat);
        $stmt_riwayat->bind_param("ssssi", $jenjang, $tahun, $institusi, $jurusan, $id_tp);

        if (!$stmt_riwayat->execute()) {
            throw new Exception("Error executing riwayat_pendidikan update: " . $stmt_riwayat->error);
        }

        // Update tabel kepegawaian
        $id_jabatan = $_POST['jabatan'];
        $id_divisi = $_POST['divisi'];
        $id_roledivisi = $_POST['role_divisi'];
        $status = $_POST['status'];
        $tgl_mulai = $_POST['tgl_mulai'];
        $nip = $_POST['nip'];

        $update_kepegawaian = "UPDATE kepegawaian 
                               SET id_jabatan = ?, id_divisi = ?, id_roledivisi = ?, nip = ?, status = ?, tgl_mulai = ? 
                               WHERE id_tp = ?";
        $stmt_kepegawaian = $conn->prepare($update_kepegawaian);
        $stmt_kepegawaian->bind_param("iiiissi", $id_jabatan, $id_divisi, $id_roledivisi, $nip, $status, $tgl_mulai, $id_tp);

        if (!$stmt_kepegawaian->execute()) {
            throw new Exception("Error executing kepegawaian update: " . $stmt_kepegawaian->error);
        }

        // Commit transaksi jika semua berhasil
        $conn->commit();

        echo "<script>
        alert('Data berhasil diupdate');
        window.location.href = '../admin/tenaga-pendidik';
    </script>";
    } catch (Exception $e) {
        // Rollback transaksi jika ada kesalahan
        $conn->rollback();

        echo "Terjadi kesalahan: " . $e->getMessage();
    }

    // Tutup statement dan koneksi
    $stmt_tp->close();
    $stmt_riwayat->close();
    $stmt_kepegawaian->close();
    $conn->close();
}
if (isset($_GET['act']) && $_GET['act'] === 'delete-tenagapendidik') {
    $conn->begin_transaction();

    try {
        // Ambil id tenaga pendidik yang akan dihapus
        $id_tp = $_POST['id_tp'];

        // Hapus dari tabel kepegawaian
        $delete_kepegawaian = "DELETE FROM kepegawaian WHERE id_tp = ?";
        $stmt_kepegawaian = $conn->prepare($delete_kepegawaian);
        $stmt_kepegawaian->bind_param("i", $id_tp);

        if (!$stmt_kepegawaian->execute()) {
            throw new Exception("Error executing kepegawaian delete: " . $stmt_kepegawaian->error);
        }

        // Hapus dari tabel riwayat_pendidikan
        $delete_riwayat = "DELETE FROM riwayat_pendidikan WHERE id_tp = ?";
        $stmt_riwayat = $conn->prepare($delete_riwayat);
        $stmt_riwayat->bind_param("i", $id_tp);

        if (!$stmt_riwayat->execute()) {
            throw new Exception("Error executing riwayat_pendidikan delete: " . $stmt_riwayat->error);
        }

        // Hapus dari tabel tenaga_pendidik
        $delete_tp = "DELETE FROM tenaga_pendidik WHERE id_tp = ?";
        $stmt_tp = $conn->prepare($delete_tp);
        $stmt_tp->bind_param("i", $id_tp);

        if (!$stmt_tp->execute()) {
            throw new Exception("Error executing tenaga_pendidik delete: " . $stmt_tp->error);
        }

        // Commit transaksi jika semua berhasil
        $conn->commit();

        echo "<script>
        alert('Data berhasil diupdate');
        window.location.href = '../admin/tenaga-pendidik';
        </script>";
    } catch (Exception $e) {
        // Rollback transaksi jika ada kesalahan
        $conn->rollback();

        echo "Terjadi kesalahan: " . $e->getMessage();
    }

    // Tutup statement dan koneksi
    $stmt_tp->close();
    $stmt_riwayat->close();
    $stmt_kepegawaian->close();
    $conn->close();
}
