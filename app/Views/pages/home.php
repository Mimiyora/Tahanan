<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php
$taskCount = count($tasks);
$progress = $taskCount > 0 ? (int) round(($completed / $taskCount) * 100) : 0;
$statusLabels = ['pending' => 'Pending', 'in_progress' => 'In progress', 'completed' => 'Completed'];
?>
<section class="today-hero">
    <div class="shell today-hero__grid">
        <div class="hero-copy">
            <p class="context-line">Tahanan Today · <?= esc(date('l, F j, Y', strtotime($today))) ?></p>
            <h1>Make space for today.</h1>
            <p class="hero-lede">Begin with the care behind every warm welcome, well-made cup, and ready table.</p>
            <div class="hero-actions">
                <a class="button button--primary" href="#today-tasks">View today’s tasks</a>
                <a class="text-link" href="<?= site_url('tasks') ?>">See the full schedule</a>
                <?php if (session()->get('isLoggedIn') === true): ?>
                    <a class="text-link" href="<?= site_url('tasks/new') ?>">Add a task</a>
                <?php endif ?>
            </div>
        </div>

        <aside class="today-summary" aria-label="Today’s task summary">
            <time class="today-summary__date" datetime="<?= esc($today) ?>">
                <strong><?= esc(date('j', strtotime($today))) ?></strong>
                <span><?= esc(date('F', strtotime($today))) ?></span>
            </time>
            <div class="today-summary__progress">
                <div class="summary-copy"><span>Today’s progress</span><strong><?= $completed ?> of <?= $taskCount ?> complete</strong></div>
                <div class="progress" role="progressbar" aria-label="Tasks completed" aria-valuemin="0" aria-valuemax="100" aria-valuenow="<?= $progress ?>">
                    <span style="width: <?= $progress ?>%"></span>
                </div>
                <p><?= $progress ?>% finished</p>
            </div>
        </aside>
    </div>
</section>

<section id="today-tasks" class="task-section">
    <div class="shell">
        <div class="section-heading">
            <div><p class="context-line">Today at Tahanan</p><h2>Keep the house in rhythm</h2></div>
            <span class="record-count-inline"><?= $taskCount ?> <?= $taskCount === 1 ? 'task' : 'tasks' ?></span>
        </div>

        <?php if ($tasks === []): ?>
            <div class="empty-panel">
                <span class="empty-panel__mark" aria-hidden="true">✓</span>
                <div><h3>No tasks scheduled for today</h3><p>Everything is clear. Review the full schedule to see what comes next.</p></div>
                <a class="button button--primary" href="<?= site_url('tasks') ?>">Open all tasks</a>
            </div>
        <?php else: ?>
            <div class="task-ledger">
                <?php foreach ($tasks as $task): ?>
                    <article class="task-row task-row--<?= esc($task['status']) ?>">
                        <span class="task-row__state" aria-hidden="true"></span>
                        <div class="task-row__copy"><h3><?= esc($task['title']) ?></h3><p>Scheduled for today</p></div>
                        <span class="status status--<?= esc($task['status']) ?>"><?= esc($statusLabels[$task['status']] ?? ucfirst($task['status'])) ?></span>
                    </article>
                <?php endforeach ?>
            </div>
        <?php endif ?>
    </div>
</section>
<?= $this->endSection() ?>
