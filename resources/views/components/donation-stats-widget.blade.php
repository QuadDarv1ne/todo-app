@props(['donationsCount', 'totalAmount', 'currenciesCount'])

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Донаты</p>
                <p class="text-2xl font-bold text-gray-900">{{ $donationsCount }}</p>
            </div>
            <div class="bg-indigo-100 rounded-full p-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-gray-500">В {{ $currenciesCount }} валютах на сумму </span>
            <span class="ml-1 font-medium text-gray-900">{{ number_format($totalAmount, 2, '.', ' ') }}</span>
        </div>
    </div>
    <div class="bg-gray-50 px-5 py-3 border-t border-gray-100">
        <a href="{{ route('donations.my') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 flex items-center">
            Подробнее
            <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>
</div>