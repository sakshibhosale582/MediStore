<?= $this->include('layouts/header') ?>
<div class="row g-4">
    <?php foreach ($offers as $offer): ?>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h4 class="fw-semibold"><?= esc($offer['title']) ?></h4>
                    <p class="text-muted"><?= esc($offer['description']) ?></p>
                    <?php if (!empty($offer['discount_percent'])): ?>
                        <span class="badge bg-success">Save <?= (float) $offer['discount_percent'] ?>%</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?= $this->include('layouts/footer') ?>