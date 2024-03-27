<div class="w-100 header-detail-order position-relative">
    <img class="img-fluid" src="<?= $produk->picture?>" alt="img">
</div>
<div class="app-content px-2 row  mb-5 pb-5">
    <div class="app-member mx-auto col-12 col-lg-8  border-1 border-white">
        <form id="detailorder" action="<?= base_url()?>widget/order/setcookie_add_tocart" method="POST">
            <input type="hidden" name="id_variant" id="id_variant">
            <input type="hidden" name="total_variant" id="total_variant">
            <div class="mt-3">
                <h1><?= $produk->nama?></h1>
                <span class="desc"><?= $produk->deskripsi?></span>
                <h3 class="greenprice">Rp <span class="showprice">-</span></h3>
            </div>
            <hr style="border-bottom: 8px solid #fff;">
            <div class="mt-3 mb-4">
                <h3 class="f-lora">Option</h3>

                <?php 
                    $check_optional = array();
                    $temp_optional = array();
                    $finaloptional = array();
                    foreach($variant as $vr){
                        if($vr->id_cabang == $_GET['cabang']){
                            if(in_array($vr->optional, $check_optional)){
                                echo "";
                            }else{
                                array_push($check_optional, $vr->optional);
                                $temp_optional = array(
                                    "idoptional"  => $vr->id_optional,
                                    "optional"    => $vr->optional
                                );
                                array_push($finaloptional, $temp_optional);
                            }
                        }
                    }

                    foreach($finaloptional as $key => $val){
                        if($key == 0){
                ?>
                    
                    <div class="pt-2">
                        <label for="<?= $val['optional']?>" class="d-flex justify-content-between">
                            <span><?= $val['optional']?></span>
                            <input type="radio" id="<?= $val['optional']?>" class="choose optional" value="<?= $val['idoptional']?>" name="optional" checked>
                        </label>
                    </div>

                <?php 
                        } else {    
                ?>
                    <div class="pt-2">
                        <label for="<?= $val['optional']?>" class="d-flex justify-content-between">
                            <span><?= $val['optional']?></span>
                            <input type="radio" id="<?= $val['optional']?>" class="choose optional" value="<?= $val['idoptional']?>" name="optional" >
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
                    if($produk->kategori == "drink"){
                ?>
                    <h3 class="f-lora">Cup Size</h3>
                <?php } else if($produk->kategori == "food"){?>
                    <h3 class="f-lora">Portion Of Food</h3>
                <?php } else {?>
                    <h3 class="f-lora">Retail</h3>
                <?php } ?>


                <?php 
                    $check_satuan = array();
                    $temp_satuan = array();
                    $finalsatuan = array();
                    foreach($variant as $vr){
                        if($vr->id_cabang == $_GET['cabang']){
                            if(in_array($vr->satuan, $check_satuan)){
                                echo "";
                            }else{
                                array_push($check_satuan, $vr->satuan);
                                $temp_satuan = array(
                                    "idsatuan"  => $vr->id_satuan,
                                    "satuan"    => $vr->satuan
                                );
                                array_push($finalsatuan, $temp_satuan);
                            }
                        }
                    }

                   foreach($finalsatuan as $key => $val){
                       if($key == 0){
                ?>
                    <div class="pt-2">
                        <label for="<?= $val['satuan']?>" class="d-flex justify-content-between">
                            <span><?= $val['satuan']?></span>
                            <input type="radio" id="<?= $val['satuan']?>" class="choose" value="<?= $val['idsatuan']?>" name="satuan" checked>
                        </label>
                    </div>
                <?php   } else {?>
                    <div class="pt-2">
                        <label for="<?= $val['satuan']?>" class="d-flex justify-content-between">
                            <span><?= $val['satuan']?></span>
                            <input type="radio" id="<?= $val['satuan']?>" class="choose" value="<?= $val['idsatuan']?>" name="satuan">
                        </label>
                    </div>
                <?php 
                        }
                    }
                ?>


            </div>
            <hr style="border-bottom: 2px solid #fff;">
            <div class="mt-3 mb-4">
                <h3 class="f-lora">Additional</h3>

                <?php 
                    $check_additional = array();
                    $temp_additional = array();
                    $finaladditional = array();
                    foreach($variant as $vr){
                        if($vr->id_cabang == $_GET['cabang']){
                            if(in_array($vr->additional, $check_additional)){
                                echo "";
                            }else{
                                array_push($check_additional, $vr->additional);
                                $temp_additional = array(
                                    "idadditional"  => $vr->id_additional,
                                    "additional"    => $vr->additional
                                );
                                array_push($finaladditional, $temp_additional);
                            }
                        }
                    }
                    foreach($finaladditional as $key => $val){
                        if($key == 0){
                ?>
                    <div class="pt-2">
                        <label for="<?= $val['additional']?>" class="d-flex justify-content-between">
                            <span><?= $val['additional']?></span>
                            <input type="radio" id="<?= $val['additional']?>" class="choose" value="<?= $val['idadditional']?>" name="additional" checked>
                        </label>
                    </div>
                    
                <?php } else {?>
                    <div class="pt-2">
                        <label for="<?= $val['additional']?>" class="d-flex justify-content-between">
                            <span><?= $val['additional']?></span>
                            <input type="radio" id="<?= $val['additional']?>" class="choose" value="<?= $val['idadditional']?>" name="additional">
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
                        <button type="submit" class="btn btn-expat px-5 w-100">ADD TO CHART</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>