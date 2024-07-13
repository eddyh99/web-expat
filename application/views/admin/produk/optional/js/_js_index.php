<!-- SELECT2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script>
    $(document).ready(function() {
        $('.optional_group_select2').select2({
            placeholder: "Optional Group",
            tags: true,
            selectOnClose: true,
            allowClear: true,
            theme: "bootstrap"
        });

    });

    var table = $('#table_list_optional').DataTable({
		"scrollX": true,
		"ajax": {
			"url": "<?=base_url()?>produk/list_alloptional",
			"type": "POST",
			"dataSrc":function (data){
				console.log(data);
				return data;							
			}
		},
		"columns": [
			{ data: 'sku' },
			{ data: 'optiongroup' },
			{ data: 'optional' },
			{ data: 'price', render: $.fn.dataTable.render.number(',', '.', 0) },
			{ 
                data: null, "mRender": function(data, type, full, meta) {
                    var btnEdit ='<a href="<?=base_url()?>produk/edit_optional/'+encodeURI(btoa(full.id))+'" class="btn btn-success mx-1 my-1"><i class="ti ti-pencil-minus fs-4"></i></a>'
					var btnDelete = '<a href="<?=base_url()?>produk/delete_optional/'+encodeURI(btoa(full.id))+'" class="del-data btn btn-danger my-1"><i class="ti ti-trash"></i></a>';
					
					return `<div class="d-flex">${btnEdit} ${btnDelete} </div>`;     
                
                        
                } 
            },
		],
	});
</script>