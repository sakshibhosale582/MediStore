<?= $this->include('layouts/header') ?>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-semibold mb-0">My Prescriptions</h4>
            <a class="btn btn-outline-success" href="<?= site_url('customer/dashboard') ?>">Back to dashboard</a>
        </div>
        <?php if (empty($prescriptions)): ?>
            <p class="text-muted mb-0">No prescriptions uploaded yet.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Uploaded</th>
                            <th>File</th>
                            <th>Status</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($prescriptions as $prescription): ?>
                            <tr>
                                <td><?= esc(date('M d, Y', strtotime($prescription['created_at']))) ?></td>
                                <td><a href="<?= esc($prescription['file']) ?>" target="_blank">View file</a></td>
                                <td><?= prescription_status_badge($prescription['status']) ?></td>
                                <td><?= esc($prescription['notes'] ?? '') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->include('layouts/footer') ?>
