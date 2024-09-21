<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Main row -->
            <div class="row">
                <div class="row table-responsive align-items-center">
                    <table class="table table-striped" id="products-table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <!-- <th scope="col">ID</th> -->
                                <th scope="col">Image</th>
                                <th scope="col">Categories</th>
                                <th scope="col">Name</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Сurrent price</th>
                                <th scope="col">Discount</th>
                                <th scope="col">Discounted price</th>
                                <th scope="col">Hot</th>
                                <th scope="col">Edit product</th>
                                <th scope="col">Delete product</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($data->products as $value) : ?>
                                <tr data-id="<?= $value->id; ?>">
                                    <th scope="row">
                                        <?= $i++; ?>
                                    </th>
                                    <td>
                                        <?= $feature->url_name ?>
                                        <img src="<?= WWW ?>/img/product/<?= $value->image; ?>" class="img-fluid rounded-start">
                                    </td>
                                    <td>
                                        <?= $value->category_name; ?>
                                    </td>
                                    <td class="name_product">
                                        <?= $value->name; ?>
                                    </td>
                                    <td>
                                        <?= $value->count; ?>
                                    </td>
                                    <td>
                                        $<?= $value->price; ?>
                                    </td>
                                    <td>
                                        <?= $value->discount; ?>
                                    </td>
                                    <td class="discounted-Price">
                                        <? if ($value->discount > 0) : ?>
                                            <?= round($value->price - ($value->price / 100 * $value->discount), 2); ?>
                                        <? else : ?>
                                            <?= $value->price; ?>
                                        <? endif; ?>
                                    </td>
                                    <td>
                                        <?= $value->hot; ?>
                                    </td>
                                    <td>
                                        <i class="fa-solid fa-pen-to-square" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> Изменить</i>
                                    </td>
                                    <td>
                                        <i class="fa-solid fa-trash delete-btn"> Удалить</i>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.row (main row) -->
        </div>
    </section>
    <!-- /.content -->
</div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

        </div>
    </div>
</div>

<!-- Modal add product -->
<div class="modal fade" id="addProductModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="row g-0 modul-box">
                <div class="col-md-4 img-box">
                    <img src="/public/img/no-image.png" class="img-fluid rounded-start" style="width:100%; height:100%;">
                </div>
                <form class="col-md-8" data-id="${
                            JSON.parse(body).productId
                        }" enctype="multipart/form-data">
                    <div class="card-body ">
                        <div class="modal-body">
                            <div class="row g-2 pb-1">
                                <div class="form-floating">
                                    <input type="text" class="form-control form-control-sm" id="floatingInputGrid" name="name" placeholder="Name product" value="">
                                    <label for="floatingInputGrid">Name product</label>
                                </div>
                            </div>
                            <div class="row g-2 pb-1">
                                <div class="form-floating">
                                    <input type="number" min="0" onkeydown="return event.key !== '-'" class="form-control form-control-sm input-price" name="price" placeholder="Price" value="">
                                    <label for="floatingInputGrid">Price</label>
                                </div>
                            </div>
                            <div class="row g-2 pb-1">
                                <div class="form-floating">
                                    <input type="text" class="form-control form-control-sm input-discount" name="discount" placeholder="Discount" value="">
                                    <label for="floatingInputGrid">Discount</label>
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="form-floating">
                                    <input type="number" min="0" onkeydown="return event.key !== '-'" class="form-control form-control-sm" name="count" placeholder="Count" value="">
                                    <label for="floatingInputGrid">Count</label>
                                </div>
                            </div>

                            <div class="row g-2 add-file-img mt-1">
                                <div class="mb-3">
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="1" placeholder="Describe the product" name="textarea"></textarea>
                                </div>
                            </div>
                            <div class="row g-2 add-file-img">
                                <div class="mb-3">
                                    <label for="floatingInputGrid">New image</label>
                                    <input class="form-control form-add-img" type="file" id="formFile" accept="image/png, image/jpeg">
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="form-floating">
                                    <select class="form-select" id="floatingSelectGrid" name="category" aria-label="Floating label select example">
                                        <?php foreach ($data->categories as $value) : ?>
                                            <option value="<?= $value->id; ?>"><?= $value->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label for="floatingSelectGrid">Categories</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary btn-add-new-product">Change</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>