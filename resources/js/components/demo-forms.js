import { showToast } from './toast.js';

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

export function initDemoForms() {
    // Generic demo forms (inquiries, profile preview, planner save)
    document.querySelectorAll('[data-demo-form]').forEach((form) => {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            if (!form.reportValidity()) return;
            const message = form.getAttribute('data-demo-message') || 'Demo action completed in frontend preview.';
            showToast(message);
            form.reset();
        });
    });

    // Demo review preview form
    document.querySelectorAll('[data-demo-review-form]').forEach((form) => {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            if (!form.reportValidity()) return;

            const container = form.closest('.sn-card');
            const list = container?.querySelector('[data-review-list]');
            const countEl = container?.querySelector('[data-review-count]');
            const emptyEl = container?.querySelector('[data-review-empty]');
            if (!list) return;

            const data = new FormData(form);
            const author = form.getAttribute('data-author-name') || 'Demo Traveler';
            const rating = data.get('rating') || '5';
            const title = String(data.get('title') || '').trim();
            const comment = String(data.get('comment') || '').trim();

            emptyEl?.remove();

            const wrapper = document.createElement('div');
            wrapper.className = 'sn-mb-2';
            wrapper.innerHTML = `
                <article class="sn-card" style="padding:1.25rem;">
                    <div class="sn-flex-between sn-mb-1">
                        <div>
                            <strong style="color:var(--sn-ink);">${escapeHtml(author)}</strong>
                            <span class="sn-muted" style="margin-left:0.5rem;font-size:0.8rem;">Just now (Demo)</span>
                        </div>
                        <span style="font-weight:800;color:var(--sn-forest);">★ ${escapeHtml(rating)}/5</span>
                    </div>
                    ${title ? `<h4 style="margin:0.25rem 0 0.4rem;font-size:0.98rem;">${escapeHtml(title)}</h4>` : ''}
                    <p class="sn-muted" style="margin:0;color:var(--sn-slate);">${escapeHtml(comment)}</p>
                </article>
            `;
            list.prepend(wrapper);

            if (countEl) {
                countEl.textContent = String(parseInt(countEl.textContent || '0', 10) + 1);
            }

            form.reset();
            showToast('Demo review added to page preview (not saved to a database).');
        });
    });

    // Demo inquiry reply form
    document.querySelectorAll('[data-demo-reply-form]').forEach((form) => {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            if (!form.reportValidity()) return;

            const thread = form.closest('[data-inquiry-thread]');
            const list = thread?.querySelector('[data-inquiry-messages]');
            const input = form.querySelector('input[name="message"]');
            const message = input?.value.trim();
            if (!list || !message) return;

            const sender = form.getAttribute('data-sender-name') || 'Traveler';
            const entry = document.createElement('div');
            entry.style.cssText = 'margin-bottom:0.75rem;padding-bottom:0.75rem;border-bottom:1px solid var(--sn-border);';
            entry.innerHTML = `
                <strong style="font-size:0.85rem;color:var(--sn-forest);">${escapeHtml(sender)}</strong>
                <span class="sn-muted" style="font-size:0.76rem;margin-left:0.5rem;">Just now (Demo)</span>
                <p style="margin:0.25rem 0 0;font-size:0.9rem;">${escapeHtml(message)}</p>
            `;
            list.appendChild(entry);
            form.reset();
            showToast('Demo reply added to conversation preview.');
        });
    });
}
