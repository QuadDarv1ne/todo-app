@props(['goals', 'title' => 'Цели'])

<div class="goal-list bg-white rounded-xl shadow-sm p-6 border border-gray-200">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-xl font-semibold text-gray-900">{{ $title }}</h3>
        <button class="p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
        </button>
    </div>
    
    @if($goals->count() > 0)
        <div class="space-y-4">
            @foreach($goals as $goal)
                <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                    <input type="checkbox" 
                           class="h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500" 
                           {{ $goal->completed ? 'checked' : '' }}>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-gray-900 {{ $goal->completed ? 'line-through text-gray-500' : '' }}">
                            {{ $goal->title }}
                        </p>
                        @if($goal->description)
                            <p class="text-sm text-gray-600 mt-1">
                                {{ Str::limit($goal->description, 60) }}
                            </p>
                        @endif
                        @if($goal->deadline)
                            <p class="text-xs text-gray-500 mt-2">
                                Срок: {{ $goal->deadline->format('d.m.Y') }}
                            </p>
                        @endif
                    </div>
                    <div class="flex-shrink-0">
                        @if($goal->progress !== null)
                            <div class="relative w-10 h-10">
                                <svg class="w-full h-full" viewBox="0 0 36 36">
                                    <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" 
                                          fill="none" stroke="#eee" stroke-width="3"></path>
                                    <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" 
                                          fill="none" stroke="#6366f1" stroke-width="3" 
                                          stroke-dasharray="{{ $goal->progress }}, 100"></path>
                                    <text x="18" y="20.5" text-anchor="middle" fill="#6366f1" font-size="8" font-weight="bold">
                                        {{ $goal->progress }}%
                                    </text>
                                </svg>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-8">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Нет целей</h3>
            <p class="mt-1 text-sm text-gray-500">Создайте свою первую цель, чтобы начать отслеживать прогресс.</p>
            <div class="mt-6">
                <button class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Создать цель
                </button>
            </div>
        </div>
    @endif
</div>