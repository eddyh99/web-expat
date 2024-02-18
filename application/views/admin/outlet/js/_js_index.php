<style>
    .th-outlet-address {
        width: 300px;
    }

</style>

<script>

    var table_outlet = $('#table_list_outlet').DataTable({
		"scrollX": true,
		"ajax": {
			"url": "<?=base_url()?>outlet/list_alloutlet",
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
			{ data: 'alamat' },
			{ data: 'opening' },
			{ data: 'kontak' },
			{ 
                data: null, "mRender": function(data, type, full, meta) {
					var btnImage = `
					<div class="dropdown my-1">
						<button class="btn btn-secondary" type="button" data-bs-toggle="modal" data-bs-target="#addinfo${full.id}">
							<i class="ti ti-info-circle"></i>
						</button> 
						<div class="modal fade" id="addinfo${full.id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
								<div class="modal-header">
									<h1 class="modal-title fs-5" id="exampleModalLabel">Preview Image</h1>
									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								</div>
								<div class="modal-body">
									<div class="d-flex justify-content-center">
										<img class="img-fluid" src="${full.picture}" alt="${full.nama}"/>
									</div>
									
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
								</div>
								</div>
							</div>
						</div>
					</div>`;
                    var btnEdit ='<a href="<?=base_url()?>outlet/edit_outlet/'+encodeURI(btoa(full.id))+'" class="btn btn-success mx-1 my-1"><i class="ti ti-pencil-minus fs-4"></i></a>'
					var btnDelete = '<a href="<?=base_url()?>outlet/delete/'+encodeURI(btoa(full.id))+'" class="del-data btn btn-danger my-1"><i class="ti ti-trash"></i></a>';
					
					return `<div class="d-flex">${btnImage} ${btnEdit} ${btnDelete} </div>`;     
                
                        
                } 
            },
		],
	});


    $(document).ready(function(){		
        $("#images-logo").on("change",function(){	
          const $input = $(this);
          const reader = new FileReader();
          reader.onload = function(){
            $("#image-container").attr("src", reader.result);
            // var tempImg = [reader.result]
            // console.log(tempImg);
            // tempImg.forEach(b64toblob);
          }
          reader.readAsDataURL($input[0].files[0]);
        });
    });


</script>