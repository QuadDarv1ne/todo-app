<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Настройки напоминаний</h3>
    
    <form id="reminder-settings-form" class="space-y-4">
        @csrf
        @method('PATCH')
        
        <!-- Включение/выключение напоминаний -->
        <div class="flex items-center justify-between">
            <div>
                <h4 class="text-md font-medium text-gray-900">Включить напоминания</h4>
                <p class="text-sm text-gray-500">Получать уведомления о приближающихся сроках задач</p>
            </div>
            <div class="relative inline-block w-10 mr-2 align-middle select-none">
                <input type="checkbox" name="reminder_enabled" id="reminder-enabled" 
                       class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer transition-all duration-200 ease-in-out"
                       {{ auth()->user()->reminder_enabled ? 'checked' : '' }}>
                <label for="reminder-enabled" 
                       class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer transition-all duration-200 ease-in-out"></label>
            </div>
        </div>
        
        <!-- Напоминания за 1 день -->
        <div class="flex items-center justify-between">
            <div>
                <h4 class="text-md font-medium text-gray-900">Напоминание за 1 день</h4>
                <p class="text-sm text-gray-500">Получать уведомление за день до срока выполнения</p>
            </div>
            <div class="relative inline-block w-10 mr-2 align-middle select-none">
                <input type="checkbox" name="reminder_1_day" id="reminder-1-day" 
                       class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer transition-all duration-200 ease-in-out"
                       {{ auth()->user()->reminder_1_day ? 'checked' : '' }}>
                <label for="reminder-1-day" 
                       class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer transition-all duration-200 ease-in-out"></label>
            </div>
        </div>
        
        <!-- Напоминания за 3 дня -->
        <div class="flex items-center justify-between">
            <div>
                <h4 class="text-md font-medium text-gray-900">Напоминание за 3 дня</h4>
                <p class="text-sm text-gray-500">Получать уведомление за 3 дня до срока выполнения</p>
            </div>
            <div class="relative inline-block w-10 mr-2 align-middle select-none">
                <input type="checkbox" name="reminder_3_days" id="reminder-3-days" 
                       class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer transition-all duration-200 ease-in-out"
                       {{ auth()->user()->reminder_3_days ? 'checked' : '' }}>
                <label for="reminder-3-days" 
                       class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer transition-all duration-200 ease-in-out"></label>
            </div>
        </div>
        
        <!-- Напоминания за 1 неделю -->
        <div class="flex items-center justify-between">
            <div>
                <h4 class="text-md font-medium text-gray-900">Напоминание за 1 неделю</h4>
                <p class="text-sm text-gray-500">Получать уведомление за неделю до срока выполнения</p>
            </div>
            <div class="relative inline-block w-10 mr-2 align-middle select-none">
                <input type="checkbox" name="reminder_1_week" id="reminder-1-week" 
                       class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer transition-all duration-200 ease-in-out"
                       {{ auth()->user()->reminder_1_week ? 'checked' : '' }}>
                <label for="reminder-1-week" 
                       class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer transition-all duration-200 ease-in-out"></label>
            </div>
        </div>
        
        <!-- Напоминания о просроченных задачах -->
        <div class="flex items-center justify-between">
            <div>
                <h4 class="text-md font-medium text-gray-900">Напоминания о просроченных задачах</h4>
                <p class="text-sm text-gray-500">Получать уведомления о просроченных задачах</p>
            </div>
            <div class="relative inline-block w-10 mr-2 align-middle select-none">
                <input type="checkbox" name="reminder_overdue" id="reminder-overdue" 
                       class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer transition-all duration-200 ease-in-out"
                       {{ auth()->user()->reminder_overdue ? 'checked' : '' }}>
                <label for="reminder-overdue" 
                       class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer transition-all duration-200 ease-in-out"></label>
            </div>
        </div>
        
        <!-- Время отправки напоминаний -->
        <div class="flex items-center justify-between">
            <div>
                <h4 class="text-md font-medium text-gray-900">Время отправки напоминаний</h4>
                <p class="text-sm text-gray-500">Во сколько отправлять ежедневные напоминания</p>
            </div>
            <div>
                <input type="time" name="reminder_time" id="reminder-time"
                       value="{{ auth()->user()->reminder_time ? auth()->user()->reminder_time->format('H:i') : '09:00' }}"
                       class="border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>
        </div>
        
        <div class="flex justify-end">
            <button type="submit" 
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                Сохранить настройки
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('reminder-settings-form');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(form);
        const data = {};
        
        for (const [key, value] of formData.entries()) {
            // Convert checkbox values to boolean
            if (key.startsWith('reminder_') && (key !== 'reminder_time')) {
                data[key] = value === 'on' ? true : (value === 'true' ? true : false);
            } else {
                data[key] = value;
            }
        }
        
        fetch('{{ route("reminders.update") }}', {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                showNotification('Настройки напоминаний успешно сохранены!', 'success');
            } else {
                // Show error message
                showNotification('Ошибка при сохранении настроек', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Ошибка при сохранении настроек', 'error');
        });
    });
    
    // Toggle switch styling
    const toggleSwitches = document.querySelectorAll('.toggle-checkbox');
    toggleSwitches.forEach(switchEl => {
        switchEl.addEventListener('change', function() {
            const label = this.nextElementSibling;
            if (this.checked) {
                label.classList.remove('bg-gray-300');
                label.classList.add('bg-indigo-600');
            } else {
                label.classList.remove('bg-indigo-600');
                label.classList.add('bg-gray-300');
            }
        });
        
        // Initialize switch state
        const label = switchEl.nextElementSibling;
        if (switchEl.checked) {
            label.classList.remove('bg-gray-300');
            label.classList.add('bg-indigo-600');
        }
    });
});

function showNotification(message, type) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 px-6 py-4 rounded-lg shadow-lg text-white z-50 ${
        type === 'success' ? 'bg-green-500' : 'bg-red-500'
    }`;
    notification.textContent = message;
    
    // Add to DOM
    document.body.appendChild(notification);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.remove();
    }, 3000);
}
</script>
@endpush