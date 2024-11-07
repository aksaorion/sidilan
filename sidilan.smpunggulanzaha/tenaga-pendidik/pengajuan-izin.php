<?php include '../components/header.php'; ?>
<?php include '../components/guru_navbar.php'; ?>
<?php
$id_tp = $_SESSION['id_tp'];
$nama = $_SESSION['nama'];
?>
<main id="main" class="main">
    <div class="col-lg-9">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Pengajuan Izin</h5>

                <!-- Vertical Form -->
                <form class="row g-3" id="absensiForm">
                    <div class="col-12">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="hidden" name="id_tp" value="<?= $id_tp ?>">
                        <input type="text" class="form-control" id="nama" name="nama" value="<?= $nama ?>" readonly>
                    </div>
                    <div class="col-12">
                        <label for="jenis" class="form-label">Nama</label>
                        <select id="jenis" name="jenis" class="form-select">
                            <option selected>Pilih Jenis Izin</option>
                            <option value="Sakit">Sakit</option>
                            <option value="Keperluan">Keperluan</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <input type="text" class="form-control" id="keterangan" name="keterangan">
                    </div>


                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </form><!-- Vertical Form -->

            </div>
        </div>
    </div>
</main>
<?php include '../components/footer.php'; ?>