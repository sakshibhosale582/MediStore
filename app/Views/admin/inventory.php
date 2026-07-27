<?= $this->include('layouts/header') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-semibold mb-1">Inventory Management</h3>
        <p class="text-muted mb-0">Adjust stock levels for medicines.</p>
    </div>
    <a class="btn btn-outline-success" href="<?= site_url('admin/dashboard') ?>">Back</a>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Medicine</th>
                        <th>Stock</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($medicines as $medicine): ?>
                        <tr>
                            <td><?= esc($medicine['name'] ?? '') ?></td>
                            <td><?= (int) ($medicine['stock'] ?? 0) ?></td>
                            <td>
                                <form method="post" action="<?= site_url('admin/inventory/stock/' . (int) $medicine['id']) ?>" class="d-flex gap-2">
                                    <?= csrf_field() ?>
                                    <input type="number" class="form-control form-control-sm" name="stock" value="<?= (int) ($medicine['stock'] ?? 0) ?>" min="0" style="max-width: 100px;">
                                    <button class="btn btn-sm btn-success">Update</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->include('layouts/footer') ?>