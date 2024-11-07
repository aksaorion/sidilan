<?php include '../components/header.php'; ?>
<?php include '../components/admin_navbar.php'; ?>
<?php $id_tp = $_SESSION['id_tp'];
$nama = $_SESSION['nama']; ?>

<main id="main" class="main">
    <div class="pagetitle">
        <?php echo generateBreadcrumb(); ?>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                       
                        <form class="row g-3" method="GET">
                            <div class="row mb-3">
                                <label for="pendidik" class="col-md-2 col-form-label"><strong>Pendidik</strong></label>
                                <div class="col-md-3">
                                    <select id="pendidik" name="pendidik" class="form-control" onchange="this.form.submit()">
                                        <option selected>Pilih Pendidik</option>
                                        <?php
                                        // Menampilkan opsi pendidik
                                        $query_tp = "SELECT * FROM tenaga_pendidik";
                                        $result_tp = $conn->query($query_tp);
                                        $nama_pendidik = ''; // Inisialisasi variabel untuk menyimpan nama pendidik
                                        if ($result_tp->num_rows > 0) {
                                            while ($row = $result_tp->fetch_assoc()) {
                                                // Set nama pendidik jika pendidik terpilih
                                                if (isset($_GET['pendidik']) && $_GET['pendidik'] == $row['id_tp']) {
                                                    $nama_pendidik = $row['nama']; // Menyimpan nama pendidik yang dipilih
                                                }
                                                echo '<option value="' . htmlspecialchars($row['id_tp']) . '"' . (isset($_GET['pendidik']) && $_GET['pendidik'] == $row['id_tp'] ? ' selected' : '') . '>' . htmlspecialchars($row['nama']) . '</option>';
                                            }
                                        } else {
                                            echo '<option value="">Tidak ada Data tersedia</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!-- Form untuk mendownload PDF -->
                            

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
                        <form class="row g-3" method="POST" action="download-jurnal.php">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-success">
                                        <i class="bi bi-arrow-down-short"></i>Download PDF
                                    </button>
                                </div>
                                <!-- Hidden inputs untuk mengirim data ke download-jurnal.php -->
                                <input type="hidden" name="pendidik" value="<?php echo isset($_GET['pendidik']) ? $_GET['pendidik'] : ''; ?>">
                                <input type="hidden" name="nama_pendidik" value="<?php echo isset($nama_pendidik) ? htmlspecialchars($nama_pendidik) : ''; ?>">
                                <input type="hidden" name="start_date" value="<?php echo isset($_GET['start_date']) ? $_GET['start_date'] : ''; ?>">
                                <input type="hidden" name="end_date" value="<?php echo isset($_GET['end_date']) ? $_GET['end_date'] : ''; ?>">
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
                                if (isset($_GET['pendidik'], $_GET['start_date'], $_GET['end_date'])) {
                                    $pendidik = $_GET['pendidik'];
                                    $start_date = $_GET['start_date'];
                                    $end_date = $_GET['end_date'];

                                    // Query untuk mendapatkan data jurnal mengajar berdasarkan pendidik dan rentang tanggal
                                    $query = "SELECT jm.tanggal, jm.id_jammulai, jm.id_jamselesai 
                                      FROM jurnal_mengajar jm
                                      WHERE jm.id_tp = '$pendidik' 
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