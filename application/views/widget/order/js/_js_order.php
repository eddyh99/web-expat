<style>

    .modal-content{
        background-color: #121212 !important;
    }

</style>

<script>

    var priceQuantity = [];
    var deliveryfee = <?= $address->delivery_fee?>;
    $(".deliveryfee-span").text(`${deliveryfee.toLocaleString('en-ID')}`);

    <?php foreach($selected_product as $key => $product){?>
        priceQuantity.push(
            {
                "id"    : <?= $key?>,
                "price" : <?= $product->price?>,
                "jumlah" : <?= $product->quantity?>,
            }
        );
    <?php }?>

    $('input[type=radio][name=cartdelivery]').on("change", function() {  
        if($(this).val() == "pickup"){  
            $('#idpengiriman').val(""); 
            $('#address').hide();
            $('#pickupoutlet').show();
            $('#labelpickup').addClass('bg-expat');
            $('#labeldelivery').removeClass('bg-expat');
            $("#ordernow").removeClass('disabled')
            deliveryfee = 0;
            $(".deliveryfee-span").text(0);
            kalkulasiprice();
        }
        else if($(this).val() == "delivery"){
            $('#idpengiriman').val(<?= @$address->id?>); 
            $('#address').show();
            $('#pickupoutlet').hide();
            $('#labelpickup').removeClass('bg-expat');
            $('#labeldelivery').addClass('bg-expat');
            deliveryfee = <?= $address->delivery_fee?>;
            $(".deliveryfee-span").text(`${deliveryfee.toLocaleString('en-ID')}`);
            kalkulasiprice();
        }
    });

    function pluscart(id){
        $('#jumlah'+id).val( function(i, val) {
            ++val;
            console.log("PLUS " + val);
            console.log(val);
            $.ajax({
                url: `<?=base_url()?>widget/order/kalkulasi_item/${id}/${val}`,
                type: "POST",
                success: function (response) {
                    console.log("");
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log("");
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
            console.log("MINUS " + val);
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
                        console.log("");
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log("");
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
        priceQuantity.forEach((el, i) => {
            subtotal = el.price * el.jumlah;
            total += subtotal;
        });
        totalsummary = total + deliveryfee;
        $(".price-span").text(`${total.toLocaleString('en-ID')}`);
        $("#amount").val(totalsummary);
        $(".total-price-span").text(`${totalsummary.toLocaleString('en-ID')}`);
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