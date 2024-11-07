<?php
include '../koneksi.php';

if (isset($_GET['act']) && $_GET['act'] === 'absen-masuk') {
    $id_tp = $_POST['id_tp'];

    $geolocation = $_POST['geolocation'];
    $foto = $_POST['foto'];
    $jam = date('H:i:s');
    $tanggal = date('Y-m-d');

    // Decode Base64 foto
    $foto = str_replace('data:image/png;base64,', '', $foto);
    $foto = str_replace(' ', '+', $foto);
    $data = base64_decode($foto);

    // Tentukan nama file foto
    $nama_file = 'foto_' . time() . '.png';

    // Simpan file foto di subdomain yang berbeda
    $file_path = '/public/' . $nama_file; // Gantilah dengan path absolut yang sesuai pada server Anda
    file_put_contents($file_path, $data);

    // Query untuk menyimpan data ke database
    $query = "INSERT INTO presensi (id_tp, tipe_presensi, geolocation, foto, jam, tanggal)
              VALUES ('$id_tp', 'Masuk', '$geolocation', '$nama_file', '$jam', '$tanggal')";

    if (mysqli_query($conn, $query)) {
         echo "<script>
            alert('Data berhasil disimpan');
            window.location.href = '../tenaga-pendidik/absen';
        </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
if (isset($_GET['act']) && $_GET['act'] === 'absen-pulang') {
    $id_tp = $_POST['id_tp'];

    $geolocation = $_POST['geolocation'];
    $foto = $_POST['foto'];
    $jam = date('H:i:s');
    $tanggal = date('Y-m-d');

    // Decode Base64 foto
    $foto = str_replace('data:image/png;base64,', '', $foto);
    $foto = str_replace(' ', '+', $foto);
    $data = base64_decode($foto);

    // Tentukan nama file foto
    $nama_file = 'foto_' . time() . '.png';

    // Simpan file foto di subdomain yang berbeda
    $file_path = '/public/' . $nama_file; // Gantilah dengan path absolut yang sesuai pada server Anda
    file_put_contents($file_path, $data);

    // Query untuk menyimpan data ke database
    $query = "INSERT INTO presensi (id_tp, tipe_presensi, geolocation, foto, jam, tanggal)
              VALUES ('$id_tp', 'Pulang', '$geolocation', '$nama_file', '$jam', '$tanggal')";

    if (mysqli_query($conn, $query)) {
         echo "<script>
            alert('Data berhasil disimpan');
            window.location.href = '../tenaga-pendidik/absen';
        </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
