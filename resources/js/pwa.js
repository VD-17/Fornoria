// Service Worker Registration
if ('serviceWorker' in navigator) {
    window.addEventListener('load', async () => {
        try {
            const registration = await navigator.serviceWorker.register('/sw.js', {
                scope: '/',
                updateViaCache: 'none', // always fetch fresh SW on reload
            });

            console.log('[PWA] Service Worker registered. Scope:', registration.scope);

            // Check for updates every time the user navigates
            registration.addEventListener('updatefound', () => {
                const newWorker = registration.installing;

                newWorker.addEventListener('statechange', () => {
                    if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                        showUpdateToast(newWorker);
                    }
                });
            });

        } catch (err) {
            console.warn('[PWA] Service Worker registration failed:', err);
        }
    });

    // When a new SW has taken control, reload to activate it
    let refreshing = false;
    navigator.serviceWorker.addEventListener('controllerchange', () => {
        if (!refreshing) {
            refreshing = true;
            window.location.reload();
        }
    });
}

function showUpdateToast(newWorker) {
    // Reuse the existing Fornoria toast system if available, else create one
    const existing = document.getElementById('pwa-update-toast');
    if (existing) return; // prevent duplicates

    const toast = document.createElement('div');
    toast.id = 'pwa-update-toast';
    toast.style.cssText = `
        position: fixed; bottom: 1.5rem; left: 50%; transform: translateX(-50%);
        background: #1a0a00; color: #fdf6ec;
        border: 1px solid #c0392b; border-radius: 6px;
        padding: .9rem 1.4rem; display: flex; align-items: center; gap: 1rem;
        font-family: 'Cinzel', sans-serif; font-size: .9rem;
        box-shadow: 0 8px 32px rgba(0,0,0,.5); z-index: 9999;
        animation: slideUp .3s ease;
    `;
    toast.innerHTML = `
        <span>🍕 A fresh update is ready!</span>
        <button id="pwa-update-btn" style="
            background:#c0392b; color:#fff; border:none; border-radius:4px;
            padding:.4rem .9rem; cursor:pointer; font-size:.85rem; letter-spacing:.5px;
        ">Refresh</button>
    `;

    // Add animation keyframe once
    if (!document.getElementById('pwa-toast-style')) {
        const style = document.createElement('style');
        style.id = 'pwa-toast-style';
        style.textContent = `@keyframes slideUp { from { opacity:0; transform:translateX(-50%) translateY(20px) } to { opacity:1; transform:translateX(-50%) translateY(0) } }`;
        document.head.appendChild(style);
    }

    document.body.appendChild(toast);

    document.getElementById('pwa-update-btn').addEventListener('click', () => {
        newWorker.postMessage({ type: 'SKIP_WAITING' });
        toast.remove();
    });
}

// Install
let deferredPrompt = null;

window.addEventListener('beforeinstallprompt', (e) => {
    e.preventDefault();
    deferredPrompt = e;

    // Show the install button if one exists in your blade templates
    const installBtn = document.getElementById('pwa-install-btn');
    if (installBtn) {
        installBtn.style.display = 'flex';

        installBtn.addEventListener('click', async () => {
            if (!deferredPrompt) return;

            deferredPrompt.prompt();
            const { outcome } = await deferredPrompt.userChoice;
            console.log('[PWA] Install outcome:', outcome);

            deferredPrompt = null;
            installBtn.style.display = 'none';
        });
    }
});

window.addEventListener('appinstalled', () => {
    deferredPrompt = null;
    const installBtn = document.getElementById('pwa-install-btn');
    if (installBtn) installBtn.style.display = 'none';
    console.log('[PWA] App installed successfully.');
});

function showOfflineBanner() {
    let banner = document.getElementById('pwa-offline-banner');
    if (!banner) {
        banner = document.createElement('div');
        banner.id = 'pwa-offline-banner';
        banner.style.cssText = `
            position: fixed; top: 0; left: 0; right: 0;
            background: #c0392b; color: #fff; text-align: center;
            padding: .6rem 1rem; font-size: .85rem; letter-spacing: .5px;
            z-index: 10000; font-family: 'Lato', sans-serif;
        `;
        banner.textContent = '⚠️  You are offline. Some features may be unavailable.';
        document.body.prepend(banner);
    }
}

function hideOfflineBanner() {
    const banner = document.getElementById('pwa-offline-banner');
    if (banner) banner.remove();
}

window.addEventListener('offline', showOfflineBanner);
window.addEventListener('online',  hideOfflineBanner);

if (!navigator.onLine) showOfflineBanner();

// Background sync helper
export async function queueForSync(storeName, payload) {
    const db = await openIDB();
    await new Promise((resolve, reject) => {
        const tx  = db.transaction(storeName, 'readwrite');
        const req = tx.objectStore(storeName).add({ ...payload, timestamp: Date.now() });
        req.onsuccess = resolve;
        req.onerror   = e => reject(e.target.error);
    });

    if ('serviceWorker' in navigator && 'SyncManager' in window) {
        const sw = await navigator.serviceWorker.ready;
        const tag = storeName === 'pending-orders' ? 'sync-orders' : 'sync-reservations';
        await sw.sync.register(tag);
    }
}

function openIDB() {
    return new Promise((resolve, reject) => {
        const req = indexedDB.open('fornoria-offline', 1);
        req.onupgradeneeded = e => {
            const db = e.target.result;
            if (!db.objectStoreNames.contains('pending-orders'))       db.createObjectStore('pending-orders',       { keyPath: 'id', autoIncrement: true });
            if (!db.objectStoreNames.contains('pending-reservations')) db.createObjectStore('pending-reservations', { keyPath: 'id', autoIncrement: true });
        };
        req.onsuccess = e => resolve(e.target.result);
        req.onerror   = e => reject(e.target.error);
    });
}
