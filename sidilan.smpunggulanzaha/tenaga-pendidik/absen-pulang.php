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
                <h5 class="card-title">Absen Pulang</h5>

                <!-- Vertical Form -->
               <form class="row g-3" id="absensiForm" method="POST" action="../proses/tp-presensi.php?act=absen-pulang" enctype="multipart/form-data">
                    <div class="col-12">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="hidden" name="id_tp" value="<?= $id_tp ?>">
                        <input type="hidden" name="tipe" value="Masuk">
                        <input type="hidden" name="geolocation" value="" id="geolocation">
                        <input type="text" class="form-control" id="nama" name="nama" value="<?= $nama ?>" readonly>
                    </div>

                    <div class="col-12">
                        <label for="foto" class="form-label">Foto</label>
                        <input type="hidden" id="foto" name="foto">
                        <div class="text-center">
                            <video id="video" width="320" height="240" autoplay class="img-thumbnail"></video>
                            <button type="button" id="snap" class="btn btn-primary mt-2">Ambil Foto</button>
                            <canvas id="canvas" width="320" height="240" style="display:none;" class="img-thumbnail"></canvas>
                        </div>
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

<script>
    // Mengambil geolocation (latitude dan longitude)
    function getGeolocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                document.getElementById('geolocation').value = position.coords.latitude + ',' + position.coords.longitude;
            }, function(error) {
                if (error.code === error.TIMEOUT) {
                    alert("Geolocation timeout, trying again...");
                    getGeolocation();
                } else {
                    alert("Geolocation error: " + error.message);
                }
            }, {
                enableHighAccuracy: true,
                timeout: 30000, // 30 detik
                maximumAge: 0
            });
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    }

    // Fungsi untuk mengaktifkan kamera
    function enableCamera() {
        var video = document.getElementById('video');
        var canvas = document.getElementById('canvas');
        var context = canvas.getContext('2d');
        var snap = document.getElementById('snap');
        var fotoInput = document.getElementById('foto');

        navigator.mediaDevices.getUserMedia({
                video: true
            })
            .then(function(stream) {
                video.srcObject = stream;
                video.play();
            })
            .catch(function(err) {
                alert("An error occurred: " + err);
            });

        // Menangkap foto ketika tombol "Ambil Foto" ditekan
        snap.addEventListener('click', function() {
            getGeolocation(); // Ambil geolocation ketika foto diambil
            context.drawImage(video, 0, 0, 320, 240);
            var dataURL = canvas.toDataURL('image/png');
            fotoInput.value = dataURL; // Simpan foto dalam format Base64 ke input hidden
            canvas.style.display = 'block'; // Tampilkan preview foto
        });
    }

    // Panggil fungsi geolocation dan kamera saat halaman dimuat
    window.onload = function() {
        getGeolocation();
        enableCamera();
    };
</script>