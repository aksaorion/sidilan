<?php include '../components/header.php'; ?>
<?php include '../components/admin_navbar.php'; ?>
<?php
// Ambil id_tp dari URL

// Pastikan $id_tp adalah integer
$id_tp = isset($_GET['pendidik']) ? intval($_GET['pendidik']) : 0;
include '../model/admin-tenagapendidik.php';

?>
<main id="main" class="main">
    <div class="pagetitle"></div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Data Tenaga Pendidik</h5>

                        <!-- Vertical Form -->
                        <form class="row g-3" action="../proses/admin_tenagapendidik.php?act=update-tenagapendidik" method="post">
                            <input type="hidden" name="id_tp" id="id_tp" value="<?= $id_tp ?>">
                            <div class="col-12">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($data_tp['nama']); ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="<?= htmlspecialchars($data_tp['tempat_lahir']); ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" value="<?= htmlspecialchars($data_tp['tgl_lahir']); ?>">
                            </div>
                            <div class="col-6">
                                <label for="gelar" class="form-label">Gelar</label>
                                <input type="text" class="form-control" id="gelar" name="gelar" value="<?= htmlspecialchars($data_tp['gelar']); ?>">
                            </div>
                            <div class="col-6">
                                <label for="role" class="form-label">Role Akun</label>
                                <select id="role" name="role" class="form-select">
                                    <option value="Guru" <?= $data_tp['role'] == 'Guru' ? 'selected' : ''; ?>>Guru</option>
                                    <option value="Karyawan" <?= $data_tp['role'] == 'Karyawan' ? 'selected' : ''; ?>>Karyawan</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="jenis_identitas" class="form-label">Jenis Identitas</label>
                                <select id="jenis_identitas" name="jenis_identitas" class="form-select">
                                    <option value="ktp" <?= $data_tp['jenis_identitas'] == 'ktp' ? 'selected' : ''; ?>>KTP</option>
                                    <option value="sim" <?= $data_tp['jenis_identitas'] == 'sim' ? 'selected' : ''; ?>>SIM</option>
                                </select>
                            </div>
                            <div class="col-md-9">
                                <label for="no_identitas" class="form-label">No Identitas</label>
                                <input type="text" class="form-control" id="no_identitas" name="no_identitas" value="<?= htmlspecialchars($data_tp['no_identitas']); ?>">
                            </div>
                            <div class="col-md-12">
                                <label for="jk" class="form-label">Jenis Kelamin</label>
                                <select id="jk" name="jk" class="form-select">
                                    <option value="L" <?= $data_tp['jk'] == 'L' ? 'selected' : ''; ?>>Laki-laki</option>
                                    <option value="P" <?= $data_tp['jk'] == 'P' ? 'selected' : ''; ?>>Perempuan</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="telepon" class="form-label">Telepon</label>
                                <input type="text" class="form-control" id="telepon" name="telepon" value="<?= htmlspecialchars($data_tp['telepon']); ?>">
                            </div>
                            <div class="col-md-12">
                                <label for="agama" class="form-label">Agama</label>
                                <select id="agama" name="agama" class="form-select">
                                    <?php
                                    if ($result_agama->num_rows > 0) {
                                        while ($row = $result_agama->fetch_assoc()) {
                                            $selected = $row['agama'] == $data_tp['agama'] ? 'selected' : '';
                                            echo '<option value="' . htmlspecialchars($row['agama']) . '" ' . $selected . '>' . htmlspecialchars($row['agama']) . '</option>';
                                        }
                                    } else {
                                        echo '<option value="">Tidak ada Data tersedia</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat" value="<?= htmlspecialchars($data_tp['alamat']); ?>">
                            </div>
                            <div class="col-md-4">
                                <label for="provinsi" class="form-label">Provinsi</label>
                                <input type="text" class="form-control" id="provinsi" name="provinsi" value="<?= htmlspecialchars($data_tp['provinsi']); ?>">
                            </div>
                            <div class="col-md-4">
                                <label for="kota" class="form-label">Kota</label>
                                <input type="text" class="form-control" id="kota" name="kota" value="<?= htmlspecialchars($data_tp['kota']); ?>">
                            </div>
                            <div class="col-md-4">
                                <label for="kecamatan" class="form-label">Kecamatan</label>
                                <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="<?= htmlspecialchars($data_tp['kecamatan']); ?>">
                            </div>

                            <br>
                            <h5 class="card-title">Riwayat Pendidikan</h5>
                            <br>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="jenjang" class="form-label">Jenjang</label>
                                    <select id="jenjang" name="jenjang" class="form-select">
                                        <option value="" disabled>Pilih Jenjang Pendidikan</option>
                                        <?php
                                        // Check if there are results in the $result_jenjang
                                        if ($result_jenjang->num_rows > 0) {
                                            while ($row = $result_jenjang->fetch_assoc()) {
                                                // Determine if the current option should be selected
                                                $selected = $row['jenjang_sekolah'] == $data_riwayat['jenjang'] ? 'selected' : '';
                                                echo '<option value="' . htmlspecialchars($row['jenjang_sekolah']) . '" ' . $selected . '>' . htmlspecialchars($row['jenjang_sekolah']) . '</option>';
                                            }
                                        } else {
                                            echo '<option value="" disabled>Tidak ada Data tersedia</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="tahun" class="form-label">Tahun Lulus</label>
                                    <input type="number" class="form-control" id="tahun" name="tahun" value="<?= htmlspecialchars($data_riwayat['tahun']); ?>">
                                </div>

                                <div class="col-md-6">
                                    <label for="institusi" class="form-label">Nama Institusi</label>
                                    <input type="text" class="form-control" id="institusi" name="institusi" value="<?= htmlspecialchars($data_riwayat['institusi']); ?>">
                                </div>

                                <div class="col-md-6">
                                    <label for="jurusan" class="form-label">Jurusan</label>
                                    <input type="text" class="form-control" id="jurusan" name="jurusan" value="<?= htmlspecialchars($data_riwayat['jurusan']); ?>">
                                </div>
                            </div>

                            <br>
                            <h5 class="card-title">Kepegawaian</h5>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="nip" class="form-label">Nomor Induk Pendidik</label>
                                    <input type="text" class="form-control" id="nip" name="nip" value="<?= htmlspecialchars($data_kepegawaian['nip']); ?>">
                                </div>

                                <div class="col-md-6">
                                    <label for="jabatan" class="form-label">Jabatan</label>
                                    <select id="jabatan" name="jabatan" class="form-select">
                                        <?php
                                        // Jika ada hasil, tampilkan opsi
                                        if ($result_jabatan->num_rows > 0) {
                                            while ($row = $result_jabatan->fetch_assoc()) {
                                                $selected = $row['id_jabatan'] == $data_kepegawaian['id_jabatan'] ? 'selected' : '';
                                                echo '<option value="' . htmlspecialchars($row['id_jabatan']) . '" ' . $selected . '>' . htmlspecialchars($row['jabatan']) . '</option>';
                                            }
                                        } else {
                                            echo '<option value="" disabled>Tidak ada Data tersedia</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="divisi" class="form-label">Divisi</label>
                                    <select id="divisi" name="divisi" class="form-select">
                                        <?php
                                        // Jika ada hasil, tampilkan opsi
                                        if ($result_divisi->num_rows > 0) {
                                            while ($row = $result_divisi->fetch_assoc()) {
                                                $selected = $row['id_divisi'] == $data_kepegawaian['id_divisi'] ? 'selected' : '';
                                                echo '<option value="' . htmlspecialchars($row['id_divisi']) . '" ' . $selected . '>' . htmlspecialchars($row['divisi']) . '</option>';
                                            }
                                        } else {
                                            echo '<option value="" disabled>Tidak ada Data tersedia</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="role_divisi" class="form-label">Role Divisi</label>
                                    <select id="role_divisi" name="role_divisi" class="form-select">
                                        <?php
                                        // Jika ada hasil, tampilkan opsi
                                        if ($result_roledivisi->num_rows > 0) {
                                            while ($row = $result_roledivisi->fetch_assoc()) {
                                                $selected = $row['id_roledivisi'] == $data_kepegawaian['id_roledivisi'] ? 'selected' : '';
                                                echo '<option value="' . htmlspecialchars($row['id_roledivisi']) . '" ' . $selected . '>' . htmlspecialchars($row['role_divisi']) . '</option>';
                                            }
                                        } else {
                                            echo '<option value="" disabled>Tidak ada Data tersedia</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="status" class="form-label">Status</label>
                                    <select id="status" name="status" class="form-select">
                                        <option value="Honorer" <?= $data_kepegawaian['status'] == 'Honorer' ? 'selected' : ''; ?>>Honorer</option>
                                        <option value="Tetap" <?= $data_kepegawaian['status'] == 'Tetap' ? 'selected' : ''; ?>>Tetap</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="tgl_mulai" class="form-label">Tanggal Mulai Kerja</label>
                                    <input type="date" class="form-control" id="tgl_mulai" name="tgl_mulai" value="<?= htmlspecialchars($data_kepegawaian['tgl_mulai']); ?>">
                                </div>
                            </div>

                            <br>
                            <h5 class="card-title">Akun Mobile</h5>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($data_tp['email']); ?>">
                                </div>

                                <div class="col-md-6">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" value="<?= htmlspecialchars($data_tp['pass']); ?>">
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="button" onclick="window.location.href='../admin/tenaga-pendidik' " class="btn btn-secondary">Kembali</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include '../components/footer.php'; ?>