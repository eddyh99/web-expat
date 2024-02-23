
<!--<div class="apps-topbar alerts row py-4">
    <div class="apps-member mx-auto col-12 col-lg-8" style="border-bottom: none;">
        <div class="alert-notif d-flex justify-content-between px-2 px-lg-0">
            <div class="action-icon">
                <a href="#" class="text-white">
                    <i class="fas fa-chevron-left fs-1"></i>
                </a>
            </div>
            <div class="action">
                <a class="text-white text-decoration-none fs-5">TOP UP</a>
            </div>
            <div class="action">
            </div>
        </div>
    </div>
</div>!-->

<div class="app-content px-2 row pt-3 mb-5 pb-5">
    <div class="app-member mx-auto col-12 col-lg-8">
        <?php if (@isset($_SESSION["error"])) { ?>
            <div class="col-12 alert alert-danger alert-dismissible fade show" role="alert">
                <span class="notif-login f-poppins"><?= $_SESSION["error"] ?></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php } ?>
        <form action="<?=base_url()?>widget/topup/summary/<?=$token?>" method="POST">
            <input type="hidden" id="token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
			<input type="hidden" name="token" value="<?=$token?>">
			<input type="hidden" name="email" value="<?=$email?>">
            <h6 class="text-white">SELECT TOP-UP VALUE</h6>
            <div class="d-flex gap-1">
                <div class="col-4">
                    <label for="rp50" class="label-amount">
                        <input type="radio" id="rp50" value="50000" name="amount" class="card-input-amount-select">
                        <span class="span-amount">Rp 50.000</span>
                    </label>
                </div>
                <div class="col-4">
                    <label for="rp100" class="label-amount">
                        <input type="radio" id="rp100" value="100000" name="amount" class="card-input-amount-select">
                        <span class="span-amount">Rp 100.000</span>
                    </label>
                </div>
                <div class="col-4">
                    <label for="rp200" class="label-amount">
                        <input type="radio" id="rp200" value="200000" name="amount" class="card-input-amount-select">
                        <span class="span-amount">Rp 200.000</span>
                    </label>
                </div>
            </div>
            <div class="d-flex gap-1 mt-2">
                <div class="col-4">
                    <label for="rp300" class="label-amount">
                        <input type="radio" id="rp300" value="300000" name="amount" class="card-input-amount-select">
                        <span class="span-amount">Rp 300.000</span>
                    </label>
                </div>
                <div class="col-4">
                    <label for="rp500" class="label-amount">
                        <input type="radio" id="rp500" value="500000" name="amount" class="card-input-amount-select">
                        <span class="span-amount">Rp 500.000</span>
                    </label>
                </div>
                <div class="col-4">
                    <label for="rp1000" class="label-amount">
                        <input type="radio" id="rp1000" value="1000000" name="amount" class="card-input-amount-select">
                        <span class="span-amount">Rp 1.000.000</span>
                    </label>
                </div>
            </div>
            
            <br><br>
            <!-- <input type="text" name="amount" placeholder="Enter specific value" class="input-amount-topup-specifict money-input"> -->
            
            <br><br><br><br>
            <h6 class="text-white">PAYMENT METHOD (by doku)</h6>
            <label for="selectcredit" class="label-method-payment my-3">
                <div class="d-flex align-items-center">
                    <input type="radio" name="methodpayment" id="selectcredit" value="credit">
                    <span class="text-white px-2">Credit Card</span>
                    <img class="img-fluid" src="<?= base_url()?>assets/img/payment/card.png" alt="credit">
                </div>
            </label>
            <br>
            <label for="selectva" class="label-method-payment my-3">
                <div class="d-flex align-items-center">
                    <input type="radio" name="methodpayment" id="selectva" value="virtual">
                    <span class="text-white px-2">Virtual Account</span>
                    <img class="img-fluid" src="<?= base_url()?>assets/img/payment/va.png" alt="credit">
                </div>
            </label>
            <br>
            <label for="selectewallet" class="label-method-payment my-3">
                <div class="d-flex align-items-center">
                    <input type="radio" name="methodpayment" id="selectewallet" value="wallet">
                    <span class="text-white px-2">e-wallet</span>
                    <img class="img-fluid" src="<?= base_url()?>assets/img/payment/e-wallet.png" alt="credit">
                </div>
            </label>
            <br>
            <label for="selectqris" class="label-method-payment my-3">
                <div class="d-flex align-items-center">
                    <input type="radio" name="methodpayment" id="selectqris" value="qris">
                    <span class="text-white px-2">QRis</span>
                    <img class="img-fluid" src="<?= base_url()?>assets/img/payment/qris.png" alt="credit">
                </div>
            </label>

            <br><br>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn-expat px-5 py-2 d-flex justify-content-center align-items-center">TOP UP</button>
            </div>
            <br><br><br>
        </form>
    </div>
</div>