(function () {
    const AUTO_DISMISS_MS = 5000; // matches CSS progress bar duration

    function dismissToast(toast) {
        toast.classList.add('toast-hiding');
        toast.addEventListener('animationend', () => {
            toast.remove();
            // Remove container if empty
            const container = document.getElementById('toast-container');
            if (container && container.children.length === 0) {
                container.remove();
            }
        }, { once: true });
    }

    // Close button handler (called inline from blade)
    window.closeToast = function (btn) {
        const toast = btn.closest('.toast');
        if (toast) dismissToast(toast);
    };

    // Auto-dismiss all toasts after AUTO_DISMISS_MS
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.toast').forEach((toast) => {
            setTimeout(() => {
                if (document.contains(toast)) {
                    dismissToast(toast);
                }
            }, AUTO_DISMISS_MS);
        });
    });
})();
