<?= $this->extend('layouts/coffeehouse') ?>

<?= $this->section('content') ?>
<section class="coffeehouse-hero">
    <div class="shell coffeehouse-hero__grid">
        <div class="reveal">
            <span class="eyebrow">Heritage brews · Modern service</span>
            <h1>Rooted in tradition.<br><em>Ready for every order.</em></h1>
            <p class="hero-lede">A simple point-of-sale home for the people who make our coffeehouse feel like home—our guests and our team.</p>
            <div class="hero-actions">
                <a class="button button--primary" href="<?= site_url('customers') ?>">View customers <span>→</span></a>
                <a class="button button--text" href="<?= site_url('coffeehouse/about') ?>">Discover our story</a>
            </div>
            <div class="coffeehouse-stats" aria-label="Store highlights">
                <div><strong>24</strong><span>local growers</span></div>
                <div><strong>2019</strong><span>doors opened</span></div>
                <div><strong>100%</strong><span>Philippine beans</span></div>
            </div>
        </div>

        <div class="coffeehouse-emblem reveal reveal--late" aria-label="Tahanan Coffee House identity">
            <div class="coffeehouse-emblem__sun"></div>
            <div class="coffeehouse-emblem__house" aria-hidden="true">
                <span class="roof-line"></span>
                <span class="house-body"><i></i><i></i><i></i></span>
            </div>
            <p>Grown here.<br><em>Served like home.</em></p>
        </div>
    </div>
</section>

<section class="coffeehouse-portals">
    <div class="shell">
        <div class="section-heading">
            <div><span class="section-label">Quick access</span><h2>People at Tahanan</h2></div>
        </div>
        <div class="portal-grid">
            <a class="portal-card portal-card--clay" href="<?= site_url('customers') ?>">
                <span>Guest directory</span><h3>Customer<br>Accounts</h3><b>↗</b>
            </a>
            <a class="portal-card portal-card--green" href="<?= site_url('users') ?>">
                <span>People behind the counter</span><h3>User<br>Accounts</h3><b>↗</b>
            </a>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
