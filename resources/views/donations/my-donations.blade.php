@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
        Мои донаты
    </h2>
@endsection

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200 shadow-sm sticky top-16 z-40">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-5">
                <h1 class="text-3xl font-bold text-gray-900">Мои донаты</h1>
                <div class="grid grid-cols-3 gap-5 text-base">
                    @php
                        $totalDonations = $stats->sum('count');
                        $totalAmount = $stats->sum('total');
                        $currenciesCount = $stats->count();
                    @endphp
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-900">{{ $totalDonations }}</div>
                        <div class="text-gray-500">Всего</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-indigo-600">{{ $currenciesCount }}</div>
                        <div class="text-gray-500">Валюты</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600">{{ number_format($totalAmount, 2, '.', ' ') }}</div>
                        <div class="text-gray-500">Сумма</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- Add Donation Button -->
        <div class="mb-10">
            <button onclick="document.getElementById('donation-modal').classList.remove('hidden')" 
                    class="w-full sm:w-auto bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Создать донат
            </button>
        </div>

        <!-- Stats Overview -->
        @if($stats->count() > 0)
            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
                <!-- Donations by Currency Chart -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Донаты по валютам</h3>
                    <canvas id="donationsByCurrencyChart" height="300"></canvas>
                </div>
                
                <!-- Amount by Currency Chart -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Суммы по валютам</h3>
                    <canvas id="amountByCurrencyChart" height="300"></canvas>
                </div>
            </div>
            
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
                @foreach($stats as $currencyStats)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition">
                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-4">
                        <div class="flex justify-between items-center">
                            <h3 class="text-xl font-bold text-white">{{ $currencyStats->currency }}</h3>
                            <div class="bg-white bg-opacity-20 rounded-full p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="p-5">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Кол-во</p>
                                <p class="text-xl font-bold">{{ $currencyStats->count }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Сумма</p>
                                <p class="text-xl font-bold">{{ number_format($currencyStats->total, 2, '.', ' ') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Среднее</p>
                                <p class="text-xl font-bold">{{ number_format($currencyStats->average, 2, '.', ' ') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Макс.</p>
                                <p class="text-xl font-bold">{{ number_format($currencyStats->max, 2, '.', ' ') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-10">
                <x-empty-state
                    title="Нет донатов"
                    description="Начните с создания своего первого доната!"
                    icon='<svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>'
                    action-text="Создать донат"
                    action-url="#"
                    action-onclick="document.getElementById('donation-modal').classList.remove('hidden')"
                />
            </div>
        @endif

        <!-- Filter and Sort Controls -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-10">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <!-- Filter by Currency -->
                <div class="flex-1">
                    <form method="GET" action="{{ route('donations.my') }}" class="flex flex-col sm:flex-row gap-3">
                        <div class="flex-1">
                            <label for="currency-filter" class="block text-sm font-medium text-gray-700 mb-1">Фильтр по валюте</label>
                            <select name="currency" id="currency-filter" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2">
                                <option value="">Все валюты</option>
                                @foreach($stats as $stat)
                                    <option value="{{ $stat->currency }}" {{ $currency == $stat->currency ? 'selected' : '' }}>
                                        {{ $stat->currency }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Sort Controls -->
                        <div class="flex gap-3">
                            <div>
                                <label for="sort-by" class="block text-sm font-medium text-gray-700 mb-1">Сортировать по</label>
                                <select name="sort_by" id="sort-by" class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2">
                                    <option value="created_at" {{ $sortBy == 'created_at' ? 'selected' : '' }}>Дате</option>
                                    <option value="amount" {{ $sortBy == 'amount' ? 'selected' : '' }}>Сумме</option>
                                    <option value="currency" {{ $sortBy == 'currency' ? 'selected' : '' }}>Валюте</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="sort-order" class="block text-sm font-medium text-gray-700 mb-1">Порядок</label>
                                <select name="sort_order" id="sort-order" class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2">
                                    <option value="desc" {{ $sortOrder == 'desc' ? 'selected' : '' }}>По убыванию</option>
                                    <option value="asc" {{ $sortOrder == 'asc' ? 'selected' : '' }}>По возрастанию</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="flex items-end">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                Применить
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Recent Donations -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Последние донаты</h2>
            </div>
            @if($recentDonations->count() > 0)
                <div class="divide-y divide-gray-100">
                    @foreach($recentDonations as $donation)
                    <div class="p-6 hover:bg-gray-50 transition">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-4">
                                <div class="bg-indigo-100 rounded-full p-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-semibold text-lg">{{ $donation->formatted_amount }}</span>
                                        <span class="bg-indigo-100 text-indigo-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                            {{ $donation->currency }}
                                        </span>
                                    </div>
                                    @if($donation->description)
                                        <p class="text-gray-600 mt-1">{{ Str::limit($donation->description, 60) }}</p>
                                    @endif
                                    <p class="text-gray-500 text-sm mt-1">{{ $donation->created_at->format('d.m.Y H:i') }}</p>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                    Завершён
                                </span>
                                <button 
                                    onclick="openEditModal({{ $donation->id }}, '{{ $donation->currency }}', {{ $donation->amount }}, '{{ addslashes($donation->description) }}')"
                                    class="text-gray-500 hover:text-indigo-600 p-1 rounded-full hover:bg-indigo-50 transition"
                                    title="Редактировать"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button 
                                    onclick="deleteDonation({{ $donation->id }})"
                                    class="text-gray-500 hover:text-red-600 p-1 rounded-full hover:bg-red-50 transition"
                                    title="Удалить"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                @if($recentDonations->hasPages())
                    <div class="p-6 border-t border-gray-200">
                        <div class="flex justify-center">
                            {{ $recentDonations->appends(request()->except('page'))->links() }}
                        </div>
                    </div>
                @endif
            @else
                <div class="p-12 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Нет донатов</h3>
                    <p class="mt-1 text-gray-500">У вас пока нет донатов для отображения.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Donation Form Modal -->
<div id="donation-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md transform transition-all">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-gray-900">Новый донат</h2>
                <button onclick="document.getElementById('donation-modal').classList.add('hidden')" 
                        class="text-gray-500 hover:text-gray-700 rounded-full p-1 hover:bg-gray-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form action="{{ route('donations.store') }}" method="POST" id="donation-form">
                @csrf
                <div class="mb-5">
                    <label for="currency" class="block text-sm font-medium text-gray-700 mb-2">Валюта</label>
                    <select name="currency" id="currency" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3">
                        <option value="">Выберите валюту</option>
                        <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>USD - Доллар США</option>
                        <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>EUR - Евро</option>
                        <option value="BTC" {{ old('currency') == 'BTC' ? 'selected' : '' }}>BTC - Биткойн</option>
                        <option value="ETH" {{ old('currency') == 'ETH' ? 'selected' : '' }}>ETH - Эфириум</option>
                        <option value="RUB" {{ old('currency') == 'RUB' ? 'selected' : '' }}>RUB - Российский рубль</option>
                        <option value="UAH" {{ old('currency') == 'UAH' ? 'selected' : '' }}>UAH - Украинская гривна</option>
                    </select>
                    <div id="currency-error" class="text-red-500 text-sm mt-1 hidden"></div>
                </div>
                
                <div class="mb-5">
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">Сумма</label>
                    <div class="relative">
                        <input type="number" step="0.01" name="amount" id="amount" 
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 pl-4"
                               placeholder="0.00" value="{{ old('amount') }}" required>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <span class="text-gray-500 sm:text-sm" id="currency-symbol">Выберите валюту</span>
                        </div>
                    </div>
                    <div id="amount-error" class="text-red-500 text-sm mt-1 hidden"></div>
                </div>
                
                <div class="mb-5">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Описание (опционально)</label>
                    <textarea name="description" id="description" rows="3" 
                              class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3"
                              placeholder="Описание доната...">{{ old('description') }}</textarea>
                    <div id="description-error" class="text-red-500 text-sm mt-1 hidden"></div>
                </div>
                
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="document.getElementById('donation-modal').classList.add('hidden')"
                            class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                        Отмена
                    </button>
                    <button type="submit" 
                            class="px-5 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Создать донат
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Donation Modal -->
<div id="edit-donation-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md transform transition-all">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-gray-900">Редактировать донат</h2>
                <button onclick="document.getElementById('edit-donation-modal').classList.add('hidden')" 
                        class="text-gray-500 hover:text-gray-700 rounded-full p-1 hover:bg-gray-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form id="edit-donation-form">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit-donation-id" name="donation_id">
                <div class="mb-5">
                    <label for="edit-currency" class="block text-sm font-medium text-gray-700 mb-2">Валюта</label>
                    <select name="currency" id="edit-currency" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3">
                        <option value="">Выберите валюту</option>
                        <option value="USD">USD - Доллар США</option>
                        <option value="EUR">EUR - Евро</option>
                        <option value="BTC">BTC - Биткойн</option>
                        <option value="ETH">ETH - Эфириум</option>
                        <option value="RUB">RUB - Российский рубль</option>
                        <option value="UAH">UAH - Украинская гривна</option>
                    </select>
                    <div id="edit-currency-error" class="text-red-500 text-sm mt-1 hidden"></div>
                </div>
                
                <div class="mb-5">
                    <label for="edit-amount" class="block text-sm font-medium text-gray-700 mb-2">Сумма</label>
                    <div class="relative">
                        <input type="number" step="0.01" name="amount" id="edit-amount" 
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 pl-4"
                               placeholder="0.00" required>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <span class="text-gray-500 sm:text-sm" id="edit-currency-symbol">Выберите валюту</span>
                        </div>
                    </div>
                    <div id="edit-amount-error" class="text-red-500 text-sm mt-1 hidden"></div>
                </div>
                
                <div class="mb-5">
                    <label for="edit-description" class="block text-sm font-medium text-gray-700 mb-2">Описание (опционально)</label>
                    <textarea name="description" id="edit-description" rows="3" 
                              class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3"
                              placeholder="Описание доната..."></textarea>
                    <div id="edit-description-error" class="text-red-500 text-sm mt-1 hidden"></div>
                </div>
                
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="document.getElementById('edit-donation-modal').classList.add('hidden')"
                            class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                        Отмена
                    </button>
                    <button type="submit" 
                            class="px-5 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Сохранить
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Close modal when clicking outside of it
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('donation-modal');
        const editModal = document.getElementById('edit-donation-modal');
        const form = document.getElementById('donation-form');
        const editForm = document.getElementById('edit-donation-form');
        const currencySelect = document.getElementById('currency');
        const editCurrencySelect = document.getElementById('edit-currency');
        const currencySymbol = document.getElementById('currency-symbol');
        const editCurrencySymbol = document.getElementById('edit-currency-symbol');
        
        // Initialize charts if stats are available
        @if($stats->count() > 0)
        initializeCharts();
        @endif
        
        if (modal) {
            modal.addEventListener('click', function(event) {
                if (event.target === modal) {
                    modal.classList.add('hidden');
                }
            });
        }
        
        if (editModal) {
            editModal.addEventListener('click', function(event) {
                if (event.target === editModal) {
                    editModal.classList.add('hidden');
                }
            });
        }
        
        // Update currency symbol when currency changes
        if (currencySelect && currencySymbol) {
            currencySelect.addEventListener('change', function() {
                currencySymbol.textContent = this.value || 'Выберите валюту';
            });
        }
        
        if (editCurrencySelect && editCurrencySymbol) {
            editCurrencySelect.addEventListener('change', function() {
                editCurrencySymbol.textContent = this.value || 'Выберите валюту';
            });
        }
        
        // Handle form submission with AJAX
        if (form) {
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                // Clear previous errors
                clearErrors();
                
                const formData = new FormData(form);
                const submitButton = form.querySelector('button[type="submit"]');
                const originalText = submitButton.innerHTML;
                
                // Show loading state
                submitButton.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Создание...';
                submitButton.disabled = true;
                
                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });
                    
                    const result = await response.json();
                    
                    if (response.ok && result.success) {
                        // Success - close modal and reload page
                        modal.classList.add('hidden');
                        window.location.reload();
                    } else if (result.errors) {
                        // Validation errors
                        displayErrors(result.errors);
                    } else {
                        // Other errors
                        alert(result.message || 'Ошибка при создании доната');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Ошибка при создании доната');
                } finally {
                    // Restore button state
                    submitButton.innerHTML = originalText;
                    submitButton.disabled = false;
                }
            });
        }
        
        // Handle edit form submission with AJAX
        if (editForm) {
            editForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                // Clear previous errors
                clearEditErrors();
                
                const formData = new FormData(editForm);
                const donationId = document.getElementById('edit-donation-id').value;
                const submitButton = editForm.querySelector('button[type="submit"]');
                const originalText = submitButton.innerHTML;
                
                // Show loading state
                submitButton.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Сохранение...';
                submitButton.disabled = true;
                
                try {
                    const response = await fetch(`/donations/${donationId}`, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'X-HTTP-Method-Override': 'PUT'
                        }
                    });
                    
                    const result = await response.json();
                    
                    if (response.ok && result.success) {
                        // Success - close modal and reload page
                        editModal.classList.add('hidden');
                        window.location.reload();
                    } else if (result.errors) {
                        // Validation errors
                        displayEditErrors(result.errors);
                    } else {
                        // Other errors
                        alert(result.message || 'Ошибка при обновлении доната');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Ошибка при обновлении доната');
                } finally {
                    // Restore button state
                    submitButton.innerHTML = originalText;
                    submitButton.disabled = false;
                }
            });
        }
    });
    
    // Clear form errors
    function clearErrors() {
        document.getElementById('currency-error').classList.add('hidden');
        document.getElementById('amount-error').classList.add('hidden');
        document.getElementById('description-error').classList.add('hidden');
    }
    
    // Display form errors
    function displayErrors(errors) {
        if (errors.currency) {
            document.getElementById('currency-error').textContent = errors.currency[0];
            document.getElementById('currency-error').classList.remove('hidden');
        }
        if (errors.amount) {
            document.getElementById('amount-error').textContent = errors.amount[0];
            document.getElementById('amount-error').classList.remove('hidden');
        }
        if (errors.description) {
            document.getElementById('description-error').textContent = errors.description[0];
            document.getElementById('description-error').classList.remove('hidden');
        }
    }
    
    // Clear edit form errors
    function clearEditErrors() {
        document.getElementById('edit-currency-error').classList.add('hidden');
        document.getElementById('edit-amount-error').classList.add('hidden');
        document.getElementById('edit-description-error').classList.add('hidden');
    }
    
    // Display edit form errors
    function displayEditErrors(errors) {
        if (errors.currency) {
            document.getElementById('edit-currency-error').textContent = errors.currency[0];
            document.getElementById('edit-currency-error').classList.remove('hidden');
        }
        if (errors.amount) {
            document.getElementById('edit-amount-error').textContent = errors.amount[0];
            document.getElementById('edit-amount-error').classList.remove('hidden');
        }
        if (errors.description) {
            document.getElementById('edit-description-error').textContent = errors.description[0];
            document.getElementById('edit-description-error').classList.remove('hidden');
        }
    }
    
    // Initialize charts
    function initializeCharts() {
        // Prepare data
        const currencies = [
            @foreach($stats as $stat)
                "{{ $stat->currency }}",
            @endforeach
        ];
        const counts = [
            @foreach($stats as $stat)
                {{ $stat->count }},
            @endforeach
        ];
        const totals = [
            @foreach($stats as $stat)
                {{ $stat->total }},
            @endforeach
        ];
        
        // Color palette
        const backgroundColors = [
            'rgba(79, 70, 229, 0.8)',
            'rgba(59, 130, 246, 0.8)',
            'rgba(16, 185, 129, 0.8)',
            'rgba(245, 158, 11, 0.8)',
            'rgba(239, 68, 68, 0.8)',
            'rgba(139, 92, 246, 0.8)'
        ];
        
        const borderColors = [
            'rgba(79, 70, 229, 1)',
            'rgba(59, 130, 246, 1)',
            'rgba(16, 185, 129, 1)',
            'rgba(245, 158, 11, 1)',
            'rgba(239, 68, 68, 1)',
            'rgba(139, 92, 246, 1)'
        ];
        
        // Donations by currency chart
        const donationsCtx = document.getElementById('donationsByCurrencyChart').getContext('2d');
        new Chart(donationsCtx, {
            type: 'bar',
            data: {
                labels: currencies,
                datasets: [{
                    label: 'Количество донатов',
                    data: counts,
                    backgroundColor: backgroundColors.slice(0, currencies.length),
                    borderColor: borderColors.slice(0, currencies.length),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
        
        // Amount by currency chart
        const amountCtx = document.getElementById('amountByCurrencyChart').getContext('2d');
        new Chart(amountCtx, {
            type: 'pie',
            data: {
                labels: currencies,
                datasets: [{
                    label: 'Сумма донатов',
                    data: totals,
                    backgroundColor: backgroundColors.slice(0, currencies.length),
                    borderColor: borderColors.slice(0, currencies.length),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }
    
    // Open edit modal with donation data
    function openEditModal(id, currency, amount, description) {
        document.getElementById('edit-donation-id').value = id;
        document.getElementById('edit-currency').value = currency;
        document.getElementById('edit-amount').value = amount;
        document.getElementById('edit-description').value = description || '';
        document.getElementById('edit-currency-symbol').textContent = currency || 'Выберите валюту';
        document.getElementById('edit-donation-modal').classList.remove('hidden');
    }
    
    // Delete donation
    function deleteDonation(id) {
        if (confirm('Вы уверены, что хотите удалить этот донат?')) {
            fetch(`/donations/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert(data.message || 'Ошибка при удалении доната');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ошибка при удалении доната');
            });
        }
    }
</script>
@endsection