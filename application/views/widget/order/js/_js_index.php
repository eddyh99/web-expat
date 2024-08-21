<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>



<script type="text/javascript">
    const toastTrigger = document.getElementById('liveToastBtn')
    const toastLiveExample = document.getElementById('liveToast')

    if (toastTrigger) {
        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
        toastTrigger.addEventListener('click', () => {
            toastBootstrap.show()
        })
    }


    var harga = Number('<?= $product->price?>');
    var jumlah = 1;
    $("#total_cart").val(jumlah);

    $('#jumlahcoffe').text(jumlah);
    $('#injumlahcoffe').val(jumlah);
    
    $('.fa-plus-circle').on('click', function(){
        jumlah++;
        console.log(harga);
        $("#total_cart").val(jumlah);
        $(".showprice").text((harga * jumlah).toLocaleString('en-ID'));
        $('#jumlahcoffe').text(jumlah);
        $('#injumlahcoffe').val(jumlah);
    })

    $('.fa-minus-circle').on('click', function(){
        jumlah--;
        if(jumlah < 1){
            jumlah = 1;
            $("#total_cart").val(jumlah);
            $(".showprice").text((harga * jumlah).toLocaleString('en-ID'));
            $('#jumlahcoffe').text(jumlah);
            $('#injumlahcoffe').val(jumlah);
        }else{
            $("#total_cart").val(jumlah);
            $(".showprice").text((harga * jumlah).toLocaleString('en-ID'));
            $('#jumlahcoffe').text(jumlah);
            $('#injumlahcoffe').val(jumlah);
        }
    })


    $(document).ready(function(){
        new Readmore('article', {
            speed: 75,
            collapsedHeight: 95, 
        });


        // Input Radio Optional, Satuan, Additional is checked first
        if($(".optional").is(":checked")){
            let rdy_optional = $("input[name='optional']:checked").attr("data-opt");
            let rdy_satuan = $("input[name='satuan']:checked").attr("data-st");
            let rdy_additional = $("input[name='additional']:checked").attr("data-ad");
            $("#idoptional").val(rdy_optional);
            $("#idsatuan").val(rdy_satuan);
            $("#idadditional").val(rdy_additional);
        }

        
        // Input Radio Optional, Satuan, Additional is changes
        $('.choose').on('change', function(){
            let val_optional = $("input[name='optional']:checked");
            let val_satuan = $("input[name='satuan']:checked");
            let val_additional = $("input[name='additional']:checked");

            console.log(val_optional.val());
            console.log(val_optional.attr("data-opt"));

            
            $("#idoptional").val(val_optional.attr("data-opt"));
            $("#idsatuan").val(val_satuan.attr("data-st"));
            $("#idadditional").val(val_additional.attr("data-ad"));

            let mdata = {
                price_optional: ((val_optional.val() == undefined) ? '0' : val_optional.val()),
                price_satuan: ((val_satuan.val() == undefined) ? '0' : val_satuan.val()),
                price_additional: ((val_additional.val() == undefined) ? '0' : val_additional.val())
            }

            let baseprice = Number('<?= $product->price?>');
            let total_price = baseprice + Number(mdata.price_optional) + Number(mdata.price_satuan) + Number(mdata.price_additional);
            harga = total_price;
            jumlah = 1;
            $("#injumlahcoffe").val('1');
            $('#jumlahcoffe').text('1');
            $("#total_cart").val(jumlah);
            $(".showprice").text(total_price.toLocaleString('en-ID'));

        });



    });

    $( "#detailorder" ).on( "submit", function( event ) {
        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
        toastBootstrap.show();
        // event.preventDefault();
    });


    function postMessage(){
        Total.postMessage('<?= @$totalorder?>');
    }
    postMessage();


</script>