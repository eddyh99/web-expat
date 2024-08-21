<!-- MAIN CONTENT START -->
<div class="container-fluid">
    <div class="row my-4">
        <div class="col-lg-12 d-flex align-items-strech">
            <a href="<?= base_url()?>produk" class="btn btn-outline-expat d-flex align-items-center">
                <i class="ti ti-chevron-left fs-5 me-1"></i>
                <span>
                    Back
                </span>
            </a>
        </div>
    </div>
    <!--  Row Daftar User Agent -->
    <div class="row">
        <div class="col-lg-12 d-flex align-items-strech">
            <div class="card border-expat w-100">
                <div class="card-body">
                    <?php if (@isset($_SESSION["error"])) { ?>
                        <div class="col-12 alert alert-danger alert-dismissible fade show" role="alert">
                            <span class="notif-login f-poppins"><?= $_SESSION["error"] ?></span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } ?>
                    <h5 class="card-title fw-semibold mb-4">Add Product</h5>
                    <form action="<?= base_url()?>produk/editproduk_process/<?= $id_product?>" enctype='multipart/form-data' method="POST">
                        <input type="hidden" id="token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="mb-3 ">
                                    <label for="name" class="form-label">Name Product</label>
                                    <input type="text" class="form-control" id="name" value="<?= $product->nama?>" name="name" placeholder="Enter produk name..." required maxlength="255" autocomplete="off" maxlength="55">
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description"  rows="3" class="form-control" placeholder="Enter description..."><?= $product->deskripsi?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="kategori" class="form-label">Kategori</label>
                                    <select name="kategori" id="kategori" class="form-select">
                                        <option value="food" <?= ($product->kategori=="food")?"selected":"" ?>>Food</option>
                                        <option value="drink" <?= ($product->kategori=="drink")?"selected":"" ?>>Drink</option>
                                        <option value="retail" <?= ($product->kategori=="retail")?"selected":"" ?>>Retail</option>
                                    </select>
                                </div>
                                <div class="mb-4 col-12">
                                    <label for="subkategori" class="form-label">Sub Category</label>
                                    <select name="subkategori" id="subkategori" class="form-control">
                                        <?php foreach($subkategori as $dt){?>
                                            <option <?= ($product->subkategori==$dt->subkategori)?"selected":""?> value="<?= $dt->subkategori?>"><?= $dt->subkategori?></option>
                                        <?php }?>
                                    </select>
                                </div>                                
                                <div class="mb-4">
                                    <label for="sku" class="form-label">SKU</label>
                                    <input type="text" class="form-control" value="<?= $product->sku?>" id="sku" name="sku" maxlength="30" placeholder="Enter SKU..." required autocomplete="off">
                                </div>
                                <div class="mb-4">
                                    <label for="price" class="form-label">Base Price</label>
                                    <input type="text" class="money-input form-control" value="<?= $product->price?>" id="price" name="price" maxlength="100" placeholder="Enter price..." required autocomplete="off">
                                </div>
                                <div class="mb-3">   
                                    <label for="images-logo" class="form-label">Image</label>   
                                    <div class="d-flex flex-column">
                                        <div class="col-12 col-sm-8 col-lg-6 input-outlet-image">
                                            <input name="imgproduk" type="file" id="images-logo" accept="image/jpg, image/jpeg, image/png" style="cursor: pointer;">
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-12 d-flex flex-column flex-sm-row">
                                                <img id="image-container" class="preview-image-container" />
                                                <span class="p-4 fw-bolder">
                                                    <p class="text-findme text-start">*Maximum 2MB</p>
                                                    <p class="text-findme text-start">*png, jpg</p>
                                                </span>
                                                <div class="d-flex flex-row flex-sm-column">
                                                    <span class="d-block">previous image</span>
                                                    <img  class="preview-image-container d-block" src="<?= @$product->picture?>"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-12 col-lg-6">
                                <div class="rounded-2 p-4 mb-4" style="border: 2px dashed #72A28A;">
                                    <div class="mb-4 col-12">
                                        <label for="additional" class="form-label">Additional</label>
                                        <select name="additional[]" multiple="multiple" id="additional" class="form-control additional_select2">
                                            <?php foreach($groupadd as $ga){?>
                                                <optgroup label="<?= $ga->additional_group?>">
                                                    <?php 
                                                    foreach($additional as $ad){
                                                        if($ga->additional_group == $ad->additional_group){
                                                    ?>
                                                        <option value="<?= $ad->id?>" <?php echo (@in_array($ad->id, $additional_edit)) ? 'selected': ''?> >
                                                            <?= $ad->additional?>
                                                        </option>
                                                    <?php 
                                                        }
                                                    }
                                                    ?>
                                                </optgroup>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <div class="mb-4 col-12">
                                        <label for="optional" class="form-label">Optional</label>
                                        <select name="optional[]" multiple="multiple" id="optional" class="form-control optional_select2">
                                            <?php foreach($groupopt as $gop){?>
                                                <optgroup label="<?= $gop->optiongroup?>">
                                                    <?php 
                                                    foreach($optional as $op){
                                                        if($gop->optiongroup == $op->optiongroup){
                                                    ?>
                                                        <option value="<?= $op->id?>" <?php echo (@in_array($op->id, $optional_edit)) ? 'selected': ''?> > 
                                                            <?= $op->optional?>
                                                        </option>
                                                    <?php 
                                                            
                                                        }
                                                    }
                                                    ?>
                                                </optgroup>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <div class="mb-4 col-12">
                                        <label for="satuan" class="form-label">Satuan</label>
                                        <select name="satuan[]" multiple="multiple"  id="satuan" class="form-control satuan_select2">
                                            <?php foreach($groupst as $gst){?>
                                                <optgroup label="<?= $gst->groupname?>">
                                                    <?php 
                                                    foreach($satuan as $st){
                                                        if($gst->groupname == $st->groupname){
                                                    ?>
                                                        <option value="<?= $st->id?>" <?php echo (@in_array($st->id, $satuan_edit)) ? 'selected': ''?> >
                                                            <?= $st->satuan?>
                                                        </option>
                                                    <?php 
                                                        }
                                                    }
                                                    ?>
                                                </optgroup>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="favorite" class="form-label">Favorite</label>
                                    <select name="favorite" id="favorite" class="form-select">
                                        <option value="yes" <?= ($product->favorite=="yes")?"selected":"" ?> > 
                                            Yes
                                        </option>
                                        <option value="no" <?= ($product->favorite=="no")?"selected":"" ?> >
                                            No
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-4 col-12">
                                    <label for="cabang" class="form-label">Select Outlet</label>
                                    <select name="cabang[]" multiple="multiple" id="cabang" class="form-control cabang_select2">
                                        <?php foreach($cabang as $cb){?>
                                            <option value="<?= $cb->id?>" <?php echo (in_array($cb->id, $cabang_edit)) ? 'selected': ''?>>
                                                <?= $cb->nama?>
                                            </option>
                                        <?php }?>
                                    </select>
                                    <input type="checkbox" id="selectall">
                                    <label for="selectall">
                                        Select All
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-expat mt-3">Update Product</button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>

</div>
<!-- MAIN CONTENT END -->

