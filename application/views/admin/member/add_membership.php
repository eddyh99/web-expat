<!-- MAIN CONTENT START -->
<div class="container-fluid">
    <div class="row my-4">
        <div class="col-lg-12 d-flex align-items-strech">
            <a href="<?= base_url()?>member/membership" class="btn btn-outline-expat d-flex align-items-center">
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
                    <h5 class="card-title fw-semibold mb-4">Add Membership</h5>
                    <form action="<?= base_url()?>promotion/addpromotion_process" method="POST">
                        <input type="hidden" id="token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter title..." required autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" class="form-control" id="description" name="description" placeholder="Enter description..." required autocomplete="off">
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

                        <button type="submit" class="btn btn-expat mt-3">Save Membership</button>
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

