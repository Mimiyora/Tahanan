<?= $this->extend('layouts/coffeehouse') ?>

<?= $this->section('content') ?>
<section class="directory-hero directory-hero--green">
    <div class="shell directory-heading reveal">
        <div>
            <span class="eyebrow">Point-of-sale access</span>
            <h1>User <em>Accounts</em></h1>
            <p>Create accounts, maintain names and email addresses, and prepare profile pictures for display.</p>
        </div>
        <div class="record-count"><strong><?= count($users) ?></strong><span>managed<br>accounts</span></div>
    </div>
</section>

<section class="directory-section">
    <div class="shell">
        <div class="directory-tools">
            <label class="search-box">
                <span class="sr-only">Search user accounts</span>
                <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"></circle><path d="m16 16 5 5"></path></svg>
                <input type="search" data-table-search="user-table" placeholder="Search user accounts…">
            </label>
            <a class="button button--primary button--compact" href="<?= site_url('users/new') ?>">New user <span>+</span></a>
        </div>

        <?php if (session('success')): ?>
            <div class="notice notice--success" role="status"><?= esc(session('success')) ?></div>
        <?php endif ?>

        <div class="table-card reveal reveal--late">
            <table id="user-table">
                <thead><tr><th>User</th><th>Username</th><th>Email address</th><th><span class="sr-only">Actions</span></th></tr></thead>
                <tbody>
                <?php foreach ($users as $user): ?>
                    <?php $avatar = empty($user['avatar']) ? base_url('assets/images/avatar-placeholder.svg') : base_url('uploads/avatars/' . rawurlencode($user['avatar'])); ?>
                    <tr>
                        <td data-label="User">
                            <div class="identity">
                                <img class="avatar-image" src="<?= esc($avatar) ?>" alt="<?= esc($user['full_name']) ?> profile picture">
                                <strong><?= esc($user['full_name']) ?></strong>
                            </div>
                        </td>
                        <td data-label="Username"><span class="username">@<?= esc($user['username']) ?></span></td>
                        <td data-label="Email"><a href="mailto:<?= esc($user['email']) ?>"><?= esc($user['email']) ?></a></td>
                        <td data-label="Action"><a class="table-action" href="<?= site_url('users/' . $user['id'] . '/edit') ?>">Edit</a></td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
            <div class="empty-state" hidden>No user accounts match your search.</div>
        </div>

        <div class="legacy-panel">
            <div>
                <span class="section-label">Previous version</span>
                <h2>Legacy coffeehouse team directory</h2>
                <p>The original six staff records remain available and unchanged.</p>
            </div>
            <div class="legacy-names" aria-label="Legacy staff members">
                <?php foreach ($legacyUsers as $legacyUser): ?>
                    <span><?= esc($legacyUser['full_name']) ?></span>
                <?php endforeach ?>
            </div>
            <a class="button button--text" href="<?= site_url('coffeehouse/team') ?>">Open legacy directory →</a>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
