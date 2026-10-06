<?= $this->extend('layouts/coffeehouse') ?>

<?= $this->section('content') ?>
<section class="directory-hero">
    <div class="shell directory-heading reveal">
        <div>
            <span class="eyebrow">Guest directory</span>
            <h1>Customer <em>Accounts</em></h1>
            <p>Our community of regulars, neighbors, and new friends.</p>
        </div>
        <div class="record-count"><strong><?= count($customers) ?></strong><span>active<br>customers</span></div>
    </div>
</section>

<section class="directory-section">
    <div class="shell">
        <div class="directory-tools">
            <label class="search-box">
                <span class="sr-only">Search customers</span>
                <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"></circle><path d="m16 16 5 5"></path></svg>
                <input type="search" data-table-search="customer-table" placeholder="Search customer records…">
            </label>
            <a class="button button--primary button--compact" href="<?= site_url('customers/new') ?>">New customer <span>+</span></a>
        </div>

        <?php if (session('success')): ?>
            <div class="notice notice--success" role="status"><?= esc(session('success')) ?></div>
        <?php endif ?>

        <div class="table-card reveal reveal--late">
            <table id="customer-table">
                <thead><tr><th>Customer</th><th>Email address</th><th>Phone number</th><th><span class="sr-only">Actions</span></th></tr></thead>
                <tbody>
                <?php foreach ($customers as $customer): ?>
                    <?php $phone = $customer['phone'] ?: 'Not provided'; ?>
                    <tr>
                        <td data-label="Customer"><div class="identity"><span class="avatar"><?= esc($customer['initials']) ?></span><strong><?= esc($customer['full_name']) ?></strong></div></td>
                        <td data-label="Email"><a href="mailto:<?= esc($customer['email']) ?>"><?= esc($customer['email']) ?></a></td>
                        <td data-label="Phone">
                            <?php if ($customer['phone']): ?>
                                <a href="tel:<?= esc(str_replace(' ', '', $customer['phone'])) ?>"><?= esc($phone) ?></a>
                            <?php else: ?>
                                <?= esc($phone) ?>
                            <?php endif ?>
                        </td>
                        <td data-label="Action"><a class="table-action" href="<?= site_url('customers/' . $customer['id'] . '/edit') ?>">Edit</a></td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
            <div class="empty-state" hidden>No customer records match your search.</div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
