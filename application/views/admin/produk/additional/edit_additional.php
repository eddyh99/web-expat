<!-- MAIN CONTENT START -->
<div class="container-fluid">
    <div class="row my-4">
        <div class="col-lg-12 d-flex align-items-strech">
            <a href="<?= base_url()?>produk/additional" class="btn btn-outline-expat d-flex align-items-center">
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
                    <h5 class="card-title fw-semibold mb-4">Edit Additional Produk</h5>
                    <form action="<?= base_url()?>produk/editadditional_process" method="POST">
                        <input type="hidden" id="token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" name="urisegment" value="<?php echo $this->uri->segment('3')?>">
                        <input type="hidden" class="form-control" id="sku" name="sku" maxlength="30" value="<?= @$detail->sku?>" placeholder="Enter SKU..." required autocomplete="off">
                        <div class="mb-4 col-12">
                            <label for="additional_group" class="form-label">Additional Group</label>
                            <select name="additional_group" id="additional_group" class="form-control additional_group_select2">
                                <?php foreach($group as $dt){?>
                                    <option value="<?= $dt->additional_group?>" <?= ($dt->additional_group == $detail->additional_group)?"selected":""?>><?= $dt->additional_group?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="additional" class="form-label">Additional Name</label>
                            <input type="text" class="form-control" id="additional" value="<?= @$detail->additional?>" name="additional" placeholder="Enter additional name..." required autocomplete="off">
                        </div>
                        <div class="mb-4">
                            <label for="price" class="form-label">Price</label>
                            <input type="text" class="money-input form-control" id="price" name="price" value="<?= @$detail->price?>" placeholder="Enter price..." required autocomplete="off">
                        </div>
                        <button type="submit" class="btn btn-expat mt-3">Update Additional</button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>

</div>
<!-- MAIN CONTENT END -->

