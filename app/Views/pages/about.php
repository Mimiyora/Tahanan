<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="page-hero">
    <div class="shell page-hero__grid">
        <div class="reveal">
            <span class="eyebrow">About the system</span>
            <h1>Simple planning.<br><em>Clear priorities.</em></h1>
        </div>
        <p class="page-intro reveal reveal--late">Tasks for Today separates the work due now from the complete schedule, giving a team a useful daily dashboard without losing sight of what comes next.</p>
    </div>
</section>

<section class="about-section">
    <div class="shell about-grid">
        <div>
            <span class="section-label">Purpose</span>
            <h2>Built around the day ahead</h2>
        </div>
        <div class="about-copy">
            <p>The application uses CodeIgniter’s model-view-controller structure and a MySQL database. The welcome page filters records by the current date, while the full task list reads from the same table without that filter.</p>
            <dl class="facts">
                <div><dt>Framework</dt><dd>CodeIgniter 4</dd></div>
                <div><dt>Data layer</dt><dd>MySQL</dd></div>
                <div><dt>Developer</dt><dd>Gerard Doroja</dd></div>
                <div><dt>Course</dt><dd>IT0049 Web System Technologies</dd></div>
            </dl>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
