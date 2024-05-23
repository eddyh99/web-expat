
<div class="app-content px-2 row  mb-5 pb-5">
    <div class="app-member mx-auto col-12 col-lg-8  border-1 border-white">
        <?php if (@isset($_SESSION["error"])) { ?>
            <div class="col-12 alert alert-danger alert-dismissible fade show" role="alert">
                <span class="notif-login f-poppins"><?= $_SESSION["error"] ?></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php } ?>
        <form id="orderchart" action="<?= base_url()?>widget/order/enterpin" method="POST">
            <input type="hidden" name="id_cabang" value="<?= $_GET['cabang']?>">
            <input type="hidden" id="usertoken" name="usertoken" value="<?= $token?>">
            
            <div class="chart-delivery row mx-auto mt-5 p-2">
                <input type="hidden" id="idpengiriman" name="idpengiriman" value="<?= @$address->id?>">
           
                <label id="labelpickup" class="col-6 d-flex justify-content-center align-items-center" for="pickup">
                    <div class="">
                        <span>PICK UP</span>
                        <input type="radio" name="cartdelivery" value="pickup" id="pickup">
                    </div>
                </label>
                <label id="labeldelivery" class="col-6 d-flex bg-expat justify-content-center align-items-center" for="delivery">
                    <div>
                        <span>DELIVERY</span>
                        <input type="radio" name="cartdelivery" value="delivery" id="delivery" checked="checked">
                    </div>
                </label>
            </div>


            <div id="pickupoutlet" class="preview-cabang my-4" style="display: none;">
                <h5>Pickup Outlet</h5>
                <h6 class="color-expat"><?= $cabang->nama?></h6>
                <div class="d-flex align-items-center">
                    <img src="<?= $cabang->picture?>" alt="img">
                    <div class="preview-cabang-detail ms-3">
                        <span class="color-expat-secondary"><?= $cabang->alamat?></span><br>
                        <span class="color-expat-secondary fs-6"><?= $cabang->opening?></span><br>
                        <span class="color-expat-secondary">(<?= $cabang->kontak?>)</span>
                    </div>
                </div>
            </div>

            <div id="address" class="pt-1 mt-5">
                <h5>Delivery Address</h5>
                <h6 class="color-expat" id="shownameaddress"><?= @$address->title?></h6>
                <span class="color-expat-secondary" id="showaddress"><?= @$address->alamat?></span><br>
                <span class="color-expat-secondary" id="showphone"><?= @$address->phone?></span><br>
                <span class="color-expat-secondary fst-italic" id="shownote"></span>
                <div id="edit-in-address" class="d-flex justify-content-start align-items-center mt-2">
                    <?php if(empty($address)){?>
                        <a class="btn btn-white d-flex align-items-center" href="<?= base_url()?>widget/order/addaddress/<?= $token?>" >
                            <svg class="me-2" width="18" height="18" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.70399 1.62683H4.52291C2.72916 1.62683 1.60449 2.89675 1.60449 4.69458V9.54441C1.60449 11.3422 2.72391 12.6122 4.52291 12.6122H9.67024C11.4698 12.6122 12.5892 11.3422 12.5892 9.54441V7.19475" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.14986 6.37049L9.50911 2.01125C10.0522 1.46875 10.9324 1.46875 11.4755 2.01125L12.1854 2.72116C12.7285 3.26425 12.7285 4.14508 12.1854 4.68758L7.80519 9.06783C7.56778 9.30525 7.24578 9.43883 6.90978 9.43883H4.72461L4.77944 7.23383C4.78761 6.9095 4.92003 6.60033 5.14986 6.37049Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M8.84668 2.68481L11.5102 5.34831" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Add Address
                        </a>
                    <?php } else {?>
                        <a class="btn btn-white d-flex align-items-center" href="<?= base_url()?>widget/order/editaddress/<?= $token?>?idcabang=<?= $_GET['cabang']?>" >
                            <svg class="me-2" width="18" height="18" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.70399 1.62683H4.52291C2.72916 1.62683 1.60449 2.89675 1.60449 4.69458V9.54441C1.60449 11.3422 2.72391 12.6122 4.52291 12.6122H9.67024C11.4698 12.6122 12.5892 11.3422 12.5892 9.54441V7.19475" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.14986 6.37049L9.50911 2.01125C10.0522 1.46875 10.9324 1.46875 11.4755 2.01125L12.1854 2.72116C12.7285 3.26425 12.7285 4.14508 12.1854 4.68758L7.80519 9.06783C7.56778 9.30525 7.24578 9.43883 6.90978 9.43883H4.72461L4.77944 7.23383C4.78761 6.9095 4.92003 6.60033 5.14986 6.37049Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M8.84668 2.68481L11.5102 5.34831" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Edit Address
                        </a>
                    <?php } ?>
                  
                    <a class="btn btn-white mx-3 d-flex align-items-center" href="" data-bs-toggle="modal" data-bs-target="#addnotemodal">
                        <svg class="me-2" width="18" height="18" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.16772 9.46366H4.95605" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M9.16772 7.02152H4.95605" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M6.56363 4.585H4.95654" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.28015 1.604C9.28015 1.604 4.8019 1.60634 4.7949 1.60634C3.1849 1.61625 2.18799 2.67559 2.18799 4.29142V9.65575C2.18799 11.2798 3.19249 12.3432 4.81649 12.3432C4.81649 12.3432 9.29415 12.3414 9.30174 12.3414C10.9117 12.3315 11.9092 11.2716 11.9092 9.65575V4.29142C11.9092 2.66742 10.9042 1.604 9.28015 1.604Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Add Note
                    </a>
                    <div class="modal fade" id="addnotemodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4>Add Note</h4>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-white p-2">
                                    <div class="my-4">
                                        <label for="inptnote">Note</label>
                                        <input type="text" id="inptnote" name="inptnote" class="form-control">
                                    </div>
                                    <div class="my-4">
                                        <a id="addnote" class="btn btn-expat">Add Note</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr style="border-bottom: 2px solid #fff;">
            <?php foreach($variant as $vr){?>
                <div id="itempreview<?= $vr['id']?>" class="item-preview-order d-flex flex-column align-items-start justify-content-between py-4 my-3">
                    <div class="d-flex align-items-start">
                        <img src="<?= $vr['picture']?>" alt="img">
                        <div class="item-detail ms-3">
                            <h3><?= $vr['nama']?></h3>
                            <span class="color-expat-secondary"><?= $vr['additional']?> | <?= $vr['optional']?> | <?= $vr['satuan']?></span><br>
                            <span class="color-expat-secondary"><?= number_format($vr['harga'], 2) ?></span>
                        </div>
                        
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <i onclick="minuscart('<?= $vr['id']?>')" class="fas fa-minus-circle minus-<?= $vr['id']?> fs-5" style="cursor: pointer;"></i>
                        <!-- <input type="hidden" name="injumlahcoffe" id="injumlahcoffe"> -->
                        <span class="d-block" style="width: 34px;">
                            <input type="hidden" name="id_variant[]" value="<?= $vr['id']?>">
                            <input type="number" name="jumlah[]" class="text-center w-100 border-0 bg-transparent text-white" id="jumlah<?= $vr['id']?>" value="<?= $vr['jumlah']?>">
                        </span>
                        <i onclick="pluscart('<?= $vr['id']?>')"  class="fas fa-plus-circle plus-<?= $vr['id']?> fs-5" style="cursor: pointer;"></i>
                    </div>
                </div>
            <?php }?>
            <hr style="border-bottom: 8px solid #fff;">

            <div>
                <div class="d-flex justify-content-between mt-2">
                    <label for="" class="label-input-voucher">
                        <img height="30" src="<?= base_url()?>assets/img/widget/icon-voucher.png" alt="icon">
                        <input type="text" placeholder="Have a promotion code ?" class="form-input-voucher">
                    </label>
                    <!-- Todo: CHECK KODE VOUCHER VALID OR NOT -->
                    <a class="btn btn-primary rounded-1" style="font-size: 14px;" href="">Apply</a>
                </div>
            </div>

            <hr style="border-bottom: 2px solid #fff;">

            <div id="summaryorder">
                <h5>Payment Summary</h5>
                <div class="price d-flex justify-content-between align-items-center">
                    <span>Price</span>
                    <span>
                        <!-- <i class="fas fa-sync text-warning" onClick="window.location.reload()"></i> -->
                        Rp 
                        <span class="price-span">   
                        </span>
                    </span>
                </div>
                <div class="fee d-flex justify-content-between align-items-center">
                    <span>Fee Delivery</span>
                    <span>Rp. 0</span>
                </div>
            </div>

            <hr style="border-bottom: 2px solid #fff;">

            <div id="totalsummary" class="d-flex justify-content-between align-items-center">
                <h4 class="f-lora color-expat fw-bold">Total Payment</h4>
                <span>Rp 
                    <?php 
                        // $total -= 0;
                        // echo number_format($total, 2);
                    ?>
                    <span  class="total-price-span">

                    </span>
                </span>
                <input type="hidden" name="amount" id="amount">
            </div>


            <div id="balanceuser" class="d-flex justify-content-between align-items-center mt-3">
                <a class="btn btn-expat px-3 py-1">
                    <span>Your Balance</span>
                   Rp <?php echo number_format($user->saldo, 2) ?>
                   <input type="hidden" name="saldo" value="<?= $user->saldo?>">
                </a>
            </div>

            <!-- <div>
                <div class="d-flex justify-content-between mt-2">
                    <a class="btn btn-white d-flex justify-content-between align-items-center w-100" style="font-size: 13px;" href="" data-bs-toggle="modal" data-bs-target="#paymentmodal">
                        <span class="d-flex align-items-center">
                            <i class="fas fa-money-check-alt me-2 fs-5"></i>
                            Payment
                        </span>
                        <span class="labelpayment">
                            
                        </span>
                        <input type="hidden" name="methodpayment" id="methodpayment">
                    </a>
                    <div class="modal fade" id="paymentmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4>Select Payment Method</h4>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-white p-2">
                                    <label for="expatbalance" class="label-amount">
                                        <input type="radio" id="expatbalance" data-title="Expat Balance" value="expatbalance" name="paymentselectmodal" class="paymentradio card-input-amount-select" checked="checked" >
                                        <span class="span-amount">Expat Balance <img class="img-fluid bg-black" width="40" src="<?= base_url()?>assets/img/logo.png" alt="logo"></span>
                                    </label>
                                    <br>
                                    <label for="credit" class="label-amount">
                                        <input type="radio" id="credit" data-title="Credit Card" value="credit" name="paymentselectmodal" class="paymentradio card-input-amount-select">
                                        <span class="span-amount">Credit Card <img class="img-fluid" width="100" src="<?= base_url()?>assets/img/payment/card.png" alt="card"></span>
                                    </label>
                                    <br>
                                    <label for="va" class="label-amount">
                                        <input type="radio" id="va" data-title="Virtual Account" value="virtual" name="paymentselectmodal" class="paymentradio card-input-amount-select">
                                        <span class="span-amount">Virtual Account <img class="img-fluid" width="160" src="<?= base_url()?>assets/img/payment/va.png" alt="va"></span>
                                    </label>
                                    <br>
                                    <label for="wallet" class="label-amount">
                                        <input type="radio" id="wallet" data-title="E-Wallet" value="wallet" name="paymentselectmodal" class="paymentradio card-input-amount-select" >
                                        <span class="span-amount">E-Wallet<img class="img-fluid" width="200" src="<?= base_url()?>assets/img/payment/e-wallet.png" alt="e-wallet"></span>
                                    </label>
                                    <br>
                                    <label for="qris" class="label-amount">
                                        <input type="radio" id="qris" data-title="QRIS" value="qris" name="paymentselectmodal" class="paymentradio card-input-amount-select">
                                        <span class="span-amount">QRIS <img class="img-fluid" width="50" src="<?= base_url()?>assets/img/payment/qris.png" alt="qris"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            

            <div id="button-order" class="d-flex w-100 mt-3">
                <button type="submit" class="btn btn-expat w-100 py-3 <?= (empty($all_variant)) ? "disabled": ""?>">ORDER</button>
            </div>
            
        </form>
    </div>
</div>