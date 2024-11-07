<?php include '../components/header.php'; ?>
<?php include '../components/guru_navbar.php' ?>
<?php $id_tp = $_SESSION['id_tp']; ?>
<main id="main" class="main">
    <div class="pagetitle">

        <?php

        echo generateBreadcrumb();
        ?>

    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Pilih Jadwal</h5>

                        <!-- Table with stripped rows -->
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th>Mapel</th>
                                    <th>Kelas</th>
                                    <th>Jam Mulai</th>
                                    <th>Jam Selesai</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Koneksi ke database

                                $query = "SELECT * 
                          FROM jadwal_mengajar
                          JOIN tenaga_pendidik ON tenaga_pendidik.id_tp = jadwal_mengajar.id_tp
                          JOIN mapel ON mapel.id_mapel = jadwal_mengajar.id_mapel
                          JOIN kelas ON kelas.id_kelas = jadwal_mengajar.id_kelas
                          JOIN jam_mulai ON jam_mulai.id_jammulai = jadwal_mengajar.id_jammulai
                          JOIN jam_selesai ON jam_selesai.id_jamselesai = jadwal_mengajar.id_jamselesai
                          WHERE jadwal_mengajar.id_tp = '$id_tp'";

                                $result = mysqli_query($conn, $query);
                                $no = 1;

                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<th scope='row'>{$no}</th>";
                                    echo "<td>{$row['mapel']}</td>"; // Nama Mapel dari tabel mapel
                                    echo "<td>{$row['kelas']}</td>"; // Nama Kelas dari tabel kelas
                                    echo "<td>{$row['jam_mulai']}</td>"; // Jam Mulai dari tabel jam_mulai
                                    echo "<td>{$row['jam_selesai']}</td>"; // Jam Selesai dari tabel jam_selesai
                                    echo "<td>
                                    <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#rekapBulan" . $row['id_jadwal'] . "'>
                                        Rekap Bulan </button>
                                    <button type='button' class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#rekapTanggal" . $row['id_jadwal'] . "'>
                                        Rekap Bulan </button>
                            
                            
                          </td>";
                                    echo "</tr>";
                                    $no++;
                                    echo "
                                    <div class='modal fade' id='rekapBulan" . $row['id_jadwal'] . "' tabindex='-1' aria-labelledby='rekapBulanLabel" . $row['id_jadwal'] . "' aria-hidden='true'>
                                        <div class='modal-dialog modal-dialog-scrollable'>
                                            
                                                <div class='modal-content'>
                                                    <div class='modal-header'>
                                                        <h5 class='modal-title' id='rekapBulanLabel" . $row['id_jadwal'] . "'>Edit Data</h5>
                                                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                                    </div>
                                                    <div class='modal-body'>
                                                        <input type='hidden' name='id_jadwal' value='" . htmlspecialchars($row['id_jadwal']) . "'>
                                                        
                                                        <div class='mb-3'>
                                                                <label for='mulai' class='form-label'>Jam Mulai</label>
                                                                <input type='time' class='form-control' name='mulai' value='" . htmlspecialchars($row['jam_mulai']) . "' required>
                                                        </div>
                                                        <div class='mb-3'>
                                                                <label for='selesai' class='form-label'>Jam selesai</label>
                                                                <input type='time' class='form-control' name='selesai' value='" . htmlspecialchars($row['jam_selesai']) . "' required>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class='modal-footer'>
                                                        <a href='edit_jadwal.php?id={$row['id_jadwal']}' class='btn btn-primary btn-sm'>Rekap Bulan</a>
                                                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                                    </div>
                                                </div>
                                            
                                        </div>
                                    </div>";

                                    echo "
                                    <div class='modal fade' id='rekapTanggal" . $row['id_jadwal'] . "' tabindex='-1' aria-labelledby='rekapTanggalLabel" . $row['id_jadwal'] . "' aria-hidden='true'>
                                        <div class='modal-dialog modal-dialog-scrollable'>
                                            
                                                <div class='modal-content'>
                                                    <div class='modal-header'>
                                                        <h5 class='modal-title' id='rekapTanggalLabel" . $row['id_jadwal'] . "'>Edit Data</h5>
                                                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                                    </div>
                                                    <div class='modal-body'>
                                                        <input type='hidden' name='id_jadwal' value='" . htmlspecialchars($row['id_jadwal']) . "'>
                                                        
                                                        <div class='mb-3'>
                                                                <label for='mulai' class='form-label'>Jam Mulai</label>
                                                                <input type='time' class='form-control' name='mulai' value='" . htmlspecialchars($row['jam_mulai']) . "' required>
                                                        </div>
                                                        <div class='mb-3'>
                                                                <label for='selesai' class='form-label'>Jam selesai</label>
                                                                <input type='time' class='form-control' name='selesai' value='" . htmlspecialchars($row['jam_selesai']) . "' required>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class='modal-footer'>
                                                        <a href='edit_jadwal.php?id={$row['id_jadwal']}' class='btn btn-primary btn-sm'>Rekap Tanggal</a>
                                                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                                    </div>
                                                </div>
                                            
                                        </div>
                                    </div>";
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