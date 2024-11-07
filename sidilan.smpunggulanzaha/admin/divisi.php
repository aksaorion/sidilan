<?php include '../components/header.php';?>
<?php include '../components/admin_navbar.php' ?>
<?php


$id_sekolah = $_SESSION['sekolah'];
include '../model/admin-divisi.php';
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
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahDivisi">
                <i class="bi bi-plus"></i> Tambah Divisi
              </button>
            </div>

            <!-- Modal Tambah Mata Pelajaran -->
            <div class="modal fade" id="modalTambahDivisi" tabindex="-1">
              <div class="modal-dialog modal-dialog-scrollable">
                <form action="../proses/admin-divisi.php?act=tambah-divisi" method="post">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Tambah Divisi</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="mb-3">
                        <label for="divisi" class="form-label">Nama Divisi</label>
                        <input type="hidden" name="id_sekolah" value="<?= htmlspecialchars($id_sekolah) ?>">
                        <input type="text" class="form-control" id="divisi" name="divisi" required>
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
                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Data Divisi</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-input-tab" data-bs-toggle="pill" data-bs-target="#pills-input" type="button" role="tab" aria-controls="pills-input" aria-selected="false">Struktur Divisi</button>
              </li>


            </ul>
            <div class="tab-content pt-2" id="myTabContent">
              <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="home-tab">
                <div class="card">
                  <div class="card-body">

                    <?php


                    // Query untuk mengambil data dari tabel divisi
                    $query = "SELECT * FROM divisi ";
                    $result = $conn->query($query);

                    if (!$result) {
                      die("Query Error: " . $conn->error);
                    }
                    ?>

                    <!-- Table with stripped rows -->
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th scope="col">No</th>
                          <th scope="col">Nama Divisi</th>
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
                          echo "<td>" . htmlspecialchars($row['divisi']) . "</td>";

                          echo "<td>
                                        <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#editModal" . $row['id_divisi'] . "'>
                                        Edit
                                        </button>
                                         <form action='../proses/admin-divisi.php?act=delete-divisi' method='post' style='display:inline-block;'>
                                            <input type='hidden' name='id_divisi' value='" . $row['id_divisi'] . "'>
                                            <button type='submit' class='btn btn-danger' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>
                                            Hapus
                                            </button>
                                        </form>
                                    </td>";
                          echo "</tr>";

                          // Modal for editing
                          echo "
                                <div class='modal fade' id='editModal" . $row['id_divisi'] . "' tabindex='-1' aria-labelledby='editModalLabel" . $row['id_divisi'] . "' aria-hidden='true'>
                                <div class='modal-dialog modal-dialog-scrollable'>
                                    <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='editModalLabel" . $row['id_divisi'] . "'>Edit Data</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                    </div>
                                    <div class='modal-body'>
                                        <form action='../proses/admin-divisi.php?act=update-divisi' method='post'>
                                        <input type='hidden' name='id_divisi' value='" . $row['id_divisi'] . "'>
                                        <div class='mb-3'>
                                            <label for='divisi' class='form-label'>divisi</label>
                                            <input type='text' class='form-control' name='divisi' value='" . htmlspecialchars($row['divisi']) . "' required>
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


                    // Query untuk mengambil data dari tabel divisi
                    $query = "SELECT 
                                              kepegawaian.*, 
                                              divisi.divisi, 
                                              role_divisi.role_divisi, 
                                              tenaga_pendidik.nama 
                                          FROM 
                                              kepegawaian
                                          JOIN 
                                              divisi ON kepegawaian.id_divisi = divisi.id_divisi
                                          JOIN 
                                              role_divisi ON kepegawaian.id_roledivisi = role_divisi.id_roledivisi
                                          JOIN 
                                              tenaga_pendidik ON kepegawaian.id_tp = tenaga_pendidik.id_tp
                                         
                                          ORDER BY 
                                              divisi.divisi ASC, 
                                              role_divisi.id_roledivisi ASC;
                                          ";

                    $result = $conn->query($query);

                    if (!$result) {
                      die("Query Error: " . $conn->error);
                    }
                    ?>

                    <!-- Table with stripped rows -->
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th scope="col">No</th>
                          <th scope="col">Nama Divisi</th>
                          <th scope="col">Tenaga Pendidik</th>
                          <th scope="col">Jabatan</th>
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
                          echo "<td>" . htmlspecialchars($row['divisi']) . "</td>";
                          echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                          echo "<td>" . htmlspecialchars($row['role_divisi']) . "</td>";
                          echo "<td>
                                        <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#editModal" . $row['id_kepegawaian'] . "'>
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

                          // Modal untuk edit data
                          echo "
                                    <div class='modal fade' id='editModal" . $row['id_kepegawaian'] . "' tabindex='-1' aria-labelledby='editModalLabel" . $row['id_kepegawaian'] . "' aria-hidden='true'>
                                        <div class='modal-dialog modal-dialog-scrollable'>
                                            <form action='../proses/admin-jadwal-mengajar.php?act=update-jadwal' method='post'>
                                                <div class='modal-content'>
                                                    <div class='modal-header'>
                                                        <h5 class='modal-title' id='editModalLabel" . $row['id_kepegawaian'] . "'>Edit Data</h5>
                                                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                                    </div>
                                                    <div class='modal-body'>
                                                        <input type='hidden' name='id_kepegawaian' value='" . htmlspecialchars($row['id_kepegawaian']) . "'>
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
                                                        <div class='mb-3'>
                                                            <label for='divisi' class='form-label'>Divisi</label>
                                                            <select id='divisi' name='divisi' class='form-select'>
                                                                ";

                          // Query untuk mengambil data mapel
                          $result_divisi = $conn->query("SELECT * FROM divisi");
                          if ($result_divisi->num_rows > 0) {
                            while ($div = $result_divisi->fetch_assoc()) {
                              // Menandai divisi yang sudah dipilih
                              $selected = $row['id_divisi'] == $div['id_divisi'] ? 'selected' : '';
                              echo "<option value='" . htmlspecialchars($div['id_divisi']) . "' $selected>" . htmlspecialchars($div['divisi']) . "</option>";
                            }
                          } else {
                            echo "<option value=''>Tidak ada Data tersedia</option>";
                          }

                          echo "
                                                            </select>
                                                        </div>
                                                        <div class='mb-3'>
                                                            <label for='roledivisi' class='form-label'>Jabatan</label>
                                                            <select id='roledivisi' name='roledivisi' class='form-select'>
                                                                ";

                          // Query untuk mengambil data roledivisi
                          $result_roledivisi = $conn->query("SELECT * FROM role_divisi");
                          if ($result_roledivisi->num_rows > 0) {
                            while ($role = $result_roledivisi->fetch_assoc()) {
                              // Menandai roledivisi yang sudah dipilih
                              $selected = $row['id_roledivisi'] == $role['id_roledivisi'] ? 'selected' : '';
                              echo "<option value='" . htmlspecialchars($role['id_roledivisi']) . "' $selected>" . htmlspecialchars($role['role_divisi']) . "</option>";
                            }
                          } else {
                            echo "<option value=''>Tidak ada Data tersedia</option>";
                          }

                          echo "
                                                            </select>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    // Fetch kota saat provinsi berubah
    $('#provinsi').change(function() {
      var id_provinsi = $(this).val(); // Ambil ID provinsi yang dipilih

      if (id_provinsi) {
        $.ajax({
          url: '../proses/get_kota.php',
          type: 'GET',
          data: {
            id_provinsi: id_provinsi
          },
          success: function(data) {
            $('#kota').html(data); // Masukkan hasil data ke select kota
            $('#kecamatan').html('<option value="">Choose...</option>'); // Reset kecamatan
          },
          error: function() {
            alert('Gagal mengambil data kota');
          }
        });
      } else {
        $('#kota').html('<option value="">Choose...</option>'); // Reset kota jika provinsi tidak dipilih
        $('#kecamatan').html('<option value="">Choose...</option>'); // Reset kecamatan
      }
    });

    // Fetch kecamatan saat kota berubah
    $('#kota').change(function() {
      var id_kota = $(this).val(); // Ambil ID kota yang dipilih

      if (id_kota) {
        $.ajax({
          url: '../proses/get_kecamatan.php',
          type: 'GET',
          data: {
            id_kota: id_kota
          },
          success: function(data) {
            $('#kecamatan').html(data); // Masukkan hasil data ke select kecamatan
          },
          error: function() {
            alert('Gagal mengambil data kecamatan');
          }
        });
      } else {
        $('#kecamatan').html('<option value="">Choose...</option>'); // Reset kecamatan jika kota tidak dipilih
      }
    });
  });
</script>
<?php include '../components/footer.php' ?>