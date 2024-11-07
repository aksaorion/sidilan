<?php
require('../library/fpdf.php');
require_once('../koneksi.php'); // Koneksi database

if (isset($_POST['pendidik'], $_POST['start_date'], $_POST['end_date'])) {
    $pendidik = $_POST['pendidik'];
    $nama_pendidik = isset($_POST['nama_pendidik']) ? $_POST['nama_pendidik'] : 'Pendidik';
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Query untuk mendapatkan data jurnal mengajar
    $query = "SELECT jm.tanggal, jm.id_jammulai, jm.id_jamselesai 
              FROM jurnal_mengajar jm
              WHERE jm.id_tp = '$pendidik' 
                AND jm.tanggal BETWEEN '$start_date' AND '$end_date'
              ORDER BY jm.tanggal, jm.id_jammulai";
    $result = $conn->query($query);

    // Membuat instance FPDF
    $pdf = new FPDF();
    $pdf->AddPage();

    // Judul
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Rekap Jurnal Mengajar', 0, 1, 'C');

    // Informasi pendidik dan periode
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Pendidik: ' . $nama_pendidik, 0, 1);
    $pdf->Cell(0, 10, 'Periode: ' . $start_date . ' s/d ' . $end_date, 0, 1);

    // Header tabel
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(10, 10, '#', 1);
    $pdf->Cell(30, 10, 'Tanggal', 1);
    for ($i = 1; $i <= 11; $i++) {
        $pdf->Cell(12, 10, $i, 1);
    }
    $pdf->Ln();

    // Data tabel
    $pdf->SetFont('Arial', '', 10);
    $no = 1;
    $total_jam = 0;

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $pdf->Cell(10, 10, $no++, 1);
            $pdf->Cell(30, 10, $row['tanggal'], 1);

            $jumlah_jam = 0;
            for ($i = 1; $i <= 11; $i++) {
                if ($i >= $row['id_jammulai'] && $i <= $row['id_jamselesai']) {
                    if ($i == 6 || $i == 9) {
                        $pdf->Cell(12, 10, '', 1); // Tidak centang untuk jam ke-6 dan ke-9
                    } elseif ($i < $row['id_jamselesai']) {
                        $pdf->Cell(12, 10, 'KBM', 1); // Tanda centang untuk jam lain
                        $jumlah_jam++; // Menambah jumlah jam per hari
                    } else {
                        $pdf->Cell(12, 10, '', 1); // Tidak menambah jam di jam terakhir
                    }
                } else {
                    $pdf->Cell(12, 10, '', 1);
                }
            }

            $total_jam += $jumlah_jam;
            $pdf->Ln();
        }

        // Baris terakhir untuk total jam mengajar
        $pdf->Cell(40, 10, 'Total Jam Mengajar', 1);
        $pdf->Cell(50, 10, $total_jam . ' JP', 1, 1, 'C');
    } else {
        $pdf->Cell(0, 10, 'Tidak ada data', 1, 1);
    }

    // Menyimpan file PDF dengan nama sesuai pendidik
    $filename = 'Rekap_Absen_' . str_replace(' ', '_', $nama_pendidik) . '.pdf';
    $pdf->Output('D', $filename);
}


?>
