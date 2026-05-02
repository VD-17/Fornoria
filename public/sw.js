const CACHE_VERSION = 'v1';
const SHELL_CACHE   = `fornoria-shell-${CACHE_VERSION}`;
const DYNAMIC_CACHE = `fornoria-dynamic-${CACHE_VERSION}`;
const IMAGE_CACHE   = `fornoria-images-${CACHE_VERSION}`;

const MAX_IMAGE_CACHE  = 60;
const MAX_DYNAMIC_CACHE = 30;

const SHELL_ASSETS = [
    '/offline',
    '/manifest.json',
];

const NETWORK_FIRST_PATTERNS = [
    /\/cart/,
    /\/order/,
    /\/track/,
    /\/payment/,
    /\/reservation/,
    /\/contact/,
    /\/admin/,
    /\/login/,
    /\/register/,
    /\/logout/,
];

// Install
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(SHELL_CACHE)
            .then(cache => cache.addAll(SHELL_ASSETS))
            .then(() => self.skipWaiting())
    );
});

self.addEventListener('activate', event => {
    const allowedCaches = [SHELL_CACHE, DYNAMIC_CACHE, IMAGE_CACHE];

    event.waitUntil(
        caches.keys()
            .then(keys => Promise.all(
                keys
                    .filter(key => !allowedCaches.includes(key))
                    .map(key => caches.delete(key))
            ))
            .then(() => self.clients.claim())
    );
});

self.addEventListener('fetch', event => {
    const { request } = event;
    const url = new URL(request.url);

    // Only handle same-origin GET requests
    if (request.method !== 'GET' || url.origin !== location.origin) return;

    // Skip browser-sync / hot-reload requests in dev
    if (url.pathname.startsWith('/browser-sync')) return;

    // Images → cache-first
    if (isImageRequest(request)) {
        event.respondWith(imageStrategy(request));
        return;
    }

    // Dynamic / authenticated routes → network-first
    if (NETWORK_FIRST_PATTERNS.some(p => p.test(url.pathname))) {
        event.respondWith(networkFirstStrategy(request));
        return;
    }

    // Vite-compiled assets (JS/CSS with hash) → cache-first
    if (isStaticAsset(url)) {
        event.respondWith(cacheFirstStrategy(request));
        return;
    }

    // Everything else (HTML pages) → network-first with offline fallback
    event.respondWith(networkFirstWithOfflineFallback(request));
});

async function cacheFirstStrategy(request) {
    const cached = await caches.match(request);
    if (cached) return cached;

    try {
        const response = await fetch(request);
        if (response.ok) {
            const cache = await caches.open(SHELL_CACHE);
            cache.put(request, response.clone());
        }
        return response;
    } catch {
        return caches.match('/offline');
    }
}

async function networkFirstStrategy(request) {
    try {
        const response = await fetch(request);
        if (response.ok) {
            const cache = await caches.open(DYNAMIC_CACHE);
            cache.put(request, response.clone());
            await trimCache(DYNAMIC_CACHE, MAX_DYNAMIC_CACHE);
        }
        return response;
    } catch {
        const cached = await caches.match(request);
        return cached || caches.match('/offline');
    }
}

async function networkFirstWithOfflineFallback(request) {
    try {
        const response = await fetch(request);
        if (response.ok) {
            const cache = await caches.open(DYNAMIC_CACHE);
            cache.put(request, response.clone());
        }
        return response;
    } catch {
        const cached = await caches.match(request);
        if (cached) return cached;
        // Return the offline page for navigation requests
        if (request.mode === 'navigate') return caches.match('/offline');
        return new Response('Network error', { status: 503 });
    }
}

