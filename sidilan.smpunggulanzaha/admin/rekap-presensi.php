<?php include '../components/header.php'; ?>
<?php include '../components/admin_navbar.php'; ?>

<?php
// Koneksi database

// Inisialisasi variabel $result_presensi
$result_presensi = null;

// Ambil data periode dari form input
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';

// Inisialisasi variabel untuk menyimpan data tanggal izin dan cuti
$izin_dates = [];
$cuti_dates = [];

// Query untuk mengambil data absen dari tabel presensi, izin, dan cuti
if ($start_date && $end_date) {
  // Query untuk mengambil presensi "Masuk" beserta jam presensi
 $sql_presensi = "SELECT tenaga_pendidik.id_tp, tenaga_pendidik.nama, 
                     GROUP_CONCAT(DISTINCT presensi.tanggal ORDER BY presensi.tanggal) AS presensi_masuk,
                     COUNT(DISTINCT presensi.tanggal) AS jumlah_masuk,
                     GROUP_CONCAT(DISTINCT presensi.jam ORDER BY presensi.tanggal) AS presensi_jam
                     FROM tenaga_pendidik
                     LEFT JOIN presensi ON tenaga_pendidik.id_tp = presensi.id_tp 
                     AND presensi.tanggal BETWEEN '$start_date' AND '$end_date'
                     AND presensi.tipe_presensi = 'Masuk'
                     GROUP BY tenaga_pendidik.id_tp";


  // Jalankan query presensi
  $result_presensi = mysqli_query($conn, $sql_presensi);

  // Query untuk mengambil jumlah izin
  $sql_izin = "SELECT tenaga_pendidik.id_tp, izin.tanggal AS tanggal_izin
                 FROM tenaga_pendidik
                 LEFT JOIN izin ON tenaga_pendidik.id_tp = izin.id_tp 
                 AND izin.tanggal BETWEEN '$start_date' AND '$end_date'";
  $result_izin = mysqli_query($conn, $sql_izin);

  // Inisialisasi array izin_dates sebagai array asosiatif kosong
  while ($row_izin = mysqli_fetch_assoc($result_izin)) {
    if ($row_izin['tanggal_izin']) {
      $izin_dates[$row_izin['id_tp']][] = $row_izin['tanggal_izin'];
    }
  }

  // Query untuk mengambil jumlah cuti
  $sql_cuti = "SELECT tenaga_pendidik.id_tp, cuti.tgl_mulai, cuti.tgl_selesai
                 FROM tenaga_pendidik
                 LEFT JOIN cuti ON tenaga_pendidik.id_tp = cuti.id_tp 
                 AND (cuti.tgl_mulai BETWEEN '$start_date' AND '$end_date' 
                 OR cuti.tgl_selesai BETWEEN '$start_date' AND '$end_date')";
  $result_cuti = mysqli_query($conn, $sql_cuti);

  // Inisialisasi array cuti_dates sebagai array asosiatif kosong
  while ($row_cuti = mysqli_fetch_assoc($result_cuti)) {
    if ($row_cuti['tgl_mulai']) {
      $cuti_dates[$row_cuti['id_tp']][] = $row_cuti['tgl_mulai'];
    }
    if ($row_cuti['tgl_selesai']) {
      $cuti_dates[$row_cuti['id_tp']][] = $row_cuti['tgl_selesai'];
    }
  }
}
?>

<main id="main" class="main">
  <div class="pagetitle">
    <?php echo generateBreadcrumb(); ?>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <br>
            <!-- Form Input Periode -->
            <form class="row g-3" method="GET">
              <div class="row mb-3">
                <label for="inputEmail3" class="col-md-auto col-form-label"><strong>Periode</strong></label>
                <div class="col-md-3">
                  <input type="date" name="start_date" class="form-control" value="<?php echo $start_date; ?>">
                </div>
                <div class="col-md-auto col-form-label"><span>s/d</span></div>
                <div class="col-md-3">
                  <input type="date" name="end_date" class="form-control" value="<?php echo $end_date; ?>">
                </div>
                <div class="col-md-3">
                  <button type="submit" class="btn btn-primary">Tampilkan</button>
                </div>
              </div>
            </form>

            <!-- Tombol Download -->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
              <form method="POST" action="../proses/admin-download-absen.php">
                <input type="hidden" name="start_date" value="<?php echo $start_date; ?>">
                <input type="hidden" name="end_date" value="<?php echo $end_date; ?>">
                <button type="submit" class="btn btn-success">Download</button>
              </form>
            </div>

            <h5 class="card-title">Rekap Absen</h5>

            <!-- Tabel Rekap Absen -->
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nama</th>
                  <th>Jumlah Masuk</th>
                  <th>Jumlah Izin</th>
                  <th>Jumlah Cuti</th>
                  <?php
                  if ($start_date && $end_date) {
                    $period = new DatePeriod(
                      new DateTime($start_date),
                      new DateInterval('P1D'),
                      (new DateTime($end_date))->modify('+1 day')
                    );
                    foreach ($period as $date) {
                      echo "<th>" . $date->format('d M') . "</th>";
                    }
                  }
                  ?>
                </tr>
              </thead>
              <tbody>
                <?php if ($result_presensi && mysqli_num_rows($result_presensi) > 0): ?>
                  <?php $no = 1;
                  while ($row = mysqli_fetch_assoc($result_presensi)): ?>
                    <tr>
                      <th><?php echo $no++; ?></th>
                      <td><?php echo $row['nama']; ?></td>
                      <td><?php echo $row['jumlah_masuk']; ?></td>
                      <td><?php echo isset($izin_dates[$row['id_tp']]) ? count($izin_dates[$row['id_tp']]) : 0; ?></td>
                      <td><?php echo isset($cuti_dates[$row['id_tp']]) ? count($cuti_dates[$row['id_tp']]) / 2 : 0; ?></td>

                      <?php
                      $period = new DatePeriod(
                        new DateTime($start_date),
                        new DateInterval('P1D'),
                        (new DateTime($end_date))->modify('+1 day')
                      );

                      $presensi_dates = explode(',', $row['presensi_masuk']);
                      $presensi_jams = explode(',', $row['presensi_jam']);

                      foreach ($period as $index => $date) {
                        $current_date = $date->format('Y-m-d');
                        if (in_array($current_date, $presensi_dates)) {
                          $jam_presensi = $presensi_jams[array_search($current_date, $presensi_dates)];
                          if ($jam_presensi > '07:11:00') {
                            echo "<td>T</td>"; // Tampilkan 'T' jika presensi setelah 07:11
                          } else {
                            echo "<td>&#10003;</td>"; // Tampilkan centang
                          }
                        } elseif (isset($izin_dates[$row['id_tp']]) && in_array($current_date, $izin_dates[$row['id_tp']])) {
                          echo "<td>I</td>"; // Tampilkan 'I' untuk izin
                        } elseif (isset($cuti_dates[$row['id_tp']]) && in_array($current_date, $cuti_dates[$row['id_tp']])) {
                          echo "<td>C</td>"; // Tampilkan 'C' untuk cuti
                        } else {
                          echo "<td></td>"; // Tidak ada data
                        }
                      }
                      ?>
                    </tr>
                  <?php endwhile; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="35" class="text-center">Tidak ada data absen.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
            <!-- Akhir Tabel -->
          </div>
        </div>
      </div>
    </div>
  </section>
</main>


<?php include '../components/footer.php'; ?>