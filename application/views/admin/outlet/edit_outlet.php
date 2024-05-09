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
                    <h5 class="card-title fw-semibold mb-4">Edit Outlet</h5>
                    <form action="<?= base_url()?>outlet/editoutlet_process" enctype='multipart/form-data' method="POST">
                        <input type="hidden" id="token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" name="urisegment" value="<?php echo $this->uri->segment('3')?>">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name Outlet</label>
                            <input type="text" class="form-control" value="<?= @$outlet->nama?>" id="name" name="name" placeholder="Enter outlet name..." required autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Outlet Address</label>
                            <input type="text" class="form-control" value="<?= @$outlet->alamat?>" id="address" name="address" placeholder="Enter address..." required autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Cabang</label>
                            <select class="addprovinsi-select2" id="provinsi" name="provinsi" required>
                                <option value="Aceh" <?= (@$outlet->provinsi == "Aceh") ? 'selected' : "" ?>>Aceh</option>
                                <option value="Bali" <?= (@$outlet->provinsi == "Bali") ? 'selected' : "" ?>>Bali</option>
                                <option value="Bangka Belitung" <?= (@$outlet->provinsi == "Bangka Belitung") ? 'selected' : "" ?>>Bangka Belitung</option>
                                <option value="Banten" <?= (@$outlet->provinsi == "Banten") ? 'selected' : "" ?>>Banten</option>
                                <option value="Bengkulu"  <?= (@$outlet->provinsi == "Bengkulu") ? 'selected' : "" ?>>Bengkulu</option>
                                <option value="Jawa Tengah"  <?= (@$outlet->provinsi == "Jawa Tengah") ? 'selected' : "" ?>>Jawa Tengah</option>
                                <option value="Kalimantan Tengah"  <?= (@$outlet->provinsi == "Kalimantan Tengah") ? 'selected' : "" ?>>Kalimantan Tengah</option>
                                <option value="Sulawesi Tengah"  <?= (@$outlet->provinsi == "Sulawesi Tengah") ? 'selected' : "" ?>>Sulawesi Tengah</option>
                                <option value="Jawa Timur"  <?= (@$outlet->provinsi == "Jawa Timur") ? 'selected' : "" ?>>Jawa Timur</option>
                                <option value="Kalimantan Timur"  <?= (@$outlet->provinsi == "Kalimantan Timur") ? 'selected' : "" ?>>Kalimantan Timur</option>
                                <option value="Nusa Tenggara Timur"  <?= (@$outlet->provinsi == "Nusa Tenggara Timur") ? 'selected' : "" ?>>Nusa Tenggara Timur</option>
                                <option value="Gorontalo"  <?= (@$outlet->provinsi == "Banten") ? 'Gorontalo' : "" ?>>Gorontalo</option>
                                <option value="DKI Jakarta"  <?= (@$outlet->provinsi == "DKI Jakarta") ? 'selected' : "" ?>>DKI Jakarta</option>
                                <option value="Surabaya"  <?= (@$outlet->provinsi == "Surabaya") ? 'selected' : "" ?>>Surabaya</option>
                                <option value="Jambi"  <?= (@$outlet->provinsi == "Jambi") ? 'selected' : "" ?>>Jambi</option>
                                <option value="Lampung"  <?= (@$outlet->provinsi == "Lampung") ? 'selected' : "" ?>>Lampung</option>
                                <option value="Maluku"  <?= (@$outlet->provinsi == "Maluku") ? 'selected' : "" ?>>Maluku</option>
                                <option value="Kalimantan Utara"  <?= (@$outlet->provinsi == "Kalimantan Utara") ? 'selected' : "" ?>>Kalimantan Utara</option>
                                <option value="Maluku Utara"  <?= (@$outlet->provinsi == "Maluku Utara") ? 'selected' : "" ?>>Maluku Utara</option>
                                <option value="Sulawesi Utara"  <?= (@$outlet->provinsi == "Sulawesi Utara") ? 'selected' : "" ?>>Sulawesi Utara</option>
                                <option value="Papua"  <?= (@$outlet->provinsi == "Papua") ? 'selected' : "" ?>>Papua</option>
                                <option value="Riau"  <?= (@$outlet->provinsi == "Riau") ? 'selected' : "" ?>>Riau</option>
                                <option value="Kepulauan Riau"  <?= (@$outlet->provinsi == "Kepulauan Riau") ? 'selected' : "" ?>>Kepulauan Riau</option>
                                <option value="Sulawesi Tenggara" <?= (@$outlet->provinsi == "Sulawesi Tenggara") ? 'selected' : "" ?>>Sulawesi Tenggara</option>
                                <option value="Kalimantan Selatan"  <?= (@$outlet->provinsi == "Kalimantan Selatan") ? 'selected' : "" ?>>Kalimantan Selatan</option>
                                <option value="Sulawesi Selatan"  <?= (@$outlet->provinsi == "Sulawesi Selatan") ? 'selected' : "" ?>>Sulawesi Selatan</option>
                                <option value="Sumatera Selatan"  <?= (@$outlet->provinsi == "Sumatra Selatan") ? 'selected' : "" ?>>Sumatera Selatan</option>
                                <option value="Jawa Barat"  <?= (@$outlet->provinsi == "Jawa Barat") ? 'selected' : "" ?>>Jawa Barat</option>
                                <option value="Kalimantan Barat"  <?= (@$outlet->provinsi == "Kalimantan Barat") ? 'selected' : "" ?>>Kalimantan Barat</option>
                                <option value="Nusa Tenggara Barat"  <?= (@$outlet->provinsi == "Nusa Tenggara Barat") ? 'selected' : "" ?>>Nusa Tenggara Barat</option>
                                <option value="Papua Barat"  <?= (@$outlet->provinsi == "Papua Barat") ? 'selected' : "" ?>>Papua Barat</option>
                                <option value="Sulawesi Barat"  <?= (@$outlet->provinsi == "Sulawesi Barat") ? 'selected' : "" ?>>Sulawesi Barat</option>
                                <option value="Sumatera Barat"  <?= (@$outlet->provinsi == "Sumatra Barat") ? 'selected' : "" ?>>Sumatera Barat</option>
                                <option value="Daerah Istimewa Yogyakarta"  <?= (@$outlet->provinsi == "Daerah Istimewa Yogyakarta") ? 'selected' : "" ?>>Daerah Istimewa Yogyakarta</option>
                                <option value="Papua Selatan"  <?= (@$outlet->provinsi == "Papua Selatan") ? 'selected' : "" ?>>Papua Selatan</option>
                                <option value="Papua Tengah"  <?= (@$outlet->provinsi == "Papua Tengah") ? 'selected' : "" ?>>Papua Tengah</option>
                                <option value="Papua Pegunungan"  <?= (@$outlet->provinsi == "Papua Pegunungan") ? 'selected' : "" ?>>Papua Pegunungan</option>
                                <option value="Papua Barat Daya"  <?= (@$outlet->provinsi == "Papua Barat Daya") ? 'selected' : "" ?>>Papua Barat Daya</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="opening" class="form-label">Opening</label>
                            <input type="text" class="form-control" value="<?= @$outlet->opening?>" id="opening" name="opening" placeholder="Ex: Monday to Sunday, 7 AM - 7 PM" required autocomplete="off">
                        </div>
                        <div class="mb-4">
                            <label for="contact" class="form-label">Contact</label>
                            <input type="text" class="form-control" value="<?= @$outlet->kontak?>" id="contact" name="contact" placeholder="Enter contact outlet..." required autocomplete="off">
                        </div>
                        <div class="mb-3">   
                            <label for="images-logo" class="form-label">Image</label>   
                            <div class="d-flex flex-column">
                                <div class="col-12 col-sm-8 col-lg-6 input-outlet-image">
                                    <input name="imgoutlet" type="file" id="images-logo" accept="image/jpg, image/jpeg, image/png" style="cursor: pointer;">
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12 d-flex flex-column flex-sm-row">
                                        <img id="image-container" class="preview-image-container" />
                                        <span class="p-4 fw-bolder">
                                            <p class="text-findme text-start">*Maximum 2MB</p>
                                            <p class="text-findme text-start">*png, jpg</p>
                                        </span>
                                        <div class="d-flex flex-row flex-sm-column">
                                            <span class="d-block">previous image</span>
                                            <img  class="preview-image-container d-block" src="<?= @$outlet->picture?>"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-expat mt-3">Update Outlet</button>
                  </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- MAIN CONTENT END -->

