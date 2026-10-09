<?= $this->extend('layouts/coffeehouse') ?>

<?= $this->section('content') ?>
<section class="coffee-hero">
    <div class="shell coffee-hero__grid">
        <div class="coffee-hero__copy">
            <p class="context-line">Philippine coffee, served like home</p>
            <h1>Rooted in tradition. Ready for the day.</h1>
            <p class="hero-lede">Tahanan brings locally grown coffee, generous service, and the quiet warmth of a Filipino home to one shared table.</p>
            <div class="hero-actions">
                <a class="button button--primary" href="<?= site_url('coffeehouse/about') ?>">Read our story</a>
                <?php if (session()->get('isLoggedIn') === true): ?>
                    <a class="text-link" href="<?= site_url('customers') ?>">Open customer accounts</a>
                <?php else: ?>
                    <a class="text-link" href="<?= site_url('login') ?>">Staff log in</a>
                <?php endif ?>
            </div>
            <dl class="coffee-facts" aria-label="Coffee House highlights">
                <div><dt>24</dt><dd>local growers</dd></div>
                <div><dt>2019</dt><dd>doors opened</dd></div>
                <div><dt>100%</dt><dd>Philippine beans</dd></div>
            </dl>
        </div>
        <figure class="coffee-hero__image capiz-photo">
            <img src="<?= base_url('assets/images/tahanan-hero.webp') ?>" alt="Bright Tahanan Coffee House interior with barako coffee, warm wood, and capiz windows">
        </figure>
    </div>
</section>

<section class="welcome-section">
    <div class="shell welcome-grid">
        <div class="welcome-copy"><p class="context-line">One house, two ways in</p><h2>Come for the coffee. Stay for the people.</h2><p>Guests can learn our story and meet the legacy team. Signed-in staff can keep customer and user accounts close at hand.</p></div>
        <div class="portal-list">
            <a href="<?= site_url('coffeehouse/about') ?>"><span>Our story</span><strong>How Tahanan came home</strong></a>
            <a href="<?= site_url('coffeehouse/team') ?>"><span>Legacy team</span><strong>Meet the original six</strong></a>
            <a href="<?= site_url('customers') ?>"><span>Customer accounts</span><strong>Care for the guest directory</strong></a>
            <a href="<?= site_url('users') ?>"><span>User accounts</span><strong>Manage the people behind the counter</strong></a>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
