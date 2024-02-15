<!-- DATE PICKER -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<script>

    var table_promotion = $('#table_list_promotion').DataTable({
		"scrollX": true,
		"ajax": {
			"url": "<?=base_url()?>promotion/list_allpromotion",
			"type": "POST",
            "data": function(d) {
                d.status = $("#promotion_type").val()
            },
			"dataSrc":function (data){
				console.log(data);
				return data;							
			}
		},
		"columns": [
			{ 	data: null,
				"sortable": false, 
					render: function (data, type, row, meta) {
					return meta.row + meta.settings._iDisplayStart + 1;
				}
			},
			{ data: 'deskripsi' },
			{ data: 'tipe' },
			{ data: 'tanggal' },
			{ data: 'end_date' },
			{ 
                data: null, "mRender": function(data, type, full, meta) {
                    var btnEdit ='<a href="<?=base_url()?>member/edit_member/'+encodeURI(btoa(full.id))+'" class="btn btn-success mx-1 my-1"><i class="ti ti-pencil-minus fs-4"></i></a>'
					var btnDelete = '<a href="<?=base_url()?>member/delete/'+encodeURI(btoa(full.id))+'" class="del-data btn btn-danger my-1"><i class="ti ti-trash"></i></a>';
					return `
                        ${btnEdit} ${btnDelete}`;     
                
                        
                } 
            },
		],
	});


    $('#promotion_type').on('change', function(){
        table_promotion.ajax.reload();
    })

    $(document).ready(function(){		
        $("#images-logo").on("change",function(){	
          const $input = $(this);
          const reader = new FileReader();
          reader.onload = function(){
            $("#image-container").attr("src", reader.result);
            // var tempImg = [reader.result]
            // console.log(tempImg);
            // tempImg.forEach(b64toblob);
          }
          reader.readAsDataURL($input[0].files[0]);
        });

        
        $( "#start_date" ).datepicker({
            dateFormat: 'dd-mm-yy',
            changeYear: true,
            changeMonth: true,
            minDate: 0,
            yearRange: "-100:+20",
        }).val('');

        $( "#end_date" ).datepicker({
            dateFormat: 'dd-mm-yy',
            changeYear: true,
            changeMonth: true,
            minDate: 0,
            yearRange: "-100:+20",
        }).val('');
    });



</script>