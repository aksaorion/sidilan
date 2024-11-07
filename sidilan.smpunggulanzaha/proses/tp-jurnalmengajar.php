<?php
// Menghubungkan ke database
include '../koneksi.php'; 

// Aktifkan tampilan kesalahan
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Periksa variabel POST
if (!isset($_POST['id_tp'], $_POST['id_kelas'], $_POST['id_jadwal'], $_POST['id_mapel'], $_POST['tgl'], $_POST['id_hari'], $_POST['id_jammulai'], $_POST['id_jamselesai'])) {
    die("Data tidak lengkap");
}

// Mengambil data dari POST
$id_tp = $_POST['id_tp'];
$id_kelas = $_POST['id_kelas'];
$id_jadwal = $_POST['id_jadwal'];
$id_mapel = $_POST['id_mapel'];
$tanggal = $_POST['tgl'];
$judul = $_POST['judul'];
$id_hari = $_POST['id_hari'];
$id_jammulai = $_POST['id_jammulai'];
$id_jamselesai = $_POST['id_jamselesai'];

// Definisikan array untuk nama hari
$nama_hari = [
    1 => 'Senin',
    2 => 'Selasa',
    3 => 'Rabu',
    4 => 'Kamis',
    5 => 'Jumat',
    6 => 'Sabtu',
    7 => 'Minggu'
];

// Konversi tanggal input menjadi hari dalam bentuk angka (1-7)
$hariInput = date('N', strtotime($tanggal)); // 1 = Senin, 2 = Selasa, ..., 7 = Minggu

// Cek apakah hari yang diinputkan oleh user sesuai dengan hari pada tanggal yang dipilih
if ($id_hari != $hariInput) {
    echo "<script>
            alert('Data hanya bisa diinputkan untuk hari " . $nama_hari[$id_hari] . " sesuai tanggal yang dipilih.');
            window.location.href = '../tenaga-pendidik/jadwal-mengajar';
          </script>";
    exit; 
}


// Periksa apakah data dengan tanggal, id_jadwal, dan id_jammulai sudah ada
$checkQuery = "SELECT * FROM jurnal_mengajar WHERE tanggal = ? AND id_jammulai = ? AND id_jadwal = ?";
$stmt = $conn->prepare($checkQuery);
if (!$stmt) {
    die("Prepare statement failed: " . $conn->error);
}

$stmt->bind_param("sii", $tanggal, $id_jammulai, $id_jadwal);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Data sudah ada, lakukan update
    $updateQuery = "UPDATE jurnal_mengajar SET id_tp = ?, id_kelas = ?, id_mapel = ?, id_hari = ?, id_jamselesai = ?, judul_materi = ?, foto = NULL WHERE tanggal = ? AND id_jammulai = ? AND id_jadwal = ?";
    $updateStmt = $conn->prepare($updateQuery);
    
    if (!$updateStmt) {
        die("Prepare statement update failed: " . $conn->error);
    }

    // Bind parameter
    $updateStmt->bind_param("iiiiissii", $id_tp, $id_kelas, $id_mapel, $id_hari, $id_jamselesai, $judul, $tanggal, $id_jammulai, $id_jadwal);

    if ($updateStmt->execute()) {
        echo "<script>
                alert('Data berhasil diupdate');
                window.location.href = '../tenaga-pendidik/jadwal-mengajar'; 
              </script>";
    } else {
        echo "<script>
                alert('Gagal mengupdate data');
                window.location.href = '../tenaga-pendidik/jadwal-mengajar'; 
              </script>";
    }

    $updateStmt->close();

} else {
    // Data belum ada, lakukan insert
    $insertQuery = "INSERT INTO jurnal_mengajar (id_tp, id_jadwal, id_kelas, id_mapel, id_hari, id_jammulai, id_jamselesai, judul_materi, foto, tanggal, jam_masuk) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NULL, ?, CURRENT_TIME)";
    $insertStmt = $conn->prepare($insertQuery);
    
    if (!$insertStmt) {
        die("Prepare statement insert failed: " . $conn->error);
    }

    // Bind parameter
    $insertStmt->bind_param("iiiiiiiss", $id_tp, $id_jadwal, $id_kelas, $id_mapel, $id_hari, $id_jammulai, $id_jamselesai, $judul, $tanggal);

    if ($insertStmt->execute()) {
        echo "<script>
                alert('Data berhasil disimpan');
                window.location.href = '../tenaga-pendidik/jadwal-mengajar'; 
              </script>";
    } else {
        echo "<script>
                alert('Gagal menyimpan data');
                window.location.href = '../tenaga-pendidik/jadwal-mengajar'; 
              </script>";
    }

    $insertStmt->close();
}

$stmt->close();
$conn->close();
?>
