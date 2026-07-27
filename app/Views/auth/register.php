<?= $this->include('layouts/header') ?>
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h3 class="fw-semibold mb-3">Create account</h3>
                <form method="post" action="<?= site_url('auth/register') ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Full name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button class="btn btn-success w-100">Register</button>
                </form>
                <p class="mt-3 mb-0 text-muted">Already have an account? <a href="<?= site_url('login') ?>">Sign in</a></p>
            </div>
        </div>
    </div>
</div>
<?= $this->include('layouts/footer') ?>
