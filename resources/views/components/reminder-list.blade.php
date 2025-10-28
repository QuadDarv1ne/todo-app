@props(['reminders', 'title' => 'Напоминания'])

<div class="reminder-list bg-white rounded-xl shadow-sm p-6 border border-gray-200">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-xl font-semibold text-gray-900">{{ $title }}</h3>
        <button class="p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
        </button>
    </div>
    
    @if($reminders->count() > 0)
        <div class="space-y-4">
            @foreach($reminders as $reminder)
                @php
                    $isOverdue = $reminder->remind_at->isPast() && !$reminder->completed;
                    $borderClass = $isOverdue ? 'border-l-4 border-l-red-500' : '';
                @endphp
                
                <div class="flex items-start gap-4 p-4 rounded-lg border border-gray-200 {{ $borderClass }} hover:bg-gray-50 transition-colors duration-200">
                    <div class="flex-shrink-0 mt-1">
                        <input type="checkbox" 
                               class="h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500" 
                               {{ $reminder->completed ? 'checked' : '' }}>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-gray-900 {{ $reminder->completed ? 'line-through text-gray-500' : '' }}">
                            {{ $reminder->task->title ?? 'Напоминание' }}
                        </p>
                        <div class="flex items-center gap-2 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 {{ $isOverdue ? 'text-red-500' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-sm {{ $isOverdue ? 'text-red-600 font-medium' : 'text-gray-600' }}">
                                {{ $reminder->remind_at->format('d.m.Y H:i') }}
                                @if($isOverdue)
                                    (Просрочено)
                                @endif
                            </span>
                        </div>
                        @if($reminder->note)
                            <p class="text-sm text-gray-600 mt-2">
                                {{ Str::limit($reminder->note, 80) }}
                            </p>
                        @endif
                    </div>
                    <div class="flex-shrink-0 flex gap-1">
                        <button class="p-1.5 rounded hover:bg-gray-200 transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </button>
                        <button class="p-1.5 rounded hover:bg-gray-200 transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-8">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Нет напоминаний</h3>
            <p class="mt-1 text-sm text-gray-500">Создайте напоминания для своих задач, чтобы не забыть о важных делах.</p>
            <div class="mt-6">
                <button class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Создать напоминание
                </button>
            </div>
        </div>
    @endif
</div>