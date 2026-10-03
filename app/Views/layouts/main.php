<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Tasks for Today is a focused daily task-management dashboard.">
    <title><?= esc($title) ?> · Tasks for Today</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
</head>
<body>
    <div class="topline" aria-hidden="true"></div>
    <header class="site-header">
        <div class="shell nav-wrap">
            <a class="brand" href="<?= site_url('/') ?>" aria-label="Tasks for Today home">
                <span class="brand-mark" aria-hidden="true">
                    <svg viewBox="0 0 44 44" role="img"><path d="M7 20.5 22 8l15 12.5v16H7z"/><path d="M12 21h20M16 25v7m6-7v7m6-7v7"/><circle cx="22" cy="16.5" r="3"/></svg>
                </span>
                <span><strong>Tahanan</strong><small>Tasks for Today</small></span>
            </a>

            <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="site-nav">
                <span></span><span></span><span></span><span class="sr-only">Open navigation</span>
            </button>

            <nav id="site-nav" class="site-nav" aria-label="Main navigation">
                <a href="<?= site_url('/') ?>" class="<?= $currentPage === 'home' ? 'active' : '' ?>">Today</a>
                <a href="<?= site_url('tasks') ?>" class="<?= $currentPage === 'tasks' ? 'active' : '' ?>">All tasks</a>
                <a href="<?= site_url('profile') ?>" class="<?= $currentPage === 'profile' ? 'active' : '' ?>">Profile</a>
                <a href="<?= site_url('about') ?>" class="<?= $currentPage === 'about' ? 'active' : '' ?>">About</a>
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
                <div><strong>Tasks for Today</strong><p>A clear view of the work that matters now.</p></div>
            </div>
            <div class="footer-note">
                <span>CodeIgniter 4 · MySQL</span>
                <span>© <?= date('Y') ?> Gerard Doroja</span>
            </div>
        </div>
    </footer>

    <script src="<?= base_url('assets/js/app.js') ?>"></script>
</body>
</html>
