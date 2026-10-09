<?= $this->extend('layouts/coffeehouse') ?>

<?= $this->section('content') ?>
<section class="directory-header directory-header--sage"><div class="shell directory-header__grid"><div><p class="context-line">Guest directory</p><h1>Customer accounts</h1><p>Regulars, neighbors, and new friends who gather at Tahanan.</p></div><div class="directory-total"><strong><?= count($customers) ?></strong><span>active customers</span></div></div></section>
<section class="directory-section"><div class="shell">
    <?php if (session('success')): ?><div class="notice notice--success" role="status"><?= esc(session('success')) ?></div><?php endif ?>
    <div class="directory-tools"><label class="search-box" for="customer-search"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"></circle><path d="m16 16 5 5"></path></svg><span class="sr-only">Search customers</span><input id="customer-search" type="search" data-table-search="customer-table" aria-controls="customer-table" placeholder="Search customer records"></label><a class="button button--primary button--compact" href="<?= site_url('customers/new') ?>">New customer</a></div>
    <div class="table-wrap"><table id="customer-table"><thead><tr><th>Customer</th><th>Email address</th><th>Phone number</th><th>Action</th></tr></thead><tbody>
    <?php foreach ($customers as $customer): ?><?php $phone = $customer['phone'] ?: 'Not provided'; ?><tr><td data-label="Customer"><div class="identity"><span class="avatar"><?= esc($customer['initials']) ?></span><strong><?= esc($customer['full_name']) ?></strong></div></td><td data-label="Email"><a href="mailto:<?= esc($customer['email']) ?>"><?= esc($customer['email']) ?></a></td><td data-label="Phone"><?php if ($customer['phone']): ?><a href="tel:<?= esc(str_replace(' ', '', $customer['phone'])) ?>"><?= esc($phone) ?></a><?php else: ?><?= esc($phone) ?><?php endif ?></td><td data-label="Action"><a class="table-action" href="<?= site_url('customers/' . $customer['id'] . '/edit') ?>">Edit</a></td></tr><?php endforeach ?>
    </tbody></table><div class="empty-state" role="status" hidden>No customer records match your search. Check the name, email, or phone number.</div></div>
</div></section>
<?= $this->endSection() ?>
