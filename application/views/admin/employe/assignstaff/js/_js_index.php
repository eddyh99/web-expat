<!-- SELECT2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script>

    $(document).ready(function(){		

        $('.addstaff-select2').select2({
            placeholder: "Select Staff",
            allowClear: true,
            theme: "bootstrap", 
            width: "100%"
        });

        $('.addoutlet-select2').select2({
            placeholder: "Select Outlet",
            allowClear: true,
            theme: "bootstrap", 
            width: "100%"
        });
    });

    var table_assignstaff = $('#table_list_assignstaff').DataTable({
		"scrollX": true,
		"ajax": {
			"url": "<?=base_url()?>employe/list_assignstaff",
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
			{ data: 'nama' },
			{ data: 'cabang' },
			{ data: 'alamat' },
			{ 
                data: null, "mRender": function(data, type, full, meta) {
					return '<a href="<?=base_url()?>employe/delete_assignstaff/'+encodeURI(btoa(full.staffid))+'/'+encodeURI(btoa(full.cabang_id))+'" class="del-data btn btn-danger my-1"><i class="ti ti-trash"></i></a>';    
                } 
            },
		],
	});


</script>