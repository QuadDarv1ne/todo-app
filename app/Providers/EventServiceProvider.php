<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Models\User;
use App\Observers\UserObserver;
use App\Events\TaskCreated;
use App\Events\TaskUpdated;
use App\Events\TaskDeleted;
use App\Listeners\ClearTaskCache;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Карта слушателей событий приложения.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        TaskCreated::class => [
            ClearTaskCache::class,
        ],
        TaskUpdated::class => [
            ClearTaskCache::class,
        ],
        TaskDeleted::class => [
            ClearTaskCache::class,
        ],
    ];

    /**
     * Определяет, должны ли события быть автоматически обнаружены.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }

    /**
     * Регистрация любых событий приложения.
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);
    }
}