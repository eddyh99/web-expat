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
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter outlet name..." required maxlength="100" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Outlet Address</label>
                            <input type="text" class="form-control" id="address" name="address" placeholder="Enter address..." required autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="lat" class="form-label">
                                Latitude <small>(for more information about lat & long click <a href="https://support.google.com/maps/answer/18539?hl=en&co=GENIE.Platform%3DAndroid&oco=0" target="_blank">here</a>)</small>
                            </label>
                            <input type="text" class="form-control" id="lat" name="lat" placeholder="Enter Latitude ..." required maxlength="50" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="long" class="form-label">Longitude </label>
                            <input type="text" class="form-control" id="long" name="long" placeholder="Enter Longitude..." required maxlength="50" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">City</label>
                            <select class="addprovinsi-select2" id="provinsi" name="provinsi" >
                                <option value="Banda Aceh">Banda Aceh</option>
                                <option value="Bali">Bali</option>
                                <option value="Jakarta">Jakarta</option>
                                <option value="Tanggerang">Tanggerang</option>
                                <option value="Yogyakarta">Yogyakarta</option>
                                <option value="Surabaya">Surabaya</option>
                                <option value="Makassar">Makassar</option>
                                <option value="Medan">Medan</option>
                                <option value="Gorontalo">Gorontalo</option>
                                <option value="Jambi">Jambi</option>
                                <option value="Bandung">Bandung</option>
                                <option value="Bekasi">Bekasi</option>
                                <option value="Bogor">Bogor</option>
                                <option value="Depok">Depok</option>
                                <option value="Salatiga">Salatiga</option>
                                <option value="Semarang">Semarang</option>
                                <option value="Surakarta">Surakarta</option>
                                <option value="Kediri">Kediri</option>
                                <option value="Malang">Malang</option>
                                <option value="Mojokerto">Mojokerto</option>
                                <option value="Pontianak">Pontianak</option>
                                <option value="Banjarmasin">Banjarmasin</option>
                                <option value="Balikpapan">Balikpapan</option>
                                <option value="Samarinda">Samarinda</option>
                                <option value="IKN">IKN</option>
                                <option value="Manado">Manado</option>
                                <option value="Padang">Padang</option>
                                <option value="Jayapura">Jayapura</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="opening" class="form-label">Opening</label>
                            <input type="text" class="form-control" id="opening" name="opening" maxlength="255" placeholder="Ex: Monday to Sunday, 7 AM - 7 PM" required autocomplete="off">
                        </div>
                        <div class="mb-4">
                            <label for="contact" class="form-label">Contact</label>
                            <input type="text" class="form-control" id="contact" name="contact" maxlength="50" placeholder="Enter contact outlet..." required autocomplete="off">
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
                        <div class="mb-4 col-12">
                            <label for="produk" class="form-label">Select Produk</label>
                            <select name="produk[]" multiple="multiple" id="produk" class="form-control produk_select2">
                                <?php foreach($produk as $cb){?>
                                    <option value="<?= $cb->id?>"><?= $cb->nama?></option>
                                <?php }?>
                            </select>
                            <input type="checkbox" id="selectall">
                            <label for="selectall">
                                Select All
                            </label>
                        </div>
                        <button type="submit" class="btn btn-expat mt-3">Save Outlet</button>
                  </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- MAIN CONTENT END -->

