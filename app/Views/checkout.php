<?= $this->include('layouts/header') ?>
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h3 class="fw-semibold mb-3">Checkout</h3>
                <form method="post" action="<?= site_url('checkout/place-order') ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Shipping address</label>
                        <select name="address_id" class="form-select" required>
                            <?php foreach ($addresses as $address): ?>
                                <option value="<?= (int) $address['id'] ?>"><?= esc($address['label'] . ' - ' . $address['address_line']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Payment method</label>
                        <select name="payment_method" class="form-select">
                            <option value="cod">Cash on delivery</option>
                            <option value="online">Online payment</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control"></textarea>
                    </div>
                    <?php if (!empty($requiresPrescription)): ?>
                        <div class="mb-3">
                            <label class="form-label">Upload prescription</label>
                            <input type="file" name="prescription_file" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                            <div class="form-text">Please upload a clear photo or PDF of your prescription.</div>
                        </div>
                    <?php endif; ?>
                    <button class="btn btn-success">Place order</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="fw-semibold mb-3">Order Overview</h5>
                <div class="d-flex justify-content-between mb-2"><span>Subtotal</span><span><?= format_price($summary['subtotal']) ?></span></div>
                <div class="d-flex justify-content-between mb-2"><span>Discount</span><span>-<?= format_price($summary['discount']) ?></span></div>
                <div class="d-flex justify-content-between mb-2"><span>Tax</span><span><?= format_price($summary['tax']) ?></span></div>
                <div class="d-flex justify-content-between mb-3"><span>Delivery</span><span><?= format_price($summary['delivery_charge']) ?></span></div>
                <div class="d-flex justify-content-between fw-bold fs-5"><span>Total</span><span><?= format_price($summary['grand_total']) ?></span></div>
            </div>
        </div>
    </div>
</div>
<?= $this->include('layouts/footer') ?>
