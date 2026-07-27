<?= $this->include('layouts/header') ?>
<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h5 class="fw-semibold">Welcome back</h5>
                <p class="text-muted mb-0">Track orders, view prescriptions, and manage your addresses from one place.</p>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h5 class="fw-semibold">Customer quick actions</h5>
                <div class="d-flex flex-wrap gap-2 mt-3">
                    <a class="btn btn-outline-success" href="<?= site_url('shop') ?>">Continue shopping</a>
                    <a class="btn btn-outline-success" href="<?= site_url('customer/orders') ?>">View orders</a>
                    <a class="btn btn-outline-success" href="<?= site_url('customer/prescriptions') ?>">Prescriptions</a>
                    <a class="btn btn-outline-success" href="<?= site_url('customer/notifications') ?>">Notifications</a>
                    <a class="btn btn-outline-success" href="<?= site_url('customer/addresses') ?>">Addresses</a>
                    <a class="btn btn-outline-success" href="<?= site_url('logout') ?>">Logout</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mt-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-semibold mb-0">Recent orders</h5>
            <a class="btn btn-sm btn-outline-success" href="<?= site_url('customer/orders') ?>">View all</a>
        </div>
        <?php if (empty($orders)): ?>
            <p class="text-muted mb-0">No orders yet. Start shopping to see them here.</p>
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
                                <td><a class="btn btn-sm btn-success" href="<?= site_url('customer/orders/' . (int) $order['id']) ?>">Details</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->include('layouts/footer') ?>
