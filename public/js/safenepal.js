document.addEventListener('DOMContentLoaded', () => {
    // Public mobile navigation drawer
    const mobileToggle = document.querySelector('[data-mobile-nav-toggle]');
    const mobileDrawer = document.querySelector('[data-mobile-nav-drawer]');
    if (mobileToggle && mobileDrawer) {
        mobileToggle.addEventListener('click', () => {
            const expanded = mobileDrawer.classList.toggle('open');
            mobileToggle.setAttribute('aria-expanded', expanded ? 'true' : 'false');
        });
    }

    // Dashboard sidebar mobile toggle
    const dashToggle = document.querySelector('[data-dash-sidebar-toggle]');
    const dashSidebar = document.querySelector('[data-dash-sidebar]');
    if (dashToggle && dashSidebar) {
        dashToggle.addEventListener('click', () => {
            dashSidebar.classList.toggle('open');
        });
    }

    // Dropdown menus
    document.querySelectorAll('[data-dropdown-toggle]').forEach((btn) => {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            const parent = btn.closest('.sn-dropdown');
            document.querySelectorAll('.sn-dropdown.open').forEach((d) => {
                if (d !== parent) d.classList.remove('open');
            });
            parent?.classList.toggle('open');
        });
    });

    document.addEventListener('click', () => {
        document.querySelectorAll('.sn-dropdown.open').forEach((d) => d.classList.remove('open'));
    });

    // Accessible Modals
    document.querySelectorAll('[data-modal-open]').forEach((trigger) => {
        trigger.addEventListener('click', () => {
            const id = trigger.getAttribute('data-modal-open');
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.add('open');
                modal.setAttribute('aria-hidden', 'false');
            }
        });
    });

    document.querySelectorAll('[data-modal-close]').forEach((closer) => {
        closer.addEventListener('click', () => {
            const modal = closer.closest('.sn-modal-backdrop');
            if (modal) {
                modal.classList.remove('open');
                modal.setAttribute('aria-hidden', 'true');
            }
        });
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            document.querySelectorAll('.sn-modal-backdrop.open').forEach((m) => {
                m.classList.remove('open');
                m.setAttribute('aria-hidden', 'true');
            });
        }
    });

    // Registration role switcher (show agency fields only for agency role)
    const roleInputs = document.querySelectorAll('input[name="role"]');
    const agencyFields = document.getElementById('agency-registration-fields');
    if (roleInputs.length && agencyFields) {
        const syncAgencyFields = () => {
            const selected = document.querySelector('input[name="role"]:checked')?.value;
            agencyFields.style.display = selected === 'agency' ? 'block' : 'none';
        };
        roleInputs.forEach((input) => input.addEventListener('change', syncAgencyFields));
        syncAgencyFields();
    }

    // Image gallery thumbnail switcher
    document.querySelectorAll('[data-gallery-thumb]').forEach((thumb) => {
        thumb.addEventListener('click', () => {
            const targetId = thumb.getAttribute('data-gallery-target');
            const src = thumb.getAttribute('data-gallery-src');
            const mainImg = document.getElementById(targetId);
            if (mainImg && src) {
                mainImg.src = src;
            }
        });
    });

    // Booking total price live calculator
    const travelersInput = document.querySelector('[data-booking-travelers]');
    const unitPriceEl = document.querySelector('[data-booking-unit-price]');
    const totalPriceEl = document.querySelector('[data-booking-total-price]');
    if (travelersInput && unitPriceEl && totalPriceEl) {
        const unitPrice = parseInt(unitPriceEl.getAttribute('data-booking-unit-price') || '0', 10);
        const updateTotal = () => {
            const count = Math.max(1, parseInt(travelersInput.value || '1', 10));
            totalPriceEl.textContent = 'NPR ' + (count * unitPrice).toLocaleString();
        };
        travelersInput.addEventListener('input', updateTotal);
        updateTotal();
    }
});
