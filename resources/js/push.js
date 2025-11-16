function urlBase64ToUint8Array(base64String) {
  const padding = '='.repeat((4 - (base64String.length % 4)) % 4);
  const base64 = (base64String + padding).replace(/-/g, '+').replace(/_/g, '/');
  const rawData = atob(base64);
  const outputArray = new Uint8Array(rawData.length);
  for (let i = 0; i < rawData.length; ++i) {
    outputArray[i] = rawData.charCodeAt(i);
  }
  return outputArray;
}

async function subscribeUserToPush() {
  if (!('serviceWorker' in navigator) || !('PushManager' in window)) return { ok: false, reason: 'unsupported' };
  const meta = document.querySelector('meta[name="vapid-public-key"]');
  if (!meta || !meta.content) return { ok: false, reason: 'no-vapid' };

  const registration = await navigator.serviceWorker.ready;
  const vapidKey = urlBase64ToUint8Array(meta.content);

  let subscription = await registration.pushManager.getSubscription();
  if (!subscription) {
    const permission = await Notification.requestPermission();
    if (permission !== 'granted') return { ok: false, reason: 'permission-denied' };
    subscription = await registration.pushManager.subscribe({ userVisibleOnly: true, applicationServerKey: vapidKey });
  }

  const body = subscription.toJSON();
  await window.axios.post('/api/push/subscribe', body);
  return { ok: true };
}

async function unsubscribeUserFromPush() {
  const registration = await navigator.serviceWorker.ready;
  const subscription = await registration.pushManager.getSubscription();
  if (subscription) {
    await window.axios.post('/api/push/unsubscribe', { endpoint: subscription.endpoint });
    await subscription.unsubscribe();
    return { ok: true };
  }
  return { ok: false };
}

async function sendTestPush() {
  await window.axios.post('/api/push/test');
}

window.pushEnable = subscribeUserToPush;
window.pushDisable = unsubscribeUserFromPush;
window.pushTest = sendTestPush;

// Авто-попытка подписки (тихо, без повторного запроса разрешений)
window.addEventListener('load', () => {
  (async () => {
    if (!('serviceWorker' in navigator) || !('PushManager' in window)) return;
    const meta = document.querySelector('meta[name="vapid-public-key"]');
    if (!meta || !meta.content) return;
    const registration = await navigator.serviceWorker.ready;
    const existing = await registration.pushManager.getSubscription();
    if (!existing && Notification.permission === 'granted') {
      try { await subscribeUserToPush(); } catch {}
    }
  })();
});
