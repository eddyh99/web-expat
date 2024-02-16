
<div class="apps-topbar alerts row py-4">
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
</div>

<div class="app-content px-2 row pt-3 mb-5 pb-5">
    <div class="app-member mx-auto col-12 col-lg-8">
        <form action="" method="POST">
            <h6 class="text-white">SELECT TOP-UP VALUE</h6>
            <div class="d-flex gap-1">
                <div class="col-4">
                    <label for="rp50" class="label-amount">
                        <input type="radio" id="rp50" value="50" name="amount" class="card-input-amount-select">
                        <span class="span-amount">Rp 50.000</span>
                    </label>
                </div>
                <div class="col-4">
                    <label for="rp100" class="label-amount">
                        <input type="radio" id="rp100" value="100" name="amount" class="card-input-amount-select">
                        <span class="span-amount">Rp 100.000</span>
                    </label>
                </div>
                <div class="col-4">
                    <label for="rp200" class="label-amount">
                        <input type="radio" id="rp200" value="200" name="amount" class="card-input-amount-select">
                        <span class="span-amount">Rp 200.000</span>
                    </label>
                </div>
            </div>
            <div class="d-flex gap-1 mt-2">
                <div class="col-4">
                    <label for="rp300" class="label-amount">
                        <input type="radio" id="rp300" value="300" name="amount" class="card-input-amount-select">
                        <span class="span-amount">Rp 300.000</span>
                    </label>
                </div>
                <div class="col-4">
                    <label for="rp500" class="label-amount">
                        <input type="radio" id="rp500" value="500" name="amount" class="card-input-amount-select">
                        <span class="span-amount">Rp 500.000</span>
                    </label>
                </div>
                <div class="col-4">
                    <label for="rp1000" class="label-amount">
                        <input type="radio" id="rp1000" value="1000" name="amount" class="card-input-amount-select">
                        <span class="span-amount">Rp 1.000.000</span>
                    </label>
                </div>
            </div>
            
            <br><br>
            <input type="text" placeholder="Enter specific value" class="input-amount-topup-specifict money-input">
            
            <br><br><br><br>
            <h6 class="text-white">PAYMENT METHOD (by doku)</h6>
            <label for="selectcredit" class="label-method-payment my-3">
                <div class="d-flex align-items-center">
                    <input type="radio" name="methodpayment" id="selectcredit">
                    <span class="text-white px-2">Credit Card</span>
                    <img class="img-fluid" src="<?= base_url()?>assets/img/payment/card.png" alt="credit">
                </div>
            </label>
            <br>
            <label for="selectva" class="label-method-payment my-3">
                <div class="d-flex align-items-center">
                    <input type="radio" name="methodpayment" id="selectva">
                    <span class="text-white px-2">Virtual Account</span>
                    <img class="img-fluid" src="<?= base_url()?>assets/img/payment/va.png" alt="credit">
                </div>
            </label>
            <br>
            <label for="selectewallet" class="label-method-payment my-3">
                <div class="d-flex align-items-center">
                    <input type="radio" name="methodpayment" id="selectewallet">
                    <span class="text-white px-2">e-wallet</span>
                    <img class="img-fluid" src="<?= base_url()?>assets/img/payment/e-wallet.png" alt="credit">
                </div>
            </label>
            <br>
            <label for="selectqris" class="label-method-payment my-3">
                <div class="d-flex align-items-center">
                    <input type="radio" name="methodpayment" id="selectqris">
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

