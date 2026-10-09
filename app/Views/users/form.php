<?= $this->extend('layouts/coffeehouse') ?>

<?= $this->section('content') ?>
<section class="form-hero">
    <div class="shell form-shell">
        <div class="form-intro reveal">
            <span class="eyebrow"><?= esc($eyebrow) ?></span>
            <h1><?= esc($heading) ?></h1>
            <p>Usernames must be unique and passwords are stored as secure hashes. Profile pictures are accepted on the edit page as JPG or PNG files up to 2 MB.</p>
            <a class="back-link" href="<?= site_url('users') ?>">← Back to user accounts</a>
        </div>

        <div class="form-card reveal reveal--late">
            <?php if ($success): ?>
                <div class="notice notice--success" role="status"><?= esc($success) ?></div>
            <?php endif ?>

            <?php if ($errors): ?>
                <div class="validation-summary" role="alert">
                    <strong>Please correct the highlighted fields.</strong>
                    <ul><?php foreach ($errors as $error): ?><li><?= esc($error) ?></li><?php endforeach ?></ul>
                </div>
            <?php endif ?>

            <form action="<?= esc($action) ?>" method="post" enctype="multipart/form-data" novalidate>
                <?= csrf_field() ?>
                <?php if ($user !== null): ?>
                    <?php $avatar = empty($user['avatar']) ? base_url('assets/images/avatar-placeholder.svg') : base_url('uploads/avatars/' . rawurlencode($user['avatar'])); ?>
                    <div class="avatar-editor">
                        <img src="<?= esc($avatar) ?>" alt="Current profile picture for <?= esc($user['full_name']) ?>">
                        <div><strong>Current profile picture</strong><span>The prepared image is displayed at 320 × 320 pixels.</span></div>
                    </div>
                <?php endif ?>

                <div class="field <?= isset($errors['username']) ? 'field--error' : '' ?>">
                    <label for="username">Username <span>Required and unique</span></label>
                    <input id="username" name="username" type="text" maxlength="50" value="<?= esc(old('username', $user['username'] ?? '')) ?>" aria-describedby="username_help">
                    <small id="username_help"><?= isset($errors['username']) ? esc($errors['username']) : 'Letters, numbers, periods, underscores, and hyphens only.' ?></small>
                </div>

                <div class="field <?= isset($errors['full_name']) ? 'field--error' : '' ?>">
                    <label for="full_name">Full name <span>Required</span></label>
                    <input id="full_name" name="full_name" type="text" maxlength="100" value="<?= esc(old('full_name', $user['full_name'] ?? '')) ?>" aria-describedby="full_name_help">
                    <small id="full_name_help"><?= isset($errors['full_name']) ? esc($errors['full_name']) : 'Enter the account holder’s complete name.' ?></small>
                </div>

                <div class="field <?= isset($errors['email']) ? 'field--error' : '' ?>">
                    <label for="email">Email address <span>Required</span></label>
                    <input id="email" name="email" type="email" maxlength="100" value="<?= esc(old('email', $user['email'] ?? '')) ?>" aria-describedby="email_help">
                    <small id="email_help"><?= isset($errors['email']) ? esc($errors['email']) : 'Use a valid email address such as name@example.com.' ?></small>
                </div>

                <div class="field <?= isset($errors['password']) ? 'field--error' : '' ?>">
                    <label for="password">Password <span><?= $user === null ? 'Required' : 'Optional change' ?></span></label>
                    <input id="password" name="password" type="password" maxlength="72" autocomplete="new-password" aria-describedby="password_help">
                    <small id="password_help"><?= isset($errors['password']) ? esc($errors['password']) : ($user === null ? 'Use at least 8 characters.' : 'Leave blank to keep the current password; enter 8 or more characters to replace it.') ?></small>
                </div>

                <?php if ($user !== null): ?>
                    <div class="field field--file <?= isset($errors['avatar']) ? 'field--error' : '' ?>">
                        <label for="avatar">Profile picture <span>Optional</span></label>
                        <input id="avatar" name="avatar" type="file" accept="image/jpeg,image/png" aria-describedby="avatar_help">
                        <small id="avatar_help"><?= isset($errors['avatar']) ? esc($errors['avatar']) : 'JPG or PNG only, maximum 2 MB. The image will be cropped to a square thumbnail.' ?></small>
                    </div>
                <?php endif ?>

                <div class="form-actions">
                    <button class="button button--primary" type="submit"><?= esc($submitLabel) ?> <span>→</span></button>
                    <a class="button button--text" href="<?= site_url('users') ?>">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
