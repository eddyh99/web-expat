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
                                <option value="Banda Aceh" <?= (@$outlet->provinsi == "Banda Aceh") ? 'selected' : "" ?>>Banda Aceh</option>
                                <option value="Bali" <?= (@$outlet->provinsi == "Bali") ? 'selected' : "" ?>>Bali</option>
                                <option value="Jakarta" <?= (@$outlet->provinsi == "Jakarta") ? 'selected' : "" ?>>Jakarta</option>
                                <option value="Tanggerang" <?= (@$outlet->provinsi == "Tanggerang") ? 'selected' : "" ?>>Tanggerang</option>
                                <option value="Yogyakarta" <?= (@$outlet->provinsi == "Yogyakarta") ? 'selected' : "" ?>>Yogyakarta</option>
                                <option value="Surabaya" <?= (@$outlet->provinsi == "Surabaya") ? 'selected' : "" ?>>Surabaya</option>
                                <option value="Makassar" <?= (@$outlet->provinsi == "Makassar") ? 'selected' : "" ?>>Makassar</option>
                                <option value="Medan" <?= (@$outlet->provinsi == "Medan") ? 'selected' : "" ?>>Medan</option>
                                <option value="Gorontalo" <?= (@$outlet->provinsi == "Gorontalo") ? 'selected' : "" ?>>Gorontalo</option>
                                <option value="Jambi" <?= (@$outlet->provinsi == "Jambi") ? 'selected' : "" ?>>Jambi</option>
                                <option value="Bandung" <?= (@$outlet->provinsi == "Bandung") ? 'selected' : "" ?>>Bandung</option>
                                <option value="Bekasi" <?= (@$outlet->provinsi == "Bekasi") ? 'selected' : "" ?>>Bekasi</option>
                                <option value="Bogor" <?= (@$outlet->provinsi == "Bogor") ? 'selected' : "" ?>>Bogor</option>
                                <option value="Depok" <?= (@$outlet->provinsi == "Depok") ? 'selected' : "" ?>>Depok</option>
                                <option value="Salatiga" <?= (@$outlet->provinsi == "Salatiga") ? 'selected' : "" ?>>Salatiga</option>
                                <option value="Semarang" <?= (@$outlet->provinsi == "Semarang") ? 'selected' : "" ?>>Semarang</option>
                                <option value="Surakarta" <?= (@$outlet->provinsi == "Surakarta") ? 'selected' : "" ?>>Surakarta</option>
                                <option value="Kediri" <?= (@$outlet->provinsi == "Kediri") ? 'selected' : "" ?>>Kediri</option>
                                <option value="Malang" <?= (@$outlet->provinsi == "Malang") ? 'selected' : "" ?>>Malang</option>
                                <option value="Mojokerto" <?= (@$outlet->provinsi == "Mojokerto") ? 'selected' : "" ?>>Mojokerto</option>
                                <option value="Pontianak" <?= (@$outlet->provinsi == "Pontianak") ? 'selected' : "" ?>>Pontianak</option>
                                <option value="Banjarmasin" <?= (@$outlet->provinsi == "Banjarmasin") ? 'selected' : "" ?>>Banjarmasin</option>
                                <option value="Balikpapan" <?= (@$outlet->provinsi == "Balikpapan") ? 'selected' : "" ?>>Balikpapan</option>
                                <option value="Samarinda" <?= (@$outlet->provinsi == "Samarinda") ? 'selected' : "" ?>>Samarinda</option>
                                <option value="IKN" <?= (@$outlet->provinsi == "IKN") ? 'selected' : "" ?>>IKN</option>
                                <option value="Manado" <?= (@$outlet->provinsi == "Manado") ? 'selected' : "" ?>>Manado</option>
                                <option value="Padang" <?= (@$outlet->provinsi == "Padang") ? 'selected' : "" ?>>Padang</option>
                                <option value="Jayapura" <?= (@$outlet->provinsi == "Jayapura") ? 'selected' : "" ?>>Jayapura</option>
                               
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

