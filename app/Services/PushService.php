<?php

namespace App\Services;

use App\Models\PushSubscription;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;

class PushService
{
    protected WebPush $webPush;

    public function __construct()
    {
        $auth = [
            'VAPID' => [
                'subject' => config('app.url', url('/')),
                'publicKey' => (string) config('push.vapid_public_key'),
                'privateKey' => (string) config('push.vapid_private_key'),
            ]
        ];
        $this->webPush = new WebPush($auth);
    }

    /**
     * Отправить Web Push уведомление всем подпискам пользователя
     */
    public function sendToUser(User $user, array $payload): int
    {
        $subs = PushSubscription::where('user_id', $user->id)->get();
        if ($subs->isEmpty()) return 0;

        $sent = 0;
        $json = json_encode($payload);
        foreach ($subs as $s) {
            $subscription = Subscription::create([
                'endpoint' => $s->endpoint,
                'publicKey' => $s->p256dh,
                'authToken' => $s->auth,
            ]);
            $this->webPush->queueNotification($subscription, $json);
        }

        foreach ($this->webPush->flush() as $ignored) {
            $sent++;
        }

        return $sent;
    }
}
