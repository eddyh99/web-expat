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
                    var btnActive ='<a href="<?=base_url()?>member/manual_activation/'+encodeURI(btoa(full.id))+'" class="btn btn-primary  my-1"><i class="ti ti-key fs-4"></i></a>'
                    var btnEnabled ='<a href="<?=base_url()?>member/edit_user/'+encodeURI(btoa(full.username))+'" class="btn btn-primary  my-1"><i class="ti ti-arrow-back fs-4"></i></a>'
                    var btnEdit ='<a href="<?=base_url()?>member/edit_member/'+encodeURI(btoa(full.id))+'" class="btn btn-success mx-1 my-1"><i class="ti ti-pencil-minus fs-4"></i></a>'
					var btnDelete = '<a href="<?=base_url()?>member/delete/'+encodeURI(btoa(full.id))+'" class="del-data btn btn-danger my-1"><i class="ti ti-trash"></i></a>';
					return `
                        ${full.status == 'new' ? btnActive : ''} 
                        ${full.status == 'disabled' ? btnEnabled : ''} 
                        ${((full.status == 'active') || (full.status == 'new')) ? btnEdit : ''} 
                        ${((full.status == 'active') || (full.status == 'new')) ? btnDelete : ''}`;     
                
                        
                } 
            },
		],
	});


    $('#member_status').on('change', function(){
        table_member.ajax.reload();
    })


</script>