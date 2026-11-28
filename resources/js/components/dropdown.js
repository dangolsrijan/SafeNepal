export function initDropdowns() {
    const toggles = document.querySelectorAll('[data-dropdown-toggle]');
    if (!toggles.length) return;

    toggles.forEach((btn) => {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            const parent = btn.closest('.sn-dropdown');
            document.querySelectorAll('.sn-dropdown.open').forEach((d) => {
                if (d !== parent) {
                    d.classList.remove('open');
                    d.querySelector('[data-dropdown-toggle]')?.setAttribute('aria-expanded', 'false');
                }
            });
            const isOpen = parent?.classList.toggle('open');
            btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });
    });

    document.addEventListener('click', () => {
        document.querySelectorAll('.sn-dropdown.open').forEach((d) => {
            d.classList.remove('open');
            d.querySelector('[data-dropdown-toggle]')?.setAttribute('aria-expanded', 'false');
        });
    });
}
