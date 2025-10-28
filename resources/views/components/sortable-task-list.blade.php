@props(['tasks', 'sortable' => false])

<div class="sortable-task-list">
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
    
    @if($tasks->hasPages())
        <div class="mt-8 flex justify-center">
            {{ $tasks->links() }}
        </div>
    @endif
</div>