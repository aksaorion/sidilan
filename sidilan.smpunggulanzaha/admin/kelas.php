<?php include '../components/header.php'; ?>
<?php include '../components/admin_navbar.php'; ?>
<?php
$query_kelas_induk = "SELECT * FROM kelas_induk";
$result_kelas_induk = $conn->query($query_kelas_induk);

$id_sekolah = $_SESSION['sekolah'];
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
            <br>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahKelas"><i class="bi bi-plus"></i> Tambah Kelas</button>
            </div>

            <br>
            <div class="modal fade" id="modalTambahKelas" tabindex="-1">
              <div class="modal-dialog modal-dialog-scrollable">
                <form action="../proses/admin-kelas.php?act=tambah-kelas" method="post">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Tambah Kelas</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="mb-3">
                        <label for="kelas" class="form-label">Nama Kelas</label>
                        <input type="hidden" name="id_sekolah" value="<?= $id_sekolah ?>">
                        <input type="text" class="form-control" id="kelas" name="kelas">
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
              // Ambil data kelas dari database
              $kelasResult = $conn->query("SELECT id_kelas, kelas FROM kelas");
              $isActive = true;

              while ($kelas = $kelasResult->fetch_assoc()) {
                $activeClass = $isActive ? 'active' : '';
                echo "
                            <li class='nav-item' role='presentation'>
                                <button class='nav-link $activeClass' id='pills-{$kelas['id_kelas']}-tab' data-bs-toggle='pill' data-bs-target='#pills-{$kelas['id_kelas']}' type='button' role='tab' aria-controls='pills-{$kelas['id_kelas']}' aria-selected='$isActive'>{$kelas['kelas']}</button>
                            </li>";
                $isActive = false; // Set isActive to false after the first tab
              }
              ?>
            </ul>

            <div class="tab-content pt-2" id="pills-tabContent">
              <?php
              $kelasResult->data_seek(0); // Reset the pointer to the beginning of the result set
              $isActive = true;

              while ($kelas = $kelasResult->fetch_assoc()) {
                $activeClass = $isActive ? 'show active' : '';
                echo "<div class='tab-pane fade $activeClass' id='pills-{$kelas['id_kelas']}' role='tabpanel' aria-labelledby='pills-{$kelas['id_kelas']}-tab'>";
                echo "<div class='card'><div class='card-body'>";
                echo "<h5 class='card-title'>Siswa di Kelas {$kelas['kelas']}</h5>";

                // Ambil data siswa berdasarkan id_kelas
                $siswaResult = $conn->query("SELECT nama, nisn FROM siswa WHERE id_kelas = {$kelas['id_kelas']}");

                if ($siswaResult->num_rows > 0) {
                  echo "<table class='table table-striped'>";
                  echo "<thead><tr><th>No</th><th>Nama Siswa</th><th>NISN</th><th>Action</th></tr></thead>";
                  echo "<tbody>";
                  $no = 1;
                  while ($siswa = $siswaResult->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . htmlspecialchars($siswa['nama']) . "</td>";
                    echo "<td>" . htmlspecialchars($siswa['nisn']) . "</td>";

                    // Tombol Detail
                    echo "<td><a href='detail_siswa.php?nisn=" . htmlspecialchars($siswa['nisn']) . "' class='btn btn-primary btn-sm'>Detail</a>";

                    // Tombol Hapus
                    echo " <a href='hapus_siswa.php?nisn=" . htmlspecialchars($siswa['nisn']) . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus siswa ini?\")'>Hapus</a></td>";
                    echo "</tr>";
                  }

                  echo "</tbody></table>";
                } else {
                  echo "<p>Tidak ada siswa di kelas ini.</p>";
                }

                echo "</div></div></div>";
                $isActive = false; // Set isActive to false after the first content
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