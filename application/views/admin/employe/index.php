<!-- MAIN CONTENT START -->
<div class="container-fluid">
    <!--  Row Daftar User -->
    <div class="row my-4">
        <div class="col-lg-12 d-flex align-items-strech">
            <a href="<?= base_url()?>employe/add_employe" class="btn btn-expat d-flex align-items-center">
                <i class="ti ti-plus fs-5 me-2"></i>
                <span>
                    Add Employe
                </span>
            </a>
        </div>
    </div>
    <!--  Row List User-->
    <div class="row">
        <div class="col-lg-12 d-flex align-items-strech">
            <div class="card border-expat w-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title fw-semibold mb-4">List Employe</h5>
                    </div>
                    <table id="table_list_employe" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Email</th>
                                <th>Name</th>
                                <!-- <th class="th-role">Tanggal Lahir</th> -->
                                <th>Gender</th>
                                <th>Driver</th>
                                <th>Plafon</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Email</th>
                                <th>Name</th>
                                <!-- <th>Tanggal Lahir</th> -->
                                <th>Gender</th>
                                <th>Driver</th>
                                <th>Plafon</th>
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
<!-- SWEET ALERT END -->


