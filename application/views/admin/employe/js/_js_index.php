<script>

    var table_employe = $('#table_list_employe').DataTable({
		"scrollX": true,
		"ajax": {
			"url": "<?=base_url()?>employe/list_allemploye",
			"type": "POST",
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
			{ data: 'email' },
			{ data: 'nama' },
			{ 
                data: null, "mRender": function(data, type, full, meta) {
                    return full.dob.split("-").reverse().join("-");
                } 
            },
			{ data: 'gender' },
			{ data: 'is_driver' },
			{ data: 'plafon' },
			{ 
                data: null, "mRender": function(data, type, full, meta) {
                    var btnEdit ='<a href="<?=base_url()?>employe/edit_employe/'+encodeURI(btoa(full.id))+'" class="btn btn-success mx-1 my-1"><i class="ti ti-pencil-minus fs-4"></i></a>'
					var btnDelete = '<a href="<?=base_url()?>employe/delete/'+encodeURI(btoa(full.id))+'" class="del-data btn btn-danger my-1"><i class="ti ti-trash"></i></a>';
					return `
						${btnEdit} ${btnDelete}`; 
                
                        
                } 
            },
		],
	});



</script>