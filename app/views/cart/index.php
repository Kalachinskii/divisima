<!-- Page info -->
	<div class="page-top-info">
		<div class="container">
			<h4>Your cart</h4>
			<div class="site-pagination">
				<a href="/">Home</a> /
				<span>Your cart</span>
			</div>
		</div>
	</div>
	<!-- Page info end -->


	<!-- cart section end -->
	<section class="cart-section spad">
		<div class="container">
			<div class="row">
				<div class="col-lg-8">
					<div class="cart-table">
						<h3>Your Cart</h3>
						<div class="cart-table-warp">
							<table class="cart-products-add-del">
							<thead>
								<tr>
									<th class="product-th">Product</th>
									<th class="quy-th">Quantity</th>
									<!-- <th class="size-th">SizeSize</th> -->
									<th class="total-th">Price</th>
								</tr>
							</thead>
							<tbody>
								<!-- <?php  debug($data); ?> -->
							<?php if (empty($data->cart)) : ?>
							<h2> ТОВАРЫ НЕ ДОБАВЛЕНЫ </h2>
							<?php else : ?>
							<?php foreach ($data->cart as $product) : ?>
						
								<? $total += $product->qty * $product->price ?>
								<tr data-id="<?= $product->id ?>">
									<td class="product-col">
									<img src="<?= WWW ?>/img/product/<?= $product->image ?>" alt="product">
										<div class="pc-title">
											<h4><?= $product->name ?></h4>
											<p>$<span><?= $product->price ?></span></p>
										</div>
									</td>
									<td class="quy-col">
										<div class="quantity">
					                        <div class="pro-qty">
												<input type="number" class="qty_product" value="<?= $product->qty ?>">
											</div>
                    					</div>
									</td>
									<!-- <td class="size-col"><h4>Size M</h4></td> -->
									<td class="total-col"><h4>
										$<span id="total-product"><?= $product->qty * $product->price ?></span>
									</h4></td>
								</tr>
								<? endforeach; ?>
								<? endif; ?>
							</tbody>
						</table>
						</div>
						<div class="total-cost">
							<h6>Total <span>$ </span><span class="ml-0" id="total-cost"><?= $total ?></span></h6>
						</div>
					</div>
				</div>
				<div class="col-lg-4 card-right">
					<!-- <form class="promo-code-form">
						<input type="text" placeholder="Enter promo code">
						<button>Submit</button>
					</form> -->
					<a href="" class="site-btn">Proceed to checkout</a>
					<a href="/" class="site-btn sb-dark">Continue shopping</a>
				</div>
			</div>
		</div>
	</section>
	<!-- cart section end -->
