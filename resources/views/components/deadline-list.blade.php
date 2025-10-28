@props(['tasks', 'title' => 'Ближайшие дедлайны'])

<div class="deadline-list bg-white rounded-xl shadow-sm p-6 border border-gray-200">
    <h3 class="text-xl font-semibold text-gray-900 mb-6">{{ $title }}</h3>
    
    @if($tasks->count() > 0)
        <div class="space-y-4">
            @foreach($tasks as $task)
                @php
                    $daysUntil = now()->diffInDays($task->deadline, false);
                    $urgencyClass = $daysUntil < 0 ? 'bg-red-50 border-red-200' : ($daysUntil <= 1 ? 'bg-orange-50 border-orange-200' : ($daysUntil <= 3 ? 'bg-yellow-50 border-yellow-200' : 'bg-gray-50 border-gray-200'));
                    $urgencyText = $daysUntil < 0 ? 'text-red-800' : ($daysUntil <= 1 ? 'text-orange-800' : ($daysUntil <= 3 ? 'text-yellow-800' : 'text-gray-800'));
                @endphp
                
                <div class="flex items-center gap-4 p-4 rounded-lg border {{ $urgencyClass }} transition-colors duration-200">
                    <div class="flex-shrink-0">
                        <input type="checkbox" 
                               class="h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500" 
                               {{ $task->completed ? 'checked' : '' }}
                               data-task-id="{{ $task->id }}">
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-gray-900 {{ $task->completed ? 'line-through text-gray-500' : '' }}">
                            {{ $task->title }}
                        </p>
                        <div class="flex items-center gap-2 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 {{ $urgencyText }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-sm {{ $urgencyText }}">
                                @if($daysUntil < 0)
                                    Просрочено на {{ abs($daysUntil) }} {{ trans_choice('день|дня|дней', abs($daysUntil)) }}
                                @elseif($daysUntil == 0)
                                    Сегодня
                                @elseif($daysUntil == 1)
                                    Завтра
                                @else
                                    Через {{ $daysUntil }} {{ trans_choice('день|дня|дней', $daysUntil) }}
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="flex-shrink-0">
                        <a href="{{ route('tasks.edit', $task) }}" 
                           class="p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-8">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Нет ближайших дедлайнов</h3>
            <p class="mt-1 text-sm text-gray-500">Все задачи выполнены или не имеют установленных сроков.</p>
        </div>
    @endif
</div>