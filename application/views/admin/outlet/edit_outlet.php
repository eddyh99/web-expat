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
                                            <span class="d-block">Old Image</span>
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

