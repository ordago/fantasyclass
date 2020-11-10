// var staticCacheName = "pwa-v" + new Date().getTime();
// var filesToCache = [
//     '/offline',
//     '/css/app.css',
//     '/login',
//     '/classroom',
//     '/js/app.js',
//     '/img/logo.svg',
//     '/img/google-logo.svg',
// ];

// // Cache on install
// self.addEventListener("install", event => {
//     this.skipWaiting();
//     event.waitUntil(
//         caches.open(staticCacheName)
//         .then(cache => {
//             return cache.addAll(filesToCache);
//         })
//     )
// });

// // Clear cache on activate
// self.addEventListener('activate', event => {
//     event.waitUntil(
//         caches.keys().then(cacheNames => {
//             return Promise.all(
//                 cacheNames
//                 .filter(cacheName => (cacheName.startsWith("pwa-")))
//                 .filter(cacheName => (cacheName !== staticCacheName))
//                 .map(cacheName => caches.delete(cacheName))
//             );
//         })
//     );
// });

// // Serve from Cache
// // self.addEventListener("fetch", event => {
// // event.respondWith(
// //     caches.match(event.request)
// //     .then(response => {
// //         return response || fetch(event.request);
// //     })
// //     .catch(() => {
// //         return caches.match('offline');
// //     })
// // )
// // });

// self.addEventListener('fetch', function (event) {
//     var request = event.request;
//     // Always fetch non-GET requests from the network
//     if (request.method !== 'GET') {
//         event.respondWith(
//             fetch(request)
//             .catch(function () {
//                 return caches.match('offline');
//             })
//         );
//         return;
//     }

//     // For HTML requests, try the network first, fall back to the cache, finally the offline page
//     if (request.headers.get('Accept').indexOf('text/html') !== -1) {
//         // Fix for Chrome bug: https://code.google.com/p/chromium/issues/detail?id=573937
//         if (request.mode != 'navigate') {
//             request = new Request(request.url, {
//                 method: 'GET',
//                 headers: request.headers,
//                 mode: request.mode,
//                 credentials: request.credentials,
//                 redirect: request.redirect
//             });
//         }
//         event.respondWith(
//             fetch(request)
//             .then(function (response) {
//                 // Stash a copy of this page in the cache
//                 var copy = response.clone();
//                 caches.open(version + staticCacheName)
//                     .then(function (cache) {
//                         cache.put(request, copy);
//                     });
//                 return response;
//             })
//             .catch(function () {
//                 return caches.match(request)
//                     .then(function (response) {
//                         return response || caches.match('offline');
//                     })
//             })
//         );
//         return;
//     }
// });

'use strict';

// Licensed under a CC0 1.0 Universal (CC0 1.0) Public Domain Dedication
// http://creativecommons.org/publicdomain/zero/1.0/

(function () {

    // Update 'version' if you need to refresh the cache
    var staticCacheName = 'static';
    var version = 'v1::';

    // Store core files in a cache (including a page to display when offline)
    function updateStaticCache() {
        return caches.open(version + staticCacheName)
            .then(function (cache) {
                return cache.addAll([
                    '/',
                    '/offline',
                    '/css/home.css',
                    '/img/logo.svg',
                    '/img/google-logo.svg',
                    'https://unpkg.com/bulma@0.9.1/css/bulma.min.css',
                    'https://kit.fontawesome.com/90342cb187.js',
                ]);
            });
    };

    self.addEventListener('install', function (event) {
        event.waitUntil(updateStaticCache());
    });

    self.addEventListener('activate', function (event) {
        event.waitUntil(
            caches.keys()
            .then(function (keys) {
                // Remove caches whose name is no longer valid
                return Promise.all(keys
                    .filter(function (key) {
                        return key.indexOf(version) !== 0;
                    })
                    .map(function (key) {
                        return caches.delete(key);
                    })
                );
            })
        );
    });

    self.addEventListener('fetch', function (event) {
        var request = event.request;
        // Always fetch non-GET requests from the network
        if (request.method !== 'GET') {
            event.respondWith(
                fetch(request)
                .catch(function () {
                    return caches.match('/offline');
                })
            );
            return;
        }

        // For HTML requests, try the network first, fall back to the cache, finally the offline page
        if (request.headers.get('Accept').indexOf('text/html') !== -1) {
            // Fix for Chrome bug: https://code.google.com/p/chromium/issues/detail?id=573937
            if (request.mode != 'navigate') {
                request = new Request(request.url, {
                    method: 'GET',
                    headers: request.headers,
                    mode: request.mode,
                    credentials: request.credentials,
                    redirect: request.redirect
                });
            }
            event.respondWith(
                fetch(request)
                .then(function (response) {
                    // Stash a copy of this page in the cache
                    var copy = response.clone();
                    caches.open(version + staticCacheName)
                        .then(function (cache) {
                            cache.put(request, copy);
                        });
                    return response;
                })
                .catch(function () {
                    return caches.match(request)
                        .then(function (response) {
                            return response || caches.match('/offline');
                        })
                })
            );
            return;
        }

        // For non-HTML requests, look in the cache first, fall back to the network
        event.respondWith(
            caches.match(request)
            .then(function (response) {
                return response || fetch(request)
                    .catch(function () {
                        // If the request is for an image, show an offline placeholder
                        if (request.headers.get('Accept').indexOf('image') !== -1) {
                            return new Response('<svg width="400" height="300" role="img" aria-labelledby="offline-title" viewBox="0 0 400 300" xmlns="http://www.w3.org/2000/svg"><title id="offline-title">Offline</title><g fill="none" fill-rule="evenodd"><path fill="#D8D8D8" d="M0 0h400v300H0z"/><text fill="#9B9B9B" font-family="Helvetica Neue,Arial,Helvetica,sans-serif" font-size="72" font-weight="bold"><tspan x="93" y="172">offline</tspan></text></g></svg>', {
                                headers: {
                                    'Content-Type': 'image/svg+xml'
                                }
                            });
                        }
                    });
            })
        );
    });

    self.addEventListener('notificationclick', function (event) {
        event.notification.close();
        switch (event.action) {
            case 'open_fantasyclass_teacher':
                self.clients.openWindow("/classroom/" + event.notification.data.code + "/" + event.notification.data.section)
                break;
            case 'open_fantasyclass':
                self.clients.openWindow("/classroom/show/" + event.notification.data.code)
                break;
            default:
                self.clients.openWindow("/classroom")
                break;
        }
    });

    self.addEventListener('push', function (e) {
        if (!(self.Notification && self.Notification.permission === 'granted')) {
            //notifications aren't supported or permission not granted!
            return;
        }

        if (e.data) {
            var msg = e.data.json();
            e.waitUntil(self.registration.showNotification(msg.title, {
                body: msg.body,
                icon: msg.icon,
                actions: msg.actions,
                data: msg.data,
            }));
        }
    });
})();
