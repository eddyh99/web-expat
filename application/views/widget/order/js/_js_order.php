<script>
    
    $('input[type=radio][name=cartdelivery]').on("change", function() {  
        console.log(this.value);
        if($(this).val() == 2){   
            $('#labelpickup').addClass('bg-expat');
            $('#labeldelivery').removeClass('bg-expat');
        }
        else if($(this).val() == 1){
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
            console.log(val);
            return val;
        });
        // document.getElementById("jumlah"+id).value++;
    }

    function minuscart(id){
        
        $('#jumlah'+id).val( function(i, val) {
            --val;
            if(val < 1){
                console.log("HILANGKAN PRODUK");
                val = 1;
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
                console.log(val);
            }
            return val;
        });
    }

</script>