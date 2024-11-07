<?php
include 'conn.php';
$id_tp = $_SESSION['id_tp'];
// Query untuk mendapatkan jam presensi tipe 'Pulang' pada tanggal saat ini
$query_masuk = "SELECT jam FROM presensi WHERE tipe_presensi = 'Masuk' AND tanggal = CURRENT_DATE AND id_tp = $id_tp";
$result_masuk = $conn->query($query_masuk);
$jam_presensi = '';

if ($result_masuk && $result_masuk->num_rows > 0) {
    $row = $result_masuk->fetch_assoc();
    $jam_presensi = $row['jam'];
} else {
    $jam_presensi = 'Belum ada presensi';
}

// Menentukan apakah tepat waktu atau telat
$status = '';
$status_class = '';
if ($jam_presensi !== 'Belum ada presensi') {
    // Konversi waktu ke detik untuk perbandingan
    $waktu_batas = strtotime('07:11:00');
    $waktu_presensi = strtotime($jam_presensi);

    if ($waktu_presensi <= $waktu_batas) {
        $status = 'Tepat waktu';
        $status_class = 'text-success'; // Hijau jika tepat waktu
    } else {
        $status = 'Telat';
        $status_class = 'text-danger'; // Merah jika telat
    }
}
$query_absensi = "SELECT tipe_presensi, jam, tanggal FROM presensi WHERE id_tp = $id_tp AND tanggal >= CURDATE() - INTERVAL 30 DAY ORDER BY tanggal, jam ASC";
$result = $conn->query($query_absensi);

$masuk_data = [];
$pulang_data = [];
$categories = [];

while ($row = $result->fetch_assoc()) {
    // Konversi ke jam saja, format 'H:i' (jam:menit)
    $time = date('H:i', strtotime($row['jam']));

    if ($row['tipe_presensi'] == 'Masuk') {
        $masuk_data[] = $time;
    } elseif ($row['tipe_presensi'] == 'Pulang') {
        $pulang_data[] = $time;
    }

    // Simpan waktu sebagai kategori (hanya jam)
    if (!in_array($time, $categories)) {
        $categories[] = $time;
    }
}

$query_kerja = "SELECT tipe_presensi, jam FROM presensi WHERE id_tp = $id_tp AND tanggal >= CURDATE() - INTERVAL 30 DAY ORDER BY tanggal ASC";
$result_kerja = $conn->query($query_kerja);

$total_jam_kerja = 0;
$total_hari = 0;

while ($row_kerja = $result_kerja->fetch_assoc()) {
    // Default waktu masuk dan pulang
    $jam_masuk = '07:30';
    $jam_pulang = '14:00';

    if ($row_kerja['tipe_presensi'] == 'Masuk') {
        $jam_masuk = date('H:i', strtotime($row_kerja['jam']));
    } elseif ($row_kerja['tipe_presensi'] == 'Pulang') {
        $jam_pulang = date('H:i', strtotime($row_kerja['jam']));
    }

    // Hitung selisih jam antara masuk dan pulang
    $start_time = new DateTime($jam_masuk);
    $end_time = new DateTime($jam_pulang);
    $interval = $start_time->diff($end_time);
    $jam_kerja = $interval->h + ($interval->i / 60); // Total jam kerja

    $total_jam_kerja += $jam_kerja;
    $total_hari++;
}

// Hitung rata-rata jam kerja per hari
$rata_jam_kerja = $total_jam_kerja / $total_hari;

// Tentukan pesan berdasarkan rata-rata jam kerja
if ($rata_jam_kerja > 8) {
    $pesan = "Terimakasih, kamu telah bekerja keras!";
    $pesan_warna = "text-success"; // Warna hijau
} else {
    $pesan = "Ayo lebih semangat lagi kerjanya!";
    $pesan_warna = "text-danger"; // Warna merah
}

$query_news = "SELECT title, content, foto FROM news ORDER BY created_at DESC LIMIT 5";
$result_news = $conn->query($query_news);