async function imageStrategy(request) {
    const cached = await caches.match(request);
    if (cached) return cached;

    try {
        const response = await fetch(request);
        if (response.ok) {
            const cache = await caches.open(IMAGE_CACHE);
            cache.put(request, response.clone());
            await trimCache(IMAGE_CACHE, MAX_IMAGE_CACHE);
        }
        return response;
    } catch {
        // Return a transparent 1x1 SVG placeholder when offline
        return new Response(
            '<svg xmlns="http://www.w3.org/2000/svg" width="1" height="1"/>',
            { headers: { 'Content-Type': 'image/svg+xml' } }
        );
    }
}

function isImageRequest(request) {
    return request.destination === 'image' ||
        /\.(png|jpg|jpeg|gif|webp|svg|ico)(\?.*)?$/.test(new URL(request.url).pathname);
}

function isStaticAsset(url) {
    return /\.(css|js|woff2?|ttf|eot)(\?.*)?$/.test(url.pathname) ||
        url.pathname.startsWith('/build/');
}

async function trimCache(cacheName, maxItems) {
    const cache = await caches.open(cacheName);
    const keys  = await cache.keys();
    if (keys.length > maxItems) {
        // Delete oldest entries (FIFO)
        const toDelete = keys.slice(0, keys.length - maxItems);
        await Promise.all(toDelete.map(k => cache.delete(k)));
    }
}

self.addEventListener('sync', event => {
    if (event.tag === 'sync-orders') {
        event.waitUntil(syncPendingOrders());
    }
    if (event.tag === 'sync-reservations') {
        event.waitUntil(syncPendingReservations());
    }
});

async function syncPendingOrders() {
    // Retrieve queued order data stored by the client via IndexedDB
    const pending = await getPendingFromIDB('pending-orders');
    for (const item of pending) {
        try {
            await fetch('/cart/place-order', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': item.csrf },
                body: JSON.stringify(item.data),
            });
            await removeFromIDB('pending-orders', item.id);
        } catch {
            // Will retry on next sync
        }
    }
}

async function syncPendingReservations() {
    const pending = await getPendingFromIDB('pending-reservations');
    for (const item of pending) {
        try {
            await fetch('/', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': item.csrf },
                body: JSON.stringify(item.data),
            });
            await removeFromIDB('pending-reservations', item.id);
        } catch {
            // Will retry on next sync
        }
    }
}

// Push Notification
self.addEventListener('push', event => {
    let data = { title: 'Fornoria', body: 'You have a new update!', icon: 'logo-assets/website/Web-Icon-192_192x192.png' };

    try {
        data = { ...data, ...event.data.json() };
    } catch { /* non-JSON payload – use defaults */ }

    event.waitUntil(
        self.registration.showNotification(data.title, {
            body:    data.body,
            icon:    data.icon || 'logo-assets/website/Web-Icon-192_192x192.png',
            badge:   'logo-assets/favicons/favicon-32x32.png',
            tag:     data.tag  || 'fornoria-notification',
            data:    data.url  || '/',
            vibrate: [200, 100, 200],
            actions: data.actions || [],
        })
    );
});

self.addEventListener('notificationclick', event => {
    event.notification.close();
    const targetUrl = event.notification.data || '/';

    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true }).then(clientList => {
            for (const client of clientList) {
                if (client.url === targetUrl && 'focus' in client) return client.focus();
            }
            if (clients.openWindow) return clients.openWindow(targetUrl);
        })
    );
});

async function getPendingFromIDB(storeName) {
    const db = await openIDB();
    return new Promise((resolve, reject) => {
        const tx   = db.transaction(storeName, 'readonly');
        const req  = tx.objectStore(storeName).getAll();
        req.onsuccess = e => resolve(e.target.result);
        req.onerror   = e => reject(e.target.error);
    });
}

async function removeFromIDB(storeName, id) {
    const db = await openIDB();
    return new Promise((resolve, reject) => {
        const tx  = db.transaction(storeName, 'readwrite');
        const req = tx.objectStore(storeName).delete(id);
        req.onsuccess = () => resolve();
        req.onerror   = e => reject(e.target.error);
    });
}
