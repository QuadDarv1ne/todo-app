<?php

namespace App\Listeners;

use App\Events\TaskCreated;
use App\Events\TaskUpdated;
use App\Events\TaskDeleted;
use App\Helpers\TaskHelper;
use Illuminate\Contracts\Queue\ShouldQueue;

class ClearTaskCache implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TaskCreated|TaskUpdated|TaskDeleted $event): void
    {
        TaskHelper::clearUserTasksCache($event->task->user);
    }
}
