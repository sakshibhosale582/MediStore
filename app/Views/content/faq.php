<?= $this->include('layouts/header') ?>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h3 class="fw-semibold mb-3">Frequently Asked Questions</h3>
        <div class="accordion" id="faqAccordion">
            <?php foreach ($faqs as $index => $faq): ?>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faqHeading<?= $index ?>">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse<?= $index ?>" aria-expanded="false" aria-controls="faqCollapse<?= $index ?>">
                            <?= esc($faq['question']) ?>
                        </button>
                    </h2>
                    <div id="faqCollapse<?= $index ?>" class="accordion-collapse collapse" aria-labelledby="faqHeading<?= $index ?>" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            <?= esc($faq['answer']) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?= $this->include('layouts/footer') ?>