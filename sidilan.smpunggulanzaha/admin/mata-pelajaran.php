<?php 
include '../components/header.php'; 
include '../components/admin_navbar.php'; 

$id_sekolah = $_SESSION['sekolah'];
?>
<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
            
                <div class="card">
                    <div class="card-body">
                        <br>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahMapel">
                                <i class="bi bi-plus"></i> Tambah Mata Pelajaran
                            </button>
                        </div>

                        <!-- Modal Tambah Mata Pelajaran -->
                        <div class="modal fade" id="modalTambahMapel" tabindex="-1">
                            <div class="modal-dialog modal-dialog-scrollable">
                                <form action="../proses/admin-mapel.php?act=tambah-mapel" method="post">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Tambah Mata Pelajaran</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="mapel" class="form-label">Nama Mata Pelajaran</label>
                                                <input type="hidden" name="id_sekolah" value="<?= htmlspecialchars($id_sekolah) ?>">
                                                <input type="text" class="form-control" id="mapel" name="mapel" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- End Modal Tambah Mata Pelajaran -->

                        <h5 class="card-title">Data Mata Pelajaran</h5>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Mata Pelajaran</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                            <?php
                         

                            // Query untuk mengambil data mata pelajaran
                            $sql = "SELECT * FROM mapel WHERE id_sekolah = ?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("i", $id_sekolah);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                $no = 1;
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $no++ . "</td>";
                                    echo "<td>" . htmlspecialchars($row['mapel']) . "</td>";
                                    echo "<td>
                                            <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#editModal" . $row['id_mapel'] . "'>
                                            Edit
                                            </button>
                                            <form action='../proses/admin-mapel.php?act=delete-mapel' method='post' style='display:inline-block;'>
                                                <input type='hidden' name='id_mapel' value='" . $row['id_mapel'] . "'>
                                                <button type='submit' class='btn btn-danger' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>
                                                Hapus
                                                </button>
                                            </form>
                                          </td>";
                                    echo "</tr>";

                                    // Modal untuk edit data
                                    echo "
                                        <div class='modal fade' id='editModal" . $row['id_mapel'] . "' tabindex='-1' aria-labelledby='editModalLabel" . $row['id_mapel'] . "' aria-hidden='true'>
                                            <div class='modal-dialog modal-dialog-scrollable'>
                                                <form action='../proses/admin-mapel.php?act=update-mapel' method='post'>
                                                    <div class='modal-content'>
                                                        <div class='modal-header'>
                                                            <h5 class='modal-title' id='editModalLabel" . $row['id_mapel'] . "'>Edit Data</h5>
                                                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                                        </div>
                                                        <div class='modal-body'>
                                                            <input type='hidden' name='id_mapel' value='" . htmlspecialchars($row['id_mapel']) . "'>
                                                            <div class='mb-3'>
                                                                <label for='mapel' class='form-label'>Mata Pelajaran</label>
                                                                <input type='text' class='form-control' name='mapel' value='" . htmlspecialchars($row['mapel']) . "' required>
                                                            </div>
                                                        </div>
                                                        <div class='modal-footer'>
                                                            <button type='submit' class='btn btn-primary'>Update</button>
                                                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>";
                                }
                            } else {
                                echo "<tr><td colspan='3'>Tidak ada data mata pelajaran yang ditemukan.</td></tr>";
                            }

                            // Menutup koneksi database
                            $conn->close();
                            ?>
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include '../components/footer.php'; ?>
