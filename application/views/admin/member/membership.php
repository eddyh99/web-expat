<!-- MAIN CONTENT START -->
<div class="container-fluid">
    <!--  Row Daftar User -->
    <div class="row my-4">
        <div class="col-lg-12 d-flex align-items-strech">
            <a href="<?= base_url()?>member/add_membership" class="btn btn-expat d-flex align-items-center">
                <i class="ti ti-plus fs-5 me-2"></i>
                <span>
                    Add Membership
                </span>
            </a>
        </div>
    </div>
    <!--  Row List User-->
    <div class="row">
        <div class="col-lg-12 d-flex align-items-strech">
            <div class="card border-expat w-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title fw-semibold mb-4">List Membership</h5>
                    </div>
                    <table id="table_list_promotion" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th class="th-desc">Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    1
                                </td>
                                <td>
                                    BRONZE MEMBER
                                </td>
                                <td>
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam officia reiciendis ratione voluptatibus. Est itaque tempora vitae illo provident inventore excepturi, et voluptates esse animi sunt deleniti quos assumenda perferendis ipsum, sit dolorum nam dignissimos architecto quidem, optio ipsa harum. Perferendis, pariatur? Alias voluptatum magni hic delectus fugiat vero placeat beatae dignissimos iste nam corporis earum possimus magnam numquam porro quibusdam architecto maxime quidem, natus laborum consectetur labore. Quod adipisci, repellendus, iusto sequi accusamus ex voluptatibus, a temporibus aliquam hic eos? Ipsa alias laboriosam incidunt totam ea. Laudantium exercitationem ratione aspernatur, soluta voluptatum officiis voluptas nisi ullam cupiditate voluptate beatae cum dicta eos iusto quod nulla velit repudiandae ipsum dolores impedit, blanditiis doloribus, ab praesentium. Eum exercitationem explicabo adipisci laudantium cumque. Minus consectetur, enim quia animi maxime culpa accusantium omnis, doloremque quibusdam ex unde? Tenetur corporis nam tempore laudantium pariatur, rem repellat laboriosam fuga veniam possimus eos. Error sequi qui, atque explicabo quod facilis veniam optio ex, asperiores nostrum labore beatae reiciendis quibusdam recusandae impedit. Dicta blanditiis aliquam esse aliquid, facilis modi doloremque repellat saepe illo eius reiciendis quos alias animi a quis recusandae consequuntur beatae natus quam vel ex, eaque ipsam neque cupiditate! Minima aut similique impedit aliquid! Tempora.
                                </td>
                                <td>
                                    <button class="btn btn-info"><i class="ti ti-info-circle"></i></button>
                                    <button class="btn btn-success"><i class="ti ti-pencil-minus"></i></button>
                                    <button class="btn btn-danger"><i class="ti ti-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    2
                                </td>
                                <td>
                                    SILVER MEMBER
                                </td>
                                <td>
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam officia reiciendis ratione voluptatibus. Est itaque tempora vitae illo provident inventore excepturi, et voluptates esse animi sunt deleniti quos assumenda perferendis ipsum, sit dolorum nam dignissimos architecto quidem, optio ipsa harum. Perferendis, pariatur? Alias voluptatum magni hic delectus fugiat vero placeat beatae dignissimos iste nam corporis earum possimus magnam numquam porro quibusdam architecto maxime quidem, natus laborum consectetur labore. Quod adipisci, repellendus, iusto sequi accusamus ex voluptatibus, a temporibus aliquam hic eos? Ipsa alias laboriosam incidunt totam ea. Laudantium exercitationem ratione aspernatur, soluta voluptatum officiis voluptas nisi ullam cupiditate voluptate beatae cum dicta eos iusto quod nulla velit repudiandae ipsum dolores impedit, blanditiis doloribus, ab praesentium. Eum exercitationem explicabo adipisci laudantium cumque. Minus consectetur, enim quia animi maxime culpa accusantium omnis, doloremque quibusdam ex unde? Tenetur corporis nam tempore laudantium pariatur, rem repellat laboriosam fuga veniam possimus eos. Error sequi qui, atque explicabo quod facilis veniam optio ex, asperiores nostrum labore beatae reiciendis quibusdam recusandae impedit. Dicta blanditiis aliquam esse aliquid, facilis modi doloremque repellat saepe illo eius reiciendis quos alias animi a quis recusandae consequuntur beatae natus quam vel ex, eaque ipsam neque cupiditate! Minima aut similique impedit aliquid! Tempora.
                                </td>
                                <td>
                                    <button class="btn btn-info"><i class="ti ti-info-circle"></i></button>
                                    <button class="btn btn-success"><i class="ti ti-pencil-minus"></i></button>
                                    <button class="btn btn-danger"><i class="ti ti-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- MAIN CONTENT END -->

<!-- SWEET ALERT START -->
<?php if(isset($_SESSION["success"])) { ?>
    <script>
        setTimeout(function() {
            Swal.fire({
                html: '<?= $_SESSION['success'] ?>',
                position: 'top',
                timer: 3000,
                showCloseButton: true,
                showConfirmButton: false,
                icon: 'success',
                timer: 2000,
                timerProgressBar: true,
            });
        }, 100);
    </script>
<?php } ?>
<!-- SWEET ALERT END -->


