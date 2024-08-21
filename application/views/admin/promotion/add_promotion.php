<!-- MAIN CONTENT START -->
<div class="container-fluid">
    <div class="row my-4">
        <div class="col-lg-12 d-flex align-items-strech">
            <a href="<?= base_url()?>promotion" class="btn btn-outline-expat d-flex align-items-center">
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
                    <h5 class="card-title fw-semibold mb-4">Add Promotion</h5>
                    <form action="<?= base_url()?>promotion/addpromotion_process" method="POST" enctype='multipart/form-data'>
                        <input type="hidden" id="token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" class="form-control" id="description" name="description" placeholder="Enter description..." required autocomplete="off">
                        </div>
                        <div class="mb-3 col-3">
                            <label for="promotion_type" class="form-label">Promotion Type</label>
                            <select name="promotion_type" id="promotion_type" class="form-select">
                                <option value="instore">Store</option>
                                <option value="online">Online</option>
                            </select>
                        </div>
                        <div class="mb-3 col-3">
                            <label for="start_date" class="form-label">Start Date</label>
                            <div class="form-control d-flex">
                                <input type="text" class="w-100 border-0 cursor-pointer" name="start_date" id="start_date" autocomplete="off">
                                <label for="start_date" class="cursor-pointer">
                                    <i class="ti ti-calendar-event fs-6"></i>
                                </label>
                            </div>
                        </div>
                        <div class="mb-3 col-3">
                            <label for="end_date" class="form-label">End Date</label>
                            <div class="form-control d-flex">
                                <input type="text" class="w-100 border-0 cursor-pointer" name="end_date" id="end_date" autocomplete="off" >
                                <label for="end_date" class="cursor-pointer">
                                    <i class="ti ti-calendar-event fs-6"></i>
                                </label>
                            </div>
                        </div>
                        <div class="mb-3 col-3">
                            <label for="end_date" class="form-label">Milestone</label>
                            <div class="form-control d-flex">
                                <input type="number" class="w-100 border-0" name="milestone" id="milestone" value="0" >
                            </div>
                            <label for="end_date" class="cursor-pointer"><small>*fill 0 if this promotion for all milestone</small></label>
                        </div>
                        <div class="mb-3 col-3">
                            <label for="end_date" class="form-label">Minimum Purchase</label>
                            <div class="form-control d-flex">
                                <input type="number" class="w-100 border-0" name="minimum" id="minimum" value="10000" >
                            </div>
                        </div>
                        <div class="mb-3 col-3">
                            <label for="discount_type" class="form-label">Discount Type?</label>
                            <select name="discount_type" id="discount_type" class="form-select">
                                <option value="persen">Percentage</option>
                                <option value="fixed">Fixed Amount</option>
                                <option value="free item">Free Item</option>
                            </select>
                        </div>
                        <div class="mb-3 col-3">
                            <label for="end_date" class="form-label">Discount Amount</label>
                            <div class="form-control d-flex">
                                <input type="number" class="w-100 border-0" name="disc_amount" id="disc_amount" value="0" >
                            </div>
                        </div>
                        <div class="mb-3">   
                            <label for="images-logo" class="form-label">Image</label>   
                            <div class="d-flex flex-column">
                                <div class="col-12 col-sm-8 col-lg-6 input-outlet-image">
                                    <input name="imgpromotion" type="file" id="images-logo" accept="image/jpg, image/jpeg, image/png" style="cursor: pointer;">
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

                        <button type="submit" class="btn btn-expat mt-3">Save Promotion</button>
                  </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- MAIN CONTENT END -->

<script>
    <?php if (isset($_SESSION["error_validation"])) { ?>
        setTimeout(function() {
            Swal.fire({
                html: '<?= trim(str_replace('"', '', json_encode($_SESSION['error_validation']))) ?>',
                position: 'top',
                showCloseButton: true,
                showConfirmButton: false,
                icon: 'error',
                timer: 2000,
                timerProgressBar: true,
            });
        }, 100);

<?php }?>
</script>

