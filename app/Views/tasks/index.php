<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php $statusLabels = ['pending' => 'Pending', 'in_progress' => 'In progress', 'completed' => 'Completed']; ?>
<section class="directory-hero">
    <div class="shell directory-heading reveal">
        <div>
            <span class="eyebrow">Complete schedule</span>
            <h1>All <em>Tasks</em></h1>
            <p>Every active task, ordered by its scheduled date.</p>
        </div>
        <div class="record-count"><strong><?= count($tasks) ?></strong><span>total<br>tasks</span></div>
    </div>
</section>

<section class="directory-section">
    <div class="shell">
        <?php if ($success): ?>
            <div class="notice notice--success" role="status"><?= esc($success) ?></div>
        <?php endif ?>

        <div class="directory-tools">
            <label class="search-box">
                <span class="sr-only">Search tasks</span>
                <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"></circle><path d="m16 16 5 5"></path></svg>
                <input type="search" data-table-search="task-table" placeholder="Search task titles, statuses, or dates…">
            </label>
            <?php if (session()->get('isLoggedIn') === true): ?>
                <a class="button button--primary button--compact" href="<?= site_url('tasks/new') ?>">New task <span>&rarr;</span></a>
            <?php else: ?>
                <a class="button button--text" href="<?= site_url('login') ?>">Sign in to manage tasks</a>
            <?php endif ?>
        </div>

        <div class="table-card reveal reveal--late">
            <table id="task-table">
                <thead><tr><th>Task</th><th>Status</th><th>Scheduled date</th><th>Created</th><?php if (session()->get('isLoggedIn') === true): ?><th>Actions</th><?php endif ?></tr></thead>
                <tbody>
                <?php foreach ($tasks as $task): ?>
                    <tr>
                        <td data-label="Task"><strong class="task-title"><?= esc($task['title']) ?></strong></td>
                        <td data-label="Status"><span class="status status--<?= esc($task['status']) ?>"><?= esc($statusLabels[$task['status']] ?? ucfirst($task['status'])) ?></span></td>
                        <td data-label="Scheduled"><time datetime="<?= esc($task['task_date']) ?>"><?= esc(date('M j, Y', strtotime($task['task_date']))) ?></time></td>
                        <td data-label="Created"><time datetime="<?= esc($task['created_at']) ?>"><?= esc(date('M j, Y', strtotime($task['created_at']))) ?></time></td>
                        <?php if (session()->get('isLoggedIn') === true): ?>
                            <td data-label="Actions">
                                <div class="task-actions">
                                    <a class="table-action" href="<?= site_url('tasks/' . $task['id'] . '/edit') ?>">Edit</a>
                                    <form action="<?= site_url('tasks/' . $task['id'] . '/delete') ?>" method="post" onsubmit="return confirm('Archive this task? It will no longer appear on the public task pages.');">
                                        <?= csrf_field() ?>
                                        <button class="table-action table-action--danger" type="submit">Archive</button>
                                    </form>
                                </div>
                            </td>
                        <?php endif ?>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
            <div class="empty-state" hidden>No tasks match your search.</div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
