const CACHE_NAME = 'cica-pwa-cache-v1';
const urlsToCache = [
  '/',
  '/manifest.json',
  '/images/Cica.png',
  '/css/app.css',
  '/js/app.js',
  // Ajoutez ici d'autres fichiers statiques à mettre en cache
];

self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => cache.addAll(urlsToCache))
  );
});

self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(cacheNames => {
      return Promise.all(
        cacheNames.filter(name => name !== CACHE_NAME).map(name => caches.delete(name))
      );
    })
  );
});

self.addEventListener('fetch', event => {
  event.respondWith(
    caches.match(event.request)
      .then(response => response || fetch(event.request))
  );
});
