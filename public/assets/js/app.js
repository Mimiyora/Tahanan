const navToggle = document.querySelector('.nav-toggle');
const siteNav = document.querySelector('.site-nav');

if (navToggle && siteNav) {
    navToggle.addEventListener('click', () => {
        const open = navToggle.getAttribute('aria-expanded') === 'true';
        navToggle.setAttribute('aria-expanded', String(!open));
        siteNav.classList.toggle('is-open', !open);
    });
}

document.querySelectorAll('[data-table-search]').forEach((input) => {
    const table = document.getElementById(input.dataset.tableSearch);
    const rows = table ? [...table.querySelectorAll('tbody tr')] : [];
    const emptyState = table?.parentElement.querySelector('.empty-state');

    input.addEventListener('input', () => {
        const query = input.value.trim().toLowerCase();
        let visible = 0;

        rows.forEach((row) => {
            const matches = row.textContent.toLowerCase().includes(query);
            row.hidden = !matches;
            if (matches) visible += 1;
        });

        if (emptyState) emptyState.hidden = visible !== 0;
    });
});
