<?= $this->extend('layouts/coffeehouse') ?>

<?= $this->section('content') ?>
<section class="page-hero page-hero--coffeehouse">
    <div class="shell page-hero__grid">
        <div class="reveal">
            <span class="eyebrow">Our story</span>
            <h1>A coffeehouse with<br><em>old soul.</em></h1>
        </div>
        <p class="page-intro reveal reveal--late">Tahanan began with a simple belief: the best cup of coffee feels like coming home. We pair Philippine-grown beans with the gracious rhythm of the old Filipino bahay.</p>
    </div>
</section>

<section class="coffeehouse-story">
    <div class="shell about-grid">
        <div>
            <span class="section-label">Why Tahanan</span>
            <h2>Where craft meets <em>kapwa.</em></h2>
        </div>
        <div class="about-copy">
            <p>Our counter is inspired by the open windows, warm wood, and generous welcome of heritage homes across the Philippines. Behind every drink is a local story—from highland farms to neighborhood regulars.</p>
            <dl class="facts">
                <div><dt>01</dt><dd>Local by heart</dd></div>
                <div><dt>02</dt><dd>Warm by nature</dd></div>
                <div><dt>03</dt><dd>Simple by design</dd></div>
            </dl>
        </div>
    </div>
</section>

<section class="coffeehouse-quote">
    <div class="shell"><p>Sa bawat tasa, may kuwento.<br><em>In every cup, there is a story.</em></p></div>
</section>
<?= $this->endSection() ?>
