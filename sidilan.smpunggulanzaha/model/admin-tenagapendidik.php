<?php

// Query untuk mengambil data tenaga pendidik berdasarkan id_tp
$query_tp = "SELECT * FROM tenaga_pendidik
JOIN riwayat_pendidikan ON tenaga_pendidik.id_tp = riwayat_pendidikan.id_tp
JOIN kepegawaian ON tenaga_pendidik.id_tp = kepegawaian.id_tp
WHERE tenaga_pendidik.id_tp = ?";
$stmt_tp = $conn->prepare($query_tp);
$stmt_tp->bind_param('i', $id_tp); // Pastikan $id_tp adalah integer
$stmt_tp->execute();
$result_tp = $stmt_tp->get_result();
$data_tp = $result_tp->fetch_assoc(); // Ambil data sebagai array asosiatif

// Query untuk mengambil data provinsi
$query_provinsi = "SELECT id_provinsi, provinsi FROM provinsi";
$result_provinsi = $conn->query($query_provinsi);

// Query untuk mengambil data riwayat pendidikan
$query_riwayat = "SELECT * FROM riwayat_pendidikan WHERE id_tp = ?";
$stmt_riwayat = $conn->prepare($query_riwayat);
$stmt_riwayat->bind_param('i', $id_tp); // Pastikan $id_tp adalah integer
$stmt_riwayat->execute();
$result_riwayat = $stmt_riwayat->get_result();
$data_riwayat = $result_riwayat->fetch_assoc();

// Query untuk mengambil data kepegawaian
$query_kepegawaian = "SELECT kepegawaian.*, divisi.divisi, role_divisi.role_divisi, tenaga_pendidik.nama
FROM kepegawaian
JOIN divisi ON kepegawaian.id_divisi = divisi.id_divisi
JOIN role_divisi ON kepegawaian.id_roledivisi = role_divisi.id_roledivisi
JOIN tenaga_pendidik ON kepegawaian.id_tp = tenaga_pendidik.id_tp
WHERE kepegawaian.id_tp = ?";
$stmt_kepegawaian = $conn->prepare($query_kepegawaian);
$stmt_kepegawaian->bind_param('i', $id_tp); // Pastikan $id_tp adalah integer
$stmt_kepegawaian->execute();
$result_kepegawaian = $stmt_kepegawaian->get_result();
$data_kepegawaian = $result_kepegawaian->fetch_assoc();

// Query untuk mengambil data jenjang
$q_jenjang = "SELECT DISTINCT jenjang_sekolah FROM jenjang_sekolah";
$result_jenjang = $conn->query($q_jenjang);

// Query untuk mengambil data divisi
$query_divisi = "SELECT * FROM divisi";
$result_divisi = $conn->query($query_divisi);

// Query untuk mengambil data jabatan
$query_jabatan = "SELECT * FROM jabatan";
$result_jabatan = $conn->query($query_jabatan);

// Query untuk mengambil data role_divisi
$query_roledivisi = "SELECT * FROM role_divisi";
$result_roledivisi = $conn->query($query_roledivisi);

// Query untuk mengambil data agama
$query_agama = "SELECT * FROM agama";
$result_agama = $conn->query($query_agama);

// Pastikan untuk memeriksa hasil query dan menangani kemungkinan kesalahan
if ($conn->error) {
    echo "Error: " . $conn->error;
}
