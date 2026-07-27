<?= $this->include('layouts/header') ?>
<div class="row g-4">
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h4 class="fw-semibold mb-3">
                    <?= !empty($editAddress) ? 'Edit Address' : 'Add Address' ?>
                </h4>
                <form method="post" action="<?= site_url('customer/addresses/save') ?>">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id" value="<?= esc($editAddress['id'] ?? '') ?>">
                    <div class="mb-3">
                        <label class="form-label">Label</label>
                        <input type="text" name="label" class="form-control" value="<?= esc($editAddress['label'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" value="<?= esc($editAddress['name'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="<?= esc($editAddress['phone'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address_line" class="form-control" required><?= esc($editAddress['address_line'] ?? '') ?></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">City</label>
                            <input type="text" name="city" class="form-control" value="<?= esc($editAddress['city'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">State</label>
                            <input type="text" name="state" class="form-control" value="<?= esc($editAddress['state'] ?? '') ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pincode</label>
                        <input type="text" name="pincode" class="form-control" value="<?= esc($editAddress['pincode'] ?? '') ?>" required>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="is_default" value="1" <?= !empty($editAddress['is_default']) ? 'checked' : '' ?>>
                        <label class="form-check-label">Set as default</label>
                    </div>
                    <button class="btn btn-success">Save address</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="fw-semibold mb-0">Saved Addresses</h4>
                    <a class="btn btn-outline-success" href="<?= site_url('customer/dashboard') ?>">Back</a>
                </div>
                <?php if (empty($addresses)): ?>
                    <p class="text-muted mb-0">No addresses saved yet.</p>
                <?php else: ?>
                    <div class="list-group">
                        <?php foreach ($addresses as $address): ?>
                            <div class="list-group-item d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="fw-semibold">
                                        <?= esc($address['label']) ?>
                                        <?php if (!empty($address['is_default'])): ?>
                                            <span class="badge bg-success ms-2">Default</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="text-muted small">
                                        <?= esc($address['name']) ?> · <?= esc($address['phone']) ?><br>
                                        <?= esc($address['address_line']) ?><br>
                                        <?= esc($address['city']) ?>, <?= esc($address['state']) ?> - <?= esc($address['pincode']) ?>
                                    </div>
                                </div>
                                <div class="btn-group btn-group-sm">
                                    <?php if (empty($address['is_default'])): ?>
                                        <a class="btn btn-outline-success" href="<?= site_url('customer/addresses/default/' . (int) $address['id']) ?>">Set default</a>
                                    <?php endif; ?>
                                    <a class="btn btn-outline-primary" href="<?= site_url('customer/addresses/edit/' . (int) $address['id']) ?>">Edit</a>
                                    <a class="btn btn-outline-danger" href="<?= site_url('customer/addresses/delete/' . (int) $address['id']) ?>">Delete</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->include('layouts/footer') ?>
