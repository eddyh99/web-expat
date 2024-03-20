<!-- MAIN CONTENT START -->
<div class="container-fluid">
    <div class="row my-4">
        <div class="col-lg-12 d-flex align-items-strech">
            <a href="<?= base_url()?>produk/satuan" class="btn btn-outline-expat d-flex align-items-center">
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
                    <h5 class="card-title fw-semibold mb-4">Add Satuan Produk</h5>
                    <form action="<?= base_url()?>produk/addsatuan_process" method="POST">
                        <input type="hidden" id="token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <div class="mb-4 col-12">
                            <label for="satuan_group" class="form-label">Satuan Group</label>
                            <select name="satuan_group" id="satuan_group" class="form-control satuan_group_select2">
                                <?php foreach($group as $dt){?>
                                    <option value="<?= $dt->groupname?>"><?= $dt->groupname?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="satuan" class="form-label">Satuan Name</label>
                            <input type="text" class="form-control" id="satuan" name="satuan" placeholder="Enter satuan name..." required autocomplete="off">
                        </div>
                        <button type="submit" class="btn btn-expat mt-3">Save satuan</button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>

</div>
<!-- MAIN CONTENT END -->

