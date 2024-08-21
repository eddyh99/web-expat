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
                    data: 'qrmember'
                },
                {   
                    data: 'nama'
                },
                {   
                    data: 'email'
                },
                {   
                    data: 'membership'
                },
                {   
                    data: null,
                    "sortable": false, 
                        render: function (data, type, row, meta) {
                        return `<a href="<?= base_url()?>report/summarymember/${encodeURI(btoa(row.id))}" class="btn btn-primary">Details</a>`;
                    }
                },
                
            ],
    });

</script>