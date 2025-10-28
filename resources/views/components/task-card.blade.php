@props(['task', 'showActions' => true])

<div class="task-card bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
    <div class="p-4">
        <div class="flex items-start gap-3">
            @if($showActions)
                <input
                    type="checkbox"
                    class="task-toggle mt-1 h-5 w-5 text-indigo-600 rounded focus:ring-2 focus:ring-indigo-500 cursor-pointer flex-shrink-0"
                    {{ $task->completed ? 'checked' : '' }}
                    data-id="{{ $task->id }}"
                >
            @endif
            
            <div class="flex-1 min-w-0">
                <div class="flex items-start justify-between gap-2">
                    <p class="task-title text-base font-medium {{ $task->completed ? 'line-through text-gray-400' : 'text-gray-900' }} break-words">
                        {{ $task->title }}
                    </p>
                    
                    @if($showActions)
                        <div class="flex items-center gap-1 flex-shrink-0">
                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $task->completed ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $task->completed ? 'Завершено' : 'Активно' }}
                            </span>
                        </div>
                    @endif
                </div>
                
                @if($task->description)
                    <p class="task-description text-sm text-gray-600 mt-2 break-words">
                        {{ Str::limit($task->description, 100) }}
                    </p>
                @endif
                
                <div class="flex items-center gap-2 mt-3 text-xs text-gray-500">
                    <span>Создано: {{ $task->created_at->format('d.m.Y H:i') }}</span>
                    @if($task->updated_at != $task->created_at)
                        <span>•</span>
                        <span>Обновлено: {{ $task->updated_at->format('d.m.Y H:i') }}</span>
                    @endif
                </div>
            </div>
        </div>
        
        @if($showActions)
            <div class="flex items-center justify-between mt-4 pt-3 border-t border-gray-100">
                <div class="flex items-center gap-2">
                    @if(!$task->completed)
                        <button 
                            class="edit-task text-gray-500 hover:text-indigo-600 transition p-1"
                            data-id="{{ $task->id }}"
                            title="Редактировать задачу"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </button>
                    @endif
                </div>
                
                <button
                    class="delete-task text-gray-400 hover:text-red-600 transition p-1"
                    data-id="{{ $task->id }}"
                    title="Удалить задачу"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </div>
        @endif
    </div>
</div>