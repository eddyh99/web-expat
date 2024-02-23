<script>

    var jumlah = 1;

    $('#jumlahcoffe').text(jumlah);
    $('#injumlahcoffe').val(jumlah);
    
    $('.fa-plus-circle').on('click', function(){
        jumlah++;
        $('#jumlahcoffe').text(jumlah);
        $('#injumlahcoffe').val(jumlah);
    })

    $('.fa-minus-circle').on('click', function(){
        jumlah--;
        if(jumlah < 0){
            jumlah = 0;
            $('#jumlahcoffe').text(jumlah);
            $('#injumlahcoffe').val(jumlah);
        }else{
            $('#jumlahcoffe').text(jumlah);
            $('#injumlahcoffe').val(jumlah);
        }
    })


    $('input[name=chartdelivery]:radio').change(function() {  
        if($(this).val() == "pickup"){   
            $('#labelpickup').addClass('bg-expat');
            $('#labeldelivery').removeClass('bg-expat');
        }
        else if($(this).val() == "delivery"){
            $('#labelpickup').removeClass('bg-expat');
            $('#labeldelivery').addClass('bg-expat');
        }
    });

</script>