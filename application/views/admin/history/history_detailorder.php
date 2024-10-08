<!-- MAIN CONTENT START -->
<div class="container-fluid">
    <!--  Row Daftar User -->
    <div class="row my-4">
        <div class="col-lg-12 d-flex align-items-strech">
            <a href="<?= base_url()?>history/order" class="btn btn-outline-expat d-flex align-items-center">
                <i class="ti ti-chevron-left fs-5 me-1"></i>
                <span>
                    Back
                </span>
            </a>
        </div>
    </div>
    <!--  Row List User-->
    <div class="row">
        <div class="col-lg-12 d-flex align-items-strech">
            <div class="card border-expat w-100">
                <div class="card-body detail-historyorder">
                    <?php if (@isset($_SESSION["error"])) { ?>
                        <div class="col-12 alert alert-danger alert-dismissible fade show" role="alert">
                            <span class="notif-login f-poppins"><?= $_SESSION["error"] ?></span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } ?>
                    <?php if (@isset($_SESSION["success"])) { ?>
                        <div class="col-12 alert alert-success alert-dismissible fade show" role="alert">
                            <span class="notif-login f-poppins"><?= $_SESSION["success"] ?></span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } ?>
                    <div>
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="d-flex flex-column justify-content-start align-items-start">
                                <?php if($detail[0]->id_pengiriman == null){?>
                                    <h3 class="jenis-pengiriman d-flex align-items-center"> <span class="me-3">PICKUP</span> <i class="ti ti-coffee"></i></h3>
                                <?php } else{?>
                                    <h3 class="jenis-pengiriman d-flex align-items-center"> <span class="me-3">DELIVERY</span> <i class="ti ti-truck-delivery"></i></h3>
                                    <div>
                                        <div class="d-flex justify-content-between mt-2">
                                            <a class="btn btn-expat d-flex justify-content-between align-items-center w-100" style="font-size: 13px;" href="" data-bs-toggle="modal" data-bs-target="#paymentmodal">
                                                <span class="d-flex align-items-center">
                                                    <i class="ti ti-plus me-1 fs-5"></i>
                                                    Assign Driver
                                                </span>
                                                <span class="labelpayment">
                                                    
                                                </span>
                                                <input type="hidden" name="methodpayment" id="methodpayment">
                                            </a>
                                        
                                            <div class="modal fade" id="paymentmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4>Select Driver</h4>
                                                            <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-white p-2">
                                                            <div class="mb-4">
                                                                <select class=" form-select" id="driver" name="driver" >
                                                                    <?php 
                                                                    foreach($staff as $st){
                                                                        if($st->cabang == $detail[0]->cabang && $st->is_driver == 'yes'){
                                                                    ?>
                                                                        <option value="<?= $st->staffid?>"><?= $st->nama?></option>
                                                                    <?php 
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="my-4">
                                                                <button id="savedriver" class="btn btn-expat">Select Driver</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <h6 class="mt-2 fst-italic"><span id="drivername"><?= $detail[0]->namadriver?></span></h6>
                                    </div>
                                <?php } ?>
                                
                            </div>
                            <div class="d-flex flex-column justify-content-end align-items-end">
                                <h5 class="ticket-idtransaksi "><?=$invoice?></h5>
                                <h6><?=$detail[0]->tanggal?></h6>
                                <span class="<?= (($detail[0]->is_proses == 'pending') ? 'bg-danger-subtle text-danger' : (($detail[0]->is_proses == 'delivery') ? 'bg-warning-subtle text-warning' : 'bg-success-subtle text-success')) ?> badge"><?= $detail[0]->is_proses?></span>
                            </div>
                        </div>
                        <br>
                        <hr>

                        <div class="d-flex information-historyorder row">
                            <div class="col-6 pe-3 left">
                                <?php
                                    $price = 0;
                                    foreach($detail as $dt){
                                    $price += ($dt->hargaproduk +  @$dt->hargaoptional + @$dt->hargasatuan + @$dt->hargaadditional) * $dt->jumlah;
                                ?>
                                    <div class="col-12">
                                        <div class="card border-start border-success">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center justify-content-start">
                                                    <div>
                                                        <img class="img-produk" src="<?= $dt->imgprod?>" alt="img">
                                                    </div>
                                                    <div class="ms-3">
                                                        <h4 class="card-title fs-7"><?= $dt->namaproduk?></h4>
                                                        <p class="card-subtitle my-1"><?= @$dt->namaoptional?> | <?= @$dt->namaadditional?> | <?= @$dt->namasatuan?></p>
                                                        <p class="card-subtitle my-1">Quantity <?= $dt->jumlah?></p>
                                                        <p class="card-subtitle my-1">Rp <?=  number_format((($dt->hargaproduk +  @$dt->hargaoptional + @$dt->hargasatuan + @$dt->hargaadditional) * $dt->jumlah),2,".",",")?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }?>
                            </div>
                            <div class="col-6 ps-3 right">
                                <div class="col-12">
                                    <?php if($detail[0]->id_pengiriman == null){?>
                                        <h5 class="title-delivery-details">Pickup Details</h5>
                                    <?php } else {?>
                                        <h5 class="title-delivery-details">Delivery Details</h5>
                                    <?php } ?>

                                    <div>
                                        <?php if($detail[0]->picture != null){?>
                                            <img class="rounded-circle" width="60" src="<?= $detail[0]->picture ?>" alt="img">
                                        <?php } else {?>
                                            <img class="rounded-circle" width="60" src="<?= base_url()?>assets/img/men-default.png" alt="img">
                                        <?php } ?>
                                        <h6 class="pt-2"><?= $detail[0]->customer?></h6>
                                    </div>

                                    <?php if($detail[0]->id_pengiriman == null){?>
                                        <div>
                                            <span>Pickup Outlet</span>
                                            <h6><?= $detail[0]->cabang?></h6>
                                            <h6><?= $detail[0]->almtcabang?></h6>
                                        </div>
                                    <?php } else {?>
                                        <div>
                                            <span>From</span>
                                            <h6><?= $detail[0]->cabang?></h6>
                                            <h6><?= $detail[0]->almtcabang?></h6>
                                        </div>
                                        <div class="deliveryto-border"></div>
                                        <div>
                                            <span>To</span>
                                            <h6><?= $detail[0]->title?></h6>
                                            <h6><?= $detail[0]->alamat?></h6>
                                            <h6 class="fst-italic"><?= $detail[0]->phone?></h6>
                                            <h6 class="fst-italic"><?= ($detail[0]->note != null) ? '('.$detail[0]->note.')' : ''?> </h6>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-12 mt-5">
                                    <h5 class="title-delivery-details">Payment Details</h5>
                                    <div class="d-flex justify-content-between">
                                        <h6>Price</h6>
                                        <h6>Rp <?= number_format($price,2,".",",")?></h6>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <h6>Handling & Delivery Fee</h6>
                                        <h6>Rp 
                                            <?php 
                                                echo number_format($detail[0]->delivery_fee, 2, ".", ",");
                                                $total = $price + $detail[0]->delivery_fee;
                                            ?> 
                                        </h6>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <h6>Discount</h6>
                                        <h6>Rp <?= number_format("0",2,".",",")?></h6>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <h6>Total</h6>
                                        <h6>Rp <?= number_format($total,2,".",",")?></h6>
                                    </div>
                                    <form action="<?=base_url()?>history/process_order" method="post">
                                        <input type="hidden" id="id_driver" name="id_driver">
                                        <input type="hidden" name="invoice" value="<?=$invoice?>">
                                        <input type="hidden" name="jenis" value="<?= (($detail[0]->id_pengiriman == null) ? 'pickup' : 'delivery')?>">
                                        <?php if($detail[0]->is_proses == 'pending'){?>
                                        <button class="btn btn-expat d-flex align-items-center justify-content-center">
                                            <span>
                                                PROCCESS TRANSACTION
                                            </span>
                                        </button>
                                        <?php }?>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- MAIN CONTENT END -->


