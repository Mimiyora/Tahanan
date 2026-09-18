<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Tahanan Coffee House point-of-sale account portal.">
    <title><?= esc($title) ?> · Tahanan Coffee House</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
</head>
<body>
    <div class="topline" aria-hidden="true"></div>
    <header class="site-header">
        <div class="shell nav-wrap">
            <a class="brand" href="<?= site_url('/') ?>" aria-label="Tahanan Coffee House home">
                <span class="brand-mark" aria-hidden="true">
                    <svg viewBox="0 0 44 44" role="img"><path d="M7 20.5 22 8l15 12.5v16H7z"/><path d="M12 21h20M16 25v7m6-7v7m6-7v7"/><circle cx="22" cy="16.5" r="3"/></svg>
                </span>
                <span><strong>Tahanan</strong><small>Coffee House · POS</small></span>
            </a>

            <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="site-nav">
                <span></span><span></span><span></span><span class="sr-only">Open navigation</span>
            </button>

            <nav id="site-nav" class="site-nav" aria-label="Main navigation">
                <a href="<?= site_url('/') ?>" class="<?= $currentPage === 'home' ? 'active' : '' ?>">Home</a>
                <a href="<?= site_url('about') ?>" class="<?= $currentPage === 'about' ? 'active' : '' ?>">Our story</a>
                <a href="<?= site_url('customers') ?>" class="<?= $currentPage === 'customers' ? 'active' : '' ?>">Customers</a>
                <a href="<?= site_url('users') ?>" class="<?= $currentPage === 'users' ? 'active' : '' ?>">Team</a>
            </nav>
        </div>
    </header>

    <main><?= $this->renderSection('content') ?></main>

    <footer class="site-footer">
        <div class="shell footer-grid">
            <div class="footer-brand">
                <span class="brand-mark brand-mark--light" aria-hidden="true">
                    <svg viewBox="0 0 44 44" role="img"><path d="M7 20.5 22 8l15 12.5v16H7z"/><path d="M12 21h20M16 25v7m6-7v7m6-7v7"/><circle cx="22" cy="16.5" r="3"/></svg>
                </span>
                <div><strong>Tahanan Coffee House</strong><p>Every cup feels like home.</p></div>
            </div>
            <div class="footer-note">
                <span>Open daily · 7:00 AM–9:00 PM</span>
                <span>© <?= date('Y') ?> Tahanan POS</span>
            </div>
        </div>
    </footer>

    <script src="<?= base_url('assets/js/app.js') ?>"></script>
</body>
</html>
