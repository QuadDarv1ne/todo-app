@props(['items', 'title' => 'Прогресс'])

<div class="progress-list bg-white rounded-xl shadow-sm p-6 border border-gray-200">
    <h3 class="text-xl font-semibold text-gray-900 mb-6">{{ $title }}</h3>
    <div class="space-y-4">
        @foreach($items as $item)
            <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                <div class="flex items-center gap-3">
                    <div class="flex-shrink-0">
                        @if($item['completed'])
                            <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        @else
                            <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">{{ $item['title'] }}</p>
                        <p class="text-sm text-gray-500">{{ $item['description'] }}</p>
                    </div>
                </div>
                <div class="text-sm font-medium {{ $item['completed'] ? 'text-green-600' : 'text-yellow-600' }}">
                    {{ $item['completed'] ? 'Завершено' : 'В процессе' }}
                </div>
            </div>
        @endforeach
    </div>
</div>