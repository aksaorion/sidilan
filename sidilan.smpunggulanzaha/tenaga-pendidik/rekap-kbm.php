<?php include '../components/header.php'; ?>
<?php include '../components/guru_navbar.php'; ?>
<?php $id_tp = $_SESSION['id_tp']; ?>

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
                        <!-- Form untuk mendownload PDF -->
                        <form class="row g-3" method="POST" action="../proses/download-jurnal.php">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                 <a href="jadwal-mengajar" class="btn btn-warning">
                                    <i class="bi bi-plus"></i> Input Jurnal
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-arrow-down-short"></i>Download PDF
                                </button>
                            </div>
                            <input type="hidden" name="pendidik" value="<?php echo $id_tp; ?>">
                            <input type="hidden" name="nama_pendidik" value="<?php echo $nama_pendidik; ?>">
                            <input type="hidden" name="start_date" value="<?php echo isset($_GET['start_date']) ? $_GET['start_date'] : ''; ?>">
                            <input type="hidden" name="end_date" value="<?php echo isset($_GET['end_date']) ? $_GET['end_date'] : ''; ?>">
                        </form>
                        <br>
                        <!-- Form untuk menampilkan data -->
                        <form class="row g-3" method="GET">
                            <input type="hidden" class="form-control" value="<?php echo $id_tp; ?>" readonly>

                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-md-2 col-form-label"><strong>Periode</strong></label>
                                <div class="col-md-3">
                                    <input type="date" name="start_date" class="form-control" id="start_date" value="<?php echo isset($_GET['start_date']) ? $_GET['start_date'] : ''; ?>">
                                </div>
                                <div class="col-md-auto col-form-label"><span>s/d</span></div>
                                <div class="col-md-3">
                                    <input type="date" name="end_date" class="form-control" id="end_date" value="<?php echo isset($_GET['end_date']) ? $_GET['end_date'] : ''; ?>">
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary">Tampilkan</button>
                                </div>
                            </div>
                        </form>

                        <h5 class="card-title">Rekap KBM <?php echo $nama_pendidik ? ' - ' . $nama_pendidik : ''; ?></h5>

                        <!-- Table with stripped rows -->
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th>Tanggal</th>
                                    <?php
                                    // Menampilkan header untuk setiap jam
                                    for ($i = 1; $i <= 11; $i++) {
                                        echo "<th>$i</th>";
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($_GET['start_date'], $_GET['end_date'])) {
                                    $start_date = $_GET['start_date'];
                                    $end_date = $_GET['end_date'];

                                    // Query untuk mendapatkan data jurnal mengajar berdasarkan pendidik dan rentang tanggal
                                    $query = "SELECT jm.tanggal, jm.id_jammulai, jm.id_jamselesai 
                                              FROM jurnal_mengajar jm
                                              WHERE jm.id_tp = '$id_tp' 
                                                AND jm.tanggal BETWEEN '$start_date' AND '$end_date'
                                                 ORDER BY jm.tanggal, jm.id_jammulai";
                                    $result = $conn->query($query);

                                    // Inisialisasi total jam untuk menghitung total seluruh jam dalam periode tersebut
                                    $total_jam = 0;

                                    if ($result->num_rows > 0) {
                                        $no = 1;
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<th scope='row'>$no</th>";
                                            echo "<td>" . $row['tanggal'] . "</td>";

                                            $jumlah_jam = 0; // Menghitung jumlah jam dalam satu hari
                                            for ($i = 1; $i <= 11; $i++) {
                                                // Mengecualikan jam ke-6 dan ke-9 dari centang
                                                if ($i >= $row['id_jammulai'] && $i <= $row['id_jamselesai']) {
                                                    if ($i == 6 || $i == 9) {
                                                        echo "<td></td>"; // Jangan centang untuk jam ke-6 dan ke-9
                                                    } elseif ($i < $row['id_jamselesai']) {
                                                        echo "<td><i class='bi bi-check'></i></td>"; // Tanda centang untuk jam lain
                                                        $jumlah_jam++; // Menambah jumlah jam per hari
                                                    } else {
                                                        echo "<td></td>"; // Tidak menambah jam di jam terakhir
                                                    }
                                                } else {
                                                    echo "<td></td>";
                                                }
                                            }
                                            echo "</tr>";
                                            $total_jam += $jumlah_jam; // Menambah total jam keseluruhan
                                            $no++;
                                        }

                                        // Baris terakhir untuk total jam mengajar
                                        echo "<tr>";
                                        echo "<td colspan='2'><strong>Total Jam Mengajar</strong></td>";
                                        echo "<td colspan='11'><strong>$total_jam JP</strong></td>";
                                        echo "</tr>";
                                    } else {
                                        echo "<tr><td colspan='13'>Tidak ada data</td></tr>";
                                    }
                                }
                                ?>
                            </tbody>

                        </table>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include '../components/footer.php'; ?>