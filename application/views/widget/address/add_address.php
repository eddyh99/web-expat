

<div class="app-content px-2 row  mb-5 pb-5">
    <div class="app-member mx-auto col-12 col-lg-8 my-5 border-1 border-white">
        <?php if (@isset($_SESSION["error"])) { ?>
            <div class="col-12 alert alert-danger alert-dismissible fade show" role="alert">
                <span class="notif-login f-poppins"><?= $_SESSION["error"] ?></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php } ?>
        <h4>Add Address</h4>
        <form id="detailorder" action="<?= base_url()?>widget/order/addaddress_process/<?= $token?>" method="POST">
            <input type="hidden" id="idaddress" name="idaddress" value="<?= @$address->id?>">
            <input type="hidden" id="idcabang" name="idcabang" value="<?= $_GET['idcabang']?>">
            <div class="my-4 d-flex flex-column align-items-start justify-content-start">
                <label for="nameaddress">Select Location</label>
                <input type="text" id="pac-input" class="form-control " placeholder="Search Box"/>
                <div id="map"></div>
            </div>
            <div class="my-3">
                <label for="nameaddress" id="preview-pac-input">
                    <span>
                        <i class="fas fa-map-marker-alt me-2"></i>Gang Gunung Arjuna, Werdi Bhuwana
                    </span>
                </label>
            </div>
            <div class="my-4">
                <label for="nameaddress">Name Location</label>
                <input type="text" id="nameaddress" name="nameaddress" class="form-control" value="<?= @$address->title?>">
            </div>
            <div class="my-4">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" class="form-control" value="<?= @$address->alamat?>">
            </div>
            <div class="my-4">
                <label for="phone">Phone</label>
                <input type="text" id="phone" name="phone" class="form-control" value="<?= @$address->phone?>">
            </div>
            <div class="my-4">
                <button type="submit" class="btn btn-expat">Update Address</button>
            </div>
        </form>
    </div>
</div>
