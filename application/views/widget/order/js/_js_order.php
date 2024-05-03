<style>

    .modal-content{
        background-color: #121212 !important;
    }

</style>

<script>

    
    // $(document).ready(function(){
    //     setTimeout(function(){
    //         $('#addaddress').modal('toggle');
    //     }, 1000);
    // });

    <?php if(isset($address)){?>
    $.ajax({                                      
        url: `<?= base_url()?>widget/order/loadaddress/<?= $token?>`,              
        type: "post",                
        success: function (response) {
            let result = JSON.parse(response)
            $("#shownameaddress").text(result.title);
            $("#showaddress").text(result.alamat);
            $("#showphone").text(`(${result.phone})`);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus);
        }
    });
    <?php }?>

    $('input[type=radio][name=cartdelivery]').on("change", function() {  
        console.log(this.value);
        if($(this).val() == "pickup"){  
            $('#idpengiriman').val(""); 
            $('#address').hide();
            $('#pickupoutlet').show();
            $('#labelpickup').addClass('bg-expat');
            $('#labeldelivery').removeClass('bg-expat');
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

    

    let $modaladdress = $('#editaddress');
    let $modalnote = $('#addnotemodal');



    $("#addnote").on("click", function(){
        $("#shownote").text($("#inptnote").val());
        $modalnote.modal('hide');
    });

    $("#btnaddaddress").on("click", function(){

        var formData = {
            nameaddress: $("#addinptname").val(),
            address: $("#addinptaddress").val(),
            phone: $("#addinptphone").val(),
            token: $("#usertoken").val(),
        };

        $.ajax({
            url: `<?=base_url()?>widget/order/addaddress_process`,
            type: "POST",
            data: formData,
            success: function (response) {
                $('#addaddress').modal('hide');
                $.ajax({                                      
                    url: `<?= base_url()?>widget/order/loadaddress/<?= $token?>`,              
                    type: "post",                
                    success: function (response) {
                        let result = JSON.parse(response)
                        $("#shownameaddress").text(result.title);
                        $("#showaddress").text(result.alamat);
                        $("#showphone").text(`(${result.phone})`);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus);
                    }
                });

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
            }
        });

    });


    $("#updateaddress").on("click", function(){

        var formData = {
            idaddress: $("#idaddress").val(),
            nameaddress: $("#inptname").val(),
            address: $("#inptaddress").val(),
            phone: $("#inptphone").val(),
            note: $("#inptnote").val(),
            token: $("#usertoken").val(),
        };
    
        $.ajax({
            url: `<?=base_url()?>widget/order/editaddress_process`,
            type: "POST",
            data: formData,
            success: function (response) {
                $modaladdress.modal('hide');
                $.ajax({                                      
                    url: `<?= base_url()?>widget/order/loadaddress/<?= $token?>`,              
                    type: "post",                
                    success: function (response) {
                        let result = JSON.parse(response)
                        console.log(result);
                        $("#shownameaddress").text(result.title);
                        $("#showaddress").text(result.alamat);
                        $("#showphone").text(`(${result.phone})`);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus);
                    }
                });

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
            }
        })

    })

</script>