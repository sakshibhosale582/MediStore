<?= $this->include('layouts/header') ?>
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h4 class="fw-semibold mb-3">Review Prescription</h4>
                <div class="mb-3">
                    <strong>Uploaded:</strong> <?= esc(date('M d, Y H:i', strtotime($prescription['created_at']))) ?>
                </div>
                <div class="mb-3">
                    <strong>Status:</strong> <?= prescription_status_badge($prescription['status']) ?>
                </div>
                <div class="mb-3">
                    <strong>Notes:</strong><br>
                    <?= esc($prescription['notes'] ?? 'No notes provided.') ?>
                </div>
                <?php if (!empty($prescription['file'])): ?>
                    <a class="btn btn-outline-success" href="<?= esc($prescription['file']) ?>" target="_blank">Open uploaded file</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="fw-semibold mb-3">Decision</h5>
                <form method="post" action="<?= site_url('pharmacist/prescriptions/' . (int) $prescription['id'] . '/review') ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Review notes</label>
                        <textarea name="review_notes" class="form-control"></textarea>
                    </div>
                    <button class="btn btn-success">Save review</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->include('layouts/footer') ?>
