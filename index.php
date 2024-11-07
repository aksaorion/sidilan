<?php include 'config/koneksi.php' ?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>sekolahku hebat (1)</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu&amp;display=swap">
    <link rel="stylesheet" href="assets/css/clean-navbar-1.css">
    <link rel="stylesheet" href="assets/css/clean-navbar.css">
    <link rel="stylesheet" href="assets/css/Header-Blue.css">
    <link rel="stylesheet" href="assets/css/Login-Form-Clean.css">
    <link rel="stylesheet" href="assets/css/Login-Form-Dark.css">
    <link rel="stylesheet" href="assets/css/Navbar-Centered-Links-icons.css">
    <link rel="stylesheet" href="assets/css/Registration-Form-with-Photo.css">
</head>

<body>
    <section class="login-clean">
        <form action="proses/login.php" method="POST" novalidate>
            <h2 class="visually-hidden">Login Form</h2>
            <div class="illustration">
                <picture><img class="login-logo" src="assets/img/logo%20circle.png" width="100px"></picture>
            </div>
            <div class="mb-3"><label class="form-label text-break fs-4" style="margin: 0px 0px 0px;width: 289.7188px;">Login</label>
                <div style="margin-bottom: 32px;"><small>Silahkan login untuk masuk</small></div><input class="border rounded-pill form-control" type="email" name="email" placeholder="Email">
            </div>
            <div class="mb-3"><input class="border rounded-pill form-control" type="password" name="password" placeholder="Password"></div>
            <div class="text-end text-dark"><a class="forgot" href="#" style="text-align: right;"><em>Lupa Password?</em></a></div>
            <div class="mb-3"><button class="btn btn-primary border rounded-pill d-block w-100" type="submit">Log In</button></div>
        </form>
    </section>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html