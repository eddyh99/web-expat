<style>
    .th-outlet-desc {
        width: 400px !important;
    }

</style>

<script>

    var table = $('#table_list_produk').DataTable({
		"scrollX": true,
		// "order": [[0, 'desc']],
		"ajax": {
			"url": "<?=base_url()?>produk/list_allproduk",
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
			{ data: 'sku' },
			{ data: 'nama' },
			{ data: 'price', render: $.fn.dataTable.render.number(',', '.', 0) },
			{ data: 'deskripsi' },
			// { data: 'kategori' },
			// { data: 'favorite' },
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
									<h1 class="modal-title fs-5" id="exampleModalLabel">More Information</h1>
									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								</div>
								<div class="modal-body">
									<div class="d-flex justify-content-center">
										<img class="img-fluid" src="${full.picture}" alt="${full.nama}"/>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
								</div>
								</div>
							</div>
						</div>
					</div>`;
                    var btnEdit ='<a href="<?=base_url()?>produk/edit_produk/'+encodeURI(btoa(full.id))+'" class="btn btn-success mx-1 my-1"><i class="ti ti-pencil-minus fs-4"></i></a>'
					var btnDelete = '<a href="<?=base_url()?>produk/delete/'+encodeURI(btoa(full.id))+'" class="del-data btn btn-danger my-1"><i class="ti ti-trash"></i></a>';
					
					return `<div class="d-flex">${btnImage} ${btnEdit} ${btnDelete} </div>`;     
                
                        
                } 
            },
		],
		"columnDefs": [
			{ "width": "25%", "targets": 2 }, 
			{ "width": "40%", "targets": 4 }, 
			
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


	var current = 0;
	var tabs = $(".tab");
	var tabs_pill = $(".tab-pills");

	loadFormData(current);

	function loadFormData(n) {
		$(tabs_pill[n]).addClass("active");
		$(tabs[n]).removeClass("d-none");
		$("#back_button").attr("disabled", n == 0 ? true : false);
		n == tabs.length - 1
			? $("#next_button").text("Save Produk").removeAttr("onclick")
			: $("#next_button")
				.attr("type", "button")
				.text("Next")
				.attr("onclick", "next()");
	}

	function next() {
		$(tabs[current]).addClass("d-none");
		$(tabs_pill[current]).removeClass("active");

		current++;
		loadFormData(current);
	}

	function back() {
		$(tabs[current]).addClass("d-none");
		$(tabs_pill[current]).removeClass("active");

		current--;
		loadFormData(current);
	}



</script>