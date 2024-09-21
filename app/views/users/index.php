<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Main row -->
            <div class="row">
                <div class="row table-responsive ">
                    <ol class="list-group list-group-numbered" id="list-group">
                        <?php foreach ($data->users as $value) : ?>
                            <li class="mb-1 mt-1 list-group-item d-flex justify-content-between align-items-center d-none" data-id="<?= $value->id; ?>">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold" id="user-login-name"><?= $value->login; ?></div>
                                </div>
                                <button type="button" class="btn-cart btn btn-primary mr-3" data-bs-toggle="collapse" href="#collapseExample<?= $value->id; ?>" role="button" aria-expanded="false" aria-controls="collapseExample">
                                    <i class="fa-solid fa-basket-shopping">
                                        Корзина
                                    </i>
                                    <span class="badge bg-secondary"><?= $value->sum_products > 0 ? $value->sum_products : 0; ?></span>
                                </button>
                                <button type="button" class="btn btn-danger btn-del">
                                    <i class="fa-solid fa-trash"> Удалить</i>
                                </button>
                            </li>
                            <table class="table table-striped-columns collapse ulExample<?= $value->id; ?>" id="collapseExample<?= $value->id; ?>">
                            </table>
                            <!-- <ul class="mt-1 mb-1 list-group collapse ulExample<?= $value->id; ?>" id="collapseExample<?= $value->id; ?>"></ul> -->
                        <?php endforeach; ?>
                        <!-- <ul class="mt-1 mb-1 list-group collapse" id="collapseExample1">
                            <li class="list-group-item">
                                <b>Name: </b>A second item &ensp;
                                <b>Categories: </b> lingerie &ensp;
                                <b>Price: </b> 45.00$ &ensp;
                                <b>Quantity: </b> 1 &ensp;
                            </li>
                        </ul> -->
                    </ol>
                </div>
            </div>
            <!-- /.row (main row) -->
        </div>
    </section>
    <!-- /.content -->
</div>