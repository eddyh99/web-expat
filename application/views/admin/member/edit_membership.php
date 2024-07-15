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
                    <h5 class="card-title fw-semibold mb-4">Edit Membership</h5>
                    <form action="<?= base_url()?>member/membership_proses" method="POST">
                        <input type="hidden" id="token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <div class="mb-3">
                            <label for="type" class="form-label">Type</label>
                            <input type="text" class="form-control" id="type" name="type" value="<?= $result[0]['tipe']?>" readonly placeholder="Enter type..." required autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" class="form-control" id="description" name="description" value="<?= $result[0]['deskripsi']?>" placeholder="Enter description..." required autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="minpoin" class="form-label">Min. Poin</label>
                            <input type="number" class="form-control" id="minpoin" name="minpoin" value="<?= $result[0]['minpoin']?>" placeholder="Enter Min Poin..." required autocomplete="off">
                        </div>
                        <div class="mt-5">
                            <label for="minpoin" class="form-label">-------- Start Milestone --------</label>
                        </div>
                        <div class="d-flex flex-column flex-md-row">
                            <div class="m-3">
                                <label for="step1" class="form-label">Step 1</label>
                                <input type="number" class="form-control" value="<?= $result[0]['step1']?>" id="step1" name="step1"  placeholder="Enter Step 1" required autocomplete="off">
                            </div>
                            <div class="m-3">
                                <label for="step2" class="form-label">Step 2</label>
                                <input type="number" class="form-control" value="<?= $result[0]['step2']?>" id="step2" name="step2"  placeholder="Enter Step 2" required autocomplete="off">
                            </div>
                            <div class="m-3">
                                <label for="step3" class="form-label">Step 3</label>
                                <input type="number" class="form-control" value="<?= $result[0]['step3']?>" id="step3" name="step3"  placeholder="Enter Step 3" required autocomplete="off">
                            </div>
                            <div class="m-3">
                                <label for="step4" class="form-label">Step 4</label>
                                <input type="number" class="form-control" value="<?= $result[0]['step4']?>" id="step4" name="step4"  placeholder="Enter Step 4" required autocomplete="off">
                            </div>
                            <div class="m-3">
                                <label for="step5" class="form-label">Step 5</label>
                                <input type="number" class="form-control" value="<?= $result[0]['step5']?>" id="step5" name="step5"  placeholder="Enter Step 5" required autocomplete="off">
                            </div>
                            <div class="m-3">
                                <label for="step6" class="form-label">Step 6</label>
                                <input type="number" class="form-control" value="<?= $result[0]['step6']?>" id="step6" name="step6"  placeholder="Enter Step 6" required autocomplete="off">
                            </div>
                        </div>
                        <div class=" my-4">
                            <label for="minpoin" class="form-label">-------- End Milestone --------</label>
                        </div>
                        <button type="submit" class="btn btn-expat mt-3">Update Membership</button>
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

