@props(['icon', 'title', 'description', 'color' => 'indigo'])

<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-300">
    <div class="flex items-start gap-4">
        <div class="flex-shrink-0 p-3 rounded-lg bg-{{ $color }}-100 text-{{ $color }}-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                {!! $icon !!}
            </svg>
        </div>
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $title }}</h3>
            <p class="text-gray-600">{{ $description }}</p>
        </div>
    </div>
</div>