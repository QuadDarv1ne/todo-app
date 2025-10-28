@props(['achievements', 'title' => 'Достижения'])

<div class="achievement-list bg-white rounded-xl shadow-sm p-6 border border-gray-200">
    <h3 class="text-xl font-semibold text-gray-900 mb-6">{{ $title }}</h3>
    
    @if($achievements->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($achievements as $achievement)
                <div class="flex items-center gap-4 p-4 rounded-lg border {{ $achievement->unlocked ? 'border-green-200 bg-green-50' : 'border-gray-200 bg-gray-50' }} transition-colors duration-200">
                    <div class="flex-shrink-0">
                        @if($achievement->unlocked)
                            <div class="h-12 w-12 rounded-full bg-green-100 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        @else
                            <div class="h-12 w-12 rounded-full bg-gray-100 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-gray-900">
                            {{ $achievement->title }}
                            @if($achievement->unlocked)
                                <span class="ml-2 px-2 py-0.5 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                    Получено
                                </span>
                            @endif
                        </p>
                        <p class="text-sm text-gray-600 mt-1">
                            {{ $achievement->description }}
                        </p>
                        @if(!$achievement->unlocked && $achievement->progress !== null)
                            <div class="mt-2">
                                <div class="flex items-center justify-between text-xs text-gray-500 mb-1">
                                    <span>Прогресс</span>
                                    <span>{{ $achievement->progress }}/{{ $achievement->target }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                    <div class="bg-indigo-600 h-2 rounded-full progress-bar" 
                                         data-progress="{{ min(100, round(($achievement->progress / $achievement->target) * 100)) }}">
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-8">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Нет достижений</h3>
            <p class="mt-1 text-sm text-gray-500">Выполните задачи, чтобы разблокировать достижения и отпразднуйте свой прогресс!</p>
        </div>
    @endif
</div>

<style>
    .progress-bar {
        width: 0%;
        transition: width 0.5s ease;
    }
    
    /* JavaScript will update the width based on data-progress attribute */
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.progress-bar').forEach(function(bar) {
            const progress = bar.getAttribute('data-progress');
            bar.style.width = progress + '%';
        });
    });
</script>