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
                    <h5 class="card-title fw-semibold mb-4">Add Produk</h5>
                    <form action="<?= base_url()?>produk/addproduk_process" enctype='multipart/form-data' method="POST">
                        <input type="hidden" id="token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter produk name..." required autocomplete="off" maxlength="55">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" rows="3" class="form-control" placeholder="Enter description..."></textarea>
                        </div>
                        <div class="mb-3 col-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <select name="kategori" id="kategori" class="form-select">
                                <option value="food">Food</option>
                                <option value="drink">Drink</option>
                                <option value="retail">Retail</option>
                            </select>
                        </div>
                        <div class="mb-3 col-3">
                            <label for="favorite" class="form-label">Favorite</label>
                            <select name="favorite" id="favorite" class="form-select">
                                <option value="yes">yes</option>
                                <option value="no">no</option>
                            </select>
                        </div>
                        <div class="mb-3">   
                            <label for="images-logo" class="form-label">Image</label>   
                            <div class="d-flex flex-column">
                                <div class="col-12 col-sm-8 col-lg-6 input-outlet-image">
                                    <input name="imgproduk" type="file" id="images-logo" accept="image/jpg, image/jpeg, image/png" style="cursor: pointer;" >
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
                        <button type="submit" class="btn btn-expat mt-3">Save Produk</button>
                    </form>
                    

                    <!-- <section class="mt-4">
                        <div class="container">
                            <form action="<?= base_url()?>produk/addproduk_process" enctype='multipart/form-data' method="POST" class="card" >
                                <div class="card-header">
                                    <nav class="nav nav-pills nav-fill">
                                        <a class="nav-link tab-pills" style="cursor: auto;" href="#">Add Produk</a>
                                        <a class="nav-link tab-pills" style="cursor: auto;" href="#">Add Variant Produk</a>
                                        <a class="nav-link tab-pills" style="cursor: auto;" href="#">Add Addtional</a>
                                        <a class="nav-link tab-pills" style="cursor: auto;" href="#">Finish</a>
                                    </nav>
                                </div>
                                <div class="card-body">
                                    <div class="tab d-none">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter produk name..." required autocomplete="off">
                                        </div>
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea name="description" id="description" rows="3" class="form-control" placeholder="Enter description..."></textarea>
                                        </div>
                                        <div class="mb-3 col-3">
                                            <label for="favorite" class="form-label">Favorite</label>
                                            <select name="favorite" id="favorite" class="form-select">
                                                <option value="yes">yes</option>
                                                <option value="no">no</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">   
                                            <label for="images-logo" class="form-label">Image</label>   
                                            <div class="d-flex flex-column">
                                                <div class="col-12 col-sm-8 col-lg-6 input-outlet-image">
                                                    <input name="imgoutlet" type="file" id="images-logo" accept="image/jpg, image/jpeg, image/png" style="cursor: pointer;" required>
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
                                    </div>

                                    <div class="tab d-none">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Address 1</label>
                                            <input type="text" class="form-control" name="name" id="name" placeholder="Please enter address 1">
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Address 2</label>
                                            <input type="email" class="form-control" name="email" id="email" placeholder="Please enter address 2">
                                        </div>
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                            <label for="city" class="form-label">City</label>
                                            <input type="text" class="form-control" name="city" id="city" placeholder="Please enter city">
                                            </div>
                                            <div class="mb-3 col-md-6">
                                            <label for="state" class="form-label">State</label>
                                            <input type="state" class="form-control" name="state" id="state" placeholder="Please enter state">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab d-none">
                                        <div class="mb-3">
                                            <label for="company_name" class="form-label">Company Name</label>
                                            <input type="text" class="form-control" name="company_name" id="company_name" placeholder="Please enter company name">
                                        </div>
                                        <div class="mb-3">
                                            <label for="company_address" class="form-label">Company Address</label>
                                            <textarea class="form-control" name="company_address" id="company_address" placeholder="Please enter company address"></textarea>
                                        </div>
                                    </div>

                                    <div class="tab d-none">
                                        <p>All Set! Please submit to continue. Thank you</p>
                                    </div>
                                </div>
                                <div class="card-footer text-end">
                                    <div class="d-flex">
                                        <button type="button" id="back_button" class="btn btn-link fs-3" onclick="back()"><i class="ti ti-chevron-left fs-3"></i>Back</button>
                                        <button type="button" id="next_button" class="btn btn-expat ms-auto" onclick="next()">Next</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </section> -->

                </div>
            </div>
        </div>
    </div>

</div>
<!-- MAIN CONTENT END -->

