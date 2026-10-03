<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="profile-section">
    <div class="shell profile-grid">
        <div class="profile-intro reveal">
            <span class="eyebrow">Demo user</span>
            <h1>One profile.<br><em>One clear owner.</em></h1>
            <p>The profile page retrieves the single user record stored in the database.</p>
        </div>

        <article class="profile-card reveal reveal--late">
            <div class="profile-avatar" aria-hidden="true"><?= esc($initials) ?></div>
            <div class="profile-name">
                <span>Task owner</span>
                <h2><?= esc($user['full_name']) ?></h2>
                <p>@<?= esc($user['username']) ?></p>
            </div>
            <dl class="profile-details">
                <div><dt>Email</dt><dd><a href="mailto:<?= esc($user['email']) ?>"><?= esc($user['email']) ?></a></dd></div>
                <div><dt>Profile created</dt><dd><?= esc(date('F j, Y', strtotime($user['created_at']))) ?></dd></div>
                <div><dt>Account status</dt><dd><span class="status status--completed">Active</span></dd></div>
            </dl>
        </article>
    </div>
</section>
<?= $this->endSection() ?>
