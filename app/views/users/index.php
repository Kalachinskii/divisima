<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Main row -->
            <div class="row">
                <div class="row table-responsive ">
                    <ol class="list-group list-group-numbered">
                        <?php foreach ($data->users as $value) : ?>
                            <li class="mb-1 mt-1 list-group-item d-flex justify-content-between align-items-start" data-id="<?=$value->id; ?>">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold"><?=$value->login; ?></div>
                                </div>
                                <button type="button" class="btn-cart btn btn-primary mr-3" data-bs-toggle="collapse" href="#collapseExample1" role="button" aria-expanded="false" aria-controls="collapseExample">
                                    <i class="fa-solid fa-basket-shopping">
                                        Корзина
                                    </i>
                                    <span class="badge bg-secondary">4</span>
                                </button>
                                <button type="button" class="btn btn-danger">
                                    <i class="fa-solid fa-trash"> Удалить</i>
                                </button>
                            </li>
                        <?php endforeach; ?>
                        <ul class="mt-1 mb-1 list-group collapse" id="collapseExample1">
                            <li class="list-group-item">
                                <b>Name: </b>A second item &ensp;
                                <b>Categories: </b> lingerie &ensp;
                                <b>Price: </b> 45.00$ &ensp;
                                <b>Quantity: </b> 1 &ensp;
                            </li>
                            <li class="list-group-item">
                                <b>Name: </b>A second item &ensp;
                                <b>Categories: </b> lingerie &ensp;
                                <b>Price: </b> 45.00$ &ensp;
                                <b>Quantity: </b> 1 &ensp;
                            </li>
                        </ul>
                        <!-- <ul class="mt-1 mb-1 list-group collapse" id="collapseExample2">
                            <li class="list-group-item">A second item</li>
                            <li class="list-group-item">A third item</li>
                            <li class="list-group-item">A fourth item</li>
                            <li class="list-group-item">And a fifth one</li>
                        </ul> -->
                    </ol>
                </div>
            </div>
            <!-- /.row (main row) -->
        </div>
    </section>
    <!-- /.content -->
</div>