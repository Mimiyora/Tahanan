<?= $this->extend('layouts/coffeehouse') ?>

<?= $this->section('content') ?>
<section class="form-hero">
    <div class="shell form-shell">
        <div class="form-intro reveal">
            <span class="eyebrow"><?= esc($eyebrow) ?></span>
            <h1><?= esc($heading) ?></h1>
            <p>Required fields are checked on the server. If validation fails, the form keeps the values you entered.</p>
            <a class="back-link" href="<?= site_url('customers') ?>">← Back to customer accounts</a>
        </div>

        <div class="form-card reveal reveal--late">
            <?php if ($errors): ?>
                <div class="validation-summary" role="alert">
                    <strong>Please correct the highlighted fields.</strong>
                    <ul><?php foreach ($errors as $error): ?><li><?= esc($error) ?></li><?php endforeach ?></ul>
                </div>
            <?php endif ?>

            <form action="<?= esc($action) ?>" method="post" novalidate>
                <?= csrf_field() ?>
                <div class="field <?= isset($errors['full_name']) ? 'field--error' : '' ?>">
                    <label for="full_name">Full name <span>Required</span></label>
                    <input id="full_name" name="full_name" type="text" maxlength="100" value="<?= esc(old('full_name', $customer['full_name'] ?? '')) ?>" aria-describedby="full_name_help">
                    <small id="full_name_help"><?= isset($errors['full_name']) ? esc($errors['full_name']) : 'Enter the customer’s complete name.' ?></small>
                </div>

                <div class="field <?= isset($errors['email']) ? 'field--error' : '' ?>">
                    <label for="email">Email address <span>Required</span></label>
                    <input id="email" name="email" type="email" maxlength="100" value="<?= esc(old('email', $customer['email'] ?? '')) ?>" aria-describedby="email_help">
                    <small id="email_help"><?= isset($errors['email']) ? esc($errors['email']) : 'Use a valid email address such as name@example.com.' ?></small>
                </div>

                <div class="field <?= isset($errors['phone']) ? 'field--error' : '' ?>">
                    <label for="phone">Phone number <span>Optional</span></label>
                    <input id="phone" name="phone" type="tel" maxlength="20" value="<?= esc(old('phone', $customer['phone'] ?? '')) ?>" aria-describedby="phone_help">
                    <small id="phone_help"><?= isset($errors['phone']) ? esc($errors['phone']) : 'Up to 20 characters, including spaces and country code.' ?></small>
                </div>

                <div class="form-actions">
                    <button class="button button--primary" type="submit"><?= esc($submitLabel) ?> <span>→</span></button>
                    <a class="button button--text" href="<?= site_url('customers') ?>">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
