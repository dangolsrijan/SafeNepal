import { closeModal } from '../components/modal.js';
import { showToast } from '../components/toast.js';

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function fillGeoInputs(latSelector, lngSelector, statusSelector) {
    const latInput = document.querySelector(latSelector);
    const lngInput = document.querySelector(lngSelector);
    const statusEl = document.querySelector(statusSelector);

    if (!navigator.geolocation) {
        if (statusEl) statusEl.textContent = 'Geolocation is not supported by your browser. You may still proceed without GPS coordinates.';
        return;
    }

    if (statusEl) statusEl.textContent = 'Requesting current GPS coordinates...';
    navigator.geolocation.getCurrentPosition(
        (pos) => {
            const lat = pos.coords.latitude.toFixed(6);
            const lng = pos.coords.longitude.toFixed(6);
            if (latInput) latInput.value = lat;
            if (lngInput) lngInput.value = lng;
            if (statusEl) statusEl.textContent = `Location captured: ${lat}, ${lng}`;
        },
        () => {
            if (statusEl) statusEl.textContent = 'Location permission declined or unavailable. You can still enter a manual location note.';
        },
        { enableHighAccuracy: true, timeout: 8000 }
    );
}

export function initSafety() {
    // SOS Modal Geolocation Trigger
    const sosOpenBtn = document.querySelector('[data-sos-trigger]');
    if (sosOpenBtn) {
        sosOpenBtn.addEventListener('click', () => {
            fillGeoInputs('#sos-latitude', '#sos-longitude', '#sos-geo-status');
        });
    }

    // Help Near Me Geolocation Redirect
    const helpNearMeBtn = document.querySelector('[data-locate-near-me]');
    if (helpNearMeBtn) {
        helpNearMeBtn.addEventListener('click', () => {
            const statusEl = document.getElementById('near-me-status');
            if (!navigator.geolocation) {
                if (statusEl) statusEl.textContent = 'Browser geolocation unavailable. Use the region filter below.';
                return;
            }
            if (statusEl) statusEl.textContent = 'Detecting your location...';
            navigator.geolocation.getCurrentPosition(
                (pos) => {
                    const url = new URL(window.location.href);
                    url.searchParams.set('lat', pos.coords.latitude.toFixed(6));
                    url.searchParams.set('lng', pos.coords.longitude.toFixed(6));
                    window.location.href = url.toString();
                },
                () => {
                    if (statusEl) statusEl.textContent = 'Location permission denied. Filter by Nepal region below to browse demo emergency facilities.';
                }
            );
        });
    }

    // Live Check-In Countdown Timer
    let activeTargetMs = null;
    const countdownEl = document.querySelector('[data-checkin-countdown]');
    const updateCountdown = () => {
        if (!countdownEl || !activeTargetMs) return;
        const diff = activeTargetMs - Date.now();
        if (diff <= 0) {
            countdownEl.textContent = 'OVERDUE — Please confirm you are safe!';
            countdownEl.classList.add('sn-badge-high');
            return;
        }
        countdownEl.classList.remove('sn-badge-high');
        const hrs = Math.floor(diff / 3600000);
        const mins = Math.floor((diff % 3600000) / 60000);
        const secs = Math.floor((diff % 60000) / 1000);
        countdownEl.textContent = `${String(hrs).padStart(2, '0')}h ${String(mins).padStart(2, '0')}m ${String(secs).padStart(2, '0')}s remaining`;
    };

    if (countdownEl) {
        const initialIso = countdownEl.getAttribute('data-checkin-countdown');
        if (initialIso) {
            activeTargetMs = new Date(initialIso).getTime();
            updateCountdown();
            window.setInterval(updateCountdown, 1000);
        }
    }

    // Interactive Demo Check-In Panel
    const checkInPanel = document.querySelector('[data-checkin-panel]');
    if (checkInPanel) {
        const activeView = checkInPanel.querySelector('[data-checkin-active-view]');
        const startView = checkInPanel.querySelector('[data-checkin-start-view]');
        const statusBadge = checkInPanel.querySelector('[data-checkin-status]');
        const locationEl = checkInPanel.querySelector('[data-checkin-location]');
        const intervalEl = checkInPanel.querySelector('[data-checkin-interval]');
        const confirmForm = checkInPanel.querySelector('[data-checkin-confirm-form]');
        const startForm = checkInPanel.querySelector('[data-checkin-start-form]');

        confirmForm?.addEventListener('submit', (e) => {
            e.preventDefault();
            const mins = parseInt(intervalEl?.textContent || '120', 10);
            activeTargetMs = Date.now() + mins * 60000;
            if (statusBadge) statusBadge.textContent = 'Checked In';
            updateCountdown();
            confirmForm.reset();
            showToast('Demo check-in confirmed! Countdown timer reset.');
        });

        checkInPanel.querySelectorAll('[data-checkin-end]').forEach((btn) => {
            btn.addEventListener('click', () => {
                const action = btn.getAttribute('data-checkin-end');
                if (activeView) activeView.style.display = 'none';
                if (startView) startView.style.display = '';
                if (statusBadge) statusBadge.textContent = action === 'cancelled' ? 'Cancelled' : 'Completed';
                activeTargetMs = null;
                showToast(`Demo Safety Check-In session ${action}.`);
            });
        });

        startForm?.addEventListener('submit', (e) => {
            e.preventDefault();
            if (!startForm.reportValidity()) return;
            const data = new FormData(startForm);
            const destName = String(data.get('destination_name') || 'Nepal Trail').trim();
            const mins = Math.max(15, parseInt(String(data.get('interval_minutes') || '120'), 10));

            if (locationEl) locationEl.textContent = destName;
            if (intervalEl) intervalEl.textContent = String(mins);
            if (statusBadge) statusBadge.textContent = 'Active';
            if (startView) startView.style.display = 'none';
            if (activeView) activeView.style.display = '';

            activeTargetMs = Date.now() + mins * 60000;
            updateCountdown();
            startForm.reset();
            showToast(`Demo Safety Check-In started for ${destName}.`);
        });
    }

    // Demo SOS Modal Submission
    const sosForm = document.querySelector('[data-sos-demo-form]');
    if (sosForm) {
        sosForm.addEventListener('submit', (e) => {
            e.preventDefault();
            if (!sosForm.reportValidity()) return;

            const data = new FormData(sosForm);
            const lat = String(data.get('latitude') || 'N/A').trim() || 'N/A';
            const lng = String(data.get('longitude') || 'N/A').trim() || 'N/A';
            const note = String(data.get('location_note') || 'Demo SOS Trigger').trim();
            const msg = String(data.get('message') || 'Simulated emergency SOS triggered by traveler.').trim();

            const list = document.querySelector('[data-incident-list]');
            if (list) {
                const row = document.createElement('div');
                row.style.cssText = 'padding:0.75rem 0;border-bottom:1px solid var(--sn-border);';
                row.innerHTML = `
                    <div class="sn-flex-between">
                        <strong>Just now (Demo)</strong>
                        <span class="sn-badge sn-badge-high">Recorded Demo</span>
                    </div>
                    <div class="sn-muted" style="font-size:0.84rem;">GPS: ${escapeHtml(lat)}, ${escapeHtml(lng)} • ${escapeHtml(note)}</div>
                    <p style="margin:0.25rem 0 0;font-size:0.86rem;">${escapeHtml(msg)}</p>
                `;
                list.prepend(row);
            }

            closeModal(sosForm.closest('.sn-modal-backdrop'));
            sosForm.reset();
            showToast('DEMO SOS SIMULATED: No real emergency responders were dispatched. In a real emergency dial 100 / 102 / 1144.', 'warning');
        });
    }

    // Demo Personal Emergency Contact Form
    const contactForm = document.querySelector('[data-personal-contact-form]');
    if (contactForm) {
        contactForm.addEventListener('submit', (e) => {
            e.preventDefault();
            if (!contactForm.reportValidity()) return;

            const data = new FormData(contactForm);
            const name = String(data.get('name') || '').trim();
            const phone = String(data.get('phone') || '').trim();
            const list = document.querySelector('[data-personal-contact-list]');
            if (list && name && phone) {
                const row = document.createElement('div');
                row.style.cssText = 'padding:0.65rem 0;border-bottom:1px solid var(--sn-border);';
                row.innerHTML = `
                    <strong>${escapeHtml(name)}</strong> — <span style="color:var(--sn-forest);font-weight:700;">${escapeHtml(phone)}</span>
                    <div class="sn-muted" style="font-size:0.82rem;">Personal Contact (Demo Preview)</div>
                `;
                list.appendChild(row);
            }
            contactForm.reset();
            showToast('Personal emergency contact added to preview.');
        });
    }
}
