<!-- MAIN CONTENT START -->
<div class="container-fluid">
    <div class="row my-4">
        <div class="col-lg-12 d-flex align-items-strech">
            <a href="<?= base_url()?>employe" class="btn btn-outline-expat d-flex align-items-center">
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
                    <h5 class="card-title fw-semibold mb-4">Edit Employe</h5>
                    <form action="<?= base_url()?>employe/editemploye_process" method="POST">
                        <input type="hidden" id="token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" name="urisegment" value="<?php echo $this->uri->segment('3')?>">
                        <input type="hidden" name="oldpass" value="<?= $member->passwd?>">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" value="<?= @$member->nama?>" id="name" name="name" placeholder="Enter Name..." required maxlength="100" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="passwd" name="passwd" placeholder="Enter password..." maxlength="100" autocomplete="off">
                            <small class="text-danger">*leave blank if you don't want to change the password</small>
                        </div>
                        <div class="mb-3 col-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select name="gender" id="gender" class="form-select">
                                <option value="male" <?php echo ($member->gender=="male")?"selected":"" ?>>Male</option>
                                <option value="female" <?php echo ($member->gender=="female")?"selected":"" ?>>Female</option>
                            </select>
                        </div>
                        <div class="mb-3 col-3">
                            <label for="is_driver" class="form-label">Are you driver?</label>
                            <select name="is_driver" id="is_driver" class="form-select">
                                <option value="yes" <?php echo ($member->is_driver=="yes")?"selected":"" ?>>Yes</option>
                                <option value="no" <?php echo ($member->is_driver=="no")?"selected":"" ?>>No</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-expat mt-3">Update Employe</button>
                  </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- MAIN CONTENT END -->

