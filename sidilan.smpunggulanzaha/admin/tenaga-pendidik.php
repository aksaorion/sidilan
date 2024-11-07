<?php include '../components/header.php' ?>
<?php include '../components/admin_navbar.php' ?>
<?php



// Query untuk mengambil data jenjang
$q_jenjang = "SELECT DISTINCT jenjang_sekolah FROM jenjang_sekolah";
$result_jenjang = $conn->query($q_jenjang);

$query_divisi = "SELECT * FROM divisi";
$result_divisi = $conn->query($query_divisi);

$query_jabatan = "SELECT * FROM jabatan";
$result_jabatan = $conn->query($query_jabatan);

$query_roledivisi = "SELECT * FROM role_divisi";
$result_roledivisi = $conn->query($query_roledivisi);

$query_agama = "SELECT * FROM agama";
$result_agama = $conn->query($query_agama);
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

            <!-- Pills Tabs -->
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Data Tenaga Pendidik</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-input-tab" data-bs-toggle="pill" data-bs-target="#pills-input" type="button" role="tab" aria-controls="pills-input" aria-selected="false">Tambah Tenaga Pendidik</button>
              </li>


            </ul>
            <div class="tab-content pt-2" id="myTabContent">
              <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="home-tab">
                <div class="card">
                  <div class="card-body">

                    <?php


                    // Query untuk mengambil data dari tabel divisi
                    $query = "SELECT * FROM tenaga_pendidik";
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
                          <th scope="col">Nama</th>
                          <th scope="col">Email</th>
                          <th scope="col">Telepon</th>
                          <th scope="col">Alamat</th>
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
                          echo "<td>" . htmlspecialchars($row['nama'] . ' ' . $row['gelar']) . "</td>";
                          echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                          echo "<td>" . htmlspecialchars($row['telepon']) . "</td>";
                          echo "<td>" . htmlspecialchars($row['alamat']) . "</td>";
                          echo "<td>
                                <button type='button' class='btn btn-primary' onclick=\"window.location.href='edit-tenagapendidik?pendidik=" . $row['id_tp'] . "'\">
                                    Edit/Detail
                                </button>
                                 </button>
                                         <form action='../proses/admin_tenagapendidik.php?act=delete-tenagapendidik' method='post' style='display:inline-block;'>
                                            <input type='hidden' name='id_tp' value='" . $row['id_tp'] . "'>
                                            <button type='submit' class='btn btn-danger' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>
                                            Hapus
                                            </button>
                                        </form>
                              </td>";
                          echo "</tr>";


                          // Modal for editing

                        }
                        ?>

                      </tbody>
                    </table>
                    <!-- End Table with stripped rows -->

                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="pills-input" role="tabpanel" aria-labelledby="input-tab">
                <?php $id_sekolah = $_SESSION['sekolah']; ?>
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Data Tenaga Pendidik</h5>

                    <!-- Vertical Form -->
                    <form class="row g-3" action="../proses/admin_tenagapendidik.php?act=tambah-tenagapendidik" method="post">
                      <div class="col-12">
                        <input type="hidden" name="id_sekolah" id="id_sekolah" value="<?= $id_sekolah ?>">
                        <label for="inputNanme4" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama" name="nama">
                      </div>
                      <div class="col-md-6">
                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir">
                      </div>
                      <div class="col-md-6">
                        <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir">
                      </div>
                      <div class="col-6">
                        <label for="gelar" class="form-label">Gelar</label>
                        <input type="gelar" class="form-control" id="gelar" name="gelar">
                      </div>
                      <div class="col-6">
                        <label for="role" class="form-label">Role Akun</label>
                        <select id="role" name="role" class="form-select">
                          <option selected>Pilih Role</option>
                          <option value="Guru">Guru</option>
                          <option value="Karyawan">Karyawan</option>
                        </select>
                      </div>
                      <div class="col-md-3">
                        <label for="jenis_identitas" class="form-label">Jenis Identitas</label>
                        <select id="jenis_identitas" name="jenis_identitas" class="form-select">
                          <option selected>Pilih Identitas</option>
                          <option value="ktp">KTP</option>
                          <option value="sim">SIM</option>
                        </select>
                      </div>
                      <div class="col-md-9">
                        <label for="no_identitas" class="form-label">No Identitas</label>
                        <input type="text" class="form-control" id="no_identitas" name="no_identitas">
                      </div>
                      <div class="col-md-12">
                        <label for="jk" class="form-label">Jenis Kelamin</label>
                        <select id="jk" name="jk" class="form-select">
                          <option selected>Pilih Jenis Kelamin</option>
                          <option value="L">Laki-laki</option>
                          <option value="P">Perempuan</option>
                        </select>
                      </div>
                      <div class="col-12">
                        <label for="telepon" class="form-label">Telepon</label>
                        <input type="text" class="form-control" id="telepon" name="telepon">
                      </div>
                      <div class="col-md-12">
                        <label for="agama" class="form-label">Agama</label>
                        <select id="agama" name="agama" class="form-select">
                          <option selected>Pilih Agama</option>
                          <?php
                          // Jika ada hasil, tampilkan opsi

                          if ($result_agama->num_rows > 0) {
                            while ($row = $result_agama->fetch_assoc()) {
                              echo '<option value="' . htmlspecialchars($row['agama']) . '">' . htmlspecialchars($row['agama']) . '</option>';
                            }
                          } else {
                            echo '<option value="">Tidak ada Data tersedia</option>';
                          }

                          ?>
                        </select>
                      </div>
                      <div class="col-12">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" placeholder="1234 Main St">
                      </div>


                      <div class="col-md-4">
                        <label for="provinsi" class="form-label">Provinsi</label>
                        <input type="text" class="form-control" id="provinsi" name="provinsi">
                      </div>

                      <div class="col-md-4">
                        <label for="kota" class="form-label">Kota</label>
                        <input type="text" class="form-control" id="kota" name="kota">
                      </div>
                      <div class="col-md-4">
                        <label for="kecamatan" class="form-label">Kecamatan</label>
                        <input type="text" class="form-control" id="kecamatan" name="kecamatan">
                      </div>
                      <br>
                      <h5 class="card-title">Riwayat Pendidikan</h5>
                      <br>

                      <div class="col-md-6">
                        <label for="jenjang" class="form-label">Jenjang</label>
                        <select id="jenjang" name="jenjang" class="form-select">
                          <option selected>Pilih Jenjang Pendidikan</option>
                          <?php
                          // Jika ada hasil, tampilkan opsi

                          if ($result_jenjang->num_rows > 0) {
                            while ($row = $result_jenjang->fetch_assoc()) {
                              echo '<option value="' . htmlspecialchars($row['jenjang_sekolah']) . '">' . htmlspecialchars($row['jenjang_sekolah']) . '</option>';
                            }
                          } else {
                            echo '<option value="">Tidak ada Data tersedia</option>';
                          }

                          ?>




                        </select>
                      </div>
                      <div class="col-6">
                        <label for="tahun" class="form-label">Tahun Lulus</label>
                        <input type="number" class="form-control" id="tahun" name="tahun" placeholder="">
                      </div>
                      <div class="col-6">
                        <label for="institusi" class="form-label">Nama Institusi</label>
                        <input type="text" class="form-control" id="institusi" name="institusi">
                      </div>
                      <div class="col-6">
                        <label for="jurusan" class="form-label">Jurusan</label>
                        <input type="text" class="form-control" id="jurusan" name="jurusan">
                      </div>
                      <br>
                      <h5 class="card-title">Kepegawaian</h5>

                      <div class="col-12">
                        <label for="nip" class="form-label">Nomor Induk Pendidik</label>
                        <input type="text" class="form-control" id="nip" name="nip">
                      </div>
                      <div class="col-12">
                        <label for="jabatan" class="form6label">Jabatan</label>
                        <select id="jabatan" name="jabatan" class="form-select">
                          <option selected>Pilih Jabatan</option>
                          <?php
                          // Jika ada hasil, tampilkan opsi

                          if ($result_jabatan->num_rows > 0) {
                            while ($row = $result_jabatan->fetch_assoc()) {
                              echo '<option value="' . htmlspecialchars($row['id_jabatan']) . '">' . htmlspecialchars($row['jabatan']) . '</option>';
                            }
                          } else {
                            echo '<option value="">Tidak ada Data tersedia</option>';
                          }

                          ?>

                        </select>
                      </div>
                      <div class="col-md-6">
                        <label for="divisi" class="form6label">Divisi</label>
                        <select id="divisi" name="divisi" class="form-select">
                          <option selected>Pilih Divisi</option>
                          <?php
                          // Jika ada hasil, tampilkan opsi

                          if ($result_divisi->num_rows > 0) {
                            while ($row = $result_divisi->fetch_assoc()) {
                              echo '<option value="' . htmlspecialchars($row['id_divisi']) . '">' . htmlspecialchars($row['divisi']) . '</option>';
                            }
                          } else {
                            echo '<option value="">Tidak ada Data tersedia</option>';
                          }

                          ?>
                        </select>
                      </div>
                      <div class="col-md-6">
                        <label for="role_divisi" class="form6label">Role Divisi</label>
                        <select id="role_divisi" name="role_divisi" class="form-select">
                          <option selected>Pilih Role Divisi</option>
                          <?php
                          // Jika ada hasil, tampilkan opsi

                          if ($result_roledivisi->num_rows > 0) {
                            while ($row = $result_roledivisi->fetch_assoc()) {
                              echo '<option value="' . htmlspecialchars($row['id_roledivisi']) . '">' . htmlspecialchars($row['role_divisi']) . '</option>';
                            }
                          } else {
                            echo '<option value="">Tidak ada Data tersedia</option>';
                          }

                          ?>
                        </select>
                      </div>
                      <div class="col-md-6">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" class="form-select">
                          <option selected>Choose...</option>
                          <option value="Honorer">Honorer</option>
                          <option value="Tetap">Tetap</option>

                        </select>
                      </div>
                      <div class="col-6">
                        <label for="tgl_mulai" class="form-label">Tanggal Mulai Kerja</label>
                        <input type="date" class="form-control" id="tgl_mulai" name="tgl_mulai">
                      </div>

                      <br>
                      <h5 class="card-title">Akun Mobile</h5>
                      <div class="col-12">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                      </div>
                      <div class="col-12">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                      </div>

                      <div class="text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                      </div>
                  </div>

                  </form><!-- Vertical Form -->

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