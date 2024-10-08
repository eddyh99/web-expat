<!-- MAIN CONTENT START -->
<div class="container-fluid">
    <div class="row my-4">
        <div class="col-lg-12 d-flex align-items-strech">
            <a href="<?= base_url()?>produk/variant" class="btn btn-outline-expat d-flex align-items-center">
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
                    <h5 class="card-title fw-semibold mb-4">Add Variant Produk</h5>
                    <form action="<?= base_url()?>produk/addvariant_process" method="POST">
                        <input type="hidden" id="token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <div class="mb-4 col-12">
                            <label for="produk" class="form-label">Select Produk</label>
                            <select name="produk" id="produk" class="form-control produk_select2">
                                <?php foreach($allproduk as $ap){?>
                                    <option value="<?= $ap->id?>"><?= $ap->nama?></option>
                                <?php }?>
                            </select>
                        </div>
                        
                        <div class="rounded-2 p-4 mb-4" style="border: 2px dashed #72A28A;">
                            <div class="mb-4 col-12">
                                <label for="group_additional" class="form-label">Group Additional</label>
                                <select name="group_additional[]"  id="group_additional" class="form-control group_additional_select2">
                                    <option value="">--Select Additional Group--</option>
                                    <?php foreach($additional as $ad){?>
                                        <option value="<?= $ad->additional_group?>"><?= $ad->additional_group?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="mb-4 col-12">
                                <label for="additional" class="form-label">Select Additional</label>
                                <select name="additional[]" multiple="multiple" id="additional" class="form-control additional_select2">
                                </select>
                            </div>
                        </div>
                  
                        <div class="rounded-2 p-4 mb-4" style="border: 2px dashed #72A28A;">
                            <div class="mb-4 col-12">
                                <label for="group_optional" class="form-label">Group Optional</label>
                                <select name="group_optional[]"  id="group_optional" class="form-control group_optional_select2">
                                    <option value="">--Select Optional Group--</option>
                                    <?php foreach($optional as $op){?>
                                        <option value="<?= $op->optiongroup?>"><?= $op->optiongroup?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="mb-4 col-12">
                                <label for="optional" class="form-label">Select Optional</label>
                                <select name="optional[]" multiple="multiple" id="optional" class="form-control optional_select2">
                                </select>
                            </div>
                        </div>

                        <div class="rounded-2 p-4 mb-4" style="border: 2px dashed #72A28A;">
                            <div class="mb-4 col-12">
                                <label for="group_satuan" class="form-label">Group Satuan</label>
                                <select name="group_satuan[]"  id="group_satuan" class="form-control group_satuan_select2">
                                    <option value="">--Select Satuan Group--</option>
                                    <?php foreach($satuan as $st){?>
                                        <option value="<?= $st->groupname?>"><?= $st->groupname?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="mb-4 col-12">
                                <label for="satuan" class="form-label">Select Satuan</label>
                                <select name="satuan[]" multiple="multiple" id="satuan" class="form-control satuan_select2">
                                </select>
                            </div>          
                        </div>

                        <div class="mb-4 col-12">
                            <label for="satuan" class="form-label">Harga</label>
                            <input type="text" name="harga" class="money-input form-control" style="border: 1px solid #AAAAAA;">
                        </div>


                        <div class="mb-4 col-12">
                            <label for="cabang" class="form-label">Select Outlet</label>
                            <select name="cabang[]" multiple="multiple" id="cabang" class="form-control cabang_select2">
                                <!-- <option value="all">All Outlet</option> -->
                                <?php foreach($cabang as $cb){?>
                                    <option value="<?= $cb->id?>"><?= $cb->nama?></option>
                                <?php }?>
                            </select>
                            <input type="checkbox" id="selectall">
                            <label for="selectall">
                                Select All
                            </label>
                        </div>
                        
                        <!-- <div class="mb-4">
                            <label for="satuan" class="form-label">Satuan Name</label>
                            <input type="text" class="form-control" id="satuan" name="satuan" placeholder="Enter satuan name..." required autocomplete="off">
                        </div> -->
                        <button type="submit" class="btn btn-expat mt-3">Save Variant</button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>

</div>
<!-- MAIN CONTENT END -->

