const CACHE_VERSION = 'v1.0.0';
const CACHE_NAME = `todo-app-cache-${CACHE_VERSION}`;
const ASSETS_TO_CACHE = [
  '/',
  '/build/assets/app-CmgBU1f8.css',
  '/build/assets/app-Dl5CtGBl.js',
  '/build/assets/welcome-DdHWm3ep.css',
  '/favicon.ico',
  '/robots.txt',
  // Добавьте сюда другие статические ресурсы по мере необходимости
];

self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME).then(cache => {
      return cache.addAll(ASSETS_TO_CACHE);
    })
  );
  self.skipWaiting();
});

self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(keys => {
      return Promise.all(
        keys.filter(key => key !== CACHE_NAME).map(key => caches.delete(key))
      );
    })
  );
  self.clients.claim();
});

self.addEventListener('fetch', event => {
  if (event.request.method !== 'GET') return;
  event.respondWith(
    caches.match(event.request).then(response => {
      return response || fetch(event.request).then(fetchRes => {
        // Кэшируем только статические файлы
        if (fetchRes.ok && event.request.url.startsWith(self.location.origin)) {
          const ext = event.request.url.split('.').pop();
          if (['js', 'css', 'png', 'jpg', 'jpeg', 'gif', 'svg', 'webp', 'woff', 'woff2', 'ttf', 'otf'].includes(ext)) {
            caches.open(CACHE_NAME).then(cache => cache.put(event.request, fetchRes.clone()));
          }
        }
        return fetchRes;
      });
    })
  );
});
