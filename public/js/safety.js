document.addEventListener('DOMContentLoaded', () => {
    // Geolocation capture helper for SOS & Check-in & Help Near Me
    const fillGeoInputs = (latSelector, lngSelector, statusSelector) => {
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
                if (statusEl) statusEl.textContent = 'Location permission declined or unavailable. You can still submit with a manual location note.';
            },
            { enableHighAccuracy: true, timeout: 8000 }
        );
    };

    const sosOpenBtn = document.querySelector('[data-sos-trigger]');
    if (sosOpenBtn) {
        sosOpenBtn.addEventListener('click', () => {
            fillGeoInputs('#sos-latitude', '#sos-longitude', '#sos-geo-status');
        });
    }

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

    // Live Check-in Countdown Timer
    document.querySelectorAll('[data-checkin-countdown]').forEach((el) => {
        const targetIso = el.getAttribute('data-checkin-countdown');
        if (!targetIso) return;
        const targetMs = new Date(targetIso).getTime();

        const tick = () => {
            const diff = targetMs - Date.now();
            if (diff <= 0) {
                el.textContent = 'OVERDUE — Please confirm you are safe!';
                el.classList.add('sn-badge-high');
                return;
            }
            const hrs = Math.floor(diff / 3600000);
            const mins = Math.floor((diff % 3600000) / 60000);
            const secs = Math.floor((diff % 60000) / 1000);
            el.textContent = `${String(hrs).padStart(2, '0')}h ${String(mins).padStart(2, '0')}m ${String(secs).padStart(2, '0')}s remaining`;
        };
        tick();
        setInterval(tick, 1000);
    });
});
