@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Dashboard') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-gray-800 mb-6">Добро пожаловать, {{ Auth::user()->name }}!</h3>
                        
                        <!-- Stats Cards -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-md p-6 text-white">
                                <div class="flex items-center">
                                    <div class="text-3xl font-bold">{{ $totalTasks }}</div>
                                    <div class="ml-4">
                                        <div class="text-sm">Всего задач</div>
                                        <div class="text-xs opacity-75">Все ваши задачи</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-lg shadow-md p-6 text-white">
                                <div class="flex items-center">
                                    <div class="text-3xl font-bold">{{ $pendingTasks }}</div>
                                    <div class="ml-4">
                                        <div class="text-sm">Активные</div>
                                        <div class="text-xs opacity-75">Еще не завершены</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg shadow-md p-6 text-white">
                                <div class="flex items-center">
                                    <div class="text-3xl font-bold">{{ $completedTasks }}</div>
                                    <div class="ml-4">
                                        <div class="text-sm">Завершены</div>
                                        <div class="text-xs opacity-75">Выполненные задачи</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Progress Bar -->
                        @if($totalTasks > 0)
                        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                            <div class="flex justify-between items-center mb-3">
                                <h3 class="text-lg font-semibold text-gray-900">Прогресс выполнения</h3>
                                <span class="text-2xl font-bold text-indigo-600">{{ $completionPercentage }}%</span>
                            </div>
                            <div class="h-4 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-indigo-500 to-purple-600 transition-all duration-500 rounded-full" 
                                     style="width: {{ $completionPercentage }}%"></div>
                            </div>
                            <div class="mt-2 text-sm text-gray-600">{{ $completedTasks }} из {{ $totalTasks }} задач выполнено</div>
                        </div>
                        @endif
                        
                        <!-- Recent Tasks -->
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Последние задачи</h3>
                            
                            @if($recentTasks->count() > 0)
                                <div class="space-y-4">
                                    @foreach($recentTasks as $task)
                                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                                            <div class="flex items-center">
                                                <input type="checkbox" 
                                                       class="h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500" 
                                                       {{ $task->completed ? 'checked' : '' }}
                                                       disabled>
                                                <div class="ml-4">
                                                    <div class="font-medium text-gray-900 {{ $task->completed ? 'line-through text-gray-500' : '' }}">
                                                        {{ $task->title }}
                                                    </div>
                                                    @if($task->description)
                                                        <div class="text-sm text-gray-500 mt-1">
                                                            {{ Str::limit($task->description, 60) }}
                                                        </div>
                                                    @endif
                                                    <div class="text-xs text-gray-400 mt-1">
                                                        Создано: {{ $task->created_at->format('d.m.Y H:i') }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="px-2 py-1 rounded-full text-xs font-medium 
                                                {{ $task->completed ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ $task->completed ? 'Завершено' : 'Активно' }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mt-6">
                                    <a href="{{ route('tasks.index') }}" 
                                       class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Просмотреть все задачи
                                    </a>
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">Нет задач</h3>
                                    <p class="mt-1 text-sm text-gray-500">Начните с создания своей первой задачи.</p>
                                    <div class="mt-6">
                                        <a href="{{ route('tasks.index') }}" 
                                           class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
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
    </div>
@endsection