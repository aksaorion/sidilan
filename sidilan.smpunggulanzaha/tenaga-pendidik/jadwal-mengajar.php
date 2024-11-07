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
            <h5 class="card-title">Jadwal Mengajar</h5>

            <!-- Table with stripped rows -->
            <div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th>Hari</th>
                <th>Mapel</th>
                <th>Kelas</th>
                <th>Jam Mulai</th>
                <th>Jam Selesai</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT * 
                      FROM jadwal_mengajar
                      JOIN tenaga_pendidik ON tenaga_pendidik.id_tp = jadwal_mengajar.id_tp
                      JOIN hari ON hari.id_hari = jadwal_mengajar.id_hari
                      JOIN mapel ON mapel.id_mapel = jadwal_mengajar.id_mapel
                      JOIN kelas ON kelas.id_kelas = jadwal_mengajar.id_kelas
                      JOIN jam_mulai ON jam_mulai.id_jammulai = jadwal_mengajar.id_jammulai
                      JOIN jam_selesai ON jam_selesai.id_jamselesai = jadwal_mengajar.id_jamselesai
                      WHERE jadwal_mengajar.id_tp = '$id_tp'
                      ORDER BY hari.hari, jam_mulai.jam_mulai;";

            $result = mysqli_query($conn, $query);
            $no = 1;

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<th scope='row'>{$no}</th>";
                echo "<td>{$row['hari']}</td>";
                echo "<td>{$row['mapel']}</td>";
                echo "<td>{$row['kelas']}</td>";
                echo "<td>{$row['jam_mulai']}</td>";
                echo "<td>{$row['jam_selesai']}</td>";
                echo "<td>
                        <button type='button' class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#modalInputJurnal{$no}'>
                            Input Jurnal
                        </button>
                      </td>";
                echo "</tr>";

                echo "
                <div class='modal fade' id='modalInputJurnal{$no}' tabindex='-1' aria-labelledby='modalInputJurnalLabel' aria-hidden='true'>
                    <div class='modal-dialog'>
                        <form action='../proses/tp-jurnalmengajar.php' method='POST'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='modalInputJurnalLabel'>Input Jurnal Mengajar</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                </div>
                                <div class='modal-body'>
                                    <input type='hidden' name='id_tp' value='{$id_tp}'>
                                    <input type='hidden' name='id_kelas' value='{$row['id_kelas']}'>
                                    <input type='hidden' name='id_jadwal' value='{$row['id_jadwal']}'>
                                    <input type='hidden' name='id_mapel' value='{$row['id_mapel']}'>
                                    <input type='hidden' name='id_hari' value='{$row['id_hari']}'>
                                    <input type='hidden' name='id_jammulai' value='{$row['id_jammulai']}'>
                                    <input type='hidden' name='id_jamselesai' value='{$row['id_jamselesai']}'>

                                    <div class='mb-3'>
                                        <label for='tgl' class='form-label'>Tanggal</label>
                                        <input type='date' class='form-control' id='tgl' name='tgl' required>
                                    </div>

                                    <div class='mb-3'>
                                        <label for='judul' class='form-label'>Judul Materi</label>
                                        <input type='text' class='form-control' id='judul' name='judul' required>
                                    </div>
                                </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                    <button type='submit' class='btn btn-primary'>Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>";
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