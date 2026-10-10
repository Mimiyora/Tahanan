<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php $statusLabels = ['pending' => 'Pending', 'in_progress' => 'In progress', 'completed' => 'Completed']; ?>
<section class="directory-header">
    <div class="shell directory-header__grid">
        <div><p class="context-line">The house rhythm</p><h1>All tasks</h1><p>Opening, service, and closing work for the days ahead.</p></div>
        <div class="directory-total"><strong><?= count($tasks) ?></strong><span>active <?= count($tasks) === 1 ? 'task' : 'tasks' ?></span></div>
    </div>
</section>

<section class="directory-section">
    <div class="shell">
        <?php if ($success): ?><div class="notice notice--success" role="status"><?= esc($success) ?></div><?php endif ?>
        <div class="directory-tools">
            <label class="search-box" for="task-search"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"></circle><path d="m16 16 5 5"></path></svg><span class="sr-only">Search tasks</span><input id="task-search" type="search" data-table-search="task-table" aria-controls="task-table" placeholder="Search titles, statuses, or dates"></label>
            <?php if (session()->get('isLoggedIn') === true): ?><a class="button button--primary button--compact" href="<?= site_url('tasks/new') ?>">Add to the day</a><?php else: ?><a class="text-link" href="<?= site_url('login') ?>">Staff sign in</a><?php endif ?>
        </div>
        <div class="table-wrap">
            <table id="task-table">
                <thead><tr><th>Task</th><th>Status</th><th>Scheduled</th><th>Created</th><?php if (session()->get('isLoggedIn') === true): ?><th>Actions</th><?php endif ?></tr></thead>
                <tbody>
                <?php foreach ($tasks as $task): ?>
                    <tr><td data-label="Task"><strong class="task-title"><?= esc($task['title']) ?></strong></td><td data-label="Status"><span class="status status--<?= esc($task['status']) ?>"><?= esc($statusLabels[$task['status']] ?? ucfirst($task['status'])) ?></span></td><td data-label="Scheduled"><time datetime="<?= esc($task['task_date']) ?>"><?= esc(date('M j, Y', strtotime($task['task_date']))) ?></time></td><td data-label="Created"><time datetime="<?= esc($task['created_at']) ?>"><?= esc(date('M j, Y', strtotime($task['created_at']))) ?></time></td><?php if (session()->get('isLoggedIn') === true): ?><td data-label="Actions"><div class="row-actions"><a class="table-action" href="<?= site_url('tasks/' . $task['id'] . '/edit') ?>">Edit</a><form action="<?= site_url('tasks/' . $task['id'] . '/delete') ?>" method="post" onsubmit="return confirm('Archive this task? It will no longer appear on the public task pages.');"><?= csrf_field() ?><button class="table-action table-action--danger" type="submit">Archive</button></form></div></td><?php endif ?></tr>
                <?php endforeach ?>
                </tbody>
            </table>
            <div class="empty-state" role="status" hidden>No tasks match your search. Try a different title, status, or date.</div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
