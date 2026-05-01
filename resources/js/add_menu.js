document.addEventListener('DOMContentLoaded', () => {

    const overlay = document.getElementById('addMenuOverlay');
    const openBtn = document.getElementById('openAddMenuModal');
    const closeBtn = document.getElementById('modalCloseBtn');
    const cancelBtn = document.getElementById('modalCancelBtn');
    const fileInput = document.getElementById('item_image');
    const uploadText = document.getElementById('uploadText');
    const uploadHint = document.getElementById('uploadFileName');

    function openModal() {
        overlay.classList.add('is-open');
        overlay.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';

        const firstInput = overlay.querySelector('input, select');
        if (firstInput) firstInput.focus();
    }

    function closeModal() {
        overlay.classList.remove('is-open');
        overlay.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    if (openBtn) openBtn.addEventListener('click', openModal);
    if (closeBtn) closeBtn.addEventListener('click', closeModal);
    if (cancelBtn) cancelBtn.addEventListener('click', closeModal);

    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) closeModal();
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && overlay.classList.contains('is-open')) {
            closeModal();
        }
    });

    if (fileInput) {
        fileInput.addEventListener('change', () => {
            const file = fileInput.files[0];
            if (file) {
                uploadText.textContent = 'Image selected';
                uploadHint.textContent = file.name;
            } else {
                uploadText.textContent = 'Upload Image';
                uploadHint.textContent = '';
            }
        });
    }

});
