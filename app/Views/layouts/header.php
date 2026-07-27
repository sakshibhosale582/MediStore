<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0F9D8A">
    <title><?= esc($pageTitle ?? 'MediStore | Your trusted pharmacy') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/css/medistore.css') ?>" rel="stylesheet">
</head>
<body>
<div class="site-notice d-none d-md-block">
    <div class="container d-flex justify-content-between align-items-center">
        <span><i class="fa-solid fa-shield-heart me-2"></i>Licensed pharmacy care, delivered with confidence</span>
        <span><i class="fa-solid fa-truck-fast me-2"></i>Free delivery on orders above ₹499</span>
    </div>
</div>
<nav class="navbar navbar-expand-lg navbar-light pharmacy-nav sticky-top">
    <div class="container">
        <a class="navbar-brand brand-mark" href="<?= site_url('/') ?>" aria-label="MediStore home"><span class="brand-icon"><i class="fa-solid fa-heart-pulse"></i></span><span>Medi<span>Store</span></span></a>
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation"><i class="fa-solid fa-bars-staggered"></i></button>
        <div class="collapse navbar-collapse" id="mainNav">
            <form class="nav-search order-lg-1 ms-lg-4 my-3 my-lg-0" action="<?= site_url('shop') ?>" method="get">
                <i class="fa-solid fa-magnifying-glass"></i><input type="search" name="q" placeholder="Search medicines, wellness products…" aria-label="Search medicines"><button type="submit">Search</button>
            </form>
            <ul class="navbar-nav ms-lg-auto align-items-lg-center gap-lg-1">
                <li class="nav-item"><a class="nav-link" href="<?= site_url('shop') ?>">Medicines</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= site_url('offers') ?>">Offers</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= site_url('faq') ?>">Help</a></li>
                <li class="nav-item"><a class="nav-link nav-cart" href="<?= site_url('cart') ?>" aria-label="Shopping cart"><i class="fa-solid fa-bag-shopping"></i><span class="d-lg-none ms-2">Cart</span></a></li>
                <?php if (session()->get('is_logged_in')): ?>
                    <li class="nav-item dropdown"><a class="nav-link dropdown-toggle user-nav" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><span class="user-avatar"><?= esc(strtoupper(substr((string) session()->get('user_name'), 0, 1))) ?></span><span><?= esc(session()->get('user_name')) ?></span></a><ul class="dropdown-menu dropdown-menu-end shadow border-0"><li><a class="dropdown-item" href="<?= site_url(session()->get('user_role') === 'admin' ? 'admin/dashboard' : 'customer/dashboard') ?>"><i class="fa-solid fa-gauge-high me-2"></i>Dashboard</a></li><li><a class="dropdown-item" href="<?= site_url('customer/orders') ?>"><i class="fa-solid fa-box me-2"></i>My orders</a></li><li><hr class="dropdown-divider"></li><li><a class="dropdown-item text-danger" href="<?= site_url('logout') ?>"><i class="fa-solid fa-arrow-right-from-bracket me-2"></i>Sign out</a></li></ul></li>
                <?php else: ?>
                    <li class="nav-item"><a class="btn btn-primary btn-sm nav-signin" href="<?= site_url('login') ?>">Sign in</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<main class="site-main">
    <div class="container flash-wrap">
        <?php if ($error = session()->getFlashdata('error')): ?><div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fa-solid fa-circle-exclamation me-2"></i><?= esc($error) ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?>
        <?php if ($success = session()->getFlashdata('success')): ?><div class="alert alert-success alert-dismissible fade show" role="alert"><i class="fa-solid fa-circle-check me-2"></i><?= esc($success) ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?>
    </div>
