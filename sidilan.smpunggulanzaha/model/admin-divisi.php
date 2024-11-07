<?php

$query_divisi = "SELECT * FROM divisi";
$result_divisi = $conn->query($query_divisi);

$query_jabatan = "SELECT * FROM jabatan";
$result_jabatan = $conn->query($query_jabatan);

$query_roledivisi = "SELECT * FROM role_divisi";
$result_roledivisi = $conn->query($query_roledivisi);
