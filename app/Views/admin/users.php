<?= $this->include('layouts/header') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-semibold mb-1">User Management</h3>
        <p class="text-muted mb-0">Activate or deactivate user accounts.</p>
    </div>
    <a class="btn btn-outline-success" href="<?= site_url('admin/dashboard') ?>">Back</a>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= esc($user['name'] ?? '') ?></td>
                            <td><?= esc($user['email'] ?? '') ?></td>
                            <td><?= esc($user['role'] ?? '') ?></td>
                            <td><?= !empty($user['is_active']) ? 'Active' : 'Inactive' ?></td>
                            <td>
                                <?php if ((int) ($user['id'] ?? 0) !== (int) session()->get('user_id')): ?>
                                    <a class="btn btn-sm btn-outline-success" href="<?= site_url('admin/users/toggle/' . (int) $user['id']) ?>">
                                        <?= !empty($user['is_active']) ? 'Deactivate' : 'Activate' ?>
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">Current user</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->include('layouts/footer') ?>