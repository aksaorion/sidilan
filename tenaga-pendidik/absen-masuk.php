<?php
include '../component/header.php';
session_start();
$id_tp = $_SESSION['id_tp'];
$nama = $_SESSION['nama'];
?>
<section class="text-end" style="height: 92px;color: var(--bs-secondary-color);background: var(--bs-link-color);border-radius: -18px;border-bottom-left-radius: 20px;border-bottom-right-radius: 20px;">
    <div class="container" style="padding-top: 11px;">
        <div class="row">
            <div class="col-8" style="width: 270px;">
                <div class="row">
                    <div class="col text-start"><small class="border rounded-pill border-0" style="font-size: 10px;background: var(--bs-link-hover-color);padding-right: 10px;padding-left: 10px;padding-bottom: 5px;padding-top: 5px;color: var(--bs-body-bg);"><?php echo $nama ?></small></div>
                </div>
                <div class="row">
                    <div class="col" style="text-align: left;padding-top: 10px;">
                        <h6 style="font-family: 'Poppins';font-size: 16px;font-weight: bold;color: var(--bs-body-bg);padding-left: 10px;">Presensi Masuk</h6>
                    </div>
                </div>
            </div>
            <div class="col align-self-center" style="border-style: none;text-align: center;"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-box-arrow-in-down-right" style="font-size: 25px;color: var(--bs-body-bg);">
                    <path fill-rule="evenodd" d="M6.364 2.5a.5.5 0 0 1 .5-.5H13.5A1.5 1.5 0 0 1 15 3.5v10a1.5 1.5 0 0 1-1.5 1.5h-10A1.5 1.5 0 0 1 2 13.5V6.864a.5.5 0 1 1 1 0V13.5a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5v-10a.5.5 0 0 0-.5-.5H6.864a.5.5 0 0 1-.5-.5z"></path>
                    <path fill-rule="evenodd" d="M11 10.5a.5.5 0 0 1-.5.5h-5a.5.5 0 0 1 0-1h3.793L1.146 1.854a.5.5 0 1 1 .708-.708L10 9.293V5.5a.5.5 0 0 1 1 0v5z"></path>
                </svg></div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row">
            <div class="col text-center" style="padding-top: 16px;padding-bottom: 16px;">
                <h1 class="display-1" id="clock" style="font-family: 'Poppins';">07:00:00</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <form>

                    <input type="hidden" id="foto" name="foto">




                    <div class="card" style="text-align: center;">
                        <div class="text-center">
                            <!-- Video preview untuk pengambilan gambar -->
                            <video id="video" width="240" height="320" autoplay class="img-thumbnail" style="display: block; margin: auto;"></video>

                            <!-- Canvas sebagai pratinjau hasil gambar -->
                            <canvas id="canvas" width="240" height="320" style="display: none; margin: auto;" class="img-thumbnail"></canvas>

                            <!-- Tombol pengambilan gambar -->
                            <button type="button" id="snap" class="btn btn-warning mt-2">Ambil Foto</button>
                        </div>

                        <div class="card-body">
                            <h4 id="status" class="card-title" style="font-weight: bold;">Tepat Waktu</h4>
                            <p id="message" class="card-text" style="color: var(--bs-dark-text-emphasis);">Anda datang tepat waktu, ayo segera absen!</p>
                            <button class="btn btn-primary border rounded-pill" type="submit" style="font-size: 25px; font-family: 'Poppins';">Checkin Sekarang</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?php include '../component/footer.php' ?>
<script>
    function updateClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');

        document.getElementById('clock').textContent = `${hours}:${minutes}:${seconds}`;
    }

    // Memperbarui jam setiap detik
    setInterval(updateClock, 1000);

    // Memperbarui jam saat pertama kali dimuat
    updateClock();

    function updateClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');

        const currentTime = `${hours}:${minutes}:${seconds}`;
        document.getElementById('clock').textContent = currentTime;

        // Cek jika waktu saat ini lebih dari 07:11:00
        const limitTime = "07:11:00";
        const statusElement = document.getElementById('status');
        const messageElement = document.getElementById('message');

        if (currentTime < limitTime) {
            // Tepat waktu
            statusElement.textContent = "Tepat Waktu";
            statusElement.style.color = "green";
            messageElement.textContent = "Anda datang tepat waktu, ayo segera absen!";
        } else {
            // Terlambat
            statusElement.textContent = "Anda Terlambat";
            statusElement.style.color = "red";
            messageElement.textContent = "Anda datang terlambat, segera lakukan absen!";
        }
    }

    // Memperbarui jam setiap detik
    setInterval(updateClock, 1000);

    // Memperbarui jam saat pertama kali dimuat
    updateClock();

    function updateClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');

        const currentTime = `${hours}:${minutes}:${seconds}`;
        document.getElementById('clock').textContent = currentTime;

        const limitTime = "07:11:00";
        const statusElement = document.getElementById('status');
        const messageElement = document.getElementById('message');

        if (currentTime < limitTime) {
            statusElement.textContent = "Tepat Waktu";
            statusElement.style.color = "green";
            messageElement.textContent = "Anda datang tepat waktu, ayo segera absen!";
        } else {
            statusElement.textContent = "Anda Terlambat";
            statusElement.style.color = "red";
            messageElement.textContent = "Anda datang terlambat, segera lakukan absen!";
        }
    }

    setInterval(updateClock, 1000);
    updateClock();
</script>
<script>
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const snapButton = document.getElementById('snap');
    const fotoInput = document.getElementById('foto');

    // Mendapatkan akses ke kamera
    navigator.mediaDevices.getUserMedia({
            video: true
        })
        .then(stream => {
            video.srcObject = stream;
        })
        .catch(error => {
            console.error("Tidak dapat mengakses kamera:", error);
        });

    // Event untuk mengambil foto dan mengganti tombol menjadi "Ambil Ulang"
    snapButton.addEventListener('click', () => {
        if (snapButton.textContent === "Ambil Foto") {
            // Menangkap gambar dari video dan menampilkan di canvas
            canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
            const imageData = canvas.toDataURL('image/png');
            fotoInput.value = imageData; // Menyimpan data gambar ke input tersembunyi

            // Menyembunyikan video dan menampilkan canvas
            video.style.display = 'none';
            canvas.style.display = 'block';

            // Mengganti teks tombol menjadi "Ambil Ulang"
            snapButton.textContent = "Ambil Ulang";
            snapButton.classList.remove("btn-warning");
            snapButton.classList.add("btn-secondary");
        } else {
            // Menampilkan video kembali dan menyembunyikan canvas
            video.style.display = 'block';
            canvas.style.display = 'none';

            // Mengganti teks tombol kembali menjadi "Ambil Foto"
            snapButton.textContent = "Ambil Foto";
            snapButton.classList.remove("btn-secondary");
            snapButton.classList.add("btn-warning");
        }
    });
</script>