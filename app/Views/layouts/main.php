<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Tahanan Coffee House, a warm neighborhood home for Philippine coffee.">
    <meta name="theme-color" content="#35251d">
    <title><?= esc($title) ?> · Tahanan Coffee House</title>
    <link rel="icon" href="<?= base_url('assets/images/tahanan-mark.svg') ?>" type="image/svg+xml">
    <link rel="preload" href="<?= base_url('assets/fonts/lora-400.ttf') ?>" as="font" type="font/ttf" crossorigin>
    <link rel="preload" href="<?= base_url('assets/fonts/fraunces-600.ttf') ?>" as="font" type="font/ttf" crossorigin>
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
</head>
<body class="site page-<?= esc($currentPage) ?>">
    <a class="skip-link" href="#main-content">Skip to main content</a>

    <header class="site-header">
        <div class="shell nav-shell">
            <a class="brand" href="<?= site_url('/') ?>" aria-label="Tahanan Coffee House home">
                <span class="brand-mark" aria-hidden="true">
                    <img src="<?= base_url('assets/images/tahanan-mark.svg') ?>" alt="">
                </span>
                <span class="brand-copy"><strong>Tahanan</strong><small>Coffee House</small></span>
            </a>

            <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="site-nav">
                <span class="nav-toggle__lines" aria-hidden="true"><i></i><i></i></span>
                <span class="nav-toggle__label">Menu</span>
            </button>

            <div id="site-nav" class="site-nav">
                <nav class="primary-nav" aria-label="Primary navigation">
                    <a href="<?= site_url('/') ?>" <?= $currentPage === 'home' ? 'aria-current="page"' : '' ?>>Today</a>
                    <a href="<?= site_url('tasks') ?>" <?= $currentPage === 'tasks' ? 'aria-current="page"' : '' ?>>All tasks</a>
                    <a href="<?= site_url('coffeehouse') ?>" <?= $currentPage === 'coffeehouse' ? 'aria-current="page"' : '' ?>>Coffee House</a>
                    <a href="<?= site_url('coffeehouse/about') ?>" <?= $currentPage === 'coffeehouse-about' ? 'aria-current="page"' : '' ?>>Our story</a>
                    <a href="<?= site_url('profile') ?>" <?= $currentPage === 'profile' ? 'aria-current="page"' : '' ?>>Profile</a>
                    <a href="<?= site_url('about') ?>" <?= $currentPage === 'about' ? 'aria-current="page"' : '' ?>>About</a>
                </nav>

                <div class="account-nav">
                    <?php if (session()->get('isLoggedIn') === true): ?>
                        <details class="manage-menu">
                            <summary>House tools</summary>
                            <div class="manage-menu__panel">
                                <a href="<?= site_url('tasks/new') ?>">Add to the day</a>
                                <a href="<?= site_url('customers') ?>" <?= $currentPage === 'customers' ? 'aria-current="page"' : '' ?>>Our guests</a>
                                <a href="<?= site_url('users') ?>" <?= $currentPage === 'users' ? 'aria-current="page"' : '' ?>>House team</a>
                                <a href="<?= site_url('coffeehouse/team') ?>" <?= $currentPage === 'legacy-team' ? 'aria-current="page"' : '' ?>>Original team</a>
                            </div>
                        </details>
                        <div class="account-state">
                            <span>Signed in as</span>
                            <strong><?= esc(session()->get('fullName') ?: session()->get('username')) ?></strong>
                        </div>
                        <form class="logout-form" action="<?= site_url('logout') ?>" method="post">
                            <?= csrf_field() ?>
                            <button type="submit">Log out</button>
                        </form>
                    <?php else: ?>
                        <a class="login-link" href="<?= site_url('login') ?>" <?= $currentPage === 'login' ? 'aria-current="page"' : '' ?>>Staff log in</a>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </header>

    <main id="main-content"><?= $this->renderSection('content') ?></main>

    <footer class="site-footer">
        <div class="shell footer-grid">
            <div class="footer-brand">
                <span class="brand-mark brand-mark--footer" aria-hidden="true">
                    <img src="<?= base_url('assets/images/tahanan-mark.svg') ?>" alt="">
                </span>
                <div><strong>Tahanan Coffee House</strong><p>Every cup feels like home.</p></div>
            </div>
            <nav class="footer-links" aria-label="Footer navigation">
                <a href="<?= site_url('/') ?>">Today</a>
                <a href="<?= site_url('tasks') ?>">All tasks</a>
                <a href="<?= site_url('coffeehouse/about') ?>">Our story</a>
                <a href="<?= site_url('coffeehouse/team') ?>">Our team</a>
            </nav>
            <div class="footer-note">
                <span>Open daily, 7:00 AM–9:00 PM</span>
                <span>© <?= date('Y') ?> Tahanan Coffee House</span>
            </div>
        </div>
    </footer>

    <script src="<?= base_url('assets/js/app.js') ?>"></script>
</body>
</html>
