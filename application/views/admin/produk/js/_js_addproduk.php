<!-- SELECT2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>

    $(document).ready(function() {
        
        $('.cabang_select2').select2();

        $('.optional_select2').select2();
   
        $('.additional_select2').select2();
   
        $('.satuan_select2').select2();

        $("#images-logo").on("change",function(){	
          const $input = $(this);
          const reader = new FileReader();
          reader.onload = function(){
            $("#image-container").attr("src", reader.result);
          }
          reader.readAsDataURL($input[0].files[0]);
        });

    });

    $('#subkategori').select2({
        placeholder: "Sub Kategori",
        tags: true,
        selectOnClose: true,
        allowClear: true,
        theme: "bootstrap"
    });
    
    $("#selectall").click(function(){
        if($("#selectall").is(':checked') ){
            $("#cabang > option").prop("selected","selected");
            $("#cabang").trigger("change");
        }else{
            $("#cabang > option").prop("selected","");
            $("#cabang").trigger("change");
            // $("#cabang > option").removeAttr("selected");
        }
    });

</script>