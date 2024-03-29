<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>



<script>
    const toastTrigger = document.getElementById('liveToastBtn')
    const toastLiveExample = document.getElementById('liveToast')

    if (toastTrigger) {
        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
        toastTrigger.addEventListener('click', () => {
            toastBootstrap.show()
        })
    }


    var harga ;
    var jumlah = 1;
    $("#total_variant").val(jumlah);

    $('#jumlahcoffe').text(jumlah);
    $('#injumlahcoffe').val(jumlah);
    
    $('.fa-plus-circle').on('click', function(){
        jumlah++;
        console.log(jumlah);
        $("#total_variant").val(jumlah);
        $(".showprice").text((harga * jumlah).toLocaleString('en-US'));
        $('#jumlahcoffe').text(jumlah);
        $('#injumlahcoffe').val(jumlah);
    })

    $('.fa-minus-circle').on('click', function(){
        jumlah--;
        if(jumlah < 1){
            jumlah = 1;
            $("#total_variant").val(jumlah);
            $(".showprice").text((harga * jumlah).toLocaleString('en-US'));
            $('#jumlahcoffe').text(jumlah);
            $('#injumlahcoffe').val(jumlah);
        }else{
            $("#total_variant").val(jumlah);
            $(".showprice").text((harga * jumlah).toLocaleString('en-US'));
            $('#jumlahcoffe').text(jumlah);
            $('#injumlahcoffe').val(jumlah);
        }
    })


    $(document).ready(function(){
        if($(".optional").is(":checked")){
            let rdy_optional = $("input[name='optional']:checked").val();
            let rdy_satuan = $("input[name='satuan']:checked").val();
            let rdy_additional = $("input[name='additional']:checked").val();

            let rdata = {
                id_optional: rdy_optional,
                id_satuan: rdy_satuan,
                id_additional: rdy_additional
            }

            $.ajax({
                url: "<?=base_url()?>widget/order/get_harga_produk?produk=<?= $_GET['produk']?>&cabang=<?= $_GET['cabang']?>",
                type: "POST",
                data: rdata,
                success: function (response) {
                    let result = JSON.parse(response)
                    console.log(result);
                    if(result != null){
                        $("#id_variant").val(result.id_variant);
                        harga = Number(result.harga);
                        $(".showprice").text(Number(result.harga).toLocaleString('en-US'));
                    }else{
                        harga = Number(0);
                        $(".showprice").text(Number(0).toLocaleString('en-US'));
                    }
                    
                    
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus);
                }
            });
        }


        
        $('.choose').on('change', function(){
            let val_optional = $("input[name='optional']:checked").val();
            let val_satuan = $("input[name='satuan']:checked").val();
            let val_additional = $("input[name='additional']:checked").val();

            let mdata = {
                id_optional: val_optional,
                id_satuan: val_satuan,
                id_additional: val_additional
            }

            $.ajax({
                url: "<?=base_url()?>widget/order/get_harga_produk?produk=<?= $_GET['produk']?>&cabang=<?= $_GET['cabang']?>",
                type: "POST",
                data: mdata,
                success: function (response) {
                    let result = JSON.parse(response)
                    console.log(result);
                    if(result != null){
                        $("#id_variant").val(result.id_variant);
                        harga = Number(result.harga);
                        $(".showprice").text(Number(result.harga).toLocaleString('en-US'));
                    }else{
                        harga = Number(0);
                        $(".showprice").text(Number(0).toLocaleString('en-US'));
                    }
                    
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus);
                }
            });
        });
    });

    $( "#detailorder" ).on( "submit", function( event ) {
        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
        toastBootstrap.show();
        // event.preventDefault();
    });


</script>