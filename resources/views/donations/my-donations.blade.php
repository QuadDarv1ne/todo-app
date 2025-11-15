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