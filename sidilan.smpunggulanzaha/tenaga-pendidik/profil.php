<?php include '../components/header.php'; ?>
<?php include '../components/guru_navbar.php' ?>
<?php $id_tp = $_SESSION['id_tp']; ?>
<?php
$query_tp = "SELECT * FROM tenaga_pendidik
JOIN sekolah ON tenaga_pendidik.id_sekolah = sekolah.id_sekolah
JOIN riwayat_pendidikan ON tenaga_pendidik.id_tp = riwayat_pendidikan.id_tp
WHERE tenaga_pendidik.id_tp = $id_tp";
$result_tp = $conn->query($query_tp);
?>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Profile</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Users</li>
                <li class="breadcrumb-item active">Profile</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <?php if ($result_tp->num_rows > 0) {
        while ($row = $result_tp->fetch_assoc()) { ?>
            <section class="section profile">
                <div class="row">
                    <div class="col-xl-4">

                        <div class="card">
                            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                                <img src="../public/profil/<?php echo htmlspecialchars($row['foto']) ?>" alt="Profile" class="rounded-circle">
                                <h5 class="card-title"><?php echo htmlspecialchars($row['nama']) ?></h5>
                                <h3><?php echo htmlspecialchars($row['role']) ?></h3>
                                <div class="social-links mt-2">
                                    <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                                    <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                                    <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                                    <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-xl-8">

                        <div class="card">
                            <div class="card-body pt-3">
                                <!-- Bordered Tabs -->
                                <ul class="nav nav-tabs nav-tabs-bordered">

                                    <li class="nav-item">
                                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                                    </li>

                                    <li class="nav-item">
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                                    </li>

                                    <li class="nav-item">
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Settings</button>
                                    </li>

                                    <li class="nav-item">
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                                    </li>

                                </ul>
                                <div class="tab-content pt-2">

                                    <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                        <h5 class="card-title">About</h5>
                                        <p class="small fst-italic">Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.</p>

                                        <h5 class="card-title">Profile Details</h5>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label ">Full Name</div>
                                            <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($row['nama']) ?></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Instansi</div>
                                            <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($row['nama_sekolah']) ?></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Status</div>
                                            <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($row['role']) ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Gelar</div>
                                            <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($row['gelar']) ?></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Tempat, Tanggal Lahir</div>
                                            <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($row['tempat_lahir']) . ', ' . htmlspecialchars($row['tgl_lahir']) ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Agama</div>
                                            <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($row['agama']) ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">No. Identitas</div>
                                            <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($row['no_identitas']) ?></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Telepon</div>
                                            <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($row['telepon']) ?></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Email</div>
                                            <div class="col-lg-9 col-md-8">k.anderson@example.com</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Alamat</div>
                                            <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($row['alamat']) ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Provinsi</div>
                                            <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($row['provinsi']) ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Kota</div>
                                            <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($row['kota']) ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Kecamatan</div>
                                            <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($row['kecamatan']) ?></div>
                                        </div>



                                    </div>

                                    <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                                        <!-- Profile Edit Form -->
                                        <form action="../proses/tp-profil.php?act=update-profil" method="post" enctype="multipart/form-data">
                                            <div class="row mb-3">
                                                <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <img src="../public/profil/<?php echo htmlspecialchars($row['foto']) ?>" alt="Profile">
                                                    <div class="pt-2">
                                                        <input type="file" name="foto" class="form-control-file">
                                                        <input type="hidden" name="id" id="" value="<?= $id_tp ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="nama" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="nama" type="text" class="form-control" id="nama" value="<?php echo htmlspecialchars($row['nama']) ?>">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="tempat" class="col-md-4 col-lg-3 col-form-label">Tempat Lahir</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="tempat" type="text" class="form-control" id="tempat" value="<?php echo htmlspecialchars($row['tempat_lahir']) ?>">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="tgl_lahir" class="col-md-4 col-lg-3 col-form-label">Tanggal Lahir</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="tgl_lahir" type="date" class="form-control" id="tgl_lahir" value="<?php echo htmlspecialchars($row['tgl_lahir']) ?>">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="gelar" class="col-md-4 col-lg-3 col-form-label">Gelar</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="gelar" type="text" class="form-control" id="gelar" value="<?php echo htmlspecialchars($row['gelar']) ?>">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="agama" class="col-md-4 col-lg-3 col-form-label">Agama</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="agama" type="text" class="form-control" id="agama" value="<?php echo htmlspecialchars($row['agama']) ?>">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="no_identitas" class="col-md-4 col-lg-3 col-form-label">No. Identitas</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="no_identitas" type="text" class="form-control" id="no_identitas" value="<?php echo htmlspecialchars($row['no_identitas']) ?>">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="telepon" class="col-md-4 col-lg-3 col-form-label">Telepon</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="telepon" type="text" class="form-control" id="telepon" value="<?php echo htmlspecialchars($row['telepon']) ?>">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="email" type="email" class="form-control" id="email" value="<?php echo htmlspecialchars($row['email']) ?>">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="alamat" class="col-md-4 col-lg-3 col-form-label">Alamat</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="alamat" type="text" class="form-control" id="alamat" value="<?php echo htmlspecialchars($row['alamat']) ?>">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="provinsi" class="col-md-4 col-lg-3 col-form-label">Provinsi</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="provinsi" type="text" class="form-control" id="provinsi" value="<?php echo htmlspecialchars($row['provinsi']) ?>">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="kota" class="col-md-4 col-lg-3 col-form-label">Kota</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="kota" type="text" class="form-control" id="kota" value="<?php echo htmlspecialchars($row['kota']) ?>">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="kecamatan" class="col-md-4 col-lg-3 col-form-label">Kecamatan</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="kecamatan" type="text" class="form-control" id="kecamatan" value="<?php echo htmlspecialchars($row['kecamatan']) ?>">
                                                </div>
                                            </div>


                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </form><!-- End Profile Edit Form -->

                                    </div>

                                    <div class="tab-pane fade pt-3" id="profile-settings">

                                        <!-- Settings Form -->
                                        <form>

                                            <div class="row mb-3">
                                                <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Email Notifications</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="changesMade" checked>
                                                        <label class="form-check-label" for="changesMade">
                                                            Changes made to your account
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="newProducts" checked>
                                                        <label class="form-check-label" for="newProducts">
                                                            Information on new products and services
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="proOffers">
                                                        <label class="form-check-label" for="proOffers">
                                                            Marketing and promo offers
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="securityNotify" checked disabled>
                                                        <label class="form-check-label" for="securityNotify">
                                                            Security alerts
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </form><!-- End settings Form -->

                                    </div>

                                    <div class="tab-pane fade pt-3" id="profile-change-password">
                                        <!-- Change Password Form -->
                                        <form>

                                            <div class="row mb-3">
                                                <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="password" type="password" class="form-control" id="currentPassword">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="newpassword" type="password" class="form-control" id="newPassword">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="renewpassword" type="password" class="form-control" id="renewPassword">
                                                </div>
                                            </div>

                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary">Change Password</button>
                                            </div>
                                        </form><!-- End Change Password Form -->

                                    </div>

                                </div><!-- End Bordered Tabs -->

                            </div>
                        </div>

                    </div>
                </div>
            </section>
    <?php }
    } ?>


</main><!-- End #main -->
<?php include '../components/footer.php' ?>