<!-- SELECT2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/rg-1.1.0/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/rg-1.1.0/datatables.min.js"></script>
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" /> -->

<style>

    div.dataTables_wrapper div.dataTables_paginate {
        background-color: #EAEFF4;
        border-radius: 8px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        border: none;
        background: #72A28A !important;
        color: #ffffff !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        border: none;
        background: #72A28A !important;
        color: #ffffff !important;
    }

    table.dataTable thead>tr>th.sorting_asc:before, 
    table.dataTable thead>tr>th.sorting_asc:after,
    table.dataTable thead>tr>th.sorting:after,
    table.dataTable thead>tr>th.sorting:before,
    table.dataTable thead>tr>th.sorting_desc:before, 
    table.dataTable thead>tr>th.sorting_desc:after
    {
        display: none;
    }

</style>

<script>


    $(document).ready(function() {
        $('.produk_select2').select2({
            placeholder: "All Produk",
            selectOnClose: true,
            allowClear: true,
            theme: "bootstrap"
        });
        
        $('.cabang_select2').select2();

        $('.optional_select2').select2();
   
        $('.additional_select2').select2();
   
        $('.satuan_select2').select2();

        // console.log( $("#produk_filter").val());
        var valfilter = $("#produk_filter").val();
        var textfilter = $("#produk_filter option:selected").text(); 
        $('#editprice').attr('href', `<?= base_url()?>produk/edit_variant?produk=${encodeURI(btoa(valfilter))}&name=${encodeURI(btoa(textfilter))}`);
    });

    $("select").on("select2:select", function (evt) {
        var element = evt.params.data.element;
        var $element = $(element);
        
        $element.detach();
        $(this).append($element);
        $(this).trigger("change");
    });

    // $('#example').DataTable()

    // var table = $('#table_list_variant').DataTable({
	// 	"scrollX": true,
	// 	"ajax": {
	// 		"url": "<?=base_url()?>produk/list_variant_produk",
	// 		"type": "POST",
    //         "data": {
    //             id_produk : function(){console.log($("#produk_filter").val()); return $("#produk_filter").val()}
    //         },
	// 		"dataSrc":function (data){
	// 			return data;							
	// 		}
	// 	},
	// 	"columns": [
	// 		{ data: 'cabang' },
	// 		{ data: 'optional' },
	// 		{ data: 'additional' },
	// 		{ data: 'satuan' },
	// 		{ data: 'harga', render: $.fn.dataTable.render.number(',', '.', 2) },
	// 		{ 
    //             data: null, "mRender": function(data, type, full, meta) {
    //                 var btnEdit ='<a href="<?=base_url()?>produk/edit_variant/'+encodeURI(btoa(full.id))+'" class="btn btn-success mx-1 my-1"><i class="ti ti-pencil-minus fs-4"></i></a>'
	// 				var btnDelete = '<a href="<?=base_url()?>produk/delete_variant/'+encodeURI(btoa(full.id))+'" class="del-data btn btn-danger my-1"><i class="ti ti-trash"></i></a>';
					
	// 				return `<div class="d-flex">${btnEdit} ${btnDelete} </div>`;     
                
                        
    //             } 
    //         },
	// 	],
	// });


    var collapsedGroups = {};
    var table = $('#table_list_variant').DataTable({
		"scrollX": true,
        "pageLength": 50,
		"ajax": {
			"url": "<?=base_url()?>produk/list_variant_produk",
			"type": "POST",
            "data": {
                id_produk : function(){return $("#produk_filter").val()}
            },
			"dataSrc":function (data){
				return data;							
			}
		},
		"columns": [
			{ data: null,
                render: function ( data, type, row ) {
                    if (type === 'display') {
                        return '';
                    }
                    return row.cabang;
                }
            },
			{ data: 'optional' },
			{ data: 'additional' },
			{ data: 'satuan' },
			{ data: 'harga', render: $.fn.dataTable.render.number(',', '.', 2) },
			{ 
                data: null, "mRender": function(data, type, full, meta) {
                    var btnEdit ='<a href="<?=base_url()?>produk/edit_variant/'+encodeURI(btoa(full.id))+'" class="btn btn-success mx-1 my-1"><i class="ti ti-pencil-minus fs-4"></i></a>'
					var btnDelete = '<a href="<?=base_url()?>produk/delete_variant/'+encodeURI(btoa(full.id))+'" class="del-data btn btn-danger my-1"><i class="ti ti-trash"></i></a>';
					
					return `<div class="d-flex">${btnEdit} ${btnDelete} </div>`;     
                
                        
                } 
            },
		],
        "rowGroup": {
            dataSrc: function(row) {
                return row.cabang;
            },
            startRender: function ( rows, group ) {
                var collapsed = !!collapsedGroups[group];
                rows.nodes().each(function (r) {
                    r.style.display = collapsed ? 'none' : '';
                });

                return $('<tr/>')
                    .append( `<td colspan="6" style="cursor: pointer;">${group}</td>` )
                    .attr('data-name', group)
                    .toggleClass('collapsed', collapsed);
                },          
        }
	});

    $('#table_list_variant tbody').on('click', 'tr.dtrg-start', function () {
        var name = $(this).data('name');
        collapsedGroups[name] = !collapsedGroups[name];
        table.draw(false);
    });



    $("#produk_filter").on("change",function(){
        valfilter = this.value;
        textfilter = $(this).find("option:selected").text();
        $('#editprice').attr('href', `<?= base_url()?>produk/edit_variant?produk=${encodeURI(btoa(valfilter))}&name=${encodeURI(btoa(textfilter))}`);
	    table.ajax.reload();
	})
</script>