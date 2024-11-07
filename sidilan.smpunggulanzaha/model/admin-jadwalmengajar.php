<?php
$id_sekolah = $_SESSION['sekolah'];
$query_guru = "SELECT * FROM tenaga_pendidik";
$result_guru = $conn->query($query_guru);

$query_mapel = "SELECT * FROM mapel WHERE id_sekolah = $id_sekolah";
$result_mapel = $conn->query($query_mapel);

$query_kelas = "SELECT * FROM kelas WHERE id_sekolah = $id_sekolah";
$result_kelas = $conn->query($query_kelas);

$query_hari = "SELECT * FROM hari";
$result_hari = $conn->query($query_hari);

$query_mulai = "SELECT * FROM jam_mulai";
$result_mulai = $conn->query($query_mulai);


$query_selesai = "SELECT * FROM jam_selesai";
$result_selesai = $conn->query($query_selesai);
