const navToggle = document.querySelector('.nav-toggle');
const siteNav = document.querySelector('.site-nav');

function setNavigation(open) {
    if (!navToggle || !siteNav) return;
    navToggle.setAttribute('aria-expanded', String(open));
    siteNav.classList.toggle('is-open', open);
    const label = navToggle.querySelector('.nav-toggle__label');
    if (label) label.textContent = open ? 'Close' : 'Menu';
}

if (navToggle && siteNav) {
    navToggle.addEventListener('click', () => {
        setNavigation(navToggle.getAttribute('aria-expanded') !== 'true');
    });

    siteNav.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => setNavigation(false));
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && navToggle.getAttribute('aria-expanded') === 'true') {
            setNavigation(false);
            navToggle.focus();
        }
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth > 1120) setNavigation(false);
    });
}

document.querySelectorAll('.manage-menu').forEach((menu) => {
    document.addEventListener('click', (event) => {
        if (menu.open && !menu.contains(event.target)) menu.removeAttribute('open');
    });
});

document.querySelectorAll('[data-table-search]').forEach((input) => {
    const table = document.getElementById(input.dataset.tableSearch);
    const rows = table ? [...table.querySelectorAll('tbody tr')] : [];
    const emptyState = table?.parentElement.querySelector('.empty-state');

    input.addEventListener('input', () => {
        const query = input.value.trim().toLocaleLowerCase();
        let visible = 0;

        rows.forEach((row) => {
            const matches = row.textContent.toLocaleLowerCase().includes(query);
            row.hidden = !matches;
            if (matches) visible += 1;
        });

        if (emptyState) emptyState.hidden = visible !== 0;
    });
});

const avatarInput = document.querySelector('[data-avatar-input]');
const avatarPreview = document.querySelector('[data-avatar-preview]');
let avatarPreviewUrl;

if (avatarInput && avatarPreview) {
    avatarInput.addEventListener('change', () => {
        const [file] = avatarInput.files;
        if (!file || !file.type.startsWith('image/')) return;
        if (avatarPreviewUrl) URL.revokeObjectURL(avatarPreviewUrl);
        avatarPreviewUrl = URL.createObjectURL(file);
        avatarPreview.src = avatarPreviewUrl;
        avatarPreview.alt = `Preview of ${file.name}`;
    });

    avatarInput.form?.addEventListener('submit', async (event) => {
        const form = event.currentTarget;
        const [file] = avatarInput.files;

        if (!file || form.dataset.avatarPrepared === 'true') return;

        event.preventDefault();
        avatarInput.setCustomValidity('');

        if (file.size > 2 * 1024 * 1024) {
            avatarInput.setCustomValidity('The profile picture must be 2 MB or smaller.');
            avatarInput.reportValidity();
            return;
        }

        try {
            const bitmap = await createImageBitmap(file, { imageOrientation: 'from-image' });
            const size = Math.min(bitmap.width, bitmap.height);
            const sourceX = (bitmap.width - size) / 2;
            const sourceY = (bitmap.height - size) / 2;
            const canvas = document.createElement('canvas');
            canvas.width = 320;
            canvas.height = 320;
            const context = canvas.getContext('2d');
            context.fillStyle = '#fff9ef';
            context.fillRect(0, 0, 320, 320);
            context.drawImage(bitmap, sourceX, sourceY, size, size, 0, 0, 320, 320);
            bitmap.close();

            const prepared = await new Promise((resolve) => canvas.toBlob(resolve, 'image/jpeg', 0.86));
            if (!prepared) throw new Error('The browser could not prepare this image.');

            const transfer = new DataTransfer();
            transfer.items.add(new File([prepared], 'avatar.jpg', { type: 'image/jpeg' }));
            avatarInput.files = transfer.files;
            form.dataset.avatarPrepared = 'true';
            form.requestSubmit(event.submitter || undefined);
        } catch {
            avatarInput.setCustomValidity('The image could not be prepared. Choose another JPG or PNG file.');
            avatarInput.reportValidity();
        }
    });
}
