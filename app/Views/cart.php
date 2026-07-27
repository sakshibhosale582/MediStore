<?= $this->include('layouts/header') ?>
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h3 class="fw-semibold mb-3">Your Cart</h3>
                <?php if (empty($summary['items'])): ?>
                    <p class="text-muted">Your cart is empty.</p>
                    <a class="btn btn-success" href="<?= site_url('shop') ?>">Continue shopping</a>
                <?php else: ?>
                    <div class="list-group">
                        <?php foreach ($summary['items'] as $item): ?>
                            <div class="list-group-item">
                                <div class="row align-items-center">
                                    <div class="col-md-7">
                                        <h6 class="fw-semibold mb-1"><?= esc($item['name']) ?></h6>
                                        <p class="small text-muted mb-0"><?= format_price($item['price']) ?> each</p>
                                    </div>
                                    <div class="col-md-2">
                                        <form method="post" action="<?= site_url('cart/update/' . (int) $item['medicine_id']) ?>">
                                            <?= csrf_field() ?>
                                            <input type="number" class="form-control" name="quantity" min="1" value="<?= (int) $item['quantity'] ?>">
                                        </form>
                                    </div>
                                    <div class="col-md-2 text-end fw-semibold">
                                        <?= format_price((float) $item['price'] * (int) $item['quantity']) ?>
                                    </div>
                                    <div class="col-md-1 text-end">
                                        <a class="btn btn-sm btn-outline-danger" href="<?= site_url('cart/remove/' . (int) $item['medicine_id']) ?>">Remove</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="fw-semibold mb-3">Order Summary</h5>
                <div class="d-flex justify-content-between mb-2"><span>Subtotal</span><span><?= format_price($summary['subtotal']) ?></span></div>
                <div class="d-flex justify-content-between mb-2"><span>Discount</span><span>-<?= format_price($summary['discount']) ?></span></div>
                <div class="d-flex justify-content-between mb-2"><span>Tax</span><span><?= format_price($summary['tax']) ?></span></div>
                <div class="d-flex justify-content-between mb-3"><span>Delivery</span><span><?= format_price($summary['delivery_charge']) ?></span></div>
                <div class="d-flex justify-content-between fw-bold fs-5"><span>Total</span><span><?= format_price($summary['grand_total']) ?></span></div>
                <form method="post" action="<?= site_url('cart/apply-coupon') ?>" class="mt-3">
                    <?= csrf_field() ?>
                    <input type="text" class="form-control mb-2" name="coupon_code" placeholder="Coupon code">
                    <button class="btn btn-outline-success w-100">Apply coupon</button>
                </form>
                <a class="btn btn-success w-100 mt-3" href="<?= site_url('checkout') ?>">Proceed to checkout</a>
            </div>
        </div>
    </div>
</div>
<?= $this->include('layouts/footer') ?>
