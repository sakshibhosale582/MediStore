<?= $this->include('layouts/header') ?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h3 class="fw-semibold text-success mb-3">Order confirmed!</h3>
                <p class="text-muted">Your order <strong><?= esc($order['order_number'] ?? '') ?></strong> has been placed successfully.</p>
                <div class="alert alert-success">We’ll process your request and update you as soon as the status changes.</div>
                <a class="btn btn-success" href="<?= site_url('customer/dashboard') ?>">Go to dashboard</a>
            </div>
        </div>
    </div>
</div>
<?= $this->include('layouts/footer') ?>