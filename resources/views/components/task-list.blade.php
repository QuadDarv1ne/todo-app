@props(['tasks', 'sortable' => false])

<div class="task-list">
    @if($sortable)
        <div class="sortable-tasks space-y-5" data-sortable="true">
            @foreach($tasks as $task)
                <x-task-card :task="$task" />
            @endforeach
        </div>
    @else
        <div class="space-y-5">
            @foreach($tasks as $task)
                <x-task-card :task="$task" />
            @endforeach
        </div>
    @endif
</div>