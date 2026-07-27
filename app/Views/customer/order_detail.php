<?= $this->include('layouts/header') ?>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h4 class="fw-semibold mb-1">Order <?= esc($order['order_number']) ?></h4>
                <p class="text-muted mb-0">Placed on <?= esc(date('M d, Y H:i', strtotime($order['created_at']))) ?></p>
            </div>
            <a class="btn btn-outline-success" href="<?= site_url('customer/orders') ?>">Back to orders</a>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 bg-light">
                    <div class="card-body">
                        <h5 class="fw-semibold">Items</h5>
                        <div class="list-group mt-3">
                            <?php foreach ($order['items'] as $item): ?>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong><?= esc($item['medicine_name']) ?></strong>
                                        <div class="text-muted small">Qty: <?= (int) $item['quantity'] ?></div>
                                    </div>
                                    <span><?= format_price($item['total']) ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 bg-light">
                    <div class="card-body">
                        <h5 class="fw-semibold">Order summary</h5>
                        <div class="d-flex justify-content-between mt-3"><span>Subtotal</span><span><?= format_price($order['subtotal']) ?></span></div>
                        <div class="d-flex justify-content-between"><span>Tax</span><span><?= format_price($order['tax']) ?></span></div>
                        <div class="d-flex justify-content-between"><span>Delivery</span><span><?= format_price($order['delivery_charge']) ?></span></div>
                        <div class="d-flex justify-content-between"><span>Discount</span><span>-<?= format_price($order['discount']) ?></span></div>
                        <div class="d-flex justify-content-between fw-bold fs-5 mt-2"><span>Total</span><span><?= format_price($order['grand_total']) ?></span></div>
                    </div>
                </div>

                <div class="card border-0 bg-light mt-3">
                    <div class="card-body">
                        <h5 class="fw-semibold">Tracking</h5>
                        <?php foreach ($order['tracking'] as $step): ?>
                            <div class="border-start border-3 ps-3 py-2">
                                <strong><?= esc(ucwords(str_replace('_', ' ', $step['status']))) ?></strong>
                                <div class="small text-muted"><?= esc($step['notes'] ?? '') ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->include('layouts/footer') ?>
