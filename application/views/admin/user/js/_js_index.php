<script>

    $('#table_list_user').DataTable({
		"scrollX": true,
		"ajax": {
			"url": "<?=base_url()?>user/list_alluser",
			"type": "POST",
			"dataSrc":function (data){
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
			{ data: 'username' },
			{ data: 'nama' },
			{ data: 'role' },
			{ 
                data: null, "mRender": function(data, type, full, meta) {
                    button='<a href="<?=base_url()?>user/edit_user/'+encodeURI(btoa(full.username))+'" class="btn btn-success mx-1 my-1"><i class="ti ti-pencil-minus fs-4"></i></a>'
					button = button + '<a href="<?=base_url()?>user/delete/'+encodeURI(btoa(full.username))+'" class="del-data btn btn-danger mx-1 my-1"><i class="ti ti-trash"></i></a>';
					return button;     
                
                        
                } 
            },
		],
	});

</script>