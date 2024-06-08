<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.css" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<!-- SELECT2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


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


    var table = $('#table_history_order').DataTable({
            "scrollX": true,
            "order": [ 1, "desc" ],
            "ajax": {
                "url": "<?=base_url()?>history/get_history_order",
                "type": "POST",
                "data": function(d) {
                    d.tanggal = $("#tanggal").val();
                    d.idcabang = $("#idcabang").val()
                },
                "dataSrc":function (data){
                    console.log(data);
                    return data;							
                }
            },
            "columns": [
                {   
                    data: 'nama', 
                },
                {   
                    data: 'tanggal', 
                },
                {   
                    data: 'id_transaksi',
                    "sortable": false,  
                },
                {
                    data: 'cabang',
                },
                {
                    data: 'is_proses',
                },
            ],
            "aoColumnDefs": [{	
				"aTargets": [5],
				"mRender": function (data, type, full, meta){
                    var btn;
                    if(full.is_proses == 'complete'){
                        btn = `
                        <a class="btn btn-success" href="<?=base_url()?>history/detail_order">
                            <i class="ti ti-info-circle"></i>
                            Details
                        </a> `;
                    }else{
                        btn = `
                        <a class="btn btn-danger" href="<?=base_url()?>history/detail_order/${encodeURI(btoa(full.id_transaksi))}">
                            <i class="ti ti-clock"></i>
                            Pending
                        </a> `;
                        
                    }
					return `
                        <a class="btn ${(full.is_proses == 'complete') ? 'btn-success' : 'btn-danger'}" href="<?=base_url()?>history/detail_order/${encodeURI(btoa(full.id_transaksi))}">
                            ${(full.is_proses == 'complete') ? '<i class="ti ti-info-circle"></i>' : '<i class="ti ti-clock"></i>'}
                            ${(full.is_proses == 'complete') ? 'Details' : 'Pending'}
                        </a> `;
				}
			}],
    });


    $('.driver-select2').select2({
        placeholder: "Select Driver",
        allowClear: true,
        theme: "bootstrap", 
        width: "100%"
    });
    
    $("#savedriver").on("click",function(){
        var isi=$( "#driver option:selected" ).text();
        $("#drivername").html(isi);
        var iddriver=$("#driver").val();
        $("#id_driver").val(iddriver)
        $('#paymentmodal').modal("hide");
    })

    $("#filter").on("click",function(){
        table.ajax.reload();
    })
</script>