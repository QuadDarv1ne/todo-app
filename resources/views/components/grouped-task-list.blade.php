@props(['tasks', 'groupBy' => 'date', 'groupLabels' => []])

<div class="grouped-task-list">
    @php
        $groupedTasks = $tasks->groupBy(function($task) use ($groupBy) {
            switch($groupBy) {
                case 'date':
                    return $task->created_at->format('Y-m-d');
                case 'priority':
                    return $task->priority ?? 'none';
                case 'category':
                    return $task->category_id ?? 'none';
                default:
                    return 'other';
            }
        });
    @endphp
    
    @foreach($groupedTasks as $group => $groupTasks)
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                @if($groupBy === 'date')
                    {{ \Carbon\Carbon::parse($group)->locale('ru')->isoFormat('D MMMM YYYY') }}
                @elseif(isset($groupLabels[$group]))
                    {{ $groupLabels[$group] }}
                @else
                    {{ ucfirst($group) }}
                @endif
                <span class="text-gray-500 text-base font-normal">({{ $groupTasks->count() }})</span>
            </h3>
            
            <div class="space-y-4">
                @foreach($groupTasks as $task)
                    <x-task-card :task="$task" />
                @endforeach
            </div>
        </div>
    @endforeach
    
    @if($tasks->hasPages())
        <div class="mt-8 flex justify-center">
            {{ $tasks->links() }}
        </div>
    @endif
</div>