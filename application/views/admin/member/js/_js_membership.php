<style>
    .th-desc {
        width: 700px;
    }
</style>

<script>
     var table_member = $('#table_list_membership').DataTable({
		"scrollX": true,
		"ajax": {
			"url": "<?=base_url()?>member/list_membership",
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
			{ data: 'tipe' },
			{ data: 'minpoin' },
			{ data: 'deskripsi' },
			{ 
                data: null, "mRender": function(data, type, full, meta) {
                    var btnEdit ='<a href="<?=base_url()?>member/edit_membership/'+encodeURI(btoa(full.tipe))+'" class="btn btn-success mx-1 my-1"><i class="ti ti-pencil-minus fs-4"></i></a>'
					return `${btnEdit}`;     
                } 
            },
		],
	});
</script>