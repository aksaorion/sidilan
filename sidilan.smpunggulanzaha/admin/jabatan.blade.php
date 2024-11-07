<x-layout>

  

    <div class="pagetitle">
      <h1>Jabatan</h1>
      <x-breadcrumb :links="$breadcrumbs" />
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

      

          <div class="card">
            <div class="card-body">
             <br>

              <!-- Pills Tabs -->
              <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Data Jabatan</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="pills-input-tab" data-bs-toggle="pill" data-bs-target="#pills-input" type="button" role="tab" aria-controls="pills-input" aria-selected="false">Tambah Jabatan</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-struktur-tab" data-bs-toggle="pill" data-bs-target="#pills-struktur" type="button" role="tab" aria-controls="pills-struktur" aria-selected="false">Tambah Struktur Organisasi</button>
                  </li>
                
              </ul>
              <div class="tab-content pt-2" id="myTabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="card">
                        <div class="card-body">
                          <br>
            
                          <!-- Table with stripped rows -->
                          <table class="table table-striped">
                            <thead>
                              <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama Jabatan</th>
                                <th scope="col">Pemegang Jabatan</th>
                                
                                <th scope="col">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <th scope="row">1</th>
                                <td></td>
                                <td></td>
                             
                                <td></td>
                              </tr>
                              
                            </tbody>
                          </table>
                          <!-- End Table with stripped rows -->
            
                        </div>
                      </div>
                </div>
                <div class="tab-pane fade" id="pills-input" role="tabpanel" aria-labelledby="input-tab">
                    <div class="card">
                        <div class="card-body">
                          <br>
            
                          <!-- Vertical Form -->
                          <form class="row g-3">
                            <div class="col-12">
                              <label for="divisi" class="form-label">Nama Jabatan</label>
                              <input type="text" class="form-control" id="divisi" name="divisi">
                            </div>
                            
                            <div class="text-center">
                              <button type="submit" class="btn btn-primary">Submit</button>
                              <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                          </form><!-- Vertical Form -->
            
                        </div>
                      </div>
                </div>
                <div class="tab-pane fade" id="pills-struktur" role="tabpanel" aria-labelledby="struktur-tab">
                    <div class="card">
                        <div class="card-body">
                          <br>
            
                          <!-- Vertical Form -->
                          <form class="row g-3">
                            <div class="col-12">
                                <select id="ops_divisi" name="ops_divisi" class="form-select">
                                    <option selected>Pilih Jabatan</option>
                                    <option>...</option>
                                  </select>
                            </div>
                            <div class="col-12">
                                <select id="ops_pendidik" name="ops_pendidik" class="form-select">
                                    <option selected>Pilih Tenaga Pendidik</option>
                                    <option>...</option>
                                  </select>
                            </div>
                            
                            <div class="text-center">
                              <button type="submit" class="btn btn-primary">Submit</button>
                              <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                          </form><!-- Vertical Form -->
            
                        </div>
                      </div>
                  </div>
                
              </div><!-- End Pills Tabs -->

            </div>
          </div>

        </div>

       

      </div>
    </section>

 
</x-layout>