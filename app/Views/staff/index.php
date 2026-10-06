<?= $this->extend('layouts/coffeehouse') ?>

<?= $this->section('content') ?>
<section class="directory-hero directory-hero--green">
    <div class="shell directory-heading reveal">
        <div>
            <span class="eyebrow">Legacy directory</span>
            <h1>Coffeehouse <em>Team</em></h1>
            <p>The former staff directory remains available alongside editable user accounts.</p>
        </div>
        <div class="record-count"><strong><?= count($users) ?></strong><span>active<br>team members</span></div>
    </div>
</section>

<section class="directory-section">
    <div class="shell">
        <div class="directory-tools">
            <label class="search-box">
                <span class="sr-only">Search team members</span>
                <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"></circle><path d="m16 16 5 5"></path></svg>
                <input type="search" data-table-search="legacy-user-table" placeholder="Search the legacy team directory…">
            </label>
            <a class="button button--primary button--compact" href="<?= site_url('users') ?>">Manage user accounts <span>→</span></a>
        </div>

        <div class="table-card reveal reveal--late">
            <table id="legacy-user-table">
                <thead><tr><th>Team member</th><th>Username</th><th>Member since</th></tr></thead>
                <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td data-label="Team member"><div class="identity"><span class="avatar avatar--green"><?= esc($user['initials']) ?></span><strong><?= esc($user['full_name']) ?></strong></div></td>
                        <td data-label="Username"><span class="username">@<?= esc($user['username']) ?></span></td>
                        <td data-label="Member since"><span class="role-badge"><?= esc(date('M j, Y', strtotime($user['created_at']))) ?></span></td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
            <div class="empty-state" hidden>No team accounts match your search.</div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
