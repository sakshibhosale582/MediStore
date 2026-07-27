<?= $this->include('layouts/header') ?>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-semibold mb-0">My Orders</h4>
            <a class="btn btn-outline-success" href="<?= site_url('customer/dashboard') ?>">Back to dashboard</a>
        </div>
        <?php if (empty($orders)): ?>
            <p class="text-muted mb-0">No orders found.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td>
                                    <strong><?= esc($order['order_number']) ?></strong><br>
                                    <small class="text-muted"><?= count($order['items']) ?> item(s)</small>
                                </td>
                                <td><?= esc(date('M d, Y', strtotime($order['created_at']))) ?></td>
                                <td><?= order_status_badge($order['order_status']) ?></td>
                                <td><?= format_price($order['grand_total']) ?></td>
                                <td><a class="btn btn-sm btn-success" href="<?= site_url('customer/orders/' . (int) $order['id']) ?>">View</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->include('layouts/footer') ?>
