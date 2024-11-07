<?php include '../components/header.php'; ?>
<?php include '../components/admin_navbar.php'; ?>
<?php
include '../model/admin-jadwalmengajar.php';


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
                        <h5 class="card-title">Data Jadwal Mengajar</h5>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahKelas"><i class="bi bi-plus"></i> Tambah Jadwal Mengajar</button>
                        </div>

                        <div class="modal fade" id="modalTambahKelas" tabindex="-1">
                            <div class="modal-dialog modal-dialog-scrollable">
                                <form action="../proses/admin-jadwal-mengajar.php?act=tambah-jadwal" method="post">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Tambah Jadwal Mengajar</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                            <div class="mb-3">
                                                <label for="guru" class="form-label">Guru</label>
                                                <select id="guru" name="guru" class="form-select">
                                                    <option selected>Pilih Guru</option>
                                                    <?php
                                                    if ($result_guru->num_rows > 0) {
                                                        while ($row = $result_guru->fetch_assoc()) {
                                                            echo '<option value="' . htmlspecialchars($row['id_tp']) . '">' . htmlspecialchars($row['nama']) . '</option>';
                                                        }
                                                    } else {
                                                        echo '<option value="">Tidak ada Data tersedia</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="mapel" class="form-label">Mata Pelajaran</label>
                                                <select id="mapel" name="mapel" class="form-select">
                                                    <option selected>Pilih Mata Pelajaran</option>
                                                    <?php
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
                                                <label for="kelas" class="form-label">Kelas</label>
                                                <select id="kelas" name="kelas" class="form-select">
                                                    <option selected>Pilih Kelas</option>
                                                    <?php
                                                    if ($result_kelas->num_rows > 0) {
                                                        while ($row = $result_kelas->fetch_assoc()) {
                                                            echo '<option value="' . htmlspecialchars($row['id_kelas']) . '">' . htmlspecialchars($row['kelas']) . '</option>';
                                                        }
                                                    } else {
                                                        echo '<option value="">Tidak ada Data tersedia</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="hari" class="form-label">Hari</label>
                                                <select id="hari" name="hari" class="form-select">
                                                    <option selected>Pilih Hari</option>
                                                    <?php
                                                    if ($result_hari->num_rows > 0) {
                                                        while ($row = $result_hari->fetch_assoc()) {
                                                            echo '<option value="' . htmlspecialchars($row['id_hari']) . '">' . htmlspecialchars($row['hari']) . '</option>';
                                                        }
                                                    } else {
                                                        echo '<option value="">Tidak ada Data tersedia</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="mulai" class="form-label">Jam Mulai</label>
                                                <select id="mulai" name="mulai" class="form-select">
                                                    <option selected>Pilih Jam Mulai</option>
                                                    <?php
                                                    if ($result_mulai->num_rows > 0) {
                                                        while ($row = $result_mulai->fetch_assoc()) {
                                                            echo '<option value="' . htmlspecialchars($row['id_jammulai']) . '">' . htmlspecialchars($row['jam_mulai']) . '</option>';
                                                        }
                                                    } else {
                                                        echo '<option value="">Tidak ada Data tersedia</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="selesai" class="form-label">Jam Selesai</label>
                                                <select id="selesai" name="selesai" class="form-select">
                                                    <option selected>Pilih Jam Selesai</option>
                                                    <?php
                                                    if ($result_selesai->num_rows > 0) {
                                                        while ($row = $result_selesai->fetch_assoc()) {
                                                            echo '<option value="' . htmlspecialchars($row['id_jamselesai']) . '">' . htmlspecialchars($row['jam_selesai']) . '</option>';
                                                        }
                                                    } else {
                                                        echo '<option value="">Tidak ada Data tersedia</option>';
                                                    }
                                                    ?>
                                                </select>
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

                        <!-- Pills Tabs -->
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <?php
                            // Ambil data hari dari database
                            $hariResult = $conn->query("SELECT id_hari, hari FROM hari");
                            $isActive = true;

                            while ($hari = $hariResult->fetch_assoc()) {
                                $activeClass = $isActive ? 'active' : '';
                                echo "
                            <li class='nav-item' role='presentation'>
                                <button class='nav-link $activeClass' id='pills-{$hari['id_hari']}-tab' data-bs-toggle='pill' data-bs-target='#pills-{$hari['id_hari']}' type='button' role='tab' aria-controls='pills-{$hari['id_hari']}' aria-selected='$isActive'>{$hari['hari']}</button>
                            </li>";
                                $isActive = false;
                            }
                            ?>
                        </ul>

                        <div class="tab-content pt-2" id="pills-tabContent">
                            <?php
                            $hariResult->data_seek(0);
                            $isActive = true;

                            while ($hari = $hariResult->fetch_assoc()) {
                                $activeClass = $isActive ? 'show active' : '';
                                echo "<div class='tab-pane fade $activeClass' id='pills-{$hari['id_hari']}' role='tabpanel' aria-labelledby='pills-{$hari['id_hari']}-tab'>";
                                echo "<div class='card'><div class='card-body'>";
                                echo "<h5 class='card-title'>Jadwal Mengajar Hari {$hari['hari']}</h5>";

                                // Ambil data jadwal mengajar berdasarkan id_hari
                                $jadwalResult = $conn->query("
                            SELECT *
                            FROM jadwal_mengajar
                            JOIN tenaga_pendidik ON tenaga_pendidik.id_tp = jadwal_mengajar.id_tp
                            JOIN mapel ON mapel.id_mapel = jadwal_mengajar.id_mapel
                            JOIN kelas ON kelas.id_kelas = jadwal_mengajar.id_kelas
                            JOIN jam_mulai ON jam_mulai.id_jammulai = jadwal_mengajar.id_jammulai
                            JOIN jam_selesai ON jam_selesai.id_jamselesai = jadwal_mengajar.id_jamselesai
                            WHERE jadwal_mengajar.id_hari = {$hari['id_hari']}
                        ");

                                if ($jadwalResult->num_rows > 0) {
                                    echo "<table class='table table-striped'>";
                                    echo "<thead>
                            <tr>
                                <th>Nama Guru</th>
                                <th>Mapel</th>
                                <th>Kelas</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th>Action</th>
                            </tr></thead>";
                                    echo "<tbody>";
                                    while ($jadwal = $jadwalResult->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($jadwal['nama']) . "</td>";
                                        echo "<td>" . htmlspecialchars($jadwal['mapel']) . "</td>";
                                        echo "<td>" . htmlspecialchars($jadwal['kelas']) . "</td>";
                                        echo "<td>" . htmlspecialchars($jadwal['jam_mulai']) . "</td>";
                                        echo "<td>" . htmlspecialchars($jadwal['jam_selesai']) . "</td>";
                                        echo "<td>
                                        <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#editModal" . $jadwal['id_jadwal'] . "'>
                                        Edit
                                        </button>
                                        <form action='../proses/admin-jadwal-mengajar.php?act=delete-jadwal' method='post' style='display:inline-block;'>
                                            <input type='hidden' name='id_jadwal' value='" . $jadwal['id_jadwal'] . "'>
                                            <button type='submit' class='btn btn-danger' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>
                                            Hapus
                                            </button>
                                        </form>
                                    </td>";
                                        echo "</tr>";

                                        // Modal untuk edit data
                                        echo "
                                    <div class='modal fade' id='editModal" . $jadwal['id_jadwal'] . "' tabindex='-1' aria-labelledby='editModalLabel" . $jadwal['id_jadwal'] . "' aria-hidden='true'>
                                        <div class='modal-dialog modal-dialog-scrollable'>
                                            <form action='../proses/admin-jadwal-mengajar.php?act=update-jadwal' method='post'>
                                                <div class='modal-content'>
                                                    <div class='modal-header'>
                                                        <h5 class='modal-title' id='editModalLabel" . $jadwal['id_jadwal'] . "'>Edit Data</h5>
                                                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                                    </div>
                                                    <div class='modal-body'>
                                                        <input type='hidden' name='id_jadwal' value='" . htmlspecialchars($jadwal['id_jadwal']) . "'>
                                                        <div class='mb-3'>
                                                            <label for='guru' class='form-label'>Guru</label>
                                                            <select id='guru' name='guru' class='form-select'>
                                                                ";

                                        // Query untuk mengambil data guru
                                        $result_guru = $conn->query("SELECT * FROM tenaga_pendidik");
                                        if ($result_guru->num_rows > 0) {
                                            while ($row = $result_guru->fetch_assoc()) {
                                                // Menandai guru yang sudah dipilih
                                                $selected = $jadwal['id_tp'] == $row['id_tp'] ? 'selected' : '';
                                                echo "<option value='" . htmlspecialchars($row['id_tp']) . "' $selected>" . htmlspecialchars($row['nama']) . "</option>";
                                            }
                                        } else {
                                            echo "<option value=''>Tidak ada Data tersedia</option>";
                                        }

                                        echo "
                                                            </select>
                                                        </div>
                                                        <div class='mb-3'>
                                                            <label for='mapel' class='form-label'>Mata Pelajaran</label>
                                                            <select id='mapel' name='mapel' class='form-select'>
                                                                ";

                                        // Query untuk mengambil data mapel
                                        $result_mapel = $conn->query("SELECT * FROM mapel");
                                        if ($result_mapel->num_rows > 0) {
                                            while ($row = $result_mapel->fetch_assoc()) {
                                                // Menandai mapel yang sudah dipilih
                                                $selected = $jadwal['id_mapel'] == $row['id_mapel'] ? 'selected' : '';
                                                echo "<option value='" . htmlspecialchars($row['id_mapel']) . "' $selected>" . htmlspecialchars($row['mapel']) . "</option>";
                                            }
                                        } else {
                                            echo "<option value=''>Tidak ada Data tersedia</option>";
                                        }

                                        echo "
                                                            </select>
                                                        </div>
                                                        <div class='mb-3'>
                                                            <label for='kelas' class='form-label'>Kelas</label>
                                                            <select id='kelas' name='kelas' class='form-select'>
                                                                ";

                                        // Query untuk mengambil data kelas
                                        $result_kelas = $conn->query("SELECT * FROM kelas");
                                        if ($result_kelas->num_rows > 0) {
                                            while ($row = $result_kelas->fetch_assoc()) {
                                                // Menandai kelas yang sudah dipilih
                                                $selected = $jadwal['id_kelas'] == $row['id_kelas'] ? 'selected' : '';
                                                echo "<option value='" . htmlspecialchars($row['id_kelas']) . "' $selected>" . htmlspecialchars($row['kelas']) . "</option>";
                                            }
                                        } else {
                                            echo "<option value=''>Tidak ada Data tersedia</option>";
                                        }

                                        echo "
                                                            </select>
                                                        </div>
                                                        <div class='mb-3'>
                                                            <label for='hari' class='form-label'>Hari</label>
                                                            <select id='hari' name='hari' class='form-select'>
                                                                ";

                                        // Query untuk mengambil data hari
                                        $result_hari = $conn->query("SELECT * FROM hari");
                                        if ($result_hari->num_rows > 0) {
                                            while ($row = $result_hari->fetch_assoc()) {
                                                // Menandai hari yang sudah dipilih
                                                $selected = $jadwal['id_hari'] == $row['id_hari'] ? 'selected' : '';
                                                echo "<option value='" . htmlspecialchars($row['id_hari']) . "' $selected>" . htmlspecialchars($row['hari']) . "</option>";
                                            }
                                        } else {
                                            echo "<option value=''>Tidak ada Data tersedia</option>";
                                        }

                                        echo "
                                                            </select>
                                                        </div>
                                                        <div class='mb-3'>
                                                                <label for='mulai' class='form-label'>Jam Mulai</label>
                                                                <input type='time' class='form-control' name='mulai' value='" . htmlspecialchars($jadwal['jam_mulai']) . "' required>
                                                        </div>
                                                        <div class='mb-3'>
                                                                <label for='selesai' class='form-label'>Jam selesai</label>
                                                                <input type='time' class='form-control' name='selesai' value='" . htmlspecialchars($jadwal['jam_selesai']) . "' required>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class='modal-footer'>
                                                        <button type='submit' class='btn btn-primary'>Update</button>
                                                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>";
                                    }
                                    echo "</tbody></table>";
                                } else {
                                    echo "<p>Tidak ada jadwal mengajar pada hari ini.</p>";
                                }

                                echo "</div></div></div>";
                                $isActive = false;
                            }
                            ?>
                        </div><!-- End Pills Tabs -->


                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include '../components/footer.php'; ?>