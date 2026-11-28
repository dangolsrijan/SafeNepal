export function initNavigation() {
    const mobileToggle = document.querySelector('[data-mobile-nav-toggle]');
    const mobileDrawer = document.querySelector('[data-mobile-nav-drawer]');
    if (mobileToggle && mobileDrawer) {
        mobileToggle.addEventListener('click', () => {
            const expanded = mobileDrawer.classList.toggle('open');
            mobileToggle.setAttribute('aria-expanded', expanded ? 'true' : 'false');
        });
    }

    const dashToggle = document.querySelector('[data-dash-sidebar-toggle]');
    const dashSidebar = document.querySelector('[data-dash-sidebar]');
    if (dashToggle && dashSidebar) {
        dashToggle.addEventListener('click', () => {
            dashSidebar.classList.toggle('open');
        });
    }

    const header = document.querySelector('[data-site-header]');
    if (header && !header.classList.contains('is-scrolled')) {
        const syncScroll = () => {
            header.classList.toggle('is-scrolled', window.scrollY > 40);
        };
        window.addEventListener('scroll', syncScroll, { passive: true });
        syncScroll();
    }
}
