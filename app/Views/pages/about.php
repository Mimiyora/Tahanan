<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="page-intro-section">
    <div class="shell intro-grid">
        <div><p class="context-line">About the system</p><h1>Daily work, held in one clear place.</h1></div>
        <p>Tasks for Today separates the work due now from the complete schedule, giving the Tahanan team a useful daily view without losing sight of what comes next.</p>
    </div>
</section>

<section class="content-section">
    <div class="shell story-grid">
        <div><p class="context-line">Built around the day ahead</p><h2>A practical home for planning</h2></div>
        <div class="story-copy"><p>The application uses CodeIgniter’s model-view-controller structure and a MySQL database. The welcome page filters records by the current date, while the full task list reads from the same active task table.</p><dl class="facts-list"><div><dt>Framework</dt><dd>CodeIgniter 4</dd></div><div><dt>Data layer</dt><dd>MySQL</dd></div><div><dt>Developer</dt><dd>Gerard Doroja</dd></div><div><dt>Course</dt><dd>IT0049 Web System Technologies</dd></div></dl></div>
    </div>
</section>
<?= $this->endSection() ?>
