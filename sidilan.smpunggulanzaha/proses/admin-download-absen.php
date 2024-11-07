<?php 
require('../library/fpdf.php'); // Update the path to your FPDF library

// Koneksi database
include '../koneksi.php';

// Ambil data periode dari form input
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';

// Inisialisasi PDF
$pdf = new FPDF('L', 'mm', 'A4'); // Landscape orientation
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

// Judul PDF
$pdf->Cell(0, 10, 'Rekap Absen Pendidik', 0, 1, 'C');
$pdf->Cell(0, 10, "Periode: $start_date s/d $end_date", 0, 1, 'C');
$pdf->Ln(10);

// Kolom header
$pdf->Cell(10, 10, '#', 1);
$pdf->Cell(60, 10, 'Nama', 1);
$pdf->Cell(6, 10, 'M', 1);  // Jumlah Masuk
$pdf->Cell(6, 10, 'I', 1);  // Jumlah Izin
$pdf->Cell(6, 10, 'C', 1);  // Jumlah Cuti
$pdf->Cell(6, 10, 'T', 1);  // Jumlah Telat (baru)

// Kolom tanggal
if ($start_date && $end_date) {
  $period = new DatePeriod(
    new DateTime($start_date),
    new DateInterval('P1D'),
    (new DateTime($end_date))->modify('+1 day')
  );

  foreach ($period as $date) {
    $pdf->Cell(6, 10, $date->format('d'), 1);  // Ukuran lebar kolom tanggal diubah menjadi 6
  }
}

$pdf->Ln();

// Ambil data izin dari database
$izin_dates = [];
$sql_izin = "SELECT id_tp, tanggal FROM izin WHERE tanggal BETWEEN '$start_date' AND '$end_date'";
$result_izin = mysqli_query($conn, $sql_izin);
while ($row_izin = mysqli_fetch_assoc($result_izin)) {
  $izin_dates[$row_izin['id_tp']][] = $row_izin['tanggal'];
}

// Ambil data cuti dari database
$cuti_dates = [];
$sql_cuti = "SELECT id_tp, tgl_mulai, tgl_selesai FROM cuti WHERE tgl_mulai BETWEEN '$start_date' AND '$end_date' OR tgl_selesai BETWEEN '$start_date' AND '$end_date'";
$result_cuti = mysqli_query($conn, $sql_cuti);
while ($row_cuti = mysqli_fetch_assoc($result_cuti)) {
  $cuti_dates[$row_cuti['id_tp']][] = $row_cuti['tgl_mulai'];
  $cuti_dates[$row_cuti['id_tp']][] = $row_cuti['tgl_selesai'];
}

// Ambil data presensi dari database
$sql_presensi = "SELECT tenaga_pendidik.id_tp, tenaga_pendidik.nama, 
                 GROUP_CONCAT(DISTINCT presensi.tanggal ORDER BY presensi.tanggal) AS presensi_masuk,
                 GROUP_CONCAT(CASE WHEN presensi.jam > '07:11:00' THEN presensi.tanggal ELSE NULL END) AS presensi_telat,
                 COUNT(DISTINCT presensi.tanggal) AS jumlah_masuk,  -- Menghitung hanya tanggal unik
                 SUM(CASE WHEN presensi.jam > '07:11:00' THEN 1 ELSE 0 END) AS jumlah_telat
                 FROM tenaga_pendidik
                 LEFT JOIN presensi ON tenaga_pendidik.id_tp = presensi.id_tp 
                 AND presensi.tanggal BETWEEN '$start_date' AND '$end_date'
                 AND presensi.tipe_presensi = 'Masuk'
                 GROUP BY tenaga_pendidik.id_tp";


$result_presensi = mysqli_query($conn, $sql_presensi);
$no = 1;

while ($row = mysqli_fetch_assoc($result_presensi)) {
  $pdf->Cell(10, 10, $no++, 1);
  $pdf->Cell(60, 10, $row['nama'], 1);
  $pdf->Cell(6, 10, $row['jumlah_masuk'], 1);
  $pdf->Cell(6, 10, isset($izin_dates[$row['id_tp']]) ? count($izin_dates[$row['id_tp']]) : 0, 1);
  $pdf->Cell(6, 10, isset($cuti_dates[$row['id_tp']]) ? count($cuti_dates[$row['id_tp']]) / 2 : 0, 1);
  $pdf->Cell(6, 10, $row['jumlah_telat'], 1); // Jumlah telat

  // Ambil presensi telat untuk tenaga pendidik
  $telat_dates = explode(',', $row['presensi_telat']);

  // Loop untuk setiap tanggal dalam periode
  foreach ($period as $date) {
    $current_date = $date->format('Y-m-d');
    if (in_array($current_date, explode(',', $row['presensi_masuk'] ?? ''))) {
      // Cek apakah tanggal ini termasuk dalam daftar telat
      if (in_array($current_date, $telat_dates)) {
        $pdf->Cell(6, 10, 'T', 1);  // Kehadiran telat
      } else {
        $pdf->Cell(6, 10, 'M', 1);  // Kehadiran normal
      }
    } elseif (isset($izin_dates[$row['id_tp']]) && in_array($current_date, $izin_dates[$row['id_tp']])) {
      $pdf->Cell(6, 10, 'I', 1);  // Izin
    } elseif (isset($cuti_dates[$row['id_tp']]) && in_array($current_date, $cuti_dates[$row['id_tp']])) {
      $pdf->Cell(6, 10, 'C', 1);  // Cuti
    } else {
      $pdf->Cell(6, 10, '', 1);  // Kosong
    }
  }

  $pdf->Ln();
}

// Output PDF
$pdf->Output('D', 'Rekap_Absen_Pendidik.pdf');

?>