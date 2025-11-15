<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Уведомления') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Заголовок с кнопкой "Отметить все как прочитанные" -->
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">
                            Все уведомления
                            @if($unreadCount > 0)
                                <span class="ml-2 px-2 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">
                                    {{ $unreadCount }} непрочитанных
                                </span>
                            @endif
                        </h3>
                        
                        @if($unreadCount > 0)
                            <form method="POST" action="{{ route('notifications.readAll') }}" class="inline">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                                    Отметить все как прочитанные
                                </button>
                            </form>
                        @endif
                    </div>

                    <!-- Список уведомлений -->
                    @forelse($notifications as $notification)
                        <div class="border-b border-gray-200 py-4 {{ $notification->read_at ? 'bg-white' : 'bg-blue-50' }}">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <!-- Иконка типа уведомления -->
                                    <div class="flex items-center mb-2">
                                        @if($notification->type === 'App\Notifications\TaskDueReminder')
                                            <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @elseif($notification->type === 'App\Notifications\TaskLimitApproaching')
                                            <svg class="w-5 h-5 text-orange-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @endif
                                        
                                        <span class="font-semibold text-gray-900">
                                            {{ $notification->data['task_title'] ?? 'Уведомление' }}
                                        </span>
                                        
                                        @if(!$notification->read_at)
                                            <span class="ml-2 w-2 h-2 bg-blue-600 rounded-full"></span>
                                        @endif
                                    </div>
                                    
                                    <!-- Сообщение уведомления -->
                                    <p class="text-sm text-gray-700 mb-2">
                                        {{ $notification->data['message'] ?? 'Новое уведомление' }}
                                    </p>
                                    
                                    <!-- Дополнительная информация -->
                                    @if(isset($notification->data['due_date']))
                                        <p class="text-xs text-gray-500">
                                            Срок: {{ \Carbon\Carbon::parse($notification->data['due_date'])->format('d.m.Y H:i') }}
                                        </p>
                                    @endif
                                    
                                    <!-- Время получения -->
                                    <p class="text-xs text-gray-400 mt-1">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                
                                <!-- Действия -->
                                <div class="flex gap-2 ml-4">
                                    @if(!$notification->read_at)
                                        <form method="POST" action="{{ route('notifications.read', $notification->id) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                Прочитано
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <form method="POST" action="{{ route('notifications.destroy', $notification->id) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                            Удалить
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            <p class="text-gray-500 text-lg font-medium">Нет уведомлений</p>
                            <p class="text-gray-400 text-sm mt-1">Вы в курсе всех событий!</p>
                        </div>
                    @endforelse

                    <!-- Пагинация -->
                    @if($notifications->hasPages())
                        <div class="mt-6">
                            {{ $notifications->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
