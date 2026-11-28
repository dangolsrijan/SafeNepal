export function initBookingCalculator() {
    const travelersInput = document.querySelector('[data-booking-travelers]');
    const unitPriceEl = document.querySelector('[data-booking-unit-price]');
    const totalPriceEl = document.querySelector('[data-booking-total-price]');
    if (!travelersInput || !unitPriceEl || !totalPriceEl) return;

    const unitPrice = parseInt(unitPriceEl.getAttribute('data-booking-unit-price') || '0', 10);
    const updateTotal = () => {
        const count = Math.max(1, parseInt(travelersInput.value || '1', 10));
        totalPriceEl.textContent = 'NPR ' + (count * unitPrice).toLocaleString();
    };

    travelersInput.addEventListener('input', updateTotal);
    updateTotal();
}
