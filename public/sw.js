const CACHE_NAME = 'harvestinn-v1.0.1';
const OFFLINE_URL = '/offline.html';

// Essential files to cache immediately (keep this minimal for fast loading)
const essentialCache = [
  '/',
  '/offline.html',
  '/Harvest.svg',
  '/manifest.json'
];

// Additional files to cache lazily (cached as they're requested)
const lazyCache = [
  '/dashboard',
  '/products',
  '/sales',
  '/purchases',
  '/incubations',
  '/pwa-icons/icon-192x192.png',
  '/pwa-icons/icon-512x512.png'
];

// Install event - cache only essential files for fast startup
self.addEventListener('install', function(event) {
  console.log('HarvestInn SW: Installing...');
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(function(cache) {
        console.log('HarvestInn SW: Caching essential files');
        // Only cache essential files during install to speed up initial load
        return cache.addAll(essentialCache);
      })
      .catch(function(error) {
        console.log('HarvestInn SW: Install failed:', error);
      })
  );
  self.skipWaiting();
});

// Activate event - clean up old caches
self.addEventListener('activate', function(event) {
  console.log('HarvestInn SW: Activating...');
  event.waitUntil(
    caches.keys().then(function(cacheNames) {
      return Promise.all(
        cacheNames.map(function(cacheName) {
          if (cacheName !== CACHE_NAME) {
            console.log('HarvestInn SW: Deleting old cache:', cacheName);
            return caches.delete(cacheName);
          }
        })
      );
    })
  );
  self.clients.claim();
});

// Fetch event - optimized for speed
self.addEventListener('fetch', function(event) {
  // Skip cross-origin requests and non-GET requests
  if (!event.request.url.startsWith(self.location.origin) || event.request.method !== 'GET') {
    return;
  }

  // Skip service worker requests to avoid infinite loops
  if (event.request.url.includes('/sw.js')) {
    return;
  }

  event.respondWith(
    // Try cache first for static assets
    caches.match(event.request)
      .then(function(cachedResponse) {
        if (cachedResponse) {
          // Return cached version immediately
          return cachedResponse;
        }

        // Network first for dynamic content
        return fetch(event.request)
          .then(function(networkResponse) {
            // Don't cache if not a valid response
            if (!networkResponse || networkResponse.status !== 200 || networkResponse.type !== 'basic') {
              return networkResponse;
            }

            // Cache successful responses for future use (async)
            const responseToCache = networkResponse.clone();
            caches.open(CACHE_NAME)
              .then(function(cache) {
                // Only cache certain file types to avoid bloating cache
                const url = event.request.url;
                if (url.includes('/build/') || url.includes('/assets/') || 
                    url.includes('.css') || url.includes('.js') || 
                    url.includes('.png') || url.includes('.svg') ||
                    lazyCache.some(path => url.endsWith(path))) {
                  cache.put(event.request, responseToCache);
                }
              })
              .catch(() => {}); // Ignore cache errors

            return networkResponse;
          })
          .catch(function() {
            // Network failed - try to serve offline content
            if (event.request.mode === 'navigate') {
              return caches.match(OFFLINE_URL);
            }
            
            // For other requests, return a minimal error response
            return new Response('', {
              status: 503,
              statusText: 'Service Unavailable'
            });
          });
      })
  );
});

// Background sync for form submissions when back online
self.addEventListener('sync', function(event) {
  if (event.tag === 'background-sync') {
    event.waitUntil(
      // Handle queued form submissions
      console.log('HarvestInn: Background sync triggered')
    );
  }
});

// Push notifications (for future use)
self.addEventListener('push', function(event) {
  if (event.data) {
    const data = event.data.json();
    const options = {
      body: data.body,
      icon: '/pwa-icons/icon-192x192.png',
      badge: '/pwa-icons/icon-72x72.png',
      tag: 'harvestinn-notification',
      requireInteraction: true,
      actions: [
        {
          action: 'open',
          title: 'Open HarvestInn'
        },
        {
          action: 'close',
          title: 'Close'
        }
      ]
    };

    event.waitUntil(
      self.registration.showNotification(data.title, options)
    );
  }
});

// Notification click handling
self.addEventListener('notificationclick', function(event) {
  event.notification.close();

  if (event.action === 'open' || !event.action) {
    event.waitUntil(
      clients.openWindow('/')
    );
  }
});
