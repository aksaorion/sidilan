<?php include '../components/header.php'; ?>
<?php include '../components/admin_navbar.php'; ?>
<?php
$id_sekolah = $_SESSION['sekolah'];

// Query untuk mendapatkan data modul berdasarkan status
$query_modul = "SELECT * FROM modul WHERE id_sekolah = $id_sekolah";
$result_modul = $conn->query($query_modul);
?>
<main id="main" class="main">
    <div class="pagetitle">
        <!-- Page title here -->
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Data Modul Pembelajaran</h5>

                        <!-- Pills Tabs -->
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-pending-tab" data-bs-toggle="pill" data-bs-target="#pills-pending" type="button" role="tab" aria-controls="pills-pending" aria-selected="true">Pending</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-acc-tab" data-bs-toggle="pill" data-bs-target="#pills-acc" type="button" role="tab" aria-controls="pills-acc" aria-selected="false">ACC</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-ditolak-tab" data-bs-toggle="pill" data-bs-target="#pills-ditolak" type="button" role="tab" aria-controls="pills-ditolak" aria-selected="false">Ditolak</button>
                            </li>
                        </ul>

                        <div class="tab-content pt-2" id="pills-tabContent">
                            <!-- Tab Pending -->
                            <div class="tab-pane fade show active" id="pills-pending" role="tabpanel" aria-labelledby="pills-pending-tab">
                                <?php
                                // Query untuk modul dengan status Pending
                                $query_pending = "SELECT tenaga_pendidik.nama, mapel.mapel,kelas_induk.kelas_induk,tenaga_pendidik.id_sekolah,modul.file,modul.status,modul.materi
                                    FROM modul
                                    JOIN tenaga_pendidik ON tenaga_pendidik.id_tp = modul.id_tp
                                    JOIN mapel ON mapel.id_mapel = modul.id_mapel
                                    JOIN kelas_induk ON kelas_induk.id_kelasinduk = modul.id_kelasinduk
                                    WHERE modul.status = 'Pending' AND tenaga_pendidik.id_sekolah = $id_sekolah";
                                $result_pending = $conn->query($query_pending);

                                if ($result_pending->num_rows > 0) {
                                    echo "<table class='table table-striped'>";
                                    echo "<thead>
                                            <tr>
                                                <th>Nama Guru</th>
                                                <th>Mapel</th>
                                                <th>Kelas</th>
                                                <th>Materi</th>
                                                <th>File</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>";
                                    echo "<tbody>";
                                    while ($modul = $result_pending->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($modul['nama']) . "</td>";
                                        echo "<td>" . htmlspecialchars($modul['mapel']) . "</td>";
                                        echo "<td>" . htmlspecialchars($modul['kelas_induk']) . "</td>";
                                        echo "<td>" . htmlspecialchars($modul['materi']) . "</td>";

                                        // Link untuk membuka file di tab baru
                                        if (!empty($modul['file'])) {
                                            echo "<td><a href='" . htmlspecialchars($modul['file']) . "' target='_blank' class='btn btn-info'>Lihat File</a></td>";
                                        } else {
                                            echo "<td>File tidak tersedia</td>";
                                        }

                                        echo "<td>" . htmlspecialchars($modul['status']) . "</td>";
                                        echo "<td>
                    <button class='btn btn-primary'>ACC</button>
                    <button class='btn btn-warning'>Tolak</button>
                    <button class='btn btn-danger'>Hapus</button>
                  </td>";
                                        echo "</tr>";
                                    }
                                    echo "</tbody></table>";
                                } else {
                                    echo "<p>Tidak ada modul dengan status Pending.</p>";
                                }
                                ?>
                            </div>


                            <!-- Tab ACC -->
                            <div class="tab-pane fade" id="pills-acc" role="tabpanel" aria-labelledby="pills-acc-tab">
                                <?php
                                // Query untuk modul dengan status ACC
                                $query_acc = "SELECT *
                                FROM modul
                                JOIN tenaga_pendidik ON tenaga_pendidik.id_tp = modul.id_tp
                                JOIN mapel ON mapel.id_mapel = modul.id_mapel
                                JOIN kelas ON kelas.id_kelasinduk = modul.id_kelasinduk 
                                WHERE modul.status = 'ACC' AND modul.id_sekolah = $id_sekolah";
                                $result_acc = $conn->query($query_acc);

                                if ($result_acc->num_rows > 0) {
                                    echo "<table class='table table-striped'>";
                                    echo "<thead>
                                            <tr>
                                                 <th>Nama Guru</th>
                                                <th>Mapel</th>
                                                <th>Kelas</th>
                                                <th>Materi</th>
                                                <th>File</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                          </thead>";
                                    echo "<tbody>";
                                    while ($modul = $result_acc->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($modul['nama']) . "</td>";
                                        echo "<td>" . htmlspecialchars($modul['mapel']) . "</td>";
                                        echo "<td>" . htmlspecialchars($modul['kelas_induk']) . "</td>";
                                        echo "<td>" . htmlspecialchars($modul['materi']) . "</td>";

                                        // Link untuk membuka file di tab baru
                                        if (!empty($modul['file'])) {
                                            echo "<td><a href='" . htmlspecialchars($modul['file']) . "' target='_blank' class='btn btn-info'>Lihat File</a></td>";
                                        } else {
                                            echo "<td>File tidak tersedia</td>";
                                        }

                                        echo "<td>" . htmlspecialchars($modul['status']) . "</td>";
                                        echo "<td>
                                                <button class='btn btn-primary'>Edit</button>
                                                <button class='btn btn-danger'>Hapus</button>
                                              </td>";
                                        echo "</tr>";
                                    }
                                    echo "</tbody></table>";
                                } else {
                                    echo "<p>Tidak ada modul dengan status ACC.</p>";
                                }
                                ?>
                            </div>

                            <!-- Tab Ditolak -->
                            <div class="tab-pane fade" id="pills-ditolak" role="tabpanel" aria-labelledby="pills-ditolak-tab">
                                <?php
                                // Query untuk modul dengan status Ditolak
                                $query_ditolak = "SELECT *
                                    FROM modul
                                    JOIN tenaga_pendidik ON tenaga_pendidik.id_tp = modul.id_tp
                                    JOIN mapel ON mapel.id_mapel = modul.id_mapel
                                    JOIN kelas ON kelas.id_kelasinduk = modul.id_kelasinduk 
                                    WHERE modul.status = 'Ditolak' AND modul.id_sekolah = $id_sekolah";
                                $result_ditolak = $conn->query($query_ditolak);

                                if ($result_ditolak->num_rows > 0) {
                                    echo "<table class='table table-striped'>";
                                    echo "<thead>
                                            <tr>
                                                 <th>Nama Guru</th>
                                                <th>Mapel</th>
                                                <th>Kelas</th>
                                                <th>Materi</th>
                                                <th>File</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                          </thead>";
                                    echo "<tbody>";
                                    while ($modul = $result_ditolak->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($modul['nama']) . "</td>";
                                        echo "<td>" . htmlspecialchars($modul['mapel']) . "</td>";
                                        echo "<td>" . htmlspecialchars($modul['kelas_induk']) . "</td>";
                                        echo "<td>" . htmlspecialchars($modul['materi']) . "</td>";

                                        // Link untuk membuka file di tab baru
                                        if (!empty($modul['file'])) {
                                            echo "<td><a href='" . htmlspecialchars($modul['file']) . "' target='_blank' class='btn btn-info'>Lihat File</a></td>";
                                        } else {
                                            echo "<td>File tidak tersedia</td>";
                                        }

                                        echo "<td>" . htmlspecialchars($modul['status']) . "</td>";
                                        echo "<td>
                                                <button class='btn btn-primary'>Edit</button>
                                                <button class='btn btn-danger'>Hapus</button>
                                              </td>";
                                        echo "</tr>";
                                    }
                                    echo "</tbody></table>";
                                } else {
                                    echo "<p>Tidak ada modul dengan status Ditolak.</p>";
                                }
                                ?>
                            </div>
                        </div><!-- End Pills Tabs -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include '../components/footer.php'; ?>