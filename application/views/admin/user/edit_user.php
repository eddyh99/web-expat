<!-- MAIN CONTENT START -->
<div class="container-fluid">
    <div class="row my-4">
        <div class="col-lg-12 d-flex align-items-strech">
            <a href="<?= base_url()?>user" class="btn btn-outline-expat d-flex align-items-center">
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
                    <h5 class="card-title fw-semibold mb-4">Edit User</h5>
                    <form action="<?= base_url()?>user/edituser_process" method="POST">
                        <input type="hidden" id="token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" name="urisegment" value="<?php echo $this->uri->segment('3')?>">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" value="<?= $user->username?>" id="username" name="username" placeholder="Enter username..." required autocomplete="off" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="passwd" name="passwd" placeholder="Enter password..." maxlength="100" autocomplete="off">
                            <small class="text-danger">*leave blank if you don't want to change the password</small>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" value="<?= $user->nama?>" id="name" name="name" placeholder="Enter name..." maxlength="100" required autocomplete="off">
                        </div>
                        <div class="mb-3 col-3">
                            <label for="role" class="form-label">Role</label>
                            <select name="role" id="role" class="form-select">
                                <option value="admin" <?php echo ($user->role=="admin")?"selected":"" ?>>Admin</option>
                                <option value="kasir" <?php echo ($user->role=="kasir")?"selected":"" ?>>Kasir</option>
                                <option value="hr" <?php echo ($user->role=="hr")?"selected":"" ?>>HR</option>
                                <option value="marketing" <?php echo ($user->role=="marketing")?"selected":"" ?>>Marketing</option>
                                <option value="finance" <?php echo ($user->role=="finance")?"selected":"" ?>>Finance</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-expat mt-3">Update User</button>
                  </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- MAIN CONTENT END -->

