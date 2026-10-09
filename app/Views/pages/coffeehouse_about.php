<?= $this->extend('layouts/coffeehouse') ?>

<?= $this->section('content') ?>
<section class="story-hero">
    <div class="shell story-hero__grid">
        <div class="story-hero__copy"><p class="context-line">Our story</p><h1>A coffeehouse with an old soul.</h1><p>Tahanan began with a simple belief: the best cup of coffee feels like coming home. We pair Philippine-grown beans with the gracious rhythm of the old Filipino bahay.</p></div>
        <figure class="capiz-photo story-photo"><img src="<?= base_url('assets/images/tahanan-pour.webp') ?>" alt="Coffee prepared by hand with a brass kettle beside sunlit capiz windows"></figure>
    </div>
</section>

<section class="story-section">
    <div class="shell story-grid">
        <div><p class="context-line">Why Tahanan</p><h2>Craft shaped by kapwa</h2></div>
        <div class="story-copy">
            <p>Our counter is inspired by open windows, warm wood, and the generous welcome of heritage homes across the Philippines. Behind every drink is a local story—from highland farms to neighborhood regulars.</p>
            <dl class="principle-list">
                <div><dt>Local by heart</dt><dd>We celebrate Philippine beans and the growers who bring them to the table.</dd></div>
                <div><dt>Warm by nature</dt><dd>Service begins with attention, ease, and room for people to belong.</dd></div>
                <div><dt>Simple by design</dt><dd>Good coffee, honest materials, and tools that help the team do good work.</dd></div>
            </dl>
        </div>
    </div>
</section>

<blockquote class="house-quote"><div class="shell"><p>Sa bawat tasa, may kuwento.</p><footer>In every cup, there is a story.</footer></div></blockquote>
<?= $this->endSection() ?>
