<?= $this->include('layouts/header') ?>
<div class="row g-4">
    <div class="col-lg-5">
        <img src="<?= esc(upload_url($medicine['image'])) ?>" onerror="this.onerror=null;this.src='<?= base_url('assets/img/placeholder-medicine.png') ?>';" class="product-detail-image" alt="<?= esc($medicine['name']) ?>">
    </div>
    <div class="col-lg-7">
        <span class="section-kicker"><?= esc($medicine['category_name'] ?? 'Healthcare') ?></span><h1 class="section-title h2 mb-2"><?= esc($medicine['name']) ?></h1>
        <p class="text-muted mb-3"><?= esc($medicine['generic_name'] ?? '') ?></p>
        <div class="mb-3">
            <span class="badge bg-success me-2"><?= esc($medicine['category_name'] ?? '') ?></span>
            <span class="badge bg-light text-dark me-2"><?= esc($medicine['brand_name'] ?? '') ?></span>
            <?php if (!empty($medicine['prescription_required'])): ?>
                <span class="badge bg-warning text-dark">Prescription required</span>
            <?php endif; ?>
        </div>
        <p class="price-current fs-4 mb-2"><?= format_price($medicine['effective_price']) ?></p><p class="small text-muted"><i class="fa-solid fa-circle-check text-success me-1"></i><?= (int) ($medicine['stock'] ?? 0) > 0 ? 'In stock and ready to dispatch' : 'Currently unavailable' ?></p>
        <p class="text-muted"><?= esc($medicine['description'] ?? '') ?></p>
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="fw-bold"><i class="fa-solid fa-circle-info text-success me-2"></i>Medicine details</h5>
                <ul class="mb-0">
                    <li>Manufacturer: <?= esc($medicine['manufacturer_name'] ?? '—') ?></li>
                    <li>Stock: <?= (int) ($medicine['stock'] ?? 0) ?></li>
                    <li>Expiry: <?= esc($medicine['expiry_date'] ?? '—') ?></li>
                </ul>
            </div>
        </div>
        <form method="post" action="<?= site_url('cart/add/' . (int) $medicine['id']) ?>" class="mt-3">
            <?= csrf_field() ?>
            <div class="input-group" style="max-width: 260px;">
                <input type="number" class="form-control" name="quantity" min="1" value="1">
                <button class="btn btn-success"><i class="fa-solid fa-bag-shopping me-1"></i>Add to cart</button>
            </div>
        </form>
        <a class="btn btn-outline-danger mt-2" href="<?= site_url('wishlist/toggle/' . (int) $medicine['id']) ?>">Add to wishlist</a>

        <div class="card border-0 shadow-sm mt-4">
            <div class="card-body">
                <h5 class="fw-semibold">Leave a review</h5>
                <?php if (session()->get('is_logged_in')): ?>
                    <form method="post" action="<?= site_url('medicine/' . esc($medicine['slug']) . '/review') ?>">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label class="form-label">Rating</label>
                            <select name="rating" class="form-select">
                                <option value="5">5 Star</option>
                                <option value="4">4 Star</option>
                                <option value="3">3 Star</option>
                                <option value="2">2 Star</option>
                                <option value="1">1 Star</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Comment</label>
                            <textarea name="comment" class="form-control"></textarea>
                        </div>
                        <button class="btn btn-success">Submit review</button>
                    </form>
                <?php else: ?>
                    <p class="text-muted mb-0">Please <a href="<?= site_url('login') ?>">log in</a> to submit a review.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="card border-0 shadow-sm mt-4">
            <div class="card-body">
                <h5 class="fw-semibold">Customer reviews</h5>
                <?php if (empty($reviews)): ?>
                    <p class="text-muted mb-0">No reviews yet for this medicine.</p>
                <?php else: ?>
                    <div class="d-flex flex-column gap-3 mt-3">
                        <?php foreach ($reviews as $review): ?>
                            <div class="border rounded p-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <strong><?= esc($review['user_name'] ?? 'Customer') ?></strong>
                                    <span class="badge bg-success"><?= (int) $review['rating'] ?>/5</span>
                                </div>
                                <p class="mb-0 mt-2 text-muted"><?= esc($review['comment'] ?? '') ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->include('layouts/footer') ?>
