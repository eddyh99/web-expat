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
                    <div class="row">
                        <div class="col-4">
                            <div>
                                <img class="img-fluid w-50" src="<?= $memberm->picture?>" alt="img">
                                <!-- image masih salah -->
                            </div>
                            <div>
                                <span><?= $member->memberid?></span>
                            </div>
                            <div>
                                <h5 class="mt-3"><?= $member->nama?></h5>
                            </div>
                        </div>
                        <div class="col-4 d-flex flex-column justify-content-between">
                            <div>
                                <h5>Contact: </h5>
                                <span><?= $member->email?></span><br>
                                <span><?= $member->phone?></span>
                            </div>
                            <div>
                                <h5>Membership: </h5>
                                <span><?= $member->membership?> | <?= $memberm->poin?> poin</span>
                            </div>
                            <div>
                                <h5>Gender: </h5>
                                <span><?= $member->gender?></span>
                            </div>
                        </div>
                        <div class="col-4 d-flex flex-column justify-content-between">
                            <div>
                                <h5>Tanggal Lahir: </h5>
                                <span><?= $member->dob?></span>
                            </div>
                            <div>
                                <h5>Country: </h5>
                                <span><?= $member->country?></span>
                            </div>
                            <div>
                                <h5>Saldo: </h5>
                                <span>Rp <?=  number_format($memberm->saldo,2,".",",")?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- List Topup Member -->
    <div class="row">
        <div class="col-lg-12 d-flex align-items-strech">
            <div class="card border-expat w-100">
                <div class="card-body">
                    <div class="d-flex flex-column align-items-end flex-md-row col-12 col-lg-8 mb-4">
                        <div class="col-12 col-md-6 mx-2 my-2 my-md-0">
                            <label class="text-start d-block mb-2">Select Month</label>
                            <input type="month" value="<?= date('Y-m')?>" id="month_topup" name="month_topup" class="form-control" autocomplete="off">
                        </div>
                        <div class="col-12 col-md-2 my-2 my-md-0">
                            <button id="filter_topup" class="btn btn-info">
                                <i class="ti ti-filter fs-5 me-1"></i>
                                Filter
                            </button>
                        </div>
                    </div>
                    <table id="table_membertopup" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Amount</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Amount</th>
                                <th>Tanggal</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- List Transaksi Order Member -->
    <div class="row">
        <div class="col-lg-12 d-flex align-items-strech">
            <div class="card border-expat w-100">
                <div class="card-body">
                    <div class="d-flex flex-column align-items-end flex-md-row col-12 col-lg-8 mb-4">
                        <div class="col-12 col-md-6 mx-2 my-2 my-md-0">
                            <label class="text-start d-block mb-2">Select Month</label>
                            <input type="month" value="<?= date('Y-m')?>" id="month_order" name="month_order" class="form-control" autocomplete="off">
                        </div>
                        <div class="col-12 col-md-2 my-2 my-md-0">
                            <button id="filter_order" class="btn btn-info">
                                <i class="ti ti-filter fs-5 me-1"></i>
                                Filter
                            </button>
                        </div>
                    </div>
                    <table id="table_memberorder" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                            </tr>
                        </tfoot>
                    </table>
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

<?php if(isset($_SESSION["error"])) { ?>
    <script>
        setTimeout(function() {
            Swal.fire({
                html: '<?= $_SESSION['error'] ?>',
                position: 'top',
                timer: 3000,
                showCloseButton: true,
                showConfirmButton: false,
                icon: 'error',
                timer: 2000,
                timerProgressBar: true,
            });
        }, 100);
    </script>
<?php } ?>
<!-- SWEET ALERT END -->


