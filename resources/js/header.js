document.addEventListener('DOMContentLoaded', () => {

    // Dropdown
    const userProfile     = document.getElementById('userProfile');
    const dropdownContent = document.getElementById('dropdownContent');
    let dropdownOpen = false;

    if (userProfile && dropdownContent) {

        userProfile.addEventListener('click', (e) => {
            dropdownOpen ? closeDropdown() : openDropdown();
            e.stopPropagation();
        });

        userProfile.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                dropdownOpen ? closeDropdown() : openDropdown();
            }
        });

        document.addEventListener('click', (e) => {
            if (!userProfile.contains(e.target)) closeDropdown();
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeDropdown();
        });

        dropdownContent.addEventListener('click', (e) => e.stopPropagation());
    }

    function openDropdown() {
        dropdownOpen = true;
        dropdownContent.classList.add('show');
        userProfile.classList.add('open');
        userProfile.setAttribute('aria-expanded', 'true');
    }

    function closeDropdown() {
        dropdownOpen = false;
        dropdownContent.classList.remove('show');
        userProfile.classList.remove('open');
        userProfile.setAttribute('aria-expanded', 'false');
    }

    // Navbar 
    const navOpenBtn  = document.getElementById('navOpenBtn');
    const navCloseBtn = document.getElementById('navCloseBtn');
    const navbar      = document.getElementById('navbar');
    const navOverlay  = document.getElementById('navOverlay');

    if (!navOpenBtn || !navbar) return;

    navOpenBtn.addEventListener('click', openNav);
    navCloseBtn?.addEventListener('click', closeNav);
    navOverlay?.addEventListener('click', closeNav);

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeNav();
    });

    navbar.querySelectorAll('.nav-list a').forEach((link) => {
        link.addEventListener('click', closeNav);
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth > 768) {
            closeNav();
            document.body.style.overflow = '';
        }
    });

    function openNav() {
        navbar.classList.add('open');
        navOverlay?.classList.add('active');
        navOpenBtn.setAttribute('aria-expanded', 'true');
        navOpenBtn.classList.add('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeNav() {
        navbar.classList.remove('open');
        navOverlay?.classList.remove('active');
        navOpenBtn.setAttribute('aria-expanded', 'false');
        navOpenBtn.classList.remove('hidden');
        document.body.style.overflow = '';
    }

});
