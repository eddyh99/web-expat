<!-- MOMENT JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>


<script>

    $('#table_allmembers').DataTable({
            "scrollX": true,
            "ajax": {
                "url": "<?=base_url()?>report/get_all_member",
                "type": "POST",
                "dataSrc": function (data){
                    console.log(data);
                    return data;							
                }
            },
            "columns": [
                { 	
                    data: null,
                    "sortable": false, 
                        render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {   
                    data: 'nama'
                },
                {   
                    data: 'nama'
                },
                {   
                    data: 'nama'
                },
                {   
                    data: 'nama'
                },
                {   
                    data: 'nama'
                },
                
            ],
    });

    var table_topup = $('#table_membertopup').DataTable({
            "scrollX": true,
            "ajax": {
                "url": "<?=base_url()?>report/get_list_topup",
                "type": "POST",
                "data": function(d) {
                    d.startmonth = moment($("#month_topup").val()).startOf('month').format('YYYY-MM-DD');
                    d.endmonth = moment($("#month_topup").val()).endOf('month').format('YYYY-MM-DD');
                    d.idmember = '<?= $idmember?>';
                },
                "dataSrc": function (data){
                    return data;							
                }
            },
            "columns": [
                {   
                    data: 'topup', render: $.fn.dataTable.render.number(',', '.', 0) ,
                },
                {   
                    data: null,
                    "sortable": false, 
                    render: function (data, type, row, meta) {
                        
                        var date = new Date(row.tanggal);
                        var day = ("0" + date.getDate()).slice(-2);
                        var month = ("0" + (date.getMonth() + 1)).slice(-2);
                        var year = date.getFullYear();
                        var hours = ("0" + date.getHours()).slice(-2);
                        var minutes = ("0" + date.getMinutes()).slice(-2);
                        var seconds = ("0" + date.getSeconds()).slice(-2);

                        return `${hours}:${minutes}:${seconds} | ${day}-${month}-${year}`; 
                    }
                },
            ],
    });

    $("#filter_topup").on("click",function(){
        table_topup.ajax.reload();
    })

    var table_order = $('#table_memberorder').DataTable({
            "scrollX": true,
            "ajax": {
                "url": "<?=base_url()?>report/get_list_order",
                "type": "POST",
                "data": function(d) {
                    d.startmonth = moment($("#month_order").val()).startOf('month').format('YYYY-MM-DD');
                    d.endmonth = moment($("#month_order").val()).endOf('month').format('YYYY-MM-DD');
                    d.idmember = '<?= $idmember?>';
                },
                "dataSrc": function (data){
                    console.log(data);
                    return data;							
                }
            },
            "columns": [
                {   
                    data: 'nama'
                },
                {   
                    data: 'jumlah'
                },
            ],
    });

    $("#filter_order").on("click",function(){
        table_order.ajax.reload();
    })

</script>