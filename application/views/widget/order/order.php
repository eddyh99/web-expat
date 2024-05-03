
<div class="app-content px-2 row  mb-5 pb-5">
    <div class="app-member mx-auto col-12 col-lg-8  border-1 border-white">
        <form id="orderchart" action="<?= base_url()?>widget/order/detail_process" method="POST">
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

            <?php if(empty($address)){?>
                <div class="modal" id="addaddress" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="false">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4>Add Your Address</h4>
                                <!-- <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button> -->
                            </div>
                            <div class="modal-body text-white p-2">
                                <div class="my-4">
                                    <label for="addinptname">Name Location</label>
                                    <input type="text" id="addinptname" name="addinptname" class="form-control" >
                                </div>
                                <div class="my-4">
                                    <label for="addinptaddress">Address</label>
                                    <input type="text" id="addinptaddress" name="addinptaddress" class="form-control" >
                                </div>
                                <div class="my-4">
                                    <label for="addinptphone">Phone</label>
                                    <input type="text" id="addinptphone" name="addinptphone" class="form-control" >
                                </div>
                                <div class="my-4">
                                    <a id="btnaddaddress" class="btn btn-expat">Add Address</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    setTimeout(function(){
                        $('#addaddress').modal('show');
                    }, 100);
                </script>
            <?php }?>

            <!-- <div id="editaddress" class="d-flex justify-content-center align-items-center p-3">
                <a class="btn btn-white px-3 m-3" href="">Add Address</a>
                <a class="btn btn-white px-3 m-3" href="">Add Note</a>
            </div> -->

            <div id="pickupoutlet" class="preview-cabang my-4" style="display: none;">
                <h2>Pickup Outlet</h2>
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
                <h2>Delivery Address</h2>
                <h4 class="color-expat" id="shownameaddress"></h4>
                <span class="color-expat-secondary" id="showaddress"></span><br>
                <span class="color-expat-secondary" id="showphone"></span><br>
                <span class="color-expat-secondary fst-italic" id="shownote"></span>
                <div id="edit-in-address" class="d-flex justify-content-start align-items-center mt-2">
                    <a class="btn btn-white d-flex align-items-center" href="" data-bs-toggle="modal" data-bs-target="#editaddress">
                        <svg class="me-2" width="18" height="18" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.70399 1.62683H4.52291C2.72916 1.62683 1.60449 2.89675 1.60449 4.69458V9.54441C1.60449 11.3422 2.72391 12.6122 4.52291 12.6122H9.67024C11.4698 12.6122 12.5892 11.3422 12.5892 9.54441V7.19475" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M5.14986 6.37049L9.50911 2.01125C10.0522 1.46875 10.9324 1.46875 11.4755 2.01125L12.1854 2.72116C12.7285 3.26425 12.7285 4.14508 12.1854 4.68758L7.80519 9.06783C7.56778 9.30525 7.24578 9.43883 6.90978 9.43883H4.72461L4.77944 7.23383C4.78761 6.9095 4.92003 6.60033 5.14986 6.37049Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M8.84668 2.68481L11.5102 5.34831" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Edit Address
                    </a>
                    <div class="modal fade" id="editaddress" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4>Edit Address</h4>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-white p-2">
                                    <input type="hidden" id="idaddress" name="idaddress" value="<?= @$address->id?>">
                                    <div class="my-4">
                                        <label for="inptname">Name Location</label>
                                        <input type="text" id="inptname" name="inptname" class="form-control" value="<?= @$address->title?>">
                                    </div>
                                    <div class="my-4">
                                        <label for="inptaddress">Address</label>
                                        <input type="text" id="inptaddress" name="inptaddress" class="form-control" value="<?= @$address->alamat?>">
                                    </div>
                                    <div class="my-4">
                                        <label for="inptphone">Phone</label>
                                        <input type="text" id="inptphone" name="inptphone" class="form-control" value="<?= @$address->phone?>">
                                    </div>
                                    <div class="my-4">
                                        <a id="updateaddress" class="btn btn-expat">Update Address</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  
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
                <div id="itempreview<?= $vr['id']?>" class="item-preview-order d-flex align-items-center justify-content-between my-4">
                    <div class="d-flex align-items-center">
                        <img src="<?= $vr['picture']?>" alt="img">
                        <div class="item-detail ms-3">
                            <h3><?= $vr['nama']?></h3>
                            <span class="color-expat-secondary"><?= $vr['additional']?> | <?= $vr['optional']?></span><br>
                            <span class="color-expat-secondary"><?= number_format($vr['harga'], 2) ?></span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <i onclick="minuscart('<?= $vr['id']?>')" class="fas fa-minus-circle minus-<?= $vr['id']?> fs-3" style="cursor: pointer;"></i>
                        <!-- <input type="hidden" name="injumlahcoffe" id="injumlahcoffe"> -->
                        <span class="d-block" style="width: 50px;">
                            <input type="hidden" name="id_variant[]" value="<?= $vr['id']?>">
                            <input type="number" name="jumlah[]" class="text-center w-100 border-0 bg-transparent text-white" id="jumlah<?= $vr['id']?>" value="<?= $vr['jumlah']?>">
                        </span>
                        <i onclick="pluscart('<?= $vr['id']?>')"  class="fas fa-plus-circle plus-<?= $vr['id']?> fs-3" style="cursor: pointer;"></i>
                    </div>
                </div>
            <?php }?>
            <!-- <div class="item-preview-order d-flex align-items-center justify-content-between my-3">
                <div class="d-flex align-items-center">
                    <img src="<?= base_url()?>assets/img/widget/expresso.png" alt="img">
                    <div class="item-detail ms-2">
                        <h3>Capucinno</h3>
                        <span class="color-expat-secondary">1 shot | nomad</span>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <i class="fas fa-minus-circle fs-3" style="cursor: pointer;"></i>
                    <input type="hidden" name="injumlahcoffe" id="injumlahcoffe">
                    <span class="mx-4" id="jumlahcoffe"></span>
                    <i class="fas fa-plus-circle fs-3" style="cursor: pointer;"></i>
                </div>
            </div>
           -->
            <hr style="border-bottom: 8px solid #fff;">

            <div id="summaryorder">
                <h2>Payment Summary</h2>
                <div class="price d-flex justify-content-between align-items-center">
                    <span>Price</span>
                    <span> Rp 
                        <?php 
                            $price = 0;
                            $quantity = 0;
                            $total = 0;
                            foreach($variant as $vr){
                                $price += $vr['harga'];
                                $quantity += $vr['jumlah']; 
                            }
                            $total = $price * $quantity;
                            echo number_format($total, 2);
                        ?>
                    </span>
                </div>
                <div class="fee d-flex justify-content-between align-items-center">
                    <span>Fee Delivery</span>
                    <span>Rp. 18.000</span>
                </div>
            </div>

            <hr style="border-bottom: 2px solid #fff;">

            <div id="totalsummary" class="d-flex justify-content-between align-items-center">
                <h2 class="f-lora color-expat fw-bold">Total Payment</h2>
                <span>Rp 
                    <?php 
                        $total -= 18000;
                        echo number_format($total, 2);?>
                </span>
            </div>


            <div id="paymentmethod" class="d-flex justify-content-between align-items-center mt-3">
                <a class="btn btn-white px-4 py-1" href="">CASH</a>
            </div>

            <div id="button-order" class="d-flex w-100 mt-3">
                <button type="submit" class="btn btn-expat w-100 py-3">ORDER</button>
            </div>

        </form>
    </div>
</div>