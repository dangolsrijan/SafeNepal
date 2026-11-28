import { initAccordions } from './components/accordion.js';
import { initDemoForms } from './components/demo-forms.js';
import { initDropdowns } from './components/dropdown.js';
import { initModals } from './components/modal.js';
import { initNavigation } from './components/navigation.js';
import { initReveal } from './components/reveal.js';
import { initSaveToggles } from './components/save-toggle.js';
import { initTabs } from './components/tabs.js';
import { initBookingCalculator } from './pages/booking.js';
import { initGallery } from './pages/gallery.js';
import { initSafety } from './pages/safety.js';
import { initTripPlanner } from './pages/trip-planner.js';

document.addEventListener('DOMContentLoaded', () => {
    initNavigation();
    initDropdowns();
    initModals();
    initTabs();
    initAccordions();
    initReveal();
    initSaveToggles();
    initDemoForms();
    initGallery();
    initBookingCalculator();
    initTripPlanner();
    initSafety();
});
