<div class="app-content px-2 row  mb-5 pb-5">
    <div class="app-member mx-auto col-12 col-lg-8 mt-5 border-1 border-white">
        <?php if (@isset($_SESSION["error"])) { ?>
            <div class="col-12 alert alert-danger alert-dismissible fade show" role="alert">
                <span class="notif-login f-poppins"><?= $_SESSION["error"] ?></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php } ?>
        <form id="enterpinform" action="<?= base_url()?>widget/order/detail_process" method="POST">

            <input type="hidden" id="usertoken" name="usertoken" value="<?= $token?>">
            <input type="hidden" id="id_cabang" name="id_cabang" value="<?= $token?>">
            <div class="mb-4">
                <h1 class="f-lora color-expat">Enter Pin </h1>
            </div>
            <div>
                <input type="text" id="pincode" name="enterpin" class="form-control" placeholder="Enter pincode" />
            </div>
        </form>
    </div>
</div>