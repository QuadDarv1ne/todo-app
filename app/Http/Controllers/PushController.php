<?php

namespace App\Http\Controllers;

use App\Models\PushSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;

class PushController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'endpoint' => 'required|url',
            'keys.p256dh' => 'required|string',
            'keys.auth' => 'required|string',
        ]);

        $userId = Auth::id();
        $endpoint = $request->input('endpoint');
        $p256dh = $request->input('keys.p256dh');
        $auth = $request->input('keys.auth');

        $sub = PushSubscription::updateOrCreate(
            ['endpoint' => $endpoint],
            ['user_id' => $userId, 'p256dh' => $p256dh, 'auth' => $auth]
        );

        return response()->json(['status' => 'ok']);
    }

    public function unsubscribe(Request $request)
    {
        $request->validate(['endpoint' => 'required|url']);
        PushSubscription::where('endpoint', $request->input('endpoint'))->delete();
        return response()->json(['status' => 'ok']);
    }

    public function test(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $subs = PushSubscription::where('user_id', $user->id)->get();
        if ($subs->isEmpty()) {
            return response()->json(['error' => 'No subscriptions'], 404);
        }

        $auth = [
            'VAPID' => [
                'subject' => config('app.url', url('/')),
                'publicKey' => (string) config('push.vapid_public_key'),
                'privateKey' => (string) config('push.vapid_private_key'),
            ]
        ];

        $webPush = new WebPush($auth);
        foreach ($subs as $s) {
            $subscription = Subscription::create([
                'endpoint' => $s->endpoint,
                'publicKey' => $s->p256dh,
                'authToken' => $s->auth,
            ]);

            $payload = json_encode([
                'title' => 'TODO App',
                'body' => 'Тестовое push-уведомление',
                'icon' => '/icons/any-192.svg',
                'url' => url('/tasks'),
            ]);

            $webPush->queueNotification($subscription, $payload);
        }

        foreach ($webPush->flush() as $report) {
            if (!$report->isSuccess()) {
                Log::warning('Push send failed', ['endpoint' => $report->getEndpoint(), 'reason' => $report->getReason()]);
            }
        }

        return response()->json(['status' => 'sent']);
    }
}
