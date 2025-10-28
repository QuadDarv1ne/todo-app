@props(['task', 'showActions' => true])

<div class="task-card bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-lg transition-all duration-300 overflow-hidden">
    <div class="p-5">
        <div class="flex items-start gap-4">
            @if($showActions)
                <div class="pt-1">
                    <input
                        type="checkbox"
                        class="task-toggle h-5 w-5 text-indigo-600 rounded-full focus:ring-2 focus:ring-indigo-500 cursor-pointer flex-shrink-0 transition-all duration-200"
                        {{ $task->completed ? 'checked' : '' }}
                        data-id="{{ $task->id }}"
                    >
                </div>
            @endif
            
            <div class="flex-1 min-w-0">
                <div class="flex items-start justify-between gap-3">
                    <p class="task-title text-lg font-semibold {{ $task->completed ? 'line-through text-gray-400' : 'text-gray-900' }} break-words transition-colors duration-200">
                        {{ $task->title }}
                    </p>
                    
                    @if($showActions)
                        <div class="flex items-center gap-2 flex-shrink-0">
                            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $task->completed ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }} transition-colors duration-200">
                                {{ $task->completed ? 'Завершено' : 'Активно' }}
                            </span>
                        </div>
                    @endif
                </div>
                
                @if($task->description)
                    <p class="task-description text-gray-600 mt-3 break-words leading-relaxed">
                        {{ Str::limit($task->description, 150) }}
                    </p>
                @endif
                
                <div class="flex items-center gap-3 mt-4 text-sm text-gray-500">
                    <span class="flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ $task->created_at->format('d.m.Y H:i') }}
                    </span>
                    @if($task->updated_at != $task->created_at)
                        <span>•</span>
                        <span class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1h-3a1 1 0 01-1-1v-3a1 1 0 011-1h1a2 2 0 100-4h-1a1 1 0 01-1-1v-3a1 1 0 011-1h3a1 1 0 001-1V4z" />
                            </svg>
                            {{ $task->updated_at->format('d.m.Y H:i') }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
        
        @if($showActions)
            <div class="flex items-center justify-between mt-5 pt-4 border-t border-gray-100">
                <div class="flex items-center gap-2">
                    @if(!$task->completed)
                        <button 
                            class="edit-task p-2 rounded-lg text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 transition-all duration-200"
                            data-id="{{ $task->id }}"
                            title="Редактировать задачу"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </button>
                    @endif
                </div>
                
                <button
                    class="delete-task p-2 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-all duration-200"
                    data-id="{{ $task->id }}"
                    title="Удалить задачу"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </div>
        @endif
    </div>
</div>