@props(['notes', 'title' => 'Заметки'])

<div class="note-list bg-white rounded-xl shadow-sm p-6 border border-gray-200">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-xl font-semibold text-gray-900">{{ $title }}</h3>
        <button class="p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
        </button>
    </div>
    
    @if($notes->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($notes as $note)
                <div class="flex flex-col p-4 rounded-lg border border-gray-200 hover:border-indigo-300 hover:shadow-sm transition-all duration-200">
                    <div class="flex items-start justify-between mb-3">
                        <h4 class="font-semibold text-gray-900">{{ Str::limit($note->title, 30) }}</h4>
                        <div class="flex gap-1">
                            <button class="p-1 rounded hover:bg-gray-100 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                            <button class="p-1 rounded hover:bg-gray-100 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    @if($note->content)
                        <p class="text-gray-600 text-sm mb-4 flex-1">
                            {{ Str::limit($note->content, 100) }}
                        </p>
                    @endif
                    <div class="flex items-center justify-between text-xs text-gray-500">
                        <span>{{ $note->updated_at->format('d.m.Y H:i') }}</span>
                        @if($note->tags->count() > 0)
                            <div class="flex gap-1">
                                @foreach($note->tags->take(3) as $tag)
                                    <span class="px-2 py-0.5 bg-gray-100 text-gray-600 rounded-full">
                                        {{ $tag->name }}
                                    </span>
                                @endforeach
                                @if($note->tags->count() > 3)
                                    <span class="px-2 py-0.5 bg-gray-100 text-gray-600 rounded-full">
                                        +{{ $note->tags->count() - 3 }}
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-8">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Нет заметок</h3>
            <p class="mt-1 text-sm text-gray-500">Создайте свою первую заметку, чтобы сохранить важную информацию.</p>
            <div class="mt-6">
                <button class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Создать заметку
                </button>
            </div>
        </div>
    @endif
</div>