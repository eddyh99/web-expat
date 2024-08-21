<div class="w-100 header-detail-order position-relative">
    <img class="img-fluid" src="<?= $product->picture?>" alt="img">
</div>
<div class="app-content px-2 row  mb-5 pb-5">
    <div class="app-member mx-auto col-12 col-lg-8  border-1 border-white">
        <form id="detailorder" action="<?= base_url()?>widget/order/setcookie_add_tocart" method="POST">
            <input type="hidden" name="idcabang" value="<?= $_GET['cabang']?>">
            <input type="hidden" name="idproduk" value="<?= $_GET['product']?>">
            <input type="hidden" name="idoptional" id="idoptional">
            <input type="hidden" name="idsatuan" id="idsatuan">
            <input type="hidden" name="idadditional" id="idadditional">
            <input type="hidden" name="total_cart" id="total_cart">
            <div class="mt-3">
                <h1><?= $product->nama?></h1>
                <article class="article desc"><?= $product->deskripsi?></article>
                <h3 class="greenprice">Rp <span class="showprice"><?= number_format($product->price, 0,",",".")?></span></h3>
            </div>
            <div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3">
                <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        <i class="fas fa-cart-plus me-2"></i>
                        <strong class="me-auto">Adding to cart</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        Please check your menu
                    </div>
                </div>
            </div>
            <hr style="border-bottom: 8px solid #fff;">

            <div class="mt-3 mb-4">
                
                <?php if(!empty($optional)){?>
                    <h3 class="f-lora">Option</h3>
                <?php 
                    }
                    foreach($optional as $op){
                        if($op->price == 0){
                ?>
                    <div class="pt-2">
                        <label for="<?= $op->sku?>" class="d-flex justify-content-between">
                            <span><?= $op->optional?></span>
                            <input type="radio" id="<?= $op->sku?>" data-opt="<?= $op->id?>" value="<?= $op->price?>" class="choose optional" name="optional" checked>
                        </label>
                    </div>
                <?php 
                        }
                    }
                ?>

                <?php 
                    foreach($optional as $op){
                        if($op->price != 0){
                ?>
                    <div class="pt-2">
                        <label for="<?= $op->sku?>" class="d-flex justify-content-between">
                            <span><?= $op->optional?> <small>( +<?= number_format($op->price, 0,",",".")?>)</small></span>
                            <input type="radio" id="<?= $op->sku?>" data-opt="<?= $op->id?>" class="choose" value="<?= $op->price?>" name="optional">
                        </label>
                    </div>
                <?php 
                        }
                    }
                ?>
                    
            </div>
            <hr style="border-bottom: 2px solid #fff;">
            <div class="mt-3 mb-4">
                <?php 
                    if(!empty($satuan)){
                    if($product->kategori == "drink"){
                ?>
                    <h3 class="f-lora">Cup Size</h3>
                <?php } else if($product->kategori == "food"){?>
                    <h3 class="f-lora">Portion Of Food</h3>
                <?php } else {?>
                    <h3 class="f-lora">Satuan</h3>
                <?php }} ?>



                <?php 
                    foreach($satuan as $st){
                        if($st->price == 0){
                ?>
                    <div class="pt-2">
                        <label for="<?= $st->sku?>" class="d-flex justify-content-between">
                            <span><?= $st->satuan?></span>
                            <input type="radio" id="<?= $st->sku?>" data-st="<?= $st->id?>" value="<?= $st->price?>" class="choose" name="satuan" checked>
                        </label>
                    </div>
                <?php 
                        }
                    }
                ?>

                <?php 
                    foreach($satuan as $st){
                        if($st->price != 0){
                ?>
                    <div class="pt-2">
                        <label for="<?= $st->sku?>" class="d-flex justify-content-between">
                            <span><?= $st->satuan?> <small>( +<?= number_format($st->price, 0,",",".")?>)</small></span>
                            <input type="radio" id="<?= $st->sku?>" data-st="<?= $st->id?>" value="<?= $st->price?>" class="choose" name="satuan">
                        </label>
                    </div>
                <?php 
                        }
                    }
                ?>


            </div>
            <hr style="border-bottom: 2px solid #fff;">
            <div class="mt-3 mb-4">
                
                <?php if(!empty($additional)){?>
                <h3 class="f-lora">Additional</h3>
                <?php }?>


                <?php 
                    foreach($additional as $ad){
                        if($ad->price == 0){
                ?>
                    <div class="pt-2">
                        <label for="<?= $ad->sku?>" class="d-flex justify-content-between">
                            <span><?= $ad->additional?></span>
                            <input type="radio" id="<?= $ad->sku?>" data-ad="<?= $ad->id?>" value="<?= $ad->price?>" class="choose" name="additional" checked>
                        </label>
                    </div>
                <?php 
                        }
                    }
                ?>

                <?php 
                    foreach($additional as $ad){
                        if($ad->price != 0){
                ?>
                    <div class="pt-2">
                        <label for="<?= $ad->sku?>" class="d-flex justify-content-between">
                            <span><?= $ad->additional?> <small>( +<?= number_format($ad->price, 0,",",".")?>)</small></span>
                            <input type="radio" id="<?= $ad->sku?>" data-ad="<?= $ad->id?>" value="<?= $ad->price?>" class="choose" name="additional">
                        </label>
                    </div>
                <?php 
                        }
                    }
                ?>

            </div>
            <div class="pt-2">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-minus-circle fs-3" style="cursor: pointer;"></i>
                        <input type="hidden" name="injumlahcoffe" id="injumlahcoffe">
                        <span class="mx-4" id="jumlahcoffe"></span>
                        <i class="fas fa-plus-circle fs-3" style="cursor: pointer;"></i>
                    </div>
                    <div class="w-90 d-flex justify-content-end ps-4">
                        <button type="submit" class="btn btn-expat add-tocart px-5 w-100">ADD TO CART</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>