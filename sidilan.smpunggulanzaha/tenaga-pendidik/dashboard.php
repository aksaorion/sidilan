<?php include '../components/header.php' ?>
<?php include '../components/guru_navbar.php' ?>
<?php include '../proses/tp-dashboard.php' ?>
<main id="main" class="main">
    <div class="pagetitle">
        <?php

        echo generateBreadcrumb();
        ?>

    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">

                    <!-- Sales Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>
                            <?php
                            $query_masuk = "SELECT jam FROM presensi WHERE tipe_presensi = 'Pulang' AND tanggal = CURRENT_DATE AND id_tp = $id_tp";
                            $result_masuk =  $conn->query($query_masuk);
                            ?>

                            <div class="card-body">
                                <h5 class="card-title">Presensi <span>| Hari Ini</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-clock"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?php echo $jam_presensi; ?></h6>
                                        <?php if ($jam_presensi !== 'Belum ada presensi'): ?>
                                            <span class="<?php echo $status_class; ?> small pt-1 fw-bold"><?php echo $status; ?></span>
                                        <?php else: ?>
                                            <span class="text-muted small pt-2 ps-1">Belum ada data presensi</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Sales Card -->

                    <!-- Revenue Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Rata-Rata Jam Kerja</h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-briefcase"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?php echo round($rata_jam_kerja, 2); ?> Jam/Hari</h6>
                                        <span class="<?php echo $pesan_warna; ?> small pt-1 fw-bold"><?php echo $pesan; ?></span>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div><!-- End Revenue Card -->
                    <div class="col-12">

                        <div class="card">
                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>

                            <div class="card-body pb-0">
                                <h5 class="card-title">News &amp; Updates <span>| Today</span></h5>

                                <div class="news">
                                    <?php while ($row = $result_news->fetch_assoc()): ?>
                                        <div class="post-item clearfix">
                                            <img src="path_to_your_image_directory/<?php echo $row['foto']; ?>" alt="">
                                            <h4><a href="#"><?php echo $row['title']; ?></a></h4>
                                            <p><?php echo substr($row['content'], 0, 100); ?>...</p> <!-- Batasi konten hanya 100 karakter -->
                                        </div>
                                    <?php endwhile; ?>
                                </div><!-- End sidebar recent posts-->
                            </div>

                        </div><!-- End News & Updates -->
                    </div>



                    <!-- Reports -->
                    <div class="col-12">
                        <div class="card">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Histori Absensi <span>/Bulan Ini</span></h5>

                                <!-- Line Chart -->
                                <div id="absensiChart"></div>

                                <script>
                                    document.addEventListener("DOMContentLoaded", () => {
                                        let masukData = <?php echo json_encode($masuk_data); ?>;
                                        let pulangData = <?php echo json_encode($pulang_data); ?>;
                                        let categoriesData = <?php echo json_encode($categories); ?>;

                                        new ApexCharts(document.querySelector("#absensiChart"), {
                                            series: [{
                                                name: 'Masuk',
                                                data: masukData // Data absensi masuk
                                            }, {
                                                name: 'Pulang',
                                                data: pulangData // Data absensi pulang
                                            }],
                                            chart: {
                                                height: 350,
                                                type: 'line', // Bisa menggunakan 'area' juga jika diinginkan
                                                toolbar: {
                                                    show: false
                                                },
                                            },
                                            markers: {
                                                size: 4
                                            },
                                            colors: ['#4154f1', '#ff771d'],
                                            fill: {
                                                type: "gradient",
                                                gradient: {
                                                    shadeIntensity: 1,
                                                    opacityFrom: 0.3,
                                                    opacityTo: 0.4,
                                                    stops: [0, 90, 100]
                                                }
                                            },
                                            dataLabels: {
                                                enabled: false
                                            },
                                            stroke: {
                                                curve: 'smooth',
                                                width: 2
                                            },
                                            xaxis: {
                                                type: 'category', // Menggunakan kategori
                                                categories: categoriesData, // Kategori waktu (jam:menit)
                                                labels: {
                                                    formatter: function(val) {
                                                        return val; // Menampilkan waktu dalam format jam
                                                    }
                                                },
                                                tickAmount: 12, // Jumlah ticks antara 06.00 - 18.00 (rentang 12 jam)
                                                min: '06:00', // Batas minimal waktu (06.00)
                                                max: '18:00' // Batas maksimal waktu (18.00)
                                            },
                                            tooltip: {
                                                x: {
                                                    format: 'HH:mm' // Format tooltip untuk jam
                                                },
                                            }
                                        }).render();
                                    });
                                </script>
                                <!-- End Line Chart -->
                            </div>



                        </div>
                    </div><!-- End Reports -->

                    <!-- Recent Sales -->





                </div>
            </div><!-- End Left side columns -->

            <!-- Right side columns -->


        </div>
    </section>
</main>

<?php include '../components/footer.php' ?>