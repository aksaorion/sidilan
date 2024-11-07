<?php include '../components/header.php' ?>
<?php include '../components/guru_navbar.php' ?>
<?php $id_tp = $_SESSION['id_tp']; ?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Dashboard</h1>
        -
        <?php

        echo generateBreadcrumb();
        ?>

    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">
                    <!-- Start Card -->
                    <div class="col-xxl-3 col-md-3">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <br>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-box-arrow-in-down-right"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h5 style=" cursor: pointer;" onclick="window.location.href='absen-masuk'">
                                            <strong>Absen Masuk</strong>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Card -->

                    <!-- Start Card -->
                    <div class="col-xxl-3 col-md-3">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <br>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-box-arrow-up-right" onclick="window.location.href='absen-pulang'"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h5 style="cursor: pointer;" onclick="window.location.href='absen-pulang'">
                                            <strong>Absen Pulang</strong>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Card -->

                    <!-- Start Card -->
                    <div class="col-xxl-3 col-md-3">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <br>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-calendar-event" onclick="window.location.href='pengajuan-izin'"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h5 style="cursor: pointer;" onclick="window.location.href='pengajuan-izin'">
                                            <strong>Izin</strong>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Card -->

                    <!-- Start Card -->
                    <div class="col-xxl-3 col-md-3">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <br>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-calendar-week" onclick="window.location.href='pengajuan-cuti'"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h5 style="cursor: pointer;" onclick="window.location.href='pengajuan-cuti'">
                                            <strong>Cuti</strong>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Card -->

                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">



                            <div class="card-body">
                                <h5 class="card-title">Recent <span>| Activity</span></h5>

                                <?php
$query = "
    SELECT tanggal, tipe_presensi, jam, geolocation, 
        CASE 
            WHEN tipe_presensi = 'Masuk' AND jam <= '07:10:00' THEN 'Tepat Waktu'
            WHEN tipe_presensi = 'Masuk' AND jam > '07:10:00' THEN 'Telat'
            ELSE 'Approved'
        END AS status
    FROM presensi
    WHERE id_tp = $id_tp
    ORDER BY tanggal DESC
    LIMIT 62;  -- Batas maksimal 31 data
";

// Eksekusi query
$result = $conn->query($query);

echo '<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Tanggal</th>
                <th scope="col">Presensi</th>
                <th scope="col">Jam</th>
                <th scope="col">Lokasi</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>';

while ($row = $result->fetch_assoc()) {
    $statusClass = $row['status'] == 'Tepat Waktu' ? 'bg-success' : ($row['status'] == 'Telat' ? 'bg-danger' : 'bg-primary');
    $lokasi = (!empty($row['geolocation'])) ? $row['geolocation'] : 'N/A';

    echo '<tr>
        <td>' . htmlspecialchars($row['tanggal']) . '</td>
        <td>' . htmlspecialchars($row['tipe_presensi']) . '</td>
        <td>' . htmlspecialchars($row['jam']) . '</td>
        <td>' . htmlspecialchars($lokasi) . '</td>
        <td><span class="badge ' . $statusClass . '">' . htmlspecialchars($row['status']) . '</span></td>
    </tr>';
}

echo '</tbody>
    </table>
</div>';
?>

                            </div>


                        </div>
                    </div><!-- End Recent Sales -->
                </div>
            </div>
            <!-- End Left side columns -->

            <!-- Right side columns -->


        </div>
    </section>
</main>
<?php include '../components/footer.php' ?>