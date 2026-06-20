// add_menu.js
// Open Add menu dialog box to add menu items to the restaurant's menu

document.addEventListener('DOMContentLoaded', () => {

    // Modal overlay and control buttons
    const overlay = document.getElementById('addMenuOverlay');
    const openBtn = document.getElementById('openAddMenuModal');
    const closeBtn = document.getElementById('modalCloseBtn');
    const cancelBtn = document.getElementById('modalCancelBtn');
    const fileInput = document.getElementById('item_image');
    const uploadText = document.getElementById('uploadText');
    const uploadHint = document.getElementById('uploadFileName');

    // Opens Add Menu modal
    function openModal() {
        overlay.classList.add('is-open');
        overlay.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';

        const firstInput = overlay.querySelector('input, select');
        if (firstInput) firstInput.focus();
    }

    // Closes Add Menu modal
    function closeModal() {
        overlay.classList.remove('is-open');
        overlay.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    // Opens and closes modal when button is clicked
    if (openBtn) openBtn.addEventListener('click', openModal);
    if (closeBtn) closeBtn.addEventListener('click', closeModal);
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

    // Uploading item picture
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
