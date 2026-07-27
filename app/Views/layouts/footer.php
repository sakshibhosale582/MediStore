</main>
<footer class="site-footer">
    <div class="container"><div class="footer-top row g-4">
        <div class="col-lg-4"><a class="brand-mark footer-brand" href="<?= site_url('/') ?>"><span class="brand-icon"><i class="fa-solid fa-heart-pulse"></i></span><span>Medi<span>Store</span></span></a><p class="mt-3 mb-3">Simple, dependable pharmacy care for you and everyone you love.</p><div class="footer-social"><a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a><a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a><a href="#" aria-label="Twitter"><i class="fa-brands fa-x-twitter"></i></a></div></div>
        <div class="col-6 col-lg-2"><h6>Shop</h6><a href="<?= site_url('shop') ?>">All medicines</a><a href="<?= site_url('offers') ?>">Latest offers</a><a href="<?= site_url('shop?prescription_required=1') ?>">Prescription care</a><a href="<?= site_url('wishlist') ?>">Wishlist</a></div>
        <div class="col-6 col-lg-2"><h6>Support</h6><a href="<?= site_url('about') ?>">About us</a><a href="<?= site_url('contact') ?>">Contact us</a><a href="<?= site_url('faq') ?>">FAQs</a><a href="<?= site_url('customer/orders') ?>">Track order</a></div>
        <div class="col-lg-4"><h6>Health updates, thoughtfully sent</h6><p class="small">Offers, wellness tips, and more—no clutter.</p><form class="footer-newsletter" onsubmit="return false"><input type="email" placeholder="Your email address" aria-label="Your email address"><button type="submit" aria-label="Subscribe"><i class="fa-solid fa-arrow-right"></i></button></form><p class="footer-contact"><i class="fa-solid fa-phone"></i> +91 1800 123 4567 <span>•</span> <i class="fa-solid fa-envelope"></i> care@medistore.in</p></div>
    </div><div class="footer-bottom"><span>© <?= date('Y') ?> MediStore. All rights reserved.</span><span>Secure payments · Licensed pharmacy · Privacy first</span></div></div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('assets/js/medistore.js') ?>"></script>
</body>
</html>
