<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.css" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<!-- Button Export Datatables -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>


<script>
    $('#tanggal').daterangepicker({
        startDate: moment().startOf('month'),
        endDate: moment().endOf('month'),
        opens: 'right',
        locale: {
            format: 'DD MMM YYYY'
        },
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().add(-1, 'days'), moment().add(-1, 'days'),],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
        }
    });

    var table = $('#table_history_topup').DataTable({
            "scrollX": true,
            "order": [ 1, "desc" ],
            "dom": 'Bfrtip',
            "buttons": [
                'excel', 'pdf',
            ],
            "ajax": {
                "url": "<?=base_url()?>history/get_history_topup",
                "type": "POST",
                "data": function(d) {
                    d.tanggal = $("#tanggal").val();
                    d.status = $("#topup_status").val()
                },
                "dataSrc":function (data){
                    console.log(data);
                    return data;							
                }
            },
            "columns": [
                { 
                    data: null,
                    "sortable": false, 
                    render: function (data, type, row, meta) {
                        return `<a class="text-decoration-underline text-black" href="<?= base_url()?>report/summarymember/${encodeURI(btoa(row.id_member))}">${row.qrmember}</a>`;    
                    
                    }
                },
                {   
                    data: 'tanggal', 
                },
                {   
                    data: 'invoice',
                    "sortable": false,  
                },
                {
                    data: 'nominal', render: $.fn.dataTable.render.number(',', '.',0, '')
                },
                {
                    data: 'poin',
                },
            ],
            "aoColumnDefs": [{	
				"aTargets": [5],
				"mRender": function (data, type, full, meta){
                    var btn;
                    if(full.status == 'success'){
                        btn = `
                        <button class="btn btn-success">
                            <i class="ti ti-check"></i>
                            Success
                        </button> `;
                    }else{
                        btn = `
                        <div class="dropdown me-1">
                            <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#approve${full.id}">
                                <i class="ti ti-clock"></i>
                                Pending
                            </button> 
                            <div class="modal fade" id="approve${full.id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Are you sure approve this invoice ? </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <h6>Invoice: <span class="text-deoration-underline"> ${full.invoice}</span></h6>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-expat" data-bs-dismiss="modal">Close</button>
                                        <a href="<?=base_url()?>history/approve_topup/${encodeURI(btoa(full.id_member))}/${encodeURI(btoa(full.invoice))}" class="btn btn-expat">Approve</a>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    }
                    
                                        

					return btn;
				}
			}],
    });

    $("#filter").on("click",function(){
        table
            .columns( 5 )
            .search( $("#topup_status").val() )
            .draw();
        table.ajax.reload();
    });

</script>