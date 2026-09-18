<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="hero">
    <div class="shell hero-grid">
        <div class="hero-copy reveal">
            <span class="eyebrow">Heritage brews · Modern service</span>
            <h1>Rooted in tradition.<br><em>Ready for every order.</em></h1>
            <p class="hero-lede">A simple point-of-sale home for the people who make our coffeehouse feel like home—our guests and our team.</p>
            <div class="hero-actions">
                <a class="button button--primary" href="<?= site_url('customers') ?>">View customers <span>→</span></a>
                <a class="button button--text" href="<?= site_url('about') ?>">Discover our story</a>
            </div>
            <div class="hero-proof" aria-label="Store highlights">
                <div><strong>24</strong><span>local growers</span></div>
                <div><strong>2019</strong><span>doors opened</span></div>
                <div><strong>100%</strong><span>Philippine beans</span></div>
            </div>
        </div>

        <div class="heritage-scene reveal reveal--late" aria-label="A stylized Filipino heritage coffeehouse facade">
            <div class="sun-disc"></div>
            <div class="leaf leaf--one"></div>
            <div class="leaf leaf--two"></div>
            <div class="house">
                <div class="roof"><span></span></div>
                <div class="upper-floor">
                    <div class="capiz-window"><i></i><i></i><i></i><i></i><i></i><i></i></div>
                    <div class="capiz-window"><i></i><i></i><i></i><i></i><i></i><i></i></div>
                    <div class="capiz-window"><i></i><i></i><i></i><i></i><i></i><i></i></div>
                </div>
                <div class="lower-floor">
                    <div class="arch arch--window"></div>
                    <div class="arch arch--door"><span>T</span></div>
                    <div class="arch arch--window"></div>
                </div>
                <div class="house-step"></div>
            </div>
            <div class="counter-card">
                <div class="counter-card__top"><span>Today’s counter</span><span class="live-dot">Live</span></div>
                <div class="counter-total"><small>Orders served</small><strong>128</strong></div>
                <div class="mini-bars" aria-hidden="true"><i style="--h:42%"></i><i style="--h:68%"></i><i style="--h:54%"></i><i style="--h:86%"></i><i style="--h:72%"></i><i style="--h:100%"></i><i style="--h:82%"></i></div>
            </div>
        </div>
    </div>
</section>

<section class="home-links">
    <div class="shell">
        <div class="section-kicker"><span>01</span><p>Quick access</p></div>
        <div class="portal-grid">
            <a class="portal-card portal-card--clay" href="<?= site_url('customers') ?>">
                <span class="portal-icon" aria-hidden="true">☕</span>
                <div><small>Guest directory</small><h2>Customer<br>Accounts</h2></div>
                <span class="circle-arrow">↗</span>
            </a>
            <a class="portal-card portal-card--green" href="<?= site_url('users') ?>">
                <span class="portal-icon" aria-hidden="true">✦</span>
                <div><small>People behind the counter</small><h2>User<br>Accounts</h2></div>
                <span class="circle-arrow">↗</span>
            </a>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
