<!-- MAIN CONTENT START -->
<div class="container-fluid">
    <!--  Row Daftar User -->
    <div class="row my-4">
        <div class="col-lg-12 d-flex align-items-strech">
            <a href="<?= base_url()?>produk/add_variant" class="btn btn-expat d-flex align-items-center">
                <i class="ti ti-plus fs-5 me-2"></i>
                <span>
                    Add Variant
                </span>
            </a>
        </div>
    </div>
    <!--  Row List User-->
    <div class="row">
        <div class="col-lg-12 d-flex align-items-strech">
            <div class="card border-expat w-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-5">
                        <h5 class="card-title fw-semibold mb-4">List Produk</h5>
                        <div class="d-flex align-items-center">
                            <select id="produk_filter" class="form-select w-100" name="produk_filter">
                                <?php foreach($produk as $p){?>
                                    <option value="<?= $p->id?>"><?= $p->nama?></option>
                                <?php }?>
                            </select>
                            <!-- <div class="ms-3 d-flex align-items-center">
                                <a id="editprice" class="btn btn-primary" style="min-width: max-content;"><i class="ti ti-pencil-minus fs-5 me-1"></i>Edit All Price</a>
                            </div> -->
                        </div>
                    </div>
                    <table id="table_list_variant" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Outlet</th>
                                <th data-orderable="false">Optional</th>
                                <th data-orderable="false">Additional</th>
                                <th data-orderable="false">Satuan</th>
                                <th data-orderable="false">Price</th>
                                <th data-orderable="false">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Outlet</th>
                                <th>Optional</th>
                                <th>Additional</th>
                                <th>Satuan</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                    
                    <!-- <table id="example" class="table table-striped mt-5 pt-5" style="width:100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Office</th>
                                <th>Age</th>
                                <th>Start date</th>
                                <th>Salary</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Tiger Nixon</td>
                                <td>System Architect</td>
                                <td>Edinburgh</td>
                                <td>61</td>
                                <td>2011-04-25</td>
                                <td>$320,800</td>
                            </tr>
                            <tr>
                                <td>Garrett Winters</td>
                                <td>Accountant</td>
                                <td>Tokyo</td>
                                <td>63</td>
                                <td>2011-07-25</td>
                                <td>$170,750</td>
                            </tr>
                            <tr>
                                <td>Jonas Alexander</td>
                                <td>Developer</td>
                                <td>San Francisco</td>
                                <td>30</td>
                                <td>2010-07-14</td>
                                <td>$86,500</td>
                            </tr>
                            <tr>
                                <td>Shad Decker</td>
                                <td>Regional Director</td>
                                <td>Edinburgh</td>
                                <td>51</td>
                                <td>2008-11-13</td>
                                <td>$183,000</td>
                            </tr>
                            <tr>
                                <td>Ashton Cox</td>
                                <td>Junior Technical Author</td>
                                <td>San Francisco</td>
                                <td>66</td>
                                <td>2009-01-12</td>
                                <td>$86,000</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Office</th>
                                <th>Age</th>
                                <th>Start date</th>
                                <th>Salary</th>
                            </tr>
                        </tfoot>
                    </table> -->
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


