<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php
$taskCount = count($tasks);
$progress = $taskCount > 0 ? (int) round(($completed / $taskCount) * 100) : 0;
$statusLabels = [
    'pending'     => 'Pending',
    'in_progress' => 'In progress',
    'completed'   => 'Completed',
];
?>
<section class="dashboard-hero">
    <div class="shell dashboard-hero__grid">
        <div class="reveal">
            <span class="eyebrow">Daily dashboard</span>
            <h1>Make space for<br><em>today.</em></h1>
            <p class="hero-lede">A focused list of tasks scheduled for <?= esc(date('l, F j, Y', strtotime($today))) ?>.</p>
            <div class="hero-actions">
                <a class="button button--primary" href="#today-tasks">View today’s tasks <span>↓</span></a>
                <a class="button button--text" href="<?= site_url('tasks') ?>">See the full task list</a>
            </div>
        </div>

        <aside class="day-summary reveal reveal--late" aria-label="Today’s task summary">
            <div class="day-summary__date"><span><?= esc(date('M', strtotime($today))) ?></span><strong><?= esc(date('j', strtotime($today))) ?></strong></div>
            <div class="day-summary__copy">
                <small>Today’s progress</small>
                <strong><?= $completed ?> of <?= $taskCount ?> complete</strong>
                <div class="progress" role="progressbar" aria-label="Tasks completed" aria-valuemin="0" aria-valuemax="100" aria-valuenow="<?= $progress ?>">
                    <span style="width: <?= $progress ?>%"></span>
                </div>
                <p><?= $progress ?>% of today’s work is finished.</p>
            </div>
        </aside>
    </div>
</section>

<section id="today-tasks" class="task-section">
    <div class="shell">
        <div class="section-heading">
            <div>
                <span class="section-label">Today</span>
                <h2>Your focused list</h2>
            </div>
            <span class="record-pill"><?= $taskCount ?> <?= $taskCount === 1 ? 'task' : 'tasks' ?></span>
        </div>

        <?php if ($tasks === []): ?>
            <div class="empty-panel">
                <span aria-hidden="true">✓</span>
                <h3>No tasks scheduled for today</h3>
                <p>Everything is clear. Review the full list to see what is coming next.</p>
                <a class="button button--primary" href="<?= site_url('tasks') ?>">Open all tasks <span>→</span></a>
            </div>
        <?php else: ?>
            <div class="task-grid">
                <?php foreach ($tasks as $index => $task): ?>
                    <article class="task-card task-card--<?= esc($task['status']) ?> reveal">
                        <div class="task-card__top">
                            <span class="task-number"><?= str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) ?></span>
                            <span class="status status--<?= esc($task['status']) ?>"><?= esc($statusLabels[$task['status']] ?? ucfirst($task['status'])) ?></span>
                        </div>
                        <h3><?= esc($task['title']) ?></h3>
                        <p>Scheduled for today</p>
                    </article>
                <?php endforeach ?>
            </div>
        <?php endif ?>
    </div>
</section>
<?= $this->endSection() ?>
