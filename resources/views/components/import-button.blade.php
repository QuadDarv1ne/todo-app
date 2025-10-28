@props(['formats' => ['csv', 'xlsx']])

<div class="import-button">
    <button type="button" 
            class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200 text-sm font-medium"
            onclick="document.getElementById('import-modal').classList.remove('hidden')">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
        </svg>
        Импорт
    </button>
    
    <!-- Import Modal -->
    <div id="import-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75" onclick="document.getElementById('import-modal').classList.add('hidden')"></div>
            </div>

            <!-- Modal container -->
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form id="import-form" enctype="multipart/form-data">
                    @csrf
                    <div class="px-6 py-5 border-b border-gray-200">
                        <h3 class="text-2xl font-bold text-gray-900">Импорт задач</h3>
                    </div>
                    <div class="px-6 py-5 space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Выберите файл</label>
                            <div class="flex items-center justify-center w-full">
                                <label for="import-file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500">
                                            <span class="font-semibold">Нажмите для загрузки</span> или перетащите файл
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            Поддерживаемые форматы: {{ implode(', ', array_map('strtoupper', $formats)) }}
                                        </p>
                                    </div>
                                    <input id="import-file" type="file" class="hidden" accept="{{ '.' . implode(',.', $formats) }}" name="file" required>
                                </label>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Формат файла</label>
                            <select name="format" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition">
                                @foreach($formats as $format)
                                    <option value="{{ $format }}">{{ strtoupper($format) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="px-6 py-4 bg-gray-50 flex justify-end gap-3">
                        <button type="button" 
                                class="px-5 py-2.5 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition"
                                onclick="document.getElementById('import-modal').classList.add('hidden')">
                            Отмена
                        </button>
                        <button type="submit"
                                class="px-5 py-2.5 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition shadow-md hover:shadow-lg">
                            Импортировать
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle file selection
        document.getElementById('import-file').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            if (fileName) {
                const label = this.closest('label');
                label.querySelector('p').innerHTML = `<span class="font-semibold">${fileName}</span>`;
            }
        });
        
        // Handle form submission
        document.getElementById('import-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            // Handle import logic here
            console.log('Importing file:', formData.get('file'));
            
            // Example implementation:
            // fetch('/import/tasks', {
            //     method: 'POST',
            //     body: formData
            // }).then(response => {
            //     if (response.ok) {
            //         document.getElementById('import-modal').classList.add('hidden');
            //         alert('Задачи успешно импортированы!');
            //     } else {
            //         throw new Error('Import failed');
            //     }
            // }).catch(error => {
            //     console.error('Import error:', error);
            //     alert('Ошибка при импорте задач');
            // });
        });
    });
</script>