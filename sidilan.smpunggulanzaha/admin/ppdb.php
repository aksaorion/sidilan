<?php include '../components/header.php';
include '../koneksi-ppdb.php'; ?>
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
                                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Data Pendaftar</button>
                            </li>
                            


                        </ul>
                        <div class="tab-content pt-2" id="myTabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="card">
                                    <div class="card-body">

                                        <?php


                                        // Query untuk mengambil data dari tabel divisi
                                        $query = "SELECT * FROM ppdb ";
                                        $result = $ppdb->query($query);

                                        if (!$result) {
                                            die("Query Error: " . $ppdb->error);
                                        }
                                        ?>

                                        <!-- Table with stripped rows -->
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">No</th>
                                                        <th scope="col">Nama</th>
                                                        <th scope="col">Email</th>
                                                        <th scope="col">Asal Sekolah</th>
                                                        <th scope="col">Tgl Lahir</th>
                                                        <th scope="col">JK</th>
                                                        <th scope="col">Alamat</th>
                                                        <th scope="col">Telepon</th>
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
                                                        echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['asal_sekolah']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['tgl_lahir']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['jk']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['alamat']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['telepon']) . "</td>";

                                                        // Mengubah nomor telepon untuk link WhatsApp
                                                        $telepon = ltrim($row['telepon'], '0'); // Hilangkan angka 0 di depan
                                                        $wa_link = "https://wa.me/62" . $telepon;

                                                        echo "<td>
                        <a href='$wa_link' class='btn btn-success' target='_blank'>
                            <i class='bi bi-telephone'></i> Hubungi
                        </a>
                        
                        <form action='../proses/admin-divisi.php?act=delete-divisi' method='post' style='display:inline-block;'>
                            <input type='hidden' name='id_divisi' value='" . $row['id_divisi'] . "'>
                            
                        </form>
                      </td>";
                                                        echo "</tr>";

                                                        // Modal for editing
                                                        
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