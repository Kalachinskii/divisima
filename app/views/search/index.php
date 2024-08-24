<!-- Product filter section -->
<section class="product-filter-section mt-5">
  <div class="container">
    <div class="section-title">
      <h2>SEARCHED PRODUCTS</h2>
    </div>
    <div class="row products">
      <? if (empty($data->searched)): ?>
        <h3>По запросу "<?= $data->search ?>" ничего не найдено</h3>
      <? else: ?>
        <? foreach ($data->searched as $product): ?>
          <div class="col-lg-3 col-sm-6 product-wrapper">
            <div class="product-item" data-id="<?= $product->id ?>" data-category="<?= $product->category_id ?>">
              <div class="pi-pic">
                <? if ($product->discount > 0): ?>
                  <div class="tag-sale">ON SALE</div>
                <? endif; ?>
                <img src="<?= WWW ?>/img/product/<?= $product->image ?>" alt="product">
                <div class="pi-links">
                  <a href="#" class="add-card"><i class="flaticon-bag"></i><span>ADD TO CART</span></a>
                  <a href="#" class="wishlist-btn"><i class="flaticon-heart"></i></a>
                </div>
              </div>
              <div class="pi-text">
                <h6>
                  <? if ($product->discount > 0): ?>
                    <s>$<?= str_replace(".", ",", $product->price) ?></s>
                    <br>
                    $<?= number_format(($product->price - ($product->price / 100 * $product->count)), 2, ".", ","); ?>
                  <? else: ?>
                    $<?= str_replace(".", ",", $product->price) ?>
                  <? endif ?>
                </h6>
                <p><?= $product->name ?> </p>
              </div>
            </div>
          </div>
        <? endforeach; ?>
      <? endif; ?>
    </div>
  </div>
</section>
<!-- Product filter section end -->