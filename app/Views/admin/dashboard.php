<?= $this->include('layouts/header') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <span class="section-kicker">Operations centre</span><h3 class="section-title h3 mb-1">Admin Dashboard</h3>
        <p class="text-muted mb-0">Manage users and keep the pharmacy platform healthy.</p>
    </div>
    <a class="btn btn-outline-success" href="<?= site_url('logout') ?>">Logout</a>
</div>
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="stat-icon mb-3"><i class="fa-solid fa-users"></i></div><h6 class="text-muted">Total users</h6>
                <h3 class="fw-bold"><?= esc($totalUsers) ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="stat-icon mb-3"><i class="fa-solid fa-user-check"></i></div><h6 class="text-muted">Active users</h6>
                <h3 class="fw-bold"><?= esc($activeUsers) ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="stat-icon mb-3"><i class="fa-solid fa-user-group"></i></div><h6 class="text-muted">Customers</h6>
                <h3 class="fw-bold"><?= esc($customerCount) ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="stat-icon mb-3"><i class="fa-solid fa-user-doctor"></i></div><h6 class="text-muted">Pharmacists</h6>
                <h3 class="fw-bold"><?= esc($pharmacistCount) ?></h3>
            </div>
        </div>
    </div>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-semibold mb-0">Admin actions</h5>
            <div class="d-flex gap-2">
                <a class="btn btn-success" href="<?= site_url('admin/users') ?>">Manage users</a>
                <a class="btn btn-outline-success" href="<?= site_url('admin/medicines') ?>">Manage medicines</a>
                <a class="btn btn-outline-success" href="<?= site_url('admin/orders') ?>">Manage orders</a>
                <a class="btn btn-outline-success" href="<?= site_url('admin/inventory') ?>">Manage inventory</a>
            </div>
        </div>
        <p class="text-muted mb-0">The admin panel is now available for managing staff accounts and recent orders.</p>
    </div>
</div>
<?= $this->include('layouts/footer') ?>
