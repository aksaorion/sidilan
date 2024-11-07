<?php include '../components/header.php' ?>
<?php include '../components/admin_navbar.php' ?>
<?php

// Query untuk mengambil data provinsi

$id_sekolah = $_SESSION['sekolah'];
include '../model/admin-jabatan.php';

?>
<main id="main" class="main">
  <div class="pagetitle">

  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">



        <div class="card">
          <div class="card-body">
            <br>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahjabatan">
                <i class="bi bi-plus"></i> Tambah Jabatan
              </button>
            </div>

            <!-- Modal Tambah Mata Pelajaran -->
            <div class="modal fade" id="modalTambahjabatan" tabindex="-1">
              <div class="modal-dialog modal-dialog-scrollable">
                <form action="../proses/admin-jabatan.php?act=tambah-jabatan" method="post">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Tambah jabatan</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="mb-3">
                        <label for="jabatan" class="form-label">Nama jabatan</label>
                        <input type="hidden" name="id_sekolah" value="<?= htmlspecialchars($id_sekolah) ?>">
                        <input type="text" class="form-control" id="jabatan" name="jabatan" required>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <!-- End Modal Tambah Mata Pelajaran -->

            <!-- Pills Tabs -->
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Data Jabatan</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-input-tab" data-bs-toggle="pill" data-bs-target="#pills-input" type="button" role="tab" aria-controls="pills-input" aria-selected="false">Struktur Jabatan</button>
              </li>


            </ul>
            <div class="tab-content pt-2" id="myTabContent">
              <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="home-tab">
                <div class="card">
                  <div class="card-body">



                    <!-- Table with stripped rows -->
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th scope="col">No</th>
                          <th scope="col">Nama Jabatan</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>

                        <?php
                        // Mengambil data dan menampilkan ke dalam tabel
                        $no = 1;
                        while ($row = $result->fetch_assoc()) {
                          echo "<tr>";
                          echo "<td>" . $no++ . "</td>";
                          echo "<td>" . htmlspecialchars($row['jabatan']) . "</td>";

                          echo "<td>
                                        <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#editModal" . $row['id_jabatan'] . "'>
                                        Edit
                                        </button>
                                         <form action='../proses/admin-jabatan.php?act=delete-jabatan' method='post' style='display:inline-block;'>
                                            <input type='hidden' name='id_jabatan' value='" . $row['id_jabatan'] . "'>
                                            <button type='submit' class='btn btn-danger' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>
                                            Hapus
                                            </button>
                                        </form>
                                    </td>";
                          echo "</tr>";

                          // Modal for editing
                          echo "
                                <div class='modal fade' id='editModal" . $row['id_jabatan'] . "' tabindex='-1' aria-labelledby='editModalLabel" . $row['id_jabatan'] . "' aria-hidden='true'>
                                <div class='modal-dialog modal-dialog-scrollable'>
                                    <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='editModalLabel" . $row['id_jabatan'] . "'>Edit Data</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                    </div>
                                    <div class='modal-body'>
                                        <form action='../proses/admin-jabatan.php?act=update-jabatan' method='post'>
                                        <input type='hidden' name='id_jabatan' value='" . $row['id_jabatan'] . "'>
                                        <div class='mb-3'>
                                            <label for='jabatan' class='form-label'>jabatan</label>
                                            <input type='text' class='form-control' name='jabatan' value='" . htmlspecialchars($row['jabatan']) . "' required>
                                        </div>
                                        
                                        
                                       
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='submit' class='btn btn-primary'>Simpan Perubahan</button>
                                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                    </div>
                                    </div>
                                     </form>
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

              <div class="tab-pane fade" id="pills-input" role="tabpanel" aria-labelledby="input-tab">

                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Tabel Data Kepegawaian</h5>
                    <?php


                    ?>

                    <!-- Table with stripped rows -->
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th scope="col">No</th>
                          <th scope="col">Nama Jabatan</th>
                          <th scope="col">Tenaga Pendidik</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        // Mengambil data dan menampilkan ke dalam tabel
                        $no = 1;
                        while ($row = $result_kepegawaian->fetch_assoc()) {
                          echo "<tr>";
                          echo "<td>" . $no++ . "</td>";
                          echo "<td>" . htmlspecialchars($row['jabatan']) . "</td>";
                          echo "<td>" . htmlspecialchars($row['nama']) . "</td>";

                          echo "<td>
                                        <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#editjab" . $row['id_kepegawaian'] . "'>
                                        Edit
                                        </button>
                                        <form action='../proses/admin-jadwal-mengajar.php?act=delete-jadwal' method='post' style='display:inline-block;'>
                                            <input type='hidden' name='id_kepegawaian' value='" . $row['id_kepegawaian'] . "'>
                                            <button type='submit' class='btn btn-danger' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>
                                            Hapus
                                            </button>
                                        </form>
                                    </td>";
                          echo "</tr>";

                          // Modal for editing
                          echo "
                                <div class='modal fade' id='editjab" . $row['id_kepegawaian'] . "' tabindex='-1' aria-labelledby='editjabLabel" . $row['id_kepegawaian'] . "' aria-hidden='true'>
                                <div class='modal-dialog modal-dialog-scrollable'>
                                    <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='editjabLabel" . $row['id_kepegawaian'] . "'>Edit Data</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                    </div>
                                    <div class='modal-body'>
                                        <form action='../proses/admin-jabatan.php?act=update-jabatan' method='post'>
                                        <input type='hidden' name='id_kepegawaian' value='" . $row['id_kepegawaian'] . "'>
                                        <div class='mb-3'>
                                                            <label for='jabatan' class='form-label'>jabatan</label>
                                                            <select id='jabatan' name='jabatan' class='form-select'>
                                                                ";

                          // Query untuk mengambil data jabatan
                          $result_jabatan = $conn->query("SELECT * FROM jabatan");
                          if ($result_jabatan->num_rows > 0) {
                            while ($tp = $result_jabatan->fetch_assoc()) {
                              // Menandai jabatan yang sudah dipilih
                              $selected = $row['id_jabatan'] == $tp['id_jabatan'] ? 'selected' : '';
                              echo "<option value='" . htmlspecialchars($tp['id_jabatan']) . "' $selected>" . htmlspecialchars($tp['jabatan']) . "</option>";
                            }
                          } else {
                            echo "<option value=''>Tidak ada Data tersedia</option>";
                          }

                          echo "
                                                            </select>
                                                        </div>
                                        <div class='mb-3'>
                                                            <label for='guru' class='form-label'>Guru</label>
                                                            <select id='guru' name='guru' class='form-select'>
                                                                ";

                          // Query untuk mengambil data guru
                          $result_guru = $conn->query("SELECT * FROM tenaga_pendidik");
                          if ($result_guru->num_rows > 0) {
                            while ($tp = $result_guru->fetch_assoc()) {
                              // Menandai guru yang sudah dipilih
                              $selected = $row['id_tp'] == $tp['id_tp'] ? 'selected' : '';
                              echo "<option value='" . htmlspecialchars($tp['id_tp']) . "' $selected>" . htmlspecialchars($tp['nama']) . "</option>";
                            }
                          } else {
                            echo "<option value=''>Tidak ada Data tersedia</option>";
                          }

                          echo "
                                                            </select>
                                                        </div>
                                        
                                       
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='submit' class='btn btn-primary'>Simpan Perubahan</button>
                                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                    </div>
                                    </div>
                                     </form>
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


          </div><!-- End Pills Tabs -->

        </div>
      </div>

    </div>



    </div>
  </section>



</main>

<?php include '../components/footer.php' ?>