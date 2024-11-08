<?php include '../component/header.php';
include '../proses/tp-dashboard.php';

$nama = $_SESSION['nama'];
$sekolah = $_SESSION['email']; ?>

<section class="text-end" style="height: 92px;color: var(--bs-secondary-color);background: var(--bs-link-color);border-radius: -18px;border-bottom-left-radius: 20px;border-bottom-right-radius: 20px;">
    <div class="container" style="padding-top: 11px;">
        <div class="row">
            <div class="col-8" style="width: 270px;">
                <div class="row">
                    <div class="col text-start"><small class="border rounded-pill border-0" style="font-size: 10px;background: var(--bs-link-hover-color);padding-right: 10px;padding-left: 10px;padding-bottom: 5px;padding-top: 5px;color: var(--bs-body-bg);"><?= $sekolah ?></small></div>
                </div>
                <div class="row">
                    <div class="col" style="text-align: left;padding-top: 10px;">
                        <h6 class="header-name" style="font-family: 'Poppins';font-size: 12px;font-weight: bold;color: var(--bs-body-bg);padding-left: 10px;"><?= $nama ?></h6>
                    </div>
                </div>
            </div>
            <div class="col" style="border-style: none;"><img style="width: 30px;height: 30px;" width="30" height="30" src="../assets/img/PROFIL.png"></div>
        </div>
    </div>
</section>
<section>
    <div class="container" style="padding-top: 15px;padding-bottom: 15px;">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body border rounded border-0" style="background: var(--bs-link-color);">
                        <div><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-box-arrow-in-down-right" style="font-size: 34px;color: var(--bs-body-bg);">
                                <path fill-rule="evenodd" d="M6.364 2.5a.5.5 0 0 1 .5-.5H13.5A1.5 1.5 0 0 1 15 3.5v10a1.5 1.5 0 0 1-1.5 1.5h-10A1.5 1.5 0 0 1 2 13.5V6.864a.5.5 0 1 1 1 0V13.5a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5v-10a.5.5 0 0 0-.5-.5H6.864a.5.5 0 0 1-.5-.5z"></path>
                                <path fill-rule="evenodd" d="M11 10.5a.5.5 0 0 1-.5.5h-5a.5.5 0 0 1 0-1h3.793L1.146 1.854a.5.5 0 1 1 .708-.708L10 9.293V5.5a.5.5 0 0 1 1 0v5z"></path>
                            </svg></div><small style="color: var(--bs-body-bg);">Absen Masuk</small>
                        <h4 class="card-title" style="color: var(--bs-body-bg);"><?php echo $jam_presensi ?></h4>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body border rounded border-0" style="background: var(--bs-orange);">
                        <div><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-box-arrow-up-right" style="font-size: 34px;color: var(--bs-body-bg);">
                                <path fill-rule="evenodd" d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5z"></path>
                                <path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0v-5z"></path>
                            </svg></div><small style="color: var(--bs-body-bg);">Absen Pulang</small>
                        <h4 class="card-title" style="color: var(--bs-body-bg);"><?php echo $jam_checkout ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row">
            <div class="col">
                <h6 style="font-family: 'Poppins';">Menu Aplikasi</h6>
            </div>
        </div>
        <div class="row">
            <div class="col text-center" style="padding-left: 0px;">
                <div class="card float-none" style="border-style: none;">
                    <div class="card-header" style="color: var(--bs-light);background: var(--bs-white);padding: 9px 16px;padding-left: 19px;padding-bottom: 16px;padding-right: 0px;border-style: none;border-color: var(--bs-white);">
                        <ul class="nav nav-tabs card-header-tabs" style="border-style: none;">
                            <li class="nav-item text-center" style="margin-right: 15px; border-style: none; width: 70px;">
                                <a class="nav-link active" href="absen-masuk" style="font-family: poppins; font-size: 7px; border-style: none;">
                                    <img src="../assets/img/log-in.png" width="30px" style="display: block; margin: 0 auto;">
                                    <span style="margin-top: 8px; display: block;">Absen Masuk</span>
                                </a>
                            </li>

                            <li class="nav-item text-center" style="margin-right: 15px; width: 70px; border-style: none;">
                                <a class="nav-link active" href="#" style="font-family: poppins; font-size: 7px; border-style: none;">
                                    <img src="../assets/img/logout.png" width="30px" style="display: block; margin: 0 auto;">
                                    <span style="margin-top: 8px; display: block;">Absen Keluar</span>
                                </a>
                            </li>
                            <li class="nav-item text-center" style="margin-right: 15px; width: 70px; border-style: none;">
                                <a class="nav-link active" href="#" style="font-family: poppins; font-size: 7px; border-style: none;">
                                    <img src="../assets/img/absence.png" width="30px" style="display: block; margin: 0 auto;">
                                    <span style="margin-top: 8px; display: block;">Izin</span>
                                </a>
                            </li>
                            <li class="nav-item text-center" style="margin-right: 0px; width: 70px; border-style: none;">
                                <a class="nav-link active" href="#" style="font-family: poppins; font-size: 7px; border-style: none;">
                                    <img src="../assets/img/absentism.png" width="30px" style="display: block; margin: 0 auto;">
                                    <span style="margin-top: 8px; display: block;">Cuti</span>
                                </a>
                            </li>
                            <li class="nav-item text-center" style="margin-right: 15px; width: 70px; border-style: none;">
                                <a class="nav-link active" href="#" style="font-family: poppins; font-size: 7px; border-style: none;">
                                    <img src="../assets/img/teacher.png" width="30px" style="display: block; margin: 0 auto;">
                                    <span style="margin-top: 8px; display: block;">Jurnal Mengajar</span>
                                </a>
                            </li>
                            <li class="nav-item text-center" style="margin-right: 15px; width: 70px; border-style: none;">
                                <a class="nav-link active" href="#" style="font-family: poppins; font-size: 7px; border-style: none;">
                                    <img src="../assets/img/copy.png" width="30px" style="display: block; margin: 0 auto;">
                                    <span style="margin-top: 8px; display: block;">Modul Ajar</span>
                                </a>
                            </li>
                            <li class="nav-item text-center" style="margin-right: 15px; width: 70px; border-style: none;">
                                <a class="nav-link active" href="#" style="font-family: poppins; font-size: 7px; border-style: none;">
                                    <img src="../assets/img/light-bulb.png" width="30px" style="display: block; margin: 0 auto;">
                                    <span style="margin-top: 8px; display: block;">Media</span>
                                </a>
                            </li>
                            <li class="nav-item text-center" style="margin-right: 0px; width: 70px; border-style: none;">
                                <a class="nav-link active" href="../proses/login?act=logout" style="font-family: poppins; font-size: 7px; border-style: none;">
                                    <img src="../assets/img/application.png" width="30px" style="display: block; margin: 0 auto;">
                                    <span style="margin-top: 8px; display: block;">More Apps</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row">
            <div class="col">
                <h6 style="font-family: 'Poppins';">Pengumuman</h6>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Update SIDILAN V1.2</h4>
                        <p class="card-text">Segera update SIDILAN</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include '../component/footer.php' ?>