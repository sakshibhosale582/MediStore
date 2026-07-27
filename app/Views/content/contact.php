<?= $this->include('layouts/header') ?>
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h3 class="fw-semibold mb-3">Contact Us</h3>
                <form method="post" action="<?= site_url('contact/submit') ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Message</label>
                        <textarea name="message" class="form-control" rows="5" required></textarea>
                    </div>
                    <button class="btn btn-success">Send message</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->include('layouts/footer') ?>