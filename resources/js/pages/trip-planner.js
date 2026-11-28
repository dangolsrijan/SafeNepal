import { showToast } from '../components/toast.js';

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

export function initTripPlanner() {
    // Allow removing cards from generated planner itinerary preview
    const plannerItinerary = document.querySelector('[data-planner-itinerary]');
    if (plannerItinerary) {
        plannerItinerary.addEventListener('click', (e) => {
            const btn = e.target.closest('[data-remove-card]');
            if (!btn) return;
            btn.closest('[data-itinerary-card]')?.remove();
            showToast('Activity removed from itinerary preview.');
        });
    }

    // Interactive Traveler Trip Editor (frontend state)
    const editor = document.querySelector('[data-trip-editor]');
    const settingsForm = document.querySelector('[data-trip-settings-form]');
    if (!editor) return;

    const budgetInput = document.querySelector('[data-trip-budget-input]');
    const travelersInput = document.querySelector('[data-trip-travelers-input]');
    const estimatedTotalEl = document.querySelector('[data-trip-estimated-total]');
    const remainingEl = document.querySelector('[data-trip-budget-remaining]');
    const headingEl = document.querySelector('[data-trip-heading]');

    const recalculateTotals = () => {
        const travelers = Math.max(1, parseInt(travelersInput?.value || '1', 10));
        const budget = Math.max(0, parseInt(budgetInput?.value || '0', 10));
        let grandTotal = 0;

        editor.querySelectorAll('[data-trip-day]').forEach((dayEl) => {
            let dayTotal = 0;
            dayEl.querySelectorAll('[data-activity-item]').forEach((item) => {
                const perPerson = parseInt(item.getAttribute('data-activity-cost') || '0', 10);
                dayTotal += perPerson * travelers;
            });
            grandTotal += dayTotal;
            const dayBadge = dayEl.querySelector('[data-day-budget]');
            if (dayBadge) {
                dayBadge.textContent = `Daily Est: NPR ${dayTotal.toLocaleString()}`;
            }
        });

        if (estimatedTotalEl) {
            estimatedTotalEl.textContent = `NPR ${grandTotal.toLocaleString()}`;
        }
        if (remainingEl) {
            const diff = budget - grandTotal;
            remainingEl.textContent = `NPR ${diff.toLocaleString()}`;
            remainingEl.style.color = diff >= 0 ? 'var(--sn-low-fg)' : 'var(--sn-high-fg)';
        }
    };

    if (settingsForm) {
        settingsForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const titleVal = settingsForm.querySelector('input[name="title"]')?.value.trim();
            if (titleVal && headingEl) {
                headingEl.textContent = titleVal;
            }
            recalculateTotals();
            showToast('Trip settings updated in frontend preview.');
        });
        budgetInput?.addEventListener('input', recalculateTotals);
        travelersInput?.addEventListener('input', recalculateTotals);
    }

    editor.addEventListener('click', (e) => {
        const removeBtn = e.target.closest('[data-remove-activity]');
        if (!removeBtn) return;
        removeBtn.closest('[data-activity-item]')?.remove();
        recalculateTotals();
        showToast('Activity removed from itinerary preview.');
    });

    editor.querySelectorAll('[data-add-activity-form]').forEach((form) => {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            if (!form.reportValidity()) return;

            const dayEl = form.closest('[data-trip-day]');
            const list = dayEl?.querySelector('[data-day-activities]');
            if (!list) return;

            const data = new FormData(form);
            const title = String(data.get('title') || '').trim();
            const startTime = String(data.get('start_time') || '15:00').trim();
            const duration = String(data.get('duration_hours') || '2').trim();
            const cost = Math.max(0, parseInt(String(data.get('estimated_cost_npr') || '0'), 10));
            const location = String(data.get('location') || 'Nepal').trim();
            const description = String(data.get('description') || '').trim();

            list.querySelector('[data-day-empty]')?.remove();

            const item = document.createElement('div');
            item.className = 'sn-timeline-item';
            item.setAttribute('data-activity-item', '');
            item.setAttribute('data-activity-cost', String(cost));
            item.innerHTML = `
                <span class="sn-timeline-dot"></span>
                <div style="border:1px solid var(--sn-border);border-radius:10px;padding:1rem;background:var(--sn-bg);">
                    <div class="sn-flex-between sn-mb-1">
                        <strong style="color:var(--sn-forest);font-size:0.88rem;">⏰ ${escapeHtml(startTime)} • ${escapeHtml(duration)} hrs</strong>
                        <span style="font-weight:700;font-size:0.86rem;">NPR ${cost.toLocaleString()}/person</span>
                    </div>
                    <h4 style="margin:0.2rem 0;">${escapeHtml(title)}</h4>
                    ${description ? `<p class="sn-muted" style="font-size:0.85rem;margin:0 0 0.5rem;">${escapeHtml(description)}</p>` : ''}
                    <div class="sn-flex-between">
                        <span class="sn-muted" style="font-size:0.8rem;">📍 ${escapeHtml(location)}</span>
                        <button type="button" class="sn-btn sn-btn-ghost sn-btn-sm" data-remove-activity style="color:var(--sn-high-fg);">Remove Activity</button>
                    </div>
                </div>
            `;
            list.appendChild(item);

            form.reset();
            recalculateTotals();
            showToast(`Added "${title}" to your itinerary preview.`);
        });
    });

    recalculateTotals();
}
