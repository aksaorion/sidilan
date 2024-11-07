<?php include '../components/header.php'; ?>
<?php include '../components/guru_navbar.php' ?>
<?php $id_tp = $_SESSION['id_tp']; ?>
<?php
$query_kelas_induk = "SELECT * FROM kelas_induk";
$result_kelas_induk = $conn->query($query_kelas_induk);

$query_tahun = "SELECT * FROM tahun_ajar";
$result_tahun = $conn->query($query_tahun);

$query_mapel = "SELECT * FROM mapel";
$result_mapel = $conn->query($query_mapel);
?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Dashboard</h1>
        -
        <?php

        echo generateBreadcrumb();
        ?>

    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <br>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahKelas"><i class="bi bi-plus"></i> Upload Modul</button>
                        </div>

                        <h5 class="card-title">Modul Pembelajaran</h5>

                        <div class="modal fade" id="modalTambahKelas" tabindex="-1">
                            <div class="modal-dialog modal-dialog-scrollable">
                                <form action="../proses/tp-modul.php?act=tambah-modul" method="post" enctype="multipart/form-data">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Upload Modul</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">

                                                <input type="hidden" name="id_tp" value="<?= $id_tp ?>">

                                            </div>
                                            <div class="mb-3">
                                                <label for="mapel" class="form-label">Mata Pelajaran</label>
                                                <select id="mapel" name="mapel" class="form-select">
                                                    <option selected>Pilih Mata Pelajaran</option>
                                                    <?php
                                                    // Jika ada hasil, tampilkan opsi

                                                    if ($result_mapel->num_rows > 0) {
                                                        while ($row = $result_mapel->fetch_assoc()) {
                                                            echo '<option value="' . htmlspecialchars($row['id_mapel']) . '">' . htmlspecialchars($row['mapel']) . '</option>';
                                                        }
                                                    } else {
                                                        echo '<option value="">Tidak ada Data tersedia</option>';
                                                    }

                                                    ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="kelas_induk" class="form-label">Kelas Induk</label>
                                                <select id="kelas_induk" name="kelas_induk" class="form-select">
                                                    <option selected>Pilih Kelas Induk</option>
                                                    <?php
                                                    // Jika ada hasil, tampilkan opsi

                                                    if ($result_kelas_induk->num_rows > 0) {
                                                        while ($row = $result_kelas_induk->fetch_assoc()) {
                                                            echo '<option value="' . htmlspecialchars($row['id_kelasinduk']) . '">' . htmlspecialchars($row['kelas_induk']) . '</option>';
                                                        }
                                                    } else {
                                                        echo '<option value="">Tidak ada Data tersedia</option>';
                                                    }

                                                    ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="tanggal" class="form-label">Tanggal</label>
                                                <input type="date" class="form-control" id="tanggal" name="tanggal">
                                            </div>
                                            <div class="mb-3">
                                                <label for="tahun" class="form-label">Tahun Pelajaran</label>
                                                <select id="tahun" name="tahun" class="form-select">
                                                    <option selected>Pilih Tahun Pelajaran</option>
                                                    <?php
                                                    // Jika ada hasil, tampilkan opsi

                                                    if ($result_tahun->num_rows > 0) {
                                                        while ($row = $result_tahun->fetch_assoc()) {
                                                            echo '<option value="' . htmlspecialchars($row['id_tahunajar']) . '">' . htmlspecialchars($row['tahun_ajar']) . '</option>';
                                                        }
                                                    } else {
                                                        echo '<option value="">Tidak ada Data tersedia</option>';
                                                    }

                                                    ?>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="materi" class="form-label">Judul Materi</label>
                                                <input type="text" class="form-control" id="materi" name="materi">
                                            </div>
                                            <div class="row mb-3">
                                                <label for="file" class="form-label">File</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="file" id="file" name="file">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div><!-- End Modal Dialog Scrollable-->

                        <!-- Table with stripped rows -->
                        <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th>Tanggal</th>
                                    <th>Kelas</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Materi</th>
                                    <th>Tahun</th>
                                    <th>File</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Koneksi ke database

                                $query = "SELECT modul.id_modul,modul.tanggal, kelas_induk.kelas_induk,mapel.mapel,modul.materi,tahun_ajar.tahun_ajar,modul.file,modul.status 
                          FROM modul
                          JOIN kelas_induk ON modul.id_kelasinduk = kelas_induk.id_kelasinduk
                          JOIN tahun_ajar ON modul.id_tahunajar = tahun_ajar.id_tahunajar
                          JOIN mapel ON modul.id_mapel = mapel.id_mapel
                          
                          WHERE modul.id_tp = '$id_tp'";

                                $result = mysqli_query($conn, $query);
                                $no = 1;

                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<th scope='row'>{$no}</th>";
                                    echo "<td>{$row['tanggal']}</td>"; // Nama Mapel dari tabel mapel
                                    echo "<td>{$row['kelas_induk']}</td>"; // Nama Kelas dari tabel kelas
                                    echo "<td>{$row['mapel']}</td>"; // Jam Mulai dari tabel jam_mulai
                                    echo "<td>{$row['materi']}</td>"; // Jam Selesai dari tabel jam_selesai
                                    echo "<td>{$row['tahun_ajar']}</td>";
                                    echo "<td><a href='../public/modul/{$row['file']}' target='_blank'>{$row['file']}</a></td>";
                                    echo "<td>{$row['status']}</td>";
                                    echo "<td>
                            
                            <a href='../proses/tp-modul.php?act=hapus-modul&id={$row['id_modul']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')\">Hapus</a>
                          </td>";
                                    echo "</tr>";
                                    $no++;
                                }
                                ?>
                            </tbody>
                        </table>
                        </div>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>

            </div>
        </div>
    </section>

</main>
<?php include '../components/footer.php'; ?>