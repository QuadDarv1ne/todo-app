@props(['user', 'stats' => []])

<div class="user-profile-card bg-white rounded-xl shadow-sm p-6 border border-gray-200">
    <div class="flex items-center gap-5">
        <div class="flex-shrink-0">
            <div class="h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center">
                <span class="text-xl font-bold text-indigo-700">{{ substr($user->name, 0, 1) }}</span>
            </div>
        </div>
        <div class="flex-1 min-w-0">
            <h3 class="text-xl font-bold text-gray-900">{{ $user->name }}</h3>
            <p class="text-gray-600">{{ $user->email }}</p>
            @if(!empty($stats))
                <div class="flex gap-4 mt-3">
                    @foreach($stats as $stat)
                        <div class="text-center">
                            <div class="text-lg font-bold text-gray-900">{{ $stat['value'] }}</div>
                            <div class="text-xs text-gray-500">{{ $stat['label'] }}</div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    
    <div class="mt-6 pt-6 border-t border-gray-200">
        <div class="flex gap-3">
            <a href="{{ route('profile.edit') }}" 
               class="flex-1 text-center px-4 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors duration-200">
                Редактировать профиль
            </a>
            <a href="{{ route('tasks.index') }}" 
               class="flex-1 text-center px-4 py-2 bg-white border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors duration-200">
                Мои задачи
            </a>
        </div>
    </div>
</div>