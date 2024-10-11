<!-- DATE PICKER -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<script>

    var table_promotion = $('#table_list_promotion').DataTable({
		"scrollX": true,
		"ajax": {
			"url": "<?=base_url()?>promotion/list_allpromotion",
			"type": "POST",
            "data": function(d) {
                d.status = $("#promotion_type").val()
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
			{ data: 'deskripsi' },
			{ data: 'tipe' },
			{ 
                data: null, "mRender": function(data, type, full, meta) {
                    return full.tanggal.split("-").reverse().join("-");
                } 
            },
			{ 
                data: null, "mRender": function(data, type, full, meta) {
                    return full.end_date.split("-").reverse().join("-");
                } 
             },
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
                    var btnEdit ='<a href="<?=base_url()?>promotion/edit_promotion/'+encodeURI(btoa(full.id))+'" class="btn btn-success mx-1 my-1"><i class="ti ti-pencil-minus fs-4"></i></a>'
					var btnDelete = '<a href="<?=base_url()?>promotion/delete/'+encodeURI(btoa(full.id))+'" class="del-data btn btn-danger my-1"><i class="ti ti-trash"></i></a>';
					return `<div class="d-flex">${btnImage} ${btnEdit} ${btnDelete} </div>`;     
                
                        
                } 
            },
		],
	});


    $('#promotion_type').on('change', function(){
        table_promotion.ajax.reload();
    })

    $(document).ready(function(){		
        $("#images-logo").on("change",function(){	
			const $input = $(this);
			const file = $input[0].files[0];
            
            // Check if file size is greater than 2MB 
            if (file.size > 2 * 1024 * 1024) {
                Swal.fire({
                    html: 'File size maximum 2MB',
                    position: 'top',
                    timer: 3000,
                    showCloseButton: true,
                    showConfirmButton: false,
                    icon: 'error',
                    timer: 2000,
                    timerProgressBar: true,
                });
                $input.val(''); 
                return;
            }

			const reader = new FileReader();
			reader.onload = function(){
				$("#image-container").attr("src", reader.result);
			}
			reader.readAsDataURL($input[0].files[0]);
        });

        
        $( "#start_date" ).datepicker({
            dateFormat: 'yy-mm-dd',
            changeYear: true,
            changeMonth: true,
            minDate: 0,
            yearRange: "-100:+20",
        });

        $( "#end_date" ).datepicker({
            dateFormat: 'yy-mm-dd',
            changeYear: true,
            changeMonth: true,
            minDate: 0,
            yearRange: "-100:+20",
        });
    });



</script>