<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="form-hero">
    <div class="shell form-shell">
        <div class="form-intro reveal">
            <span class="eyebrow"><?= esc($eyebrow) ?></span>
            <h1><?= esc($heading) ?></h1>
            <p>Set the task title, scheduled date, and current status. Required fields are checked on the server before the record is saved.</p>
            <a class="back-link" href="<?= site_url('tasks') ?>">&larr; Back to all tasks</a>
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
                <div class="field <?= isset($errors['title']) ? 'field--error' : '' ?>">
                    <label for="title">Task title <span>Required</span></label>
                    <input id="title" name="title" type="text" maxlength="150" value="<?= esc(old('title', $task['title'] ?? '')) ?>" aria-describedby="title_help">
                    <small id="title_help"><?= isset($errors['title']) ? esc($errors['title']) : 'Describe the work clearly in 150 characters or fewer.' ?></small>
                </div>

                <div class="field <?= isset($errors['task_date']) ? 'field--error' : '' ?>">
                    <label for="task_date">Task date <span>Required</span></label>
                    <input id="task_date" name="task_date" type="date" value="<?= esc(old('task_date', $task['task_date'] ?? '')) ?>" aria-describedby="task_date_help">
                    <small id="task_date_help"><?= isset($errors['task_date']) ? esc($errors['task_date']) : 'Choose the date when this task should appear on the schedule.' ?></small>
                </div>

                <div class="field <?= isset($errors['status']) ? 'field--error' : '' ?>">
                    <label for="status">Status <span>Required</span></label>
                    <?php $selectedStatus = old('status', $task['status'] ?? 'pending'); ?>
                    <select id="status" name="status" aria-describedby="status_help">
                        <option value="pending" <?= $selectedStatus === 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="in_progress" <?= $selectedStatus === 'in_progress' ? 'selected' : '' ?>>In progress</option>
                        <option value="completed" <?= $selectedStatus === 'completed' ? 'selected' : '' ?>>Completed</option>
                    </select>
                    <small id="status_help"><?= isset($errors['status']) ? esc($errors['status']) : 'Keep the status current so the dashboard progress remains accurate.' ?></small>
                </div>

                <div class="form-actions">
                    <button class="button button--primary" type="submit"><?= esc($submitLabel) ?> <span>&rarr;</span></button>
                    <a class="button button--text" href="<?= site_url('tasks') ?>">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
