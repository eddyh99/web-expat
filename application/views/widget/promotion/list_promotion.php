<div class="app-content px-2 row  mb-5 pb-5">
    <div class="app-member mx-auto col-12 col-lg-8  border-1 border-white">
        <form id="detailorder" action="<?= base_url()?>widget/order/setcookie_add_tocart" method="POST">
            <div class="nav-head mt-4 d-flex align-items-center justify-content-between">
                <a href="<?= base_url()?>widget/order/ordersummary/<?= $token?>?cabang=<?= $_GET['cabang']?>">
                    <i class="fas fa-chevron-left fs-1"></i>
                </a>
                <div>
                    <span>PROMOTION</span>
                </div>
                <div></div>
            </div>

            <div class="content mt-4">
                <?php for($i = 0; $i <= 5; $i++){?>
                <a href="<?= base_url()?>widget/order/claim_promotion/<?= $token?>?cabang=<?= $_GET['cabang']?>" class="my-3 d-block">
                    <img class="img-fluid rounded-3 w-100" src="<?= base_url()?>assets/img/widget/promo.png" alt="">
                </a>
                <?php }?>
            </div>
        </form>
    </div>
</div>