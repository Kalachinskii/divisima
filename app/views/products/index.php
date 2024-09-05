<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Main row -->
            <div class="row">
                <div class="row table-responsive align-items-center">
                    <table class="table table-striped ">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">ID</th>
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
                            <tr>
                                <th scope="row">
                                    1
                                </th>
                                <td>
                                    19
                                </td>
                                <td>
                                    <img src="/public/img/product/1.jpg" class="img-fluid rounded-start">
                                </td>
                                <td>
                                    lingerie
                                </td>
                                <td>
                                    Flambouold Pink Top
                                </td>
                                <td>
                                    500 штук
                                </td>
                                <td>
                                    $53,00
                                </td>
                                <td>
                                    10%
                                </td>
                                <td>
                                    $42.40
                                </td>
                                <td>
                                    1
                                </td>
                                <td>
                                    <i class="fa-solid fa-pen-to-square" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> Изменить</i>
                                </td>
                                <td>
                                    <i class="fa-solid fa-trash" data-bs-toggle="modal" data-bs-target="#delModal"> Удалить</i>
                                </td>
                            </tr>
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
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="/public/img/product/1.jpg" class="img-fluid rounded-start" style="width:100%; height:100%;">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <!-- Форма -->
                        <div class="modal-body">
                            <!-- Name -->
                            <div class="row g-2 pb-1">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="floatingInputGrid" placeholder="Name product" value="Flambouold Pink Top">
                                    <label for="floatingInputGrid">Name product</label>
                                </div>
                            </div>
                            <!-- Price -->
                            <div class="row g-2 pb-1">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="floatingInputGrid" placeholder="Price" value="53,00">
                                    <label for="floatingInputGrid">Price</label>
                                </div>
                            </div>
                            <!-- Discount -->
                            <div class="row g-2 pb-1">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="floatingInputGrid" placeholder="Discount" value="10">
                                    <label for="floatingInputGrid">Discount</label>
                                </div>
                            </div>
                            <!-- Сurrent price -->
                            <div class="row g-2 pb-1">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="floatingInputGrid" placeholder="Сurrent price" value="42.40">
                                    <label for="floatingInputGrid">Сurrent price</label>
                                </div>
                            </div>
                            <!-- Quantity -->
                            <div class="row g-2">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="floatingInputGrid" placeholder="Quantity" value="100">
                                    <label for="floatingInputGrid">Quantity</label>
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">New image</label>
                                    <input class="form-control" type="file" id="formFile">
                                </div>
                            </div>
                            <!-- Categories -->
                            <div class="row g-2">
                                <div class="form-floating">
                                    <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                                        <option selected>Categories</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                    <label for="floatingSelectGrid">Categories</label>
                                </div>
                            </div>
                            <!-- Кнопки -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Change</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal del-->
<div class="modal fade" id="delModal" tabindex="-1" aria-labelledby="delModalLabel" aria-hidden="true">
    <div class="modal-dialog text-darck bg-warning mb-3 modal-del">
        <div class="modal-footer">
            <h1 class="text-center">
                Are you sure you want to delete this product?
            </h1>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Delete</button>
        </div>
    </div>
</div>
