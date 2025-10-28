@props(['tasks', 'currentDate' => null])

@php
    $currentDate = $currentDate ?? now();
    $startOfMonth = $currentDate->copy()->startOfMonth();
    $endOfMonth = $currentDate->copy()->endOfMonth();
    $startOfWeek = $startOfMonth->copy()->startOfWeek();
    $endOfWeek = $endOfMonth->copy()->endOfWeek();
    
    // Group tasks by date
    $tasksByDate = $tasks->groupBy(function($task) {
        return $task->created_at->format('Y-m-d');
    });
@endphp

<div class="task-calendar bg-white rounded-xl shadow-sm p-6 border border-gray-200">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-xl font-semibold text-gray-900">
            {{ $currentDate->locale('ru')->isoFormat('MMMM YYYY') }}
        </h3>
        <div class="flex gap-2">
            <a href="?date={{ $currentDate->copy()->subMonth()->format('Y-m') }}" 
               class="p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <a href="?date={{ $currentDate->copy()->addMonth()->format('Y-m') }}" 
               class="p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    </div>
    
    <!-- Week days header -->
    <div class="grid grid-cols-7 gap-1 mb-2">
        @foreach(['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'] as $day)
            <div class="text-center text-sm font-medium text-gray-500 py-2">{{ $day }}</div>
        @endforeach
    </div>
    
    <!-- Calendar grid -->
    <div class="grid grid-cols-7 gap-1">
        @php
            $date = $startOfWeek->copy();
        @endphp
        
        @while($date->lte($endOfWeek))
            @php
                $isCurrentMonth = $date->month === $currentDate->month;
                $isToday = $date->isToday();
                $dateString = $date->format('Y-m-d');
                $dayTasks = $tasksByDate->get($dateString, collect());
            @endphp
            
            <div class="min-h-24 p-2 border border-gray-100 rounded-lg {{ $isCurrentMonth ? '' : 'bg-gray-50' }} {{ $isToday ? 'bg-indigo-50 border-indigo-200' : '' }}">
                <div class="text-right">
                    <span class="text-sm {{ $isCurrentMonth ? 'text-gray-900' : 'text-gray-400' }} {{ $isToday ? 'font-bold text-indigo-600' : '' }}">
                        {{ $date->day }}
                    </span>
                </div>
                
                @if($dayTasks->count() > 0)
                    <div class="mt-1 space-y-1">
                        @foreach($dayTasks->take(3) as $task)
                            <div class="text-xs p-1 bg-indigo-100 text-indigo-800 rounded truncate" 
                                 title="{{ $task->title }}">
                                {{ Str::limit($task->title, 15) }}
                            </div>
                        @endforeach
                        @if($dayTasks->count() > 3)
                            <div class="text-xs text-gray-500">
                                +{{ $dayTasks->count() - 3 }} ещё
                            </div>
                        @endif
                    </div>
                @endif
            </div>
            
            @php
                $date->addDay();
            @endphp
        @endwhile
    </div>
</div>