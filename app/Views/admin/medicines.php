<?= $this->include('layouts/header') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <span class="section-kicker">Catalogue management</span><h3 class="section-title h3 mb-1">Medicines</h3>
        <p class="text-muted mb-0">Add products, update details, and upload medicine images.</p>
    </div>
    <div class="d-flex gap-2">
        <a class="btn btn-outline-success" href="<?= site_url('admin/dashboard') ?>">Back</a>
        <a class="btn btn-success" href="<?= site_url('admin/medicines/create') ?>"><i class="fa-solid fa-plus me-1"></i>Add medicine</a>
    </div>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead><tr><th class="ps-3">Image</th><th>Medicine</th><th>Price</th><th>Stock</th><th>Status</th><th class="text-end pe-3">Action</th></tr></thead>
                <tbody>
                    <?php if (empty($medicines)): ?>
                        <tr><td colspan="6" class="text-center text-muted py-4">No medicines have been added yet.</td></tr>
                    <?php endif; ?>
                    <?php foreach ($medicines as $medicine): ?>
                        <tr>
                            <td class="ps-3"><img src="<?= esc(upload_url($medicine['image'])) ?>" alt="<?= esc($medicine['name']) ?>" width="56" height="56" class="rounded border object-fit-cover" onerror="this.onerror=null;this.src='<?= base_url('assets/img/placeholder-medicine.png') ?>';"></td>
                            <td><div class="fw-semibold"><?= esc($medicine['name']) ?></div><small class="text-muted"><?= esc($medicine['generic_name'] ?? '') ?></small></td>
                            <td><?= format_price(medicine_price($medicine)) ?></td>
                            <td><?= (int) $medicine['stock'] ?></td>
                            <td><span class="badge bg-<?= !empty($medicine['status']) ? 'success' : 'secondary' ?>"><?= !empty($medicine['status']) ? 'Active' : 'Hidden' ?></span></td>
                            <td class="text-end pe-3"><a class="btn btn-sm btn-outline-success" href="<?= site_url('admin/medicines/' . (int) $medicine['id'] . '/edit') ?>"><i class="fa-solid fa-pen-to-square me-1"></i>Edit</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->include('layouts/footer') ?>
