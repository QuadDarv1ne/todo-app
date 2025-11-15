@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">📋 Мои задачи</h1>
            <p class="mt-2 text-sm text-gray-600">Управляйте своими задачами эффективно</p>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <form action="{{ route('tasks.index') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Поиск</label>
                        <input 
                            type="text" 
                            name="search" 
                            id="search" 
                            value="{{ request('search') }}"
                            placeholder="Поиск задач..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        >
                    </div>

                    <!-- Filter -->
                    <div>
                        <label for="filter" class="block text-sm font-medium text-gray-700 mb-2">Фильтр</label>
                        <select 
                            name="filter" 
                            id="filter"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        >
                            <option value="all" {{ $filter === 'all' ? 'selected' : '' }}>Все задачи</option>
                            <option value="active" {{ $filter === 'active' ? 'selected' : '' }}>Активные</option>
                            <option value="completed" {{ $filter === 'completed' ? 'selected' : '' }}>Завершённые</option>
                            <option value="today" {{ $filter === 'today' ? 'selected' : '' }}>На сегодня</option>
                            <option value="week" {{ $filter === 'week' ? 'selected' : '' }}>На неделю</option>
                            <option value="overdue" {{ $filter === 'overdue' ? 'selected' : '' }}>Просроченные</option>
                        </select>
                    </div>

                    <!-- Priority -->
                    <div>
                        <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">Приоритет</label>
                        <select 
                            name="priority" 
                            id="priority"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        >
                            <option value="">Все</option>
                            <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>Высокий</option>
                            <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>Средний</option>
                            <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>Низкий</option>
                        </select>
                    </div>

                    <!-- Tag -->
                    @if($userTags && $userTags->isNotEmpty())
                    <div>
                        <label for="tag" class="block text-sm font-medium text-gray-700 mb-2">Тег</label>
                        <select 
                            name="tag" 
                            id="tag"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        >
                            <option value="">Все теги</option>
                            @foreach($userTags as $tag)
                                <option value="{{ $tag->id }}" {{ request('tag') == $tag->id ? 'selected' : '' }}>
                                    {{ $tag->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                        🔍 Применить фильтры
                    </button>
                    <a href="{{ route('tasks.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                        ✖️ Сбросить
                    </a>
                </div>
            </form>
        </div>

        <!-- Tasks List -->
        @if($tasks->isEmpty())
            <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                <div class="text-6xl mb-4">📝</div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Задачи не найдены</h3>
                <p class="text-gray-600">Создайте свою первую задачу или измените фильтры</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($tasks as $task)
                    <div class="task-card bg-white rounded-lg shadow-sm p-6 hover:shadow-md transition-shadow border-l-4 {{ $task->completed ? 'border-green-500' : 'border-indigo-500' }}">
                        <div class="flex items-start gap-4">
                            <!-- Checkbox -->
                            <div class="flex-shrink-0 mt-1">
                                <input 
                                    type="checkbox" 
                                    class="task-toggle w-5 h-5 text-indigo-600 rounded focus:ring-2 focus:ring-indigo-500 cursor-pointer"
                                    data-id="{{ $task->id }}"
                                    {{ $task->completed ? 'checked' : '' }}
                                >
                            </div>

                            <!-- Task Content -->
                            <div class="flex-grow">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="flex-grow">
                                        <h3 class="task-title text-lg font-semibold {{ $task->completed ? 'line-through text-gray-400' : 'text-gray-900' }}">
                                            {{ $task->title }}
                                        </h3>
                                        
                                        @if($task->description)
                                            <p class="mt-2 text-sm text-gray-600">{{ $task->description }}</p>
                                        @endif

                                        <!-- Meta info -->
                                        <div class="mt-3 flex flex-wrap gap-3 text-sm">
                                            <!-- Priority -->
                                            @if($task->priority)
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                                    {{ $task->priority === 'high' ? 'bg-red-100 text-red-800' : '' }}
                                                    {{ $task->priority === 'medium' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                    {{ $task->priority === 'low' ? 'bg-green-100 text-green-800' : '' }}
                                                ">
                                                    {{ $task->priority === 'high' ? '🔴 Высокий' : '' }}
                                                    {{ $task->priority === 'medium' ? '🟡 Средний' : '' }}
                                                    {{ $task->priority === 'low' ? '🟢 Низкий' : '' }}
                                                </span>
                                            @endif

                                            <!-- Due date -->
                                            @if($task->due_date)
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    📅 {{ \Carbon\Carbon::parse($task->due_date)->format('d.m.Y') }}
                                                </span>
                                            @endif

                                            <!-- Status -->
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                                {{ $task->completed ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}
                                            ">
                                                {{ $task->completed ? '✅ Завершено' : '⏳ Активно' }}
                                            </span>

                                            <!-- Tags -->
                                            @if($task->tags && $task->tags->isNotEmpty())
                                                @foreach($task->tags as $tag)
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                        🏷️ {{ $tag->name }}
                                                    </span>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex-shrink-0 flex gap-2">
                                        <button 
                                            class="edit-task p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                            data-id="{{ $task->id }}"
                                            title="Редактировать"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>

                                        <button 
                                            class="delete-task p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                            data-id="{{ $task->id }}"
                                            title="Удалить"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $tasks->links() }}
            </div>
        @endif
    </div>
</div>
@endsection