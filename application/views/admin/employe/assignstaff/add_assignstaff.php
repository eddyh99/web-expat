<!-- MAIN CONTENT START -->
<div class="container-fluid">
    <div class="row my-4">
        <div class="col-lg-12 d-flex align-items-strech">
            <a href="<?= base_url()?>employe/assign_staff" class="btn btn-outline-expat d-flex align-items-center">
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
                    <h5 class="card-title fw-semibold mb-4">Add Assign Staff</h5>
                    <form action="<?= base_url()?>employe/addproccess_assignstaff" enctype='multipart/form-data' method="POST">
                        <input type="hidden" id="token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <div class="mb-3">
                            <label for="address" class="form-label">Employe</label>
                            <select class="addstaff-select2" id="staff" name="staff" >
                                <?php foreach($staff as $st){
                                    if($st->status == 'active'){    
                                ?>
                                    <option value="<?= $st->id?>"><?= $st->nama?></option>
                                <?php 
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Outlet</label>
                            <select class="addoutlet-select2" id="outlet" name="outlet" >
                                <?php foreach($cabang as $cb){ ?>
                                    <option value="<?= $cb->id?>"><?= $cb->nama?></option>
                                <?php 
                                    }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-expat mt-3">Save Staff</button>
                  </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- MAIN CONTENT END -->

