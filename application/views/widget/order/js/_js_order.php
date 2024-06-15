<style>

    .modal-content{
        background-color: #121212 !important;
    }

</style>

<script>

    var priceQuantity = [];

    <?php foreach($variant as $vr){?>
        priceQuantity.push(
            {
                "id"    : <?= $vr['id']?>,
                "price" : <?= $vr['harga']?>,
                "jumlah" : <?= $vr['jumlah']?>,
            }
        );
    <?php }?>

    $('input[type=radio][name=cartdelivery]').on("change", function() {  
        console.log(this.value);
        if($(this).val() == "pickup"){  
            $('#idpengiriman').val(""); 
            $('#address').hide();
            $('#pickupoutlet').show();
            $('#labelpickup').addClass('bg-expat');
            $('#labeldelivery').removeClass('bg-expat');
            $("#ordernow").removeClass('disabled')
        }
        else if($(this).val() == "delivery"){
            $('#idpengiriman').val(<?= @$address->id?>); 
            $('#address').show();
            $('#pickupoutlet').hide();
            $('#labelpickup').removeClass('bg-expat');
            $('#labeldelivery').addClass('bg-expat');
        }
    });

    function pluscart(id){
        $('#jumlah'+id).val( function(i, val) {
            ++val;
            $.ajax({
                url: `<?=base_url()?>widget/order/kalkulasi_item/${id}/${val}`,
                type: "POST",
                success: function (response) {
                    console.log(response);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus);
                }
            });
            priceQuantity.forEach((el, i) => {
                if(el.id == id){
                    el.jumlah = val;
                }
            });
            kalkulasiprice();
            return val;
        });
    }

    function minuscart(id){
        
        $('#jumlah'+id).val( function(i, val) {
            --val;
            if(val < 1){
                console.log("HILANGKAN PRODUK");
                val = 0;
                $.ajax({
                    url: `<?=base_url()?>widget/order/remove_item/${id}/${val}`,
                    type: "POST",
                    success: function (response) {
                        $('#itempreview'+id).remove();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus);
                    }
                });
                priceQuantity.forEach((el, i) => {
                    if(el.id == id){
                        el.jumlah = val;
                    }
                });
                kalkulasiprice();
                return val;
            }else{
                $.ajax({
                    url: `<?=base_url()?>widget/order/kalkulasi_item/${id}/${val}`,
                    type: "POST",
                    success: function (response) {
                        console.log(response);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus);
                    }
                });
                priceQuantity.forEach((el, i) => {
                    if(el.id == id){
                        el.jumlah = val;
                    }
                });
                kalkulasiprice();
                return val;
            }
        });
    }

    function kalkulasiprice(){
        let subtotal = 0;
        let total = 0;
        let totalsummary = 0;
        let deliveryfee = <?= $address->delivery_fee?>;
        console.log(deliveryfee);
        priceQuantity.forEach((el, i) => {
            subtotal = el.price * el.jumlah;
            total += subtotal;
        });
        totalsummary = total + deliveryfee;
        $(".price-span").text(`${total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')}`);
        $("#amount").val(totalsummary);
        $(".total-price-span").text(`${totalsummary.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')}`);
    }
    kalkulasiprice();


    let $modalnote = $('#addnotemodal');
    $("#addnote").on("click", function(){
        $("#shownote").text($("#inptnote").val());
        $modalnote.modal('hide');
    });

    // $(document).ready(function(){
    //     if($(".paymentradio").is(":checked")){
    //         let rdy_method = $("input[name='paymentselectmodal']:checked").val();
    //         let rdy_label = $("input[name='paymentselectmodal']:checked").data("title");
    //         $("#methodpayment").val(rdy_method);
    //         $(".labelpayment").text(rdy_label);
    //     }
        
    //     $('.paymentradio').on('change', function(){
    //         let chg_method = $("input[name='paymentselectmodal']:checked").val();
    //         let chg_label = $("input[name='paymentselectmodal']:checked").data("title");
    //         console.log(chg_label);
    //         $("#methodpayment").val(chg_method);
    //         $(".labelpayment").text(chg_label);
    //     });
    // });


</script>