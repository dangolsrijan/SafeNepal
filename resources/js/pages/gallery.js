export function initGallery() {
    document.querySelectorAll('[data-gallery-thumb]').forEach((thumb) => {
        thumb.addEventListener('click', () => {
            const targetId = thumb.getAttribute('data-gallery-target');
            const src = thumb.getAttribute('data-gallery-src');
            const mainImg = targetId ? document.getElementById(targetId) : null;
            if (mainImg && src) {
                mainImg.src = src;
            }
        });
    });
}
