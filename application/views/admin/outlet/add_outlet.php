<!-- MAIN CONTENT START -->
<div class="container-fluid">
    <div class="row my-4">
        <div class="col-lg-12 d-flex align-items-strech">
            <a href="<?= base_url()?>outlet" class="btn btn-outline-expat d-flex align-items-center">
                <i class="ti ti-chevron-left fs-5 me-1"></i>
                <span>
                    Back
                </span>
            </a>
        </div>
    </div>
    <!--  Row Daftar User Agent -->
    <div class="row">
        <div class="col-lg-12 d-flex align-items-strech">
            <div class="card border-expat w-100">
                <div class="card-body">
                    <?php if (@isset($_SESSION["error"])) { ?>
                        <div class="col-12 alert alert-danger alert-dismissible fade show" role="alert">
                            <span class="notif-login f-poppins"><?= $_SESSION["error"] ?></span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } ?>
                    <h5 class="card-title fw-semibold mb-4">Add Outlet</h5>
                    <form action="<?= base_url()?>outlet/addoutlet_process" enctype='multipart/form-data' method="POST">
                        <input type="hidden" id="token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter outlet name..." required autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Outlet Address</label>
                            <input type="text" class="form-control" id="address" name="address" placeholder="Enter address..." required autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Cabang</label>
                            <select class="addprovinsi-select2" id="provinsi" name="provinsi" >
                                <option value="Aceh">Aceh</option>
                                <option value="Bali">Bali</option>
                                <option value="Bangka Belitung">Bangka Belitung</option>
                                <option value="Banten">Banten</option>
                                <option value="Bengkulu">Bengkulu</option>
                                <option value="Jawa Tengah">Jawa Tengah</option>
                                <option value="Kalimantan Tengah">Kalimantan Tengah</option>
                                <option value="Sulawesi Tengah">Sulawesi Tengah</option>
                                <option value="Jawa Timur">Jawa Timur</option>
                                <option value="Kalimantan Timur">Kalimantan Timur</option>
                                <option value="Nusa Tenggara Timur">Nusa Tenggara Timur</option>
                                <option value="Gorontalo">Gorontalo</option>
                                <option value="DKI Jakarta">DKI Jakarta</option>
                                <option value="Surabaya">Surabaya</option>
                                <option value="Jambi">Jambi</option>
                                <option value="Lampung">Lampung</option>
                                <option value="Maluku">Maluku</option>
                                <option value="Kalimantan Utara">Kalimantan Utara</option>
                                <option value="Maluku Utara">Maluku Utara</option>
                                <option value="Sulawesi Utara">Sulawesi Utara</option>
                                <option value="Papua">Papua</option>
                                <option value="Riau">Riau</option>
                                <option value="Kepulauan Riau">Kepulauan Riau</option>
                                <option value="Sulawesi Tenggara">Sulawesi Tenggara</option>
                                <option value="Kalimantan Selatan">Kalimantan Selatan</option>
                                <option value="Sulawesi Selatan">Sulawesi Selatan</option>
                                <option value="Sumatera Selatan">Sumatera Selatan</option>
                                <option value="Jawa Barat">Jawa Barat</option>
                                <option value="Kalimantan Barat">Kalimantan Barat</option>
                                <option value="Nusa Tenggara Barat">Nusa Tenggara Barat</option>
                                <option value="Papua Barat">Papua Barat</option>
                                <option value="Sulawesi Barat">Sulawesi Barat</option>
                                <option value="Sumatera Barat">Sumatera Barat</option>
                                <option value="Daerah Istimewa Yogyakarta">Daerah Istimewa Yogyakarta</option>
                                <option value="Papua Selatan">Papua Selatan</option>
                                <option value="Papua Tengah">Papua Tengah</option>
                                <option value="Papua Pegunungan">Papua Pegunungan</option>
                                <option value="Papua Barat Daya">Papua Barat Daya</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="opening" class="form-label">Opening</label>
                            <input type="text" class="form-control" id="opening" name="opening" placeholder="Ex: Monday to Sunday, 7 AM - 7 PM" required autocomplete="off">
                        </div>
                        <div class="mb-4">
                            <label for="contact" class="form-label">Contact</label>
                            <input type="text" class="form-control" id="contact" name="contact" placeholder="Enter contact outlet..." required autocomplete="off">
                        </div>
                        <div class="mb-3">   
                            <label for="images-logo" class="form-label">Image</label>   
                            <div class="d-flex flex-column">
                                <div class="col-12 col-sm-8 col-lg-6 input-outlet-image">
                                    <input name="imgoutlet" type="file" id="images-logo" accept="image/jpg, image/jpeg, image/png" style="cursor: pointer;" >
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12 d-flex flex-column flex-sm-row">
                                        <img id="image-container" class="preview-image-container" />
                                        <span class="p-4 fw-bolder">
                                            <p class="text-findme text-start">*Maximum 2MB</p>
                                            <p class="text-findme text-start">*png, jpg</p>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-expat mt-3">Save Outlet</button>
                  </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- MAIN CONTENT END -->

