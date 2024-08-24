<!-- Hero section -->
<section class="hero-section">
  <div class="hero-slider owl-carousel">
    <? foreach ($data->banners as $banner): ?>
      <div class="hs-item set-bg" data-setbg="<?= WWW ?>/img/<?= $banner->url_name ?>">
        <div class="container">
          <div class="row">
            <div class="col-xl-6 col-lg-7 text-white">
              <span><?= $banner->texts->label ?></span>
              <h2><?= $banner->texts->title ?></h2>
              <p><?= $banner->texts->desc ?></p>
              <a href="#" class="site-btn sb-line">DISCOVER</a>
              <a href="#" class="site-btn sb-white">ADD TO CART</a>
            </div>
          </div>
          <div class="offer-card text-white">
            <span>from</span>
            <h2>$29</h2>
            <p>SHOP NOW</p>
          </div>
        </div>
      </div>
    <? endforeach; ?>
  </div>
  <div class="container">
    <div class="slide-num-holder" id="snh-1"></div>
  </div>
</section>
<!-- Hero section end -->



<!-- Features section -->
<section class="features-section">
  <div class="container-fluid">
    <div class="row">
      <? foreach ($data->features as $feature): ?>
        <div class="col-md-4 p-0 feature">
          <div class="feature-inner">
            <div class="feature-icon">
              <img src="<?= WWW ?>/img/icons/<?= $feature->url_name ?>" alt="feature">
            </div>
            <h2><?= $feature->texts->title ?></h2>
          </div>
        </div>
      <? endforeach; ?>
    </div>
  </div>
</section>
<!-- Features section end -->

<!-- letest product section -->
<section class="top-letest-product-section">
  <div class="container">
    <div class="section-title">
      <h2>POPULAR PRODUCTS</h2>
    </div>
    <div class="product-slider owl-carousel">
      <? foreach ($data->hot_products as $product): ?>
        <div class="product-item" data-id="<?= $product->id ?>" data-category="<?= $product->category_id ?>">
          <div class="pi-pic">
            <? if ($product->discount > 0): ?>
              <div class="tag-sale">ON SALE</div>
            <? endif; ?>
            <img src="<?= WWW ?>/img/product/<?= $product->image ?>" alt="product">
            <div class="pi-links">
              <a href="#" class="add-card"><i class="flaticon-bag"></i><span>ADD TO CART</span></a>
              <a href="#" class="wishlist-btn">
                <!-- ИЗБРАННОЕ/НЕ -->
                <? if (isset($data->favourites) AND !empty($data->favourites) AND in_array($product->id, $data->favourites)) : ?>
                  <i class="flaticon-heart favourite"></i>
                <? else: ?>
                  <i class="flaticon-heart"></i>
                <?php endif; ?>
              </a>
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
      <? endforeach; ?>

    </div>
  </div>
</section>
<!-- letest product section end -->



<!-- Product filter section -->
<section class="product-filter-section">
  <div class="container">
    <div class="section-title">
      <h2>BROWSE ALL PRODUCTS</h2>
    </div>
    <ul class="product-filter-menu">
      <li><a href="" data-id="0" class="active">ALL</a></li>
      <? foreach ($data->categories as $categorie): ?>
        <li><a href="" data-id="<?= $categorie->id ?>"><?= $categorie->name ?></a></li>
      <? endforeach; ?>
    </ul>
    <div class="row products">
      <? foreach ($data->products as $product): ?>
        <div class="col-lg-3 col-sm-6 product-wrapper">
          <div class="product-item" data-id="<?= $product->id ?>" data-category="<?= $product->category_id ?>">
            <div class="pi-pic">
              <? if ($product->discount > 0): ?>
                <div class="tag-sale">ON SALE</div>
              <? endif; ?>
              <img src="<?= WWW ?>/img/product/<?= $product->image ?>" alt="product">
              <div class="pi-links">
                <a href="#" class="add-card"><i class="flaticon-bag"></i><span>ADD TO CART</span></a>
                <a href="#" class="wishlist-btn">
                  <!-- ИЗБРАННОЕ/НЕ -->
                  <? if (isset($data->favourites) AND !empty($data->favourites) AND in_array($product->id, $data->favourites)) : ?>
                    <i class="flaticon-heart favourite"></i>
                  <? else: ?>
                    <i class="flaticon-heart"></i>
                  <?php endif; ?>
                </a>
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
    </div>
    <div class="text-center pt-5 load-more-wrapper">
      <button class="site-btn sb-line sb-dark load-more">LOAD MORE</button>
    </div>
  </div>
</section>
<!-- Product filter section end -->

<!-- РАЗОБРАТЬСЯ -->
<div class="modal fade" id="favouritesErrorModal" tabindex="-1" aria-labelledby="favouritesErrorModalLabel"
  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title fs-5" id="favouritesErrorModalLabel">
                  Authorization
        </h3>
      </div>
      <div class="modal-body">
        Чтобы добавить в избранное необходимо авторизоваться
      </div>
      <div class="modal-footer justify-content-start">
                  <a href="/signin" type="button" class="btn btn-primary">Login</a>
                  <a href="/signup" type="button" class="btn btn-outline-primary">Registr</a>
      </div>
    </div>
  </div>
</div>