export function initTabs() {
    document.querySelectorAll('[data-tabs]').forEach((tabBar) => {
        const buttons = tabBar.querySelectorAll('[data-tab-filter]');
        const items = document.querySelectorAll('[data-tab-item]');
        if (!buttons.length || !items.length) return;

        buttons.forEach((btn) => {
            btn.addEventListener('click', () => {
                const filter = btn.getAttribute('data-tab-filter');
                buttons.forEach((b) => {
                    const active = b === btn;
                    b.classList.toggle('active', active);
                    b.setAttribute('aria-selected', active ? 'true' : 'false');
                });

                items.forEach((item) => {
                    const type = item.getAttribute('data-tab-item');
                    item.style.display = (filter === 'all' || type === filter) ? '' : 'none';
                });
            });
        });
    });
}
