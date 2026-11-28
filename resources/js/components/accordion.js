export function initAccordions() {
    document.querySelectorAll('[data-accordion]').forEach((accordion) => {
        const items = accordion.querySelectorAll('[data-accordion-item]');

        items.forEach((item) => {
            const trigger = item.querySelector('[data-accordion-trigger]');
            if (!trigger) return;

            trigger.addEventListener('click', () => {
                const isOpen = item.classList.contains('open');

                items.forEach((other) => {
                    other.classList.remove('open');
                    other.querySelector('[data-accordion-trigger]')?.setAttribute('aria-expanded', 'false');
                });

                if (!isOpen) {
                    item.classList.add('open');
                    trigger.setAttribute('aria-expanded', 'true');
                }
            });
        });
    });
}
