<script>

    var table_member = $('#table_list_member').DataTable({
		"scrollX": true,
		"ajax": {
			"url": "<?=base_url()?>member/list_allmember",
			"type": "POST",
            "data": function(d) {
                d.status = $("#member_status").val()
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
			{ data: 'email' },
			{ data: 'nama' },
			{ 
                data: null, "mRender": function(data, type, full, meta) {
                    return full.dob.split("-").reverse().join("-");
                } 
            },
			{ data: 'gender' },
			{ data: 'membership' },
			{ 
                data: null, "mRender": function(data, type, full, meta) {
                    button='<a href="<?=base_url()?>user/edit_user/'+encodeURI(btoa(full.username))+'" class="btn btn-success mx-1 my-1"><i class="ti ti-pencil-minus fs-4"></i></a>'
					button = button + '<a href="<?=base_url()?>user/delete/'+encodeURI(btoa(full.username))+'" class="del-data btn btn-danger mx-1 my-1"><i class="ti ti-trash"></i></a>';
					return button;     
                
                        
                } 
            },
		],
	});


    $('#member_status').on('change', function(){
        table_member.ajax.reload();
    })


</script>