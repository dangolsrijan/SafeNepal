export function showToast(message, type = 'info') {
    const container = document.querySelector('[data-toast-container]');
    if (!container) return;

    const toast = document.createElement('div');
    toast.className = `sn-toast${type === 'warning' ? ' sn-toast-warning' : ''}`;
    toast.setAttribute('role', 'status');
    toast.textContent = message;
    container.appendChild(toast);

    window.setTimeout(() => {
        toast.remove();
    }, 4500);
}
