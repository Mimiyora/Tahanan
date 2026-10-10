<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="profile-section">
    <div class="shell profile-grid">
        <div class="profile-intro"><p class="context-line">Meet the house</p><h1>The person behind the plan.</h1><p>Good service begins with people who notice the details and care for the day ahead.</p></div>
        <article class="profile-card">
            <div class="profile-card__top"><div class="profile-avatar" aria-hidden="true"><?= esc($initials) ?></div><div><span>Tahanan steward</span><h2><?= esc($user['full_name']) ?></h2><p>@<?= esc($user['username']) ?></p></div></div>
            <dl class="profile-details"><div><dt>Contact</dt><dd><a href="mailto:<?= esc($user['email']) ?>"><?= esc($user['email']) ?></a></dd></div><div><dt>Part of Tahanan since</dt><dd><?= esc(date('F j, Y', strtotime($user['created_at']))) ?></dd></div><div><dt>Today</dt><dd><span class="status status--completed">Ready to serve</span></dd></div></dl>
        </article>
    </div>
</section>
<?= $this->endSection() ?>
