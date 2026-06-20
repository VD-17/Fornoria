// add_admin.js
// Opens Add Admin dialog box to add new admins

// Dom
document.addEventListener('DOMContentLoaded', () => {

    // Modal overlay and control buttons
    const overlay = document.getElementById('addAdminOverlay');
    const openBtn = document.getElementById('openAddAdminModal');
    const closeBtn = document.getElementById('modalCloseBtn');
    const cancelBtn = document.getElementById('modalCancelBtn');

    // Opens Add Admin modal
    function openModal() {
        overlay.classList.add('is-open');
        overlay.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';

        const firstInput = overlay.querySelector('input, select');
        if (firstInput) firstInput.focus();
    }

    // Closes Add Admin modal
    function closeModal() {
        overlay.classList.remove('is-open');
        overlay.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    // Opens modal when the "Add Admin" button is clicked
    if (openBtn) openBtn.addEventListener('click', openModal);

    // Closes modal when the cross button is clicked
    if (closeBtn) closeBtn.addEventListener('click', closeModal);

    // Close modal when the cancel button is clicked
    if (cancelBtn) cancelBtn.addEventListener('click', closeModal);

    // Close modal when clicking outside the modal content
    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) closeModal();
    });

    // Close modal when the Escape key is pressed
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && overlay.classList.contains('is-open')) {
            closeModal();
        }
    });

});
