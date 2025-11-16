const CACHE_VERSION = 'v1.0.0';
const CACHE_NAME = `todo-app-cache-${CACHE_VERSION}`;
const ASSETS_TO_CACHE = [
  '/',
  '/offline.html',
  '/manifest.webmanifest',
  '/favicon.ico',
  '/robots.txt'
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

  const req = event.request;
  const url = new URL(req.url);

  // Навигационные запросы: Network-first с офлайн-фолбэком
  if (req.mode === 'navigate') {
    event.respondWith(
      fetch(req).catch(() => caches.match('/offline.html'))
    );
    return;
  }

  // Стратегия cache-first для статических ассетов с до-кэшированием по мере запроса
  event.respondWith(
    caches.match(req).then(cached => {
      if (cached) return cached;
      return fetch(req).then(resp => {
        if (resp.ok && url.origin === self.location.origin) {
          const ext = url.pathname.split('.').pop();
          if (['js','css','png','jpg','jpeg','gif','svg','webp','woff','woff2','ttf','otf','json','webmanifest'].includes(ext)) {
            caches.open(CACHE_NAME).then(cache => cache.put(req, resp.clone()));
          }
        }
        return resp;
      }).catch(() => cached);
    })
  );
});

// Обработка входящих push-сообщений
self.addEventListener('push', event => {
  let data = {};
  try { data = event.data ? event.data.json() : {}; } catch {}
  const title = data.title || 'Уведомление';
  const body = data.body || 'У вас новое уведомление';
  const icon = data.icon || '/icons/any-192.svg';
  const url = data.url || '/';
  event.waitUntil(self.registration.showNotification(title, { body, icon, data: { url } }));
});

self.addEventListener('notificationclick', event => {
  event.notification.close();
  const url = (event.notification && event.notification.data && event.notification.data.url) || '/';
  event.waitUntil(
    clients.matchAll({ type: 'window', includeUncontrolled: true }).then(windowClients => {
      for (const client of windowClients) {
        if ('focus' in client) {
          client.navigate(url);
          return client.focus();
        }
      }
      if (clients.openWindow) {
        return clients.openWindow(url);
      }
    })
  );
});
