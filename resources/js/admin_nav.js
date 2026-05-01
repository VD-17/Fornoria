document.addEventListener('DOMContentLoaded', () => {

    const navOpenBtn  = document.getElementById('navOpenBtn');
    const navCloseBtn = document.getElementById('navCloseBtn');
    const sideNavBar  = document.getElementById('sideNavBar');
    const navOverlay  = document.getElementById('navOverlay');

    if (!sideNavBar) return;

    navOpenBtn?.addEventListener('click', openNav);
    navCloseBtn?.addEventListener('click', closeNav);
    navOverlay?.addEventListener('click', closeNav);

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeNav();
    });

    sideNavBar.querySelectorAll('.nav-list a').forEach((link) => {
        link.addEventListener('click', () => {
            if (window.innerWidth <= 900) closeNav();
        });
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth > 900) {
            closeNav();
            document.body.style.overflow = '';
        }
    });

    function openNav() {
        sideNavBar.classList.add('open');
        navOverlay?.classList.add('active');
        navOverlay?.removeAttribute('aria-hidden');
        navOpenBtn?.setAttribute('aria-expanded', 'true');
        navOpenBtn?.classList.add('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeNav() {
        sideNavBar.classList.remove('open');
        navOverlay?.classList.remove('active');
        navOverlay?.setAttribute('aria-hidden', 'true');
        navOpenBtn?.setAttribute('aria-expanded', 'false');
        navOpenBtn?.classList.remove('hidden');
        document.body.style.overflow = '';
    }

});
