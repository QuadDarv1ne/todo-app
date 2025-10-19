<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\TaskHelper;

class TaskHelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('task-helper', function () {
            return new TaskHelper();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}