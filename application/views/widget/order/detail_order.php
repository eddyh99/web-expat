<div class="w-100 header-detail-order position-relative">
    <img class="img-fluid" src="<?= base_url()?>assets/img/widget/expresso.png" alt="img">
</div>
<div class="app-content px-2 row  mb-5 pb-5">
    <div class="app-member mx-auto col-12 col-lg-8  border-1 border-white">
        <form id="detailorder" action="<?= base_url()?>widget/order/detail_process" method="POST">
            <div class="mt-3">
                    <h1>Espresso</h1>
                    <span class="desc">Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus libero nulla tempora!</span>
                    <h3 class="showprice">Rp 38.000</h3>
            </div>
            <hr style="border-bottom: 8px solid #fff;">
            <div class="mt-3 mb-4">
                <h3 class="f-lora">Option Available</h3>
                <div class="pt-2">
                    <label for="hot" class="d-flex justify-content-between">
                        <span>Hot</span>
                        <input type="radio" id="hot" value="hot" name="typecoffe">
                    </label>
                </div>
                <div class="pt-2">
                    <label for="iced" class="d-flex justify-content-between">
                        <span>Iced</span>
                        <input type="radio" id="iced" value="iced" name="typecoffe">
                    </label>
                </div>
            </div>
            <hr style="border-bottom: 2px solid #fff;">
            <div class="mt-3 mb-4">
                <h3 class="f-lora">Cup Size</h3>
                <div class="pt-2">
                    <label for="cupsisze" class="d-flex justify-content-between">
                        <span>4 oz</span>
                        <input type="radio" id="cupsisze" value="4" name="cupsize">
                    </label>
                </div>
            </div>
            <hr style="border-bottom: 2px solid #fff;">
            <div class="mt-3 mb-4">
                <h3 class="f-lora">Espresso</h3>
                <div class="pt-2">
                    <label for="shot0" class="d-flex justify-content-between">
                        <span>Normal Shot</span>
                        <input type="radio" id="shot0" value="0" name="shot">
                    </label>
                </div>
                <div class="pt-2">
                    <label for="shot1" class="d-flex justify-content-between">
                        <span>+1 Shot +Rp 10.000</span>
                        <input type="radio" id="shot1" value="1" name="shot">
                    </label>
                </div>
                <div class="pt-2">
                    <label for="shot2" class="d-flex justify-content-between">
                        <span>+2 Shot +Rp 20.000</span>
                        <input type="radio" id="shot2" value="2" name="shot">
                    </label>
                </div>
                <div class="pt-2">
                    <label for="shot3" class="d-flex justify-content-between">
                        <span>+3 Shot +Rp 30.000</span>
                        <input type="radio" id="shot3" value="3" name="shot">
                    </label>
                </div>
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