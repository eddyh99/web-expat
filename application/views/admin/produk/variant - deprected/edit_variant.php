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
                    <form action="<?= base_url()?>produk/editvariant_process" method="POST">
                        <input type="hidden" id="token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" name="urisegment" value="<?php echo $this->uri->segment('3')?>">
                        <input type="hidden" name="idproduk" value="<?php echo @base64_decode($_GET['produk'])?>">
                        
                        <?php if(!empty(@$variant->satuan)){?>
                            <h5 class="card-title fw-semibold mb-4">Edit Per Variant Produk</h5>
                            <div class="col-md-4 single-note-item all-category">
                                <div class="card card-body">
                                    <span class="side-stick"></span>
                                    <h5 class="note-title text-truncate w-75 mb-0" > 
                                        <?= @$variant->cabang?>
                                    </h5>
                                    <div class="note-content">
                                        <p class="note-inner-content" data-notecontent="Blandit tempus porttitor aasfs. Integer posuere erat a ante venenatis."> 
                                            <div class="d-flex justify-content-between my-3">
                                                <span>Additional</span> 
                                                <span><?= @$variant->additional?></span> 
                                            </div>
                                            <div class="d-flex justify-content-between my-3">
                                                <span>Optional</span> 
                                                <span><?= @$variant->optional?></span> 
                                            </div>
                                            <div class="d-flex justify-content-between my-3">
                                                <span>Satuan</span> 
                                                <span><?= @$variant->satuan?></span> 
                                            </div>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php } else {?>
                            <h5 class="card-title fw-semibold mb-4">Edit All Variant Produk <span class="text-decoration-underline"><?= @base64_decode($_GET['name'])?></span></h5>
                            <div class="alert alert-warning" role="alert">
                                Attention to this edit will affect all variants of this product
                            </div>
                        <?php } ?>

                        <div class="mb-4 col-12">
                            <label for="satuan" class="form-label">Harga</label>
                            <input type="text" value="<?= @$variant->harga?>" name="newharga" class="money-input form-control" style="border: 1px solid #AAAAAA;">
                        </div>
                        
                        <button type="submit" class="btn btn-expat mt-3">Update Harga</button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>

</div>
<!-- MAIN CONTENT END -->

