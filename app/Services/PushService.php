<?php

namespace App\Services;

use App\Models\PushSubscription;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;

class PushService
{
    protected ?WebPush $webPush = null;
    protected bool $enabled = false;

    public function __construct()
    {
        $publicKey = config('push.vapid_public_key');
        $privateKey = config('push.vapid_private_key');

        // Проверяем наличие и корректность VAPID ключей
        if (empty($publicKey) || empty($privateKey) || 
            strlen($publicKey) < 20 || strlen($privateKey) < 20) {
            Log::warning('Push notifications disabled: VAPID keys not configured');
            $this->enabled = false;
            return;
        }

        try {
            $auth = [
                'VAPID' => [
                    'subject' => config('app.url', url('/')),
                    'publicKey' => (string) $publicKey,
                    'privateKey' => (string) $privateKey,
                ]
            ];
            $this->webPush = new WebPush($auth);
            $this->enabled = true;
        } catch (\Exception $e) {
            Log::error('Failed to initialize WebPush: ' . $e->getMessage());
            $this->enabled = false;
        }
    }

    /**
     * Проверить, включены ли push-уведомления
     */
    public function isEnabled(): bool
    {
        return $this->enabled && $this->webPush !== null;
    }

    /**
     * Отправить Web Push уведомление всем подпискам пользователя
     */
    public function sendToUser(User $user, array $payload): int
    {
        if (!$this->isEnabled()) {
            Log::info('Push notifications not sent: service is disabled');
            return 0;
        }

        $subs = PushSubscription::where('user_id', $user->id)->get();
        if ($subs->isEmpty()) {
            return 0;
        }

        $sent = 0;
        $json = json_encode($payload);
        
        foreach ($subs as $s) {
            try {
                $subscription = Subscription::create([
                    'endpoint' => $s->endpoint,
                    'publicKey' => $s->p256dh,
                    'authToken' => $s->auth,
                ]);
                $this->webPush->queueNotification($subscription, $json);
            } catch (\Exception $e) {
                Log::error('Failed to queue notification: ' . $e->getMessage());
                continue;
            }
        }

        try {
            foreach ($this->webPush->flush() as $report) {
                if ($report->isSuccess()) {
                    $sent++;
                } else {
                    Log::warning('Push notification failed', [
                        'endpoint' => $report->getEndpoint(),
                        'reason' => $report->getReason(),
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error('Failed to flush notifications: ' . $e->getMessage());
        }

        return $sent;
    }
}
