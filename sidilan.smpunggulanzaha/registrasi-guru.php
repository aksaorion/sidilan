<?php
include 'conn.php';
// Query untuk mengambil data tenaga pendidik berdasarkan id_tp
$query_tp = "SELECT * FROM tenaga_pendidik
JOIN riwayat_pendidikan ON tenaga_pendidik.id_tp = riwayat_pendidikan.id_tp
JOIN kepegawaian ON tenaga_pendidik.id_tp = kepegawaian.id_tp
WHERE tenaga_pendidik.id_tp = ?";
$stmt_tp = $conn->prepare($query_tp);
$stmt_tp->bind_param('i', $id_tp); // Pastikan $id_tp adalah integer
$stmt_tp->execute();
$result_tp = $stmt_tp->get_result();
$data_tp = $result_tp->fetch_assoc(); // Ambil data sebagai array asosiatif

// Query untuk mengambil data provinsi
$query_provinsi = "SELECT id_provinsi, provinsi FROM provinsi";
$result_provinsi = $conn->query($query_provinsi);

// Query untuk mengambil data riwayat pendidikan
$query_riwayat = "SELECT * FROM riwayat_pendidikan WHERE id_tp = ?";
$stmt_riwayat = $conn->prepare($query_riwayat);
$stmt_riwayat->bind_param('i', $id_tp); // Pastikan $id_tp adalah integer
$stmt_riwayat->execute();
$result_riwayat = $stmt_riwayat->get_result();
$data_riwayat = $result_riwayat->fetch_assoc();

// Query untuk mengambil data kepegawaian
$query_kepegawaian = "SELECT kepegawaian.*, divisi.divisi, role_divisi.role_divisi, tenaga_pendidik.nama
FROM kepegawaian
JOIN divisi ON kepegawaian.id_divisi = divisi.id_divisi
JOIN role_divisi ON kepegawaian.id_roledivisi = role_divisi.id_roledivisi
JOIN tenaga_pendidik ON kepegawaian.id_tp = tenaga_pendidik.id_tp
WHERE kepegawaian.id_tp = ?";
$stmt_kepegawaian = $conn->prepare($query_kepegawaian);
$stmt_kepegawaian->bind_param('i', $id_tp); // Pastikan $id_tp adalah integer
$stmt_kepegawaian->execute();
$result_kepegawaian = $stmt_kepegawaian->get_result();
$data_kepegawaian = $result_kepegawaian->fetch_assoc();

// Query untuk mengambil data jenjang
$q_jenjang = "SELECT DISTINCT jenjang_sekolah FROM jenjang_sekolah";
$result_jenjang = $conn->query($q_jenjang);

// Query untuk mengambil data divisi
$query_divisi = "SELECT * FROM divisi";
$result_divisi = $conn->query($query_divisi);

// Query untuk mengambil data jabatan
$query_jabatan = "SELECT * FROM jabatan";
$result_jabatan = $conn->query($query_jabatan);

// Query untuk mengambil data role_divisi
$query_roledivisi = "SELECT * FROM role_divisi";
$result_roledivisi = $conn->query($query_roledivisi);

// Query untuk mengambil data agama
$query_agama = "SELECT * FROM agama";
$result_agama = $conn->query($query_agama);

// Pastikan untuk memeriksa hasil query dan menangani kemungkinan kesalahan
if ($conn->error) {
    echo "Error: " . $conn->error;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>SIDILAN - Sistem Informasi SMP Unggulan</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    
  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">


</head>

<body>

    <main>


        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Data Tenaga Pendidik</h5>

                <!-- Vertical Form -->
                <form class="row g-3" action="proses.php?act=tambah-tenagapendidik" method="post">
                    <div class="col-12">
                        <input type="hidden" name="id_sekolah" id="id_sekolah" value="1">
                        <label for="nama" class="form-label">Nama Lengkap</label>
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
                        <input type="text" class="form-control" id="gelar" name="gelar">
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

                    <h5 class="card-title mt-3">Riwayat Pendidikan</h5>

                    <div class="col-md-6">
                        <label for="jenjang" class="form-label">Jenjang</label>
                        <select id="jenjang" name="jenjang" class="form-select">
                            <option selected>Pilih Jenjang Pendidikan</option>
                            <?php
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
                        <button type="submit" class="btn btn-primary">SIMPAN</button>
                    </div>
                </form><!-- Vertical Form -->
            </div>
        </div>

    </main>
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>



    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>


</body>