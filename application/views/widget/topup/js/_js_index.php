<script>

    $(document).ready(function() {
        $('.card-input-amount-select').change(function(){
            let selected_value = $("input[name='amount']:checked").val();
            $("input[name='amount']").parent('label').removeClass('active-topup');
            $("input[name='amount']").next('.span-amount').removeClass('active');
            if ($("input[name='amount']").is(':checked')){
                $("input[name='amount']:checked").parent('label').addClass('active-topup');
                $("input[name='amount']:checked").next('.span-amount').addClass('active');
                $("input[type='text']").val('');
            }
        })

        $("input[type='text']").blur(function(){
            if(!$(this).val()){
                console.log("");
            } else{
                $("input[name='amount']:checked").parent('label').removeClass('active-topup');
                $("input[name='amount']:checked").next('.span-amount').removeClass('active');
                $("input[name='amount']").attr("checked", false);

            }
        });
        
    });

</script>