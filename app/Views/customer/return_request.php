<?= $this->include('layouts/header') ?>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h4 class="fw-semibold mb-3">Return Request</h4>
        <p class="text-muted">Request a return for order <strong><?= esc($order['order_number']) ?></strong>.</p>
        <form method="post" action="<?= site_url('customer/returns/' . (int) $order['id'] . '/submit') ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Reason for return</label>
                <textarea name="reason" class="form-control" required></textarea>
            </div>
            <button class="btn btn-success">Submit request</button>
        </form>
    </div>
</div>
<?= $this->include('layouts/footer') ?>