<div class="app-botbar fixed-bottom row">
    <div class="app-member mx-auto col-12 col-lg-5">
        <div class="d-flex flex-row justify-content-around">
            <div class="d-flex flex-column justify-content-center align-items-center">
                <a class="icon-svg home rounded-circle fill" href="<?= base_url() ?>homepage">
                    <svg width="28" height="26" viewBox="0 0 28 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21.9978 26.0002H17.4487C16.9346 25.8199 16.8143 25.5567 16.8174 25.0627C16.8296 23.1402 16.8264 21.2173 16.8169 19.2949C16.8158 19.0591 16.7872 18.8024 16.6865 18.5926C16.4125 18.0217 15.8878 17.8287 15.265 17.8297C14.5421 17.8307 13.8186 17.8491 13.0967 17.8251C12.2672 17.7976 11.5808 18.3848 11.6036 19.2353C11.654 21.148 11.6126 23.0633 11.6243 24.9771C11.6275 25.4553 11.4764 25.8128 10.9957 26.0002H6.02306C5.30965 25.8174 4.66886 25.5241 4.20297 24.9425C3.85528 24.5081 3.6014 24.0314 3.59822 23.4814C3.58338 20.8746 3.58709 18.2672 3.58391 15.6603C3.58391 15.5712 3.58391 15.4816 3.58391 15.4423C3.28498 15.4189 3.01573 15.4245 2.7592 15.3726C2.04473 15.229 1.44899 14.9046 1.09176 14.2599C1.06102 14.2247 1.02974 14.1891 0.999003 14.1539C0.892469 13.9181 0.786466 13.6824 0.679932 13.4466C0.679932 13.3447 0.679932 13.2434 0.679932 13.1415V12.8365C0.679932 12.7173 0.679932 12.5987 0.679932 12.48C0.821447 12.2106 0.963492 11.9417 1.10501 11.6723C1.11826 11.654 1.13098 11.6357 1.14423 11.6168C1.20995 11.5308 1.26454 11.434 1.34193 11.3596C5.07326 7.77297 8.80672 4.18782 12.5396 0.602661C12.6011 0.543588 12.6679 0.490625 12.7326 0.434607C12.7527 0.421876 12.7729 0.408635 12.793 0.395904C13.2997 0.103083 13.8244 -0.0486753 14.4392 0.013963C15.0482 0.0766013 15.5411 0.307803 15.9604 0.705531C17.764 2.41561 19.5651 4.12925 21.3613 5.84697C23.0971 7.50714 24.8234 9.17546 26.5581 10.8366C27.0934 11.3495 27.5975 11.876 27.7199 12.6328C27.6993 12.9409 27.7247 13.2602 27.6494 13.5556C27.4242 14.4432 26.8459 15.0365 25.9173 15.2712C25.5802 15.3563 25.2246 15.3736 24.8552 15.425C24.8552 15.4317 24.8552 15.4637 24.8552 15.4953C24.8562 18.0197 24.8594 20.5435 24.8552 23.0679C24.8552 23.3083 24.8425 23.5568 24.7815 23.788C24.5324 24.7306 23.9473 25.4156 23.0144 25.8087C22.8241 25.8892 22.6196 25.9376 22.4213 26.0002H21.9984H21.9978Z" fill="white"/>
                    </svg>
                </a>
                <span class="text-white text-botbar">Home</span>
            </div>
            <div class="d-flex flex-column justify-content-center align-items-center circle-scan">
                <a class="icon-svg list rounded-circle fill scan" href="<?= base_url() ?>statistic">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M0 224h192V32H0v192zM64 96h64v64H64V96zm192-64v192h192V32H256zm128 128h-64V96h64v64zM0 480h192V288H0v192zm64-128h64v64H64v-64zm352-64h32v128h-96v-32h-32v96h-64V288h96v32h64v-32zm0 160h32v32h-32v-32zm-64 0h32v32h-32v-32z"/></svg>
                </a>
                <span class="text-white">Scan</span>
            </div>
            <div class="d-flex flex-column justify-content-center align-items-center">
                <a class="icon-svg wallet rounded-circle fill " href="<?= base_url() ?>wallet">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M256 288c79.5 0 144-64.5 144-144S335.5 0 256 0 112 64.5 112 144s64.5 144 144 144zm128 32h-55.1c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16H128C57.3 320 0 377.3 0 448v16c0 26.5 21.5 48 48 48h416c26.5 0 48-21.5 48-48v-16c0-70.7-57.3-128-128-128z"/></svg>
                </a>
                <span class="text-white text-botbar">Profile</span>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="postModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-white p-5 d-flex justify-content-center gap-2">
                <a id="explicit" class="btn-explicit-content text-white add-textarea-local" href="<?= base_url()?>post?type=explicit">Explicit contents</a>
                <a id="nonexplicit" class="btn-main-green text-white add-textarea-local" href="<?= base_url()?>post?type=non">Non explicit contents</a>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>
