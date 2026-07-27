<?= $this->include('layouts/header') ?>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h3 class="fw-semibold mb-3">Pharmacist Dashboard</h3>
        <?php if (empty($prescriptions)): ?>
            <p class="text-muted mb-0">No pending prescriptions to review.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Uploaded</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($prescriptions as $prescription): ?>
                            <tr>
                                <td><?= esc($prescription['user_id']) ?></td>
                                <td><?= esc(date('M d, Y', strtotime($prescription['created_at']))) ?></td>
                                <td><?= prescription_status_badge($prescription['status']) ?></td>
                                <td><a class="btn btn-sm btn-success" href="<?= site_url('pharmacist/prescriptions/' . (int) $prescription['id']) ?>">Review</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->include('layouts/footer') ?>
