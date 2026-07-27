<?= $this->include('layouts/header') ?>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-semibold mb-0">Notifications</h4>
            <a class="btn btn-outline-success" href="<?= site_url('customer/dashboard') ?>">Back</a>
        </div>
        <?php if (empty($notifications)): ?>
            <p class="text-muted mb-0">You have no notifications right now.</p>
        <?php else: ?>
            <div class="list-group">
                <?php foreach ($notifications as $notification): ?>
                    <div class="list-group-item d-flex justify-content-between align-items-start">
                        <div>
                            <div class="fw-semibold"><?= esc($notification['title']) ?></div>
                            <div class="text-muted small"><?= esc($notification['message']) ?></div>
                        </div>
                        <div class="text-end">
                            <?php if (empty($notification['is_read'])): ?>
                                <a class="btn btn-sm btn-outline-success" href="<?= site_url('customer/notifications/' . (int) $notification['id'] . '/read') ?>">Mark read</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->include('layouts/footer') ?>
