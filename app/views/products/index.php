<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Main row -->
            <div class="row">
                <div class="row table-responsive align-items-center">
                    <table class="table table-striped">
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
                                    <td>
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