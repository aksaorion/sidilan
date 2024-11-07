<?php


// Query untuk mengambil data dari tabel jabatan
$query = "SELECT * FROM jabatan ";
$result = $conn->query($query);

if (!$result) {
    die("Query Error: " . $conn->error);
}


// Query untuk mengambil data dari tabel jabatan
$query_kepegawaian = "SELECT  *
                                          FROM 
                                              kepegawaian
                                          JOIN 
                                              jabatan ON kepegawaian.id_jabatan = jabatan.id_jabatan
                                          JOIN 
                                              tenaga_pendidik ON kepegawaian.id_tp = tenaga_pendidik.id_tp
                                         
                                          
                                              
                                          ";

$result_kepegawaian = $conn->query($query_kepegawaian);

if (!$result_kepegawaian) {
    die("Query Error: " . $conn->error);
}
