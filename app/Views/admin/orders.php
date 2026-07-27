<?= $this->include('layouts/header') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-semibold mb-1">Order Management</h3>
        <p class="text-muted mb-0">Track recent orders and update their status.</p>
    </div>
    <a class="btn btn-outline-success" href="<?= site_url('admin/dashboard') ?>">Back</a>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Customer</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?= esc($order['order_number'] ?? '') ?></td>
                            <td><?= esc($order['shipping_name'] ?? '') ?></td>
                            <td><?= order_status_badge($order['order_status'] ?? 'pending') ?></td>
                            <td><?= format_price($order['grand_total'] ?? 0) ?></td>
                            <td><?= esc(date('M d, Y', strtotime($order['created_at']))) ?></td>
                            <td>
                                <a class="btn btn-sm btn-outline-success" href="<?= site_url('admin/orders/update/' . (int) $order['id']) ?>">Update</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->include('layouts/footer') ?>