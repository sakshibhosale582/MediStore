<?= $this->include('layouts/header') ?>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-semibold mb-0">Wishlist</h4>
            <a class="btn btn-outline-success" href="<?= site_url('customer/dashboard') ?>">Back</a>
        </div>
        <?php if (empty($items)): ?>
            <p class="text-muted mb-0">Your wishlist is empty.</p>
        <?php else: ?>
            <div class="list-group">
                <?php foreach ($items as $item): ?>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-semibold"><?= esc($item['medicine_id']) ?></div>
                            <div class="text-muted small">Saved to your wishlist</div>
                        </div>
                        <a class="btn btn-outline-danger btn-sm" href="<?= site_url('wishlist/toggle/' . (int) $item['medicine_id']) ?>">Remove</a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->include('layouts/footer') ?>
