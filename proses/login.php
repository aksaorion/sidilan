<?php

require '../config/koneksi.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Sanitize inputs to prevent SQL Injection
    $email = $conn->real_escape_string($email);
    $password = $conn->real_escape_string($password);
    $hashed_password = md5($password);  // MD5 sebaiknya diganti dengan algoritma yang lebih aman seperti bcrypt atau Argon2

    // 1. Cek di tabel admin
    $query = "SELECT * FROM admin WHERE email = '$email'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if ($hashed_password === $user['pass']) {
            // Set session untuk admin
            session_regenerate_id(true);
            $_SESSION['sekolah'] = $user['id_sekolah'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['role'] = 'admin';
            header("Location: ../admin/dashboard");
            exit;
        } else {
            // Password salah, kembali ke halaman login
            echo "<script>
                alert('Password salah!');
                window.location.href = 'index.php'; // Ganti dengan URL halaman login
            </script>";
            exit;
        }
    }

    // 2. Cek di tabel tenaga_pendidik
    $query = "SELECT * FROM tenaga_pendidik JOIN sekolah ON tenaga_pendidik.id_sekolah = sekolah.id_sekolah WHERE email = '$email'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if ($hashed_password === $user['pass']) {
            // Set session untuk tenaga pendidik
            session_regenerate_id(true);
            $_SESSION['id_tp'] = $user['id_tp'];
            $_SESSION['sekolah'] = $user['sekolah'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = 'Tenaga Pendidik';
            $_SESSION['position'] = $user['role'];

            if ($user['role'] == 'Guru') {
                header("Location: ../tenaga-pendidik/dashboard");
            } else {
                header("Location: karyawan_dashboard.php");
            }
            exit;
        } else {
            echo "<script>
                alert('Password salah!');
                window.location.href = '../';
            </script>";
            exit;
        }
    }

    // 3. Cek di tabel siswa
    $query = "SELECT * FROM siswa WHERE email = '$email'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if ($hashed_password === $user['pass']) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = 'siswa';
            header("Location: siswa_dashboard.php");
            exit;
        }
        echo "<script>
                alert('Password salah!');
                window.location.href = '../';
            </script>";
        exit;
    }

    // 4. Cek di tabel wali
    $query = "SELECT * FROM wali WHERE email = '$email'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if ($hashed_password === $user['pass']) {
            session_regenerate_id(true);
            $_SESSION['email'] = $user['email'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['sekolah'] = $user['id_sekolah'];
            $_SESSION['role'] = 'wali';
            header("Location: wali_dashboard.php");
            exit;
        }
        echo "<script>
                alert('Password salah!');
                window.location.href = '../';
            </script>";
        exit;
    }

    // Jika email atau password tidak cocok
    echo "<script>
            alert('Email atau password salah!');
            window.location.href = '../';
        </script>";
}

// Logout handling
if (isset($_GET['act']) && $_GET['act'] === 'logout') {
    session_unset();
    session_destroy();

    // Menghapus cookie session dengan aman
    setcookie(session_name(), '', time() - 3600, '/', '', true, true);
    header("Location: ../");
    exit;
}
