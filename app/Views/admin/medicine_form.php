<?= $this->include('layouts/header') ?>
<?php $isEdit = $medicine !== null; ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div><span class="section-kicker">Catalogue management</span><h3 class="section-title h3 mb-1"><?= $isEdit ? 'Edit medicine' : 'Add medicine' ?></h3><p class="text-muted mb-0">Upload a clear product image and save the medicine details.</p></div>
    <a class="btn btn-outline-success" href="<?= site_url('admin/medicines') ?>">Back to medicines</a>
</div>
<form method="post" action="<?= $isEdit ? site_url('admin/medicines/' . (int) $medicine['id']) : site_url('admin/medicines') ?>" enctype="multipart/form-data" class="card border-0 shadow-sm">
    <?= csrf_field() ?>
    <div class="card-body p-4">
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label" for="name">Medicine name *</label><input class="form-control" id="name" name="name" value="<?= esc(old('name', $medicine['name'] ?? '')) ?>" required maxlength="200"></div>
            <div class="col-md-6"><label class="form-label" for="generic_name">Generic name</label><input class="form-control" id="generic_name" name="generic_name" value="<?= esc(old('generic_name', $medicine['generic_name'] ?? '')) ?>" maxlength="200"></div>
            <div class="col-md-6"><label class="form-label" for="category_id">Category *</label><select class="form-select" id="category_id" name="category_id" required><option value="">Choose a category</option><?php foreach ($categories as $category): ?><option value="<?= (int) $category['id'] ?>" <?= (string) old('category_id', $medicine['category_id'] ?? '') === (string) $category['id'] ? 'selected' : '' ?>><?= esc($category['name']) ?></option><?php endforeach; ?></select></div>
            <div class="col-md-3"><label class="form-label" for="price">Price (₹) *</label><input class="form-control" id="price" name="price" type="number" min="0" step="0.01" value="<?= esc(old('price', $medicine['price'] ?? '')) ?>" required></div>
            <div class="col-md-3"><label class="form-label" for="discount_price">Sale price (₹)</label><input class="form-control" id="discount_price" name="discount_price" type="number" min="0" step="0.01" value="<?= esc(old('discount_price', $medicine['discount_price'] ?? '')) ?>"></div>
            <div class="col-md-4"><label class="form-label" for="stock">Stock *</label><input class="form-control" id="stock" name="stock" type="number" min="0" step="1" value="<?= esc(old('stock', $medicine['stock'] ?? 0)) ?>" required></div>
            <div class="col-md-4"><label class="form-label" for="expiry_date">Expiry date</label><input class="form-control" id="expiry_date" name="expiry_date" type="date" value="<?= esc(old('expiry_date', $medicine['expiry_date'] ?? '')) ?>"></div>
            <div class="col-md-4"><label class="form-label" for="image">Medicine image</label><input class="form-control" id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp"><div class="form-text">JPG, PNG, or WebP; maximum 5 MB.</div></div>
            <?php if ($isEdit && !empty($medicine['image'])): ?><div class="col-12"><span class="form-label d-block">Current image</span><img src="<?= esc(upload_url($medicine['image'])) ?>" alt="<?= esc($medicine['name']) ?>" class="rounded border object-fit-cover" width="120" height="120"></div><?php endif; ?>
            <div class="col-12"><label class="form-label" for="description">Description</label><textarea class="form-control" id="description" name="description" rows="3"><?= esc(old('description', $medicine['description'] ?? '')) ?></textarea></div>
            <div class="col-md-4"><label class="form-label" for="usage_info">Usage information</label><textarea class="form-control" id="usage_info" name="usage_info" rows="3"><?= esc(old('usage_info', $medicine['usage_info'] ?? '')) ?></textarea></div>
            <div class="col-md-4"><label class="form-label" for="side_effects">Side effects</label><textarea class="form-control" id="side_effects" name="side_effects" rows="3"><?= esc(old('side_effects', $medicine['side_effects'] ?? '')) ?></textarea></div>
            <div class="col-md-4"><label class="form-label" for="storage_instructions">Storage instructions</label><textarea class="form-control" id="storage_instructions" name="storage_instructions" rows="3"><?= esc(old('storage_instructions', $medicine['storage_instructions'] ?? '')) ?></textarea></div>
            <div class="col-12 d-flex gap-4"><div class="form-check"><input class="form-check-input" id="prescription_required" name="prescription_required" type="checkbox" value="1" <?= old('prescription_required', $medicine['prescription_required'] ?? 0) ? 'checked' : '' ?>><label class="form-check-label" for="prescription_required">Prescription required</label></div><div class="form-check"><input class="form-check-input" id="status" name="status" type="checkbox" value="1" <?= old('status', $medicine['status'] ?? 1) ? 'checked' : '' ?>><label class="form-check-label" for="status">Visible in shop</label></div></div>
        </div>
    </div>
    <div class="card-footer bg-white border-0 px-4 pb-4"><button class="btn btn-success" type="submit"><i class="fa-solid fa-floppy-disk me-1"></i><?= $isEdit ? 'Save changes' : 'Add medicine' ?></button></div>
</form>
<?= $this->include('layouts/footer') ?>
