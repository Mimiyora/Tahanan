<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="page-hero page-hero--story">
    <div class="shell page-hero__grid">
        <div class="reveal">
            <span class="eyebrow">Our story</span>
            <h1>A coffeehouse with<br><em>old soul.</em></h1>
        </div>
        <p class="page-intro reveal reveal--late">Tahanan began with a simple belief: the best cup of coffee feels like coming home. We pair Philippine-grown beans with the gracious rhythm of the old Filipino bahay.</p>
    </div>
</section>

<section class="story-section">
    <div class="shell story-grid">
        <div class="story-visual reveal">
            <div class="story-arch">
                <div class="sun-rays" aria-hidden="true"></div>
                <div class="coffee-cup" aria-hidden="true"><span></span></div>
                <p>Grown here.<br>Roasted with care.</p>
            </div>
        </div>
        <div class="story-copy reveal reveal--late">
            <div class="section-kicker"><span>01</span><p>Why Tahanan</p></div>
            <h2>Where craft meets <em>kapwa.</em></h2>
            <p>Our counter is inspired by the open windows, warm wood, and generous welcome of heritage homes across the Philippines. Behind every drink is a local story—from highland farms to neighborhood regulars.</p>
            <div class="value-list">
                <article><span>01</span><div><h3>Local by heart</h3><p>We celebrate beans and ingredients grown by Filipino hands.</p></div></article>
                <article><span>02</span><div><h3>Warm by nature</h3><p>Thoughtful service turns a quick coffee into a familiar ritual.</p></div></article>
                <article><span>03</span><div><h3>Simple by design</h3><p>Our POS keeps the team focused on people, not paperwork.</p></div></article>
            </div>
        </div>
    </div>
</section>

<section class="story-quote">
    <div class="shell">
        <span class="quote-mark">“</span>
        <blockquote>Sa bawat tasa, may kuwento.<br><em>In every cup, there is a story.</em></blockquote>
    </div>
</section>
<?= $this->endSection() ?>
