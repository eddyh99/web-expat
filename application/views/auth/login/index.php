<div class="card mb-0">
    <div class="card-body">
        <a href="" class="text-nowrap logo-img text-center d-block py-3 w-100">
            <img src="<?= base_url()?>assets/img/logo.png" width="180" alt="" data-aos="flip-up" data-aos-duration="2000">
        </a>
        <form action="<?= base_url()?>auth/auth_login" method="POST">
            <input type="hidden" id="token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" class="form-control" id="username" aria-describedby="UsernameHelp">
            </div>
            <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password">
            </div>
            <!-- <div class="mb-4">
                <select name="role_login" id="role_login">
                    <option value="admin">Admin</option>
                    <option value="sales">Sales</option>
                    <option value="akunting">Akunting</option>
                </select>
            </div> -->

            <!-- <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="form-check">
                    <input class="form-check-input primary" type="checkbox" value="" id="flexCheckChecked" checked>
                    <label class="form-check-label text-dark" for="flexCheckChecked">
                        Ingat Saya
                    </label>
                </div>
                <a class="text-primary fw-bold" href="<?= base_url() ?>auth/forgot_password">Forgot Password ?</a>
            </div> -->
            <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Login</button>
        </form>
    </div>
</div>
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

<?php } 
    if(isset($_SESSION["error"])){
?>
    setTimeout(function() {
        Swal.fire({
            html: '<?= $_SESSION['error'] ?>',
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


