<?php
include '../koneksi.php';
if (isset($_GET['act']) && $_GET['act'] === 'update-profil') {
    $id_tp = $_POST['id'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $gelar = $_POST['gelar'];
    $telepon = $_POST['telepon'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $no_identitas = $_POST['no_identitas'];
    $agama = $_POST['agama'];
    $tempat_lahir = $_POST['tempat'];
    $alamat = $_POST['alamat'];
    $provinsi = $_POST['provinsi'];
    $kota = $_POST['kota'];
    $kecamatan = $_POST['kecamatan'];

    // Proses upload foto
    if ($_FILES['foto']['name']) {
        $foto = $_FILES['foto']['name'];
        $foto_tmp = $_FILES['foto']['tmp_name'];
        $target_dir = "../public/profil/";

        // Membaca isi file yang diupload
        $foto_content = file_get_contents($foto_tmp);

        // Menggunakan file_put_contents untuk menempatkan file
        file_put_contents($target_dir . $foto, $foto_content);
    } else {
        // Jika tidak ada foto baru, gunakan foto yang lama
        $foto = $row['foto']; // Asumsikan Anda menyimpan foto lama di variabel $row
    }

    // Query untuk update data
    $update_tp = "UPDATE tenaga_pendidik 
    SET nama = ?, foto = ?, email = ?, gelar = ?, telepon = ?, no_identitas = ?, agama = ?, tempat_lahir = ?, tgl_lahir = ?, alamat = ?, provinsi = ?, kota = ?, kecamatan = ? 
    WHERE id_tp = ?";

    $stmt_tp = $conn->prepare($update_tp);
    $stmt_tp->bind_param("sssssssssssssi", $nama, $foto, $email, $gelar, $telepon, $no_identitas, $agama, $tempat_lahir, $tgl_lahir, $alamat, $provinsi, $kota, $kecamatan, $id_tp);

    if ($stmt_tp->execute()) {
        echo "<script>
            alert('Data berhasil diupdate');
            window.location.href = '../tenaga-pendidik/profil';
        </script>";
    } else {
        echo "Error: " . $stmt_tp->error;
    }

    // Menutup koneksi
    $stmt_tp->close();
    $conn->close();
}

if (isset($_GET['act']) && $_GET['act'] === 'update-password') {
    $id_user = $_POST['id'];
    $currentPassword = $_POST['password'];
    $newPassword = $_POST['newpassword'];
    $renewPassword = $_POST['renewpassword'];

    // Cek apakah password baru dan konfirmasi password cocok
    if ($newPassword !== $renewPassword) {
        echo "<script>
            alert('Password baru tidak cocok dengan konfirmasi password!');
            window.history.back();
        </script>";
        exit;
    }

    // Ambil password lama dari database
    $query = "SELECT pass FROM tenaga_pendidik WHERE id_tp = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    $stmt->bind_result($hashedPassword);
    $stmt->fetch();
    $stmt->close();

    // Verifikasi password lama (hash currentPassword dan bandingkan dengan hash di database)
    if (md5($currentPassword) !== $hashedPassword) {
        echo "<script>
            alert('Password lama salah!');
            window.history.back();
        </script>";
        exit;
    }

    // Hash password baru
    $newHashedPassword = md5($newPassword);

    // Update password di database
    $updateQuery = "UPDATE tenaga_pendidik SET pass = ? WHERE id_tp = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("si", $newHashedPassword, $id_user);

    if ($updateStmt->execute()) {
        echo "<script>
            alert('Password berhasil diupdate!');
            window.location.href = '../tenaga-pendidik/profil'; // Redirect ke halaman profil
        </script>";
    } else {
        echo "<script>
            alert('Gagal mengupdate password!');
        </script>";
    }

    $updateStmt->close();
    $conn->close();
}
