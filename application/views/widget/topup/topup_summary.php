
<div class="app-content px-2 row  my-5 py-5">
    <div class="app-member mx-auto col-12 col-lg-8  border-1 border-white">
        <form id="orderchart" action="<?= base_url()?>widget/topup/confirm" method="POST">
            <input type="hidden" name="token" value="<?= $data['token']?>">
            <input type="hidden" name="amount" value="<?= $data['amount']?>">
            <input type="hidden" name="email" value="<?= $data['email']?>">
            <input type="hidden" name="methodpayment" value="<?= $data['method']?>">

            <div class="d-flex flex-column justify-content-start align-items-center w-100">
                <h1 class="f-lora color-expat fw-bolder ">SUMMARY</h1>
                <hr style="border-bottom: 2px solid #fff; width: 100%;">
                <div class="d-flex justify-content-between align-items-center w-100 my-3">
                    <h6>Amount</h6>
                    <h5><?= number_format($data['amount'], 0, ',', ',')?></h5>
                </div>
                <?php if($data['method'] == 'credit'){?>
                <div id="credit" class="d-flex justify-content-between align-items-center w-100 my-3">
                    <h6>Fee Credit Card</h6>
                    <h5>3%</h5>
                </div>
                <?php }?>
                <hr style="border-bottom: 2px solid #fff; width: 100%;">
                <button type="submit" class="btn btn-expat px-5 py-2 mt-3">CONTINUE</button>
            </div>
        </form>
    </div>
</div>