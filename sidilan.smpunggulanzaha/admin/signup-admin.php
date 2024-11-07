<?php
// Tangkap id_sekolah dari URL
$id_sekolah = isset($_GET['id_sekolah']) ? $_GET['id_sekolah'] : null;

if (!$id_sekolah) {
    echo "ID Sekolah tidak ditemukan.";
    exit;
}

// Proses registrasi admin bisa dilanjutkan menggunakan $id_sekolah
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
      body {
    background-color: #6f42c1; /* Background warna ungu */
}


.card {
    background-color: #ffffff; /* Background form putih */
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border: none;
}

.card-title {
    font-size: 1.5rem;
    margin-bottom: 20px;
    color: #000; /* Warna teks judul hitam */
}

.form-label {
    font-weight: bold;
    color: #000; /* Warna label hitam */
}

.form-control {
    background-color: #f8f9fa; /* Warna background input */
    border: none;
    border-radius: 5px;
}

.form-control:focus {
    border-color: #6f42c1;
    box-shadow: 0 0 5px #6f42c1;
}

.btn-primary {
    background-color: #6f42c1;
    border: none;
    border-radius: 5px;
    color: #fff;
}

.btn-primary:hover {
    background-color: #5a379c;
}

.slider {
    background-color: #ffffff; /* Background slider putih */
    border-radius: 0 10px 10px 0;
    overflow: hidden;
}

.carousel-item img {
    object-fit: cover;
}

    </style>
</head>
<body>
    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="card w-75">
            <div class="row g-0">
                <!-- Form Register -->
                <div class="col-md-6 p-4">
                    <h5 class="card-title text-center mb-4">Register Admin</h5>
                    <form action="../proses/signup-admin.php" method="post">
                  
                    <input type="text" name="id_sekolah" value="<?= $id_sekolah ;?>">

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                           
                        </div>
                        <div class="mb-3">
                            <label for="jabatan" class="form-label">Jabatan</label>
                            <input type="text" class="form-control" id="jabatan" name="jabatan" required>
                            
                        </div>
                        <div class="mb-3">
                            <label for="telepon" class="form-label">Telepon</label>
                            <input type="text" class="form-control" id="telepon" name="telepon" required>
                           
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                           
                        </div>
                        <div class="mb-3">
                            <label for="pass" class="form-label">Password</label>
                            <input type="password" class="form-control" id="pass" name="pass" required>
                           
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Register</button>
                        </div>
                    </form>
                </div>

                <!-- Slider Section -->
                <div class="col-md-6 slider p-0">
                    <div id="carouselExampleSlidesOnly" class="carousel slide h-100" data-bs-ride="carousel">
                        <div class="carousel-inner h-100">
                            <div class="carousel-item active h-100">
                                <img src="assets/img/news-1.jpg" class="d-block w-100 h-100" alt="Slide 1">
                            </div>
                            <div class="carousel-item h-100">
                                <img src="assets/img/news-2.jpg" class="d-block w-100 h-100" alt="Slide 2">
                            </div>
                            <div class="carousel-item h-100">
                                <img src="assets/img/news-3.jpg" class="d-block w-100 h-100" alt="Slide 3">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
