<?= $this->extend('layouts/coffeehouse') ?>

<?= $this->section('content') ?>
<section class="login-page"><div class="shell login-grid"><div class="login-visual"><img src="<?= base_url('assets/images/tahanan-pour.webp') ?>" alt="Barako coffee being prepared by hand beside capiz windows"><div><p class="context-line">Staff workspace</p><h1>Welcome back.</h1><p>Sign in to plan tasks and care for Tahanan’s customer and user accounts.</p></div></div><div class="form-card login-card">
<?php if ($success): ?><div class="notice notice--success" role="status"><?= esc($success) ?></div><?php endif ?>
<?php if ($error): ?><div class="validation-summary" role="alert"><strong><?= esc($error) ?></strong></div><?php endif ?>
<?php if ($errors): ?><div class="validation-summary" role="alert"><strong>Please enter your login details.</strong><ul><?php foreach ($errors as $message): ?><li><?= esc($message) ?></li><?php endforeach ?></ul></div><?php endif ?>
<form action="<?= site_url('login') ?>" method="post"><?= csrf_field() ?>
<div class="field <?= isset($errors['username']) ? 'field--error' : '' ?>"><label for="username">Username <span>Required</span></label><input id="username" name="username" type="text" maxlength="50" autocomplete="username" value="<?= esc(old('username')) ?>" autofocus aria-describedby="username_help" <?= isset($errors['username']) ? 'aria-invalid="true"' : '' ?>><small id="username_help"><?= isset($errors['username']) ? esc($errors['username']) : 'Enter the username assigned to your staff account.' ?></small></div>
<div class="field <?= isset($errors['password']) ? 'field--error' : '' ?>"><label for="password">Password <span>Required</span></label><input id="password" name="password" type="password" maxlength="255" autocomplete="current-password" aria-describedby="password_help" <?= isset($errors['password']) ? 'aria-invalid="true"' : '' ?>><small id="password_help"><?= isset($errors['password']) ? esc($errors['password']) : 'Passwords are checked securely against the stored hash.' ?></small></div>
<div class="form-actions"><button class="button button--primary" type="submit">Sign in</button></div></form><a class="back-link" href="<?= site_url('coffeehouse') ?>">Back to the Coffee House</a></div></div></section>
<?= $this->endSection() ?>
