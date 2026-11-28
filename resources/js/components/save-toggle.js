import { showToast } from './toast.js';

const STORAGE_KEY = 'safenepal_demo_saved';

function readSavedSet() {
    try {
        const raw = window.localStorage.getItem(STORAGE_KEY);
        return new Set(raw ? JSON.parse(raw) : []);
    } catch {
        return new Set();
    }
}

function writeSavedSet(set) {
    try {
        window.localStorage.setItem(STORAGE_KEY, JSON.stringify([...set]));
    } catch {
        // Ignore storage errors in private browsing mode
    }
}

export function initSaveToggles() {
    const saved = readSavedSet();

    document.querySelectorAll('[data-save-toggle]').forEach((btn) => {
        const key = btn.getAttribute('data-save-key');
        if (!key) return;

        const defaultLabel = btn.getAttribute('data-save-label') || 'Save';
        const savedLabel = btn.getAttribute('data-saved-label') || 'Saved ✓';

        const sync = (isSaved) => {
            btn.classList.toggle('is-saved', isSaved);
            btn.setAttribute('aria-pressed', isSaved ? 'true' : 'false');
            btn.textContent = isSaved ? savedLabel : defaultLabel;
        };

        sync(saved.has(key));

        btn.addEventListener('click', () => {
            const current = readSavedSet();
            if (current.has(key)) {
                current.delete(key);
                writeSavedSet(current);
                sync(false);
                showToast('Removed from your demo saved items.');
            } else {
                current.add(key);
                writeSavedSet(current);
                sync(true);
                showToast('Saved to your SafeNepal demo collection.');
            }
        });
    });

    document.querySelectorAll('[data-remove-saved-card]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const key = btn.getAttribute('data-save-key');
            if (key) {
                const current = readSavedSet();
                current.delete(key);
                writeSavedSet(current);
            }
            btn.closest('[data-saved-card]')?.remove();
            showToast('Removed from your saved items preview.');
        });
    });
}
