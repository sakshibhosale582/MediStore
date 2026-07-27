<?= $this->include('layouts/header') ?>
<div class="row g-4">
    <div class="col-lg-3">
        <div class="card h-100">
            <div class="card-body">
                <span class="section-kicker">Refine</span><h5 class="fw-bold mb-3">Find your essentials</h5>
                <form method="get" action="<?= site_url('shop') ?>">
                    <div class="mb-3">
                        <label class="form-label">Search</label>
                        <input type="text" name="q" class="form-control" value="<?= esc($keyword) ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-select">
                            <option value="">All</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= (int) $category['id'] ?>" <?= ($filters['category_id'] ?? null) == $category['id'] ? 'selected' : '' ?>><?= esc($category['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sort</label>
                        <select name="sort" class="form-select">
                            <option value="name" <?= ($filters['sort'] ?? 'name') === 'name' ? 'selected' : '' ?>>Name</option>
                            <option value="price" <?= ($filters['sort'] ?? 'name') === 'price' ? 'selected' : '' ?>>Price</option>
                            <option value="stock" <?= ($filters['sort'] ?? 'name') === 'stock' ? 'selected' : '' ?>>Stock</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Order</label>
                        <select name="order" class="form-select">
                            <option value="ASC" <?= ($filters['order'] ?? 'ASC') === 'ASC' ? 'selected' : '' ?>>Ascending</option>
                            <option value="DESC" <?= ($filters['order'] ?? 'ASC') === 'DESC' ? 'selected' : '' ?>>Descending</option>
                        </select>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="in_stock" value="1" <?= !empty($filters['in_stock']) ? 'checked' : '' ?>>
                        <label class="form-check-label">In stock only</label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="prescription_required" value="1" <?= !empty($filters['prescription_required']) ? 'checked' : '' ?>>
                        <label class="form-check-label">Prescription required</label>
                    </div>
                    <button class="btn btn-success w-100"><i class="fa-solid fa-sliders me-1"></i>Apply filters</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-9">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <span class="section-kicker">Pharmacy catalogue</span><h3 class="section-title h3 mb-1">Medicines</h3>
                <p class="text-muted mb-0">Showing <?= count($medicines) ?> of <?= $total ?> results</p>
            </div>
        </div>
        <?php if (empty($medicines)): ?>
            <div class="alert alert-light border">No medicines matched your filters.</div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($medicines as $medicine): ?>
                    <div class="col-md-6">
                        <div class="card medicine-card h-100 card-hover">
                            <a href="<?= site_url('medicine/' . rawurlencode($medicine['slug'])) ?>"><img src="<?= esc(upload_url($medicine['image'])) ?>" onerror="this.onerror=null;this.src='<?= base_url('assets/img/placeholder-medicine.png') ?>';" class="card-img-top medicine-image" alt="<?= esc($medicine['name']) ?>"></a>
                            <div class="card-body d-flex flex-column">
                                <div class="medicine-meta mb-1"><?= esc($medicine['category_name'] ?? 'Healthcare') ?></div>
                                <a class="medicine-card-title fw-bold mb-1" href="<?= site_url('medicine/' . rawurlencode($medicine['slug'])) ?>"><?= esc($medicine['name']) ?></a>
                                <p class="medicine-meta mb-2"><?= esc($medicine['manufacturer_name'] ?? $medicine['generic_name'] ?? 'Trusted pharmacy product') ?></p>
                                <div class="small text-muted mb-3">
                                    <span class="badge bg-light text-dark"><?= esc($medicine['category_name'] ?? '') ?></span>
                                    <?php if (!empty($medicine['prescription_required'])): ?>
                                        <span class="badge bg-warning text-dark">Prescription required</span>
                                    <?php endif; ?>
                                </div>
                                <div class="mt-auto">
                                    <span class="price-current d-block mb-3"><?= format_price($medicine['effective_price']) ?></span>
                                    <div class="medicine-actions"><a class="btn btn-outline-success" href="<?= site_url('medicine/' . rawurlencode($medicine['slug'])) ?>">Details</a><form method="post" action="<?= site_url('cart/add/' . (int) $medicine['id']) ?>" class="flex-fill"><?= csrf_field() ?><input type="hidden" name="quantity" value="1"><button class="btn btn-success w-100" type="submit">Add to cart</button></form></div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($totalPages > 1): ?>
            <nav class="mt-4">
                <ul class="pagination">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                            <a class="page-link" href="<?= site_url('shop?page=' . $i . '&q=' . urlencode($keyword)) ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</div>
<?= $this->include('layouts/footer') ?>
