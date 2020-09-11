var staticCacheName = "pwa-v" + new Date().getTime();
var filesToCache = [
    // './offline',
    // '/css/app.css',
    '/js/app.js',
    '/js/vuejs_code_split/0.js',
    '/js/vuejs_code_split/1.js',
    '/js/vuejs_code_split/2.js',
    '/js/vuejs_code_split/3.js',
    '/js/vuejs_code_split/4.js',
    '/js/vuejs_code_split/5.js',
    '/js/vuejs_code_split/6.js',
    '/js/vuejs_code_split/7.js',
    '/js/vuejs_code_split/8.js',
    '/js/vuejs_code_split/9.js',
    '/js/vuejs_code_split/10.js',
];

// Cache on install
self.addEventListener("install", event => {
    this.skipWaiting();
    event.waitUntil(
        caches.open(staticCacheName)
            .then(cache => {
                return cache.addAll(filesToCache);
            })
    )
});

// Clear cache on activate
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames
                    .filter(cacheName => (cacheName.startsWith("pwa-")))
                    .filter(cacheName => (cacheName !== staticCacheName))
                    .map(cacheName => caches.delete(cacheName))
            );
        })
    );
});

// Serve from Cache
self.addEventListener("fetch", event => {
    event.respondWith(
        caches.match(event.request)
            .then(response => {
                return response || fetch(event.request);
            })
            .catch(() => {
                return caches.match('offline');
            })
    )
});