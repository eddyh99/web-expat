<!-- MAIN CONTENT START -->
<div class="container-fluid">
    <!--  Row Daftar User -->
    <div class="row my-4">
        <div class="col-lg-12 d-flex align-items-strech">
            <!-- <a href="<?= base_url()?>member/add_member" class="btn btn-expat d-flex align-items-center">
                <i class="ti ti-plus fs-5 me-2"></i>
                <span>
                    Add Member
                </span>
            </a> -->
            <!-- <label class="text-start d-block mb-2">Range Date</label>
                            <input type="text" id="tanggal" name="tanggal" class="form-control" value="" autocomplete="off"> -->
        </div>
    </div>
    <!--  Row List User-->
    <div class="row">
        <div class="col-lg-12 d-flex align-items-strech">
            <div class="card border-expat w-100">
                <div class="card-body">
                    <div class="d-flex flex-column align-items-start flex-lg-row align-items-lg-center justify-content-between">
                        <h5 class="card-title fw-semibold mb-4">List Topup</h5>
                        <div class="d-flex flex-column align-items-end flex-md-row col-12 col-lg-8">
                            <div class="col-12 col-md-6 mx-2 my-2 my-md-0">
                                <label class="text-start form-label d-block mb-2">Range Date</label>
                                <input type="text" id="tanggal" name="tanggal" class="form-control" autocomplete="off">
                            </div>
                            <div class="col-12 col-md-4 mx-2 my-2 my-md-0">
                                <label for="role" class="form-label">Topup Status</label>
                                <select name="topup_status" id="topup_status" class="form-select member-status">
                                    <option value="">All</option>
                                    <option value="pending">Pending</option>
                                    <option value="success">Success</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-2 my-2 my-md-0">
                                <button id="filter" class="btn btn-info">
                                    <i class="ti ti-filter fs-5 me-1"></i>
                                    Filter
                                </button>
                            </div>
                        </div>
                    </div>
                    <br>
                    <table id="table_history_topup" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID Member</th>
                                <th>Date</th>
                                <th>Invoice</th>
                                <th>Nominal</th>
                                <th>Poin</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID Member</th>
                                <th>Date</th>
                                <th>Invoice</th>
                                <th>Nominal</th>
                                <th>Poin</th>
                                <th>Action</th>
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


