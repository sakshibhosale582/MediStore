<?= $this->include('layouts/header') ?>
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h3 class="fw-semibold mb-3">Update Order Status</h3>
                <p class="text-muted">Order: <strong><?= esc($order['order_number'] ?? '') ?></strong></p>
                <form method="post" action="<?= site_url('admin/orders/update/' . (int) $order['id']) ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="order_status" class="form-select">
                            <option value="pending" <?= ($order['order_status'] ?? 'pending') === 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="processing" <?= ($order['order_status'] ?? 'pending') === 'processing' ? 'selected' : '' ?>>Processing</option>
                            <option value="shipped" <?= ($order['order_status'] ?? 'pending') === 'shipped' ? 'selected' : '' ?>>Shipped</option>
                            <option value="delivered" <?= ($order['order_status'] ?? 'pending') === 'delivered' ? 'selected' : '' ?>>Delivered</option>
                            <option value="cancelled" <?= ($order['order_status'] ?? 'pending') === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                        </select>
                    </div>
                    <button class="btn btn-success">Save status</button>
                    <a class="btn btn-outline-success ms-2" href="<?= site_url('admin/orders') ?>">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->include('layouts/footer') ?>