<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Панель управления</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total Tasks -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="text-3xl font-bold text-gray-900">{{ $totalTasks }}</div>
                            <div class="ml-4 text-gray-500">Всего задач</div>
                        </div>
                        <div class="mt-4">
                            <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full bg-indigo-600 rounded-full" 
                                     style="width: <?php echo $completionPercentage; ?>%"></div>
                            </div>
                            <div class="mt-2 text-sm text-gray-500">
                                {{ $completedTasks }} завершено
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Tasks -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="text-3xl font-bold text-indigo-600">{{ $pendingTasks }}</div>
                            <div class="ml-4 text-gray-500">Активные задачи</div>
                        </div>
                        <div class="mt-4">
                            <p class="text-sm text-gray-500">
                                Задачи, требующие вашего внимания
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Completed Tasks -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="text-3xl font-bold text-green-600">{{ $completedTasks }}</div>
                            <div class="ml-4 text-gray-500">Завершено</div>
                        </div>
                        <div class="mt-4">
                            <p class="text-sm text-gray-500">
                                Задачи, успешно выполненные
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900">Быстрые действия</h3>
                        <a href="{{ route('tasks.index') }}" class="text-indigo-600 hover:text-indigo-900">
                            Просмотреть все задачи
                        </a>
                    </div>
                    <div class="mt-4 flex flex-wrap gap-4">
                        <a href="{{ route('tasks.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Создать задачу
                        </a>
                        <a href="{{ route('tasks.index', ['filter' => 'pending']) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            </svg>
                            Активные задачи
                        </a>
                        <a href="{{ route('tasks.index', ['filter' => 'completed']) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Завершенные задачи
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Tasks -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900">Последние задачи</h3>
                        <a href="{{ route('tasks.index') }}" class="text-indigo-600 hover:text-indigo-900">
                            Просмотреть все
                        </a>
                    </div>
                    <div class="mt-4">
                        @if($recentTasks->count() > 0)
                            <ul class="divide-y divide-gray-200">
                                @foreach($recentTasks as $task)
                                    <li class="py-4">
                                        <div class="flex items-center">
                                            <input type="checkbox" 
                                                   class="h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500" 
                                                   {{ $task->completed ? 'checked' : '' }}
                                                   disabled>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900 {{ $task->completed ? 'line-through text-gray-500' : '' }}">
                                                    {{ $task->title }}
                                                </p>
                                                @if($task->description)
                                                    <p class="text-sm text-gray-500 truncate max-w-md">
                                                        {{ $task->description }}
                                                    </p>
                                                @endif
                                                <p class="text-xs text-gray-400 mt-1">
                                                    Создано {{ $task->created_at->format('d.m.Y H:i') }}
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Нет задач</h3>
                                <p class="mt-1 text-sm text-gray-500">Создайте свою первую задачу, чтобы начать.</p>
                                <div class="mt-6">
                                    <a href="{{ route('tasks.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                        </svg>
                                        Создать задачу
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>