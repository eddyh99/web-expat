<!-- MAIN CONTENT START -->
<div class="container-fluid">
    <div class="row my-4">
        <div class="col-lg-12 d-flex align-items-strech">
            <a href="<?= base_url()?>produk" class="btn btn-outline-expat d-flex align-items-center">
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
                    <h5 class="card-title fw-semibold mb-4">Edit Produk</h5>
                    <form action="<?= base_url()?>produk/editproduk_process" enctype='multipart/form-data' method="POST">
                        <input type="hidden" id="token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" name="urisegment" value="<?php echo $this->uri->segment('3')?>">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" value="<?= @$produk->nama?>" id="name" name="name" placeholder="Enter produk name..." required autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" rows="3" class="form-control" placeholder="Enter description..."><?= @$produk->deskripsi?></textarea>
                        </div>
                        <div class="mb-3 col-3">
                            <label for="favorite" class="form-label">Favorite</label>
                            <select name="favorite" id="favorite" class="form-select">
                                <option value="yes" <?= ($produk->favorite=="yes")?"selected":"" ?>>yes</option>
                                <option value="no" <?= ($produk->favorite=="no")?"selected":"" ?>>no</option>
                            </select>
                        </div>
                        <div class="mb-3">   
                            <label for="images-logo" class="form-label">Image</label>   
                            <div class="d-flex flex-column">
                                <div class="col-12 col-sm-8 col-lg-6 input-outlet-image">
                                    <input name="imgproduk" type="file" id="images-logo" accept="image/jpg, image/jpeg, image/png" style="cursor: pointer;">
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
                                            <img  class="preview-image-container d-block" src="<?= @$produk->picture?>"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-expat mt-3">Save Produk</button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>

</div>
<!-- MAIN CONTENT END -->

