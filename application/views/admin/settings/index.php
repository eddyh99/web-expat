<!-- MAIN CONTENT START -->
<div class="container-fluid">
    <!--  Row Daftar User -->
    <div class="row my-4">
        <div class="col-lg-12 d-flex align-items-strech">
        </div>
    </div>
    <!--  Row List User-->
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
                    <h5 class="card-title fw-semibold mb-4">Settings</h5>
                    <form action="<?= base_url()?>promotion/addpromotion_process" method="POST">
                        <input type="hidden" id="token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <div class="mb-3">
                            <label for="poin" class="form-label">Base Poin</label>
                            <input type="text" class="form-control" id="poin" name="poin" placeholder="Enter poin..." required autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="dfee" class="form-label">Delivery Fee</label>
                            <input type="text" class="form-control" id="dfee" name="dfee" placeholder="Enter Delivery Fee..." required autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="maxarea" class="form-label">Max Area Delivery</label>
                            <input type="text" class="form-control" id="maxarea" name="maxarea" placeholder="Enter Max Area Delivery..." required autocomplete="off">
                        </div>
                        <button type="submit" class="btn btn-expat mt-3">Save Settings</button>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- MAIN CONTENT END -->

<!-- SWEET ALERT START -->
<?php if(isset($_SESSION["success"])) { ?>
    <script>
        setTimeout(function() {
            Swal.fire({
                html: '<?= $_SESSION['success'] ?>',
                position: 'top',
                timer: 3000,
                showCloseButton: true,
                showConfirmButton: false,
                icon: 'success',
                timer: 2000,
                timerProgressBar: true,
            });
        }, 100);
    </script>
<?php } ?>
<!-- SWEET ALERT END -->


