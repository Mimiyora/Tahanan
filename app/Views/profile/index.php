<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="profile-section">
    <div class="shell profile-grid">
        <div class="profile-intro"><p class="context-line">Public demo profile</p><h1>The person behind the plan.</h1><p>This page retrieves the first user record stored in the shared Tahanan database.</p></div>
        <article class="profile-card">
            <div class="profile-card__top"><div class="profile-avatar" aria-hidden="true"><?= esc($initials) ?></div><div><span>Task owner</span><h2><?= esc($user['full_name']) ?></h2><p>@<?= esc($user['username']) ?></p></div></div>
            <dl class="profile-details"><div><dt>Email</dt><dd><a href="mailto:<?= esc($user['email']) ?>"><?= esc($user['email']) ?></a></dd></div><div><dt>Profile created</dt><dd><?= esc(date('F j, Y', strtotime($user['created_at']))) ?></dd></div><div><dt>Account status</dt><dd><span class="status status--completed">Active</span></dd></div></dl>
        </article>
    </div>
</section>
<?= $this->endSection() ?>
