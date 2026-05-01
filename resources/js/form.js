document.addEventListener('DOMContentLoaded', () => {

    const overlay  = document.getElementById('addFormOverlay');
    const closeBtn = document.getElementById('modalCloseBtn');

    // Modal field targets
    const modalTitle   = document.getElementById('modalTitle');
    const modalFrom    = document.getElementById('modalFrom');
    const modalDate    = document.getElementById('modalDate');
    const modalMessage = document.getElementById('modalMessage');

    function openModal(data) {
        modalTitle.textContent = data.subject;
        modalFrom.textContent = `${data.name} (${data.email})`;
        modalDate.textContent = data.date;
        modalMessage.textContent = data.message;

        overlay.classList.add('is-open');
        overlay.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';

        closeBtn.focus();
    }

    function closeModal() {
        overlay.classList.remove('is-open');
        overlay.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    // Attach to every "Open" button using event delegation
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.openFormModal');
        if (btn) {
            openModal({
                subject: btn.dataset.subject,
                name: btn.dataset.name,
                email: btn.dataset.email,
                date: btn.dataset.date,
                message: btn.dataset.message,
            });
        }
    });

    if (closeBtn) closeBtn.addEventListener('click', closeModal);

    // Close on backdrop click
    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) closeModal();
    });

    // Close on Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && overlay.classList.contains('is-open')) {
            closeModal();
        }
    });

});
