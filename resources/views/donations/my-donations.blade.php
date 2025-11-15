@extends('layouts.app')

@section('title', 'Мои донаты')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Мои донаты</h1>
        <!-- Button to open donation form modal -->
        <button onclick="document.getElementById('donation-modal').classList.remove('hidden')" 
                class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
            Создать донат
        </button>
    </div>

    <!-- Donation Form Modal -->
    <div id="donation-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Новый донат</h2>
                <button onclick="document.getElementById('donation-modal').classList.add('hidden')" 
                        class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form action="{{ route('donations.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="currency" class="block text-sm font-medium text-gray-700 mb-1">Валюта</label>
                    <select name="currency" id="currency" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="USD">USD</option>
                        <option value="EUR">EUR</option>
                        <option value="BTC">BTC</option>
                        <option value="ETH">ETH</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Сумма</label>
                    <input type="number" step="0.01" name="amount" id="amount" 
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                           placeholder="0.00" required>
                </div>
                
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Описание (опционально)</label>
                    <textarea name="description" id="description" rows="3" 
                              class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                              placeholder="Описание доната..."></textarea>
                </div>
                
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('donation-modal').classList.add('hidden')"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                        Отмена
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition">
                        Создать донат
                    </button>
                </div>
            </form>
        </div>
    </div>

    @foreach($stats as $currencyStats)
    <div class="stats-section mb-12">
        <div class="text-xl font-semibold mb-4 mt-8">Статистика для {{ $currencyStats->currency }}</div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white shadow rounded-lg p-6">
                <div class="text-gray-500 text-sm mb-1">Кол-во донатов</div>
                <div class="text-2xl font-bold">{{ number_format($currencyStats->count, 0, ',', ' ') }}</div>
            </div>
            
            <div class="bg-white shadow rounded-lg p-6">
                <div class="text-gray-500 text-sm mb-1">Общая сумма</div>
                <div class="text-2xl font-bold">{{ number_format($currencyStats->total, 2, '.', '') }}</div>
            </div>
            
            <div class="bg-white shadow rounded-lg p-6">
                <div class="text-gray-500 text-sm mb-1">Средняя сумма</div>
                <div class="text-2xl font-bold">{{ number_format($currencyStats->average, 6, '.', '') }}</div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white shadow rounded-lg p-6">
                <div class="text-gray-500 text-sm mb-1">Мин. сумма</div>
                <div class="text-2xl font-bold">{{ number_format($currencyStats->min, 2, '.', '') }}</div>
            </div>
            
            <div class="bg-white shadow rounded-lg p-6">
                <div class="text-gray-500 text-sm mb-1">Макс. сумма</div>
                <div class="text-2xl font-bold">{{ number_format($currencyStats->max, 2, '.', '') }}</div>
            </div>
        </div>
    </div>
    @endforeach

    @if($stats->isEmpty())
    <div class="bg-white shadow rounded-lg p-6">
        <p class="text-gray-500">У вас пока нет донатов</p>
    </div>
    @endif

    <div class="bg-white shadow rounded-lg p-6 mt-8">
        <h2 class="text-xl font-semibold mb-4">Последние донаты</h2>
        @foreach($recentDonations as $donation)
        <div class="border-b border-gray-100 py-4 flex justify-between items-center">
            <div>
                <span class="font-semibold text-blue-500">{{ $donation->currency }}</span>
                <div class="text-gray-500 text-sm">
                    {{ $donation->created_at->format('d.m.Y H:i') }}
                </div>
            </div>
            <div class="text-xl font-semibold">{{ number_format($donation->amount, 2) }}</div>
        </div>
        @endforeach
        
        @if($recentDonations->isEmpty())
        <p class="text-gray-500">Нет донатов для отображения</p>
        @endif
    </div>
</div>

<script>
    // Close modal when clicking outside of it
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('donation-modal');
        if (modal) {
            modal.addEventListener('click', function(event) {
                if (event.target === modal) {
                    modal.classList.add('hidden');
                }
            });
        }
    });
</script>
@endsection