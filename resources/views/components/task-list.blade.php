@props(['tasks', 'sortable' => false])

<div class="task-list">
    @if($sortable)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-4">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Сортировка задач</h3>
                <div class="flex items-center gap-2">
                    <button class="sort-btn px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 rounded-lg transition"
                            data-sort="created_at">
                        По дате
                    </button>
                    <button class="sort-btn px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 rounded-lg transition"
                            data-sort="title">
                        По названию
                    </button>
                    <button class="sort-btn px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 rounded-lg transition"
                            data-sort="order">
                        По порядку
                    </button>
                </div>
            </div>
        </div>
    @endif
    
    <div class="space-y-3 {{ $sortable ? 'sortable-tasks' : '' }}">
        @foreach($tasks as $task)
            <x-task-card :task="$task" />
        @endforeach
    </div>
</div>