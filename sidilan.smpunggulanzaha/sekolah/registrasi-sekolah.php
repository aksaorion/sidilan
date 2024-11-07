<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Sekolah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
    background-color: #6f42c1;
}

.logo {
    max-width: 300px;
    height: auto;
}
.form-label{
    
    color: #6f42c1
}

.card {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
}

.card-title {
    font-size: 1.5rem;
    margin-bottom: 20px;
}

.form-label {
    font-weight: bold;
}

.btn-primary {
    background-color: #e4a700;
    border: none;
    border-radius: 5px;
}

.btn-primary:hover {
    background-color: rgb(199, 147, 5);
}

    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <!-- Logo -->
                <div class="text-center mb-4">
                    <img src="https://smpunggulanzaha.sch.id/images/prosch-logo.png" alt="Logo Sekolah" class="logo">
                </div>

                <!-- Form Registrasi -->
                <div class="card">
                    <div class="card-body">
                        <h5 style="color: #6f42c1" class="card-title text-center"><strong>Form Registrasi Sekolah</strong></h5>
                        <form action="../proses/registrasi-sekolah.php" method="post">
                          
                            <div class="mb-3">
                                <label for="nama_sekolah" class="form-label">Nama Sekolah</label>
                                <input type="text" class="form-control" id="nama_sekolah" name="nama_sekolah" value="" required>
                                
                            </div>
                            <div class="mb-3">
                                <label for="npsn" class="form-label">NPSN</label>
                                <input type="text" class="form-control" id="npsn" name="npsn" value=""  required>
                               
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                               
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Daftar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
