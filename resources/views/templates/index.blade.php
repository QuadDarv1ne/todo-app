@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-950 py-8 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="bg-purple-100 dark:bg-purple-900/30 rounded-lg p-3">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Шаблоны задач</h1>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Создавайте и управляйте шаблонами для быстрого создания задач</p>
                </div>
            </div>
            <button onclick="openCreateTemplateModal()" class="inline-flex items-center gap-2 px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Создать шаблон
            </button>
        </div>

        <!-- Templates List -->
        @if($templates->isEmpty())
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-16 text-center">
                <div class="bg-gray-100 dark:bg-gray-700 rounded-full w-24 h-24 mx-auto mb-6 flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">Нет шаблонов</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">Создайте первый шаблон для ускорения работы с задачами</p>
                <button onclick="openCreateTemplateModal()" class="inline-flex items-center gap-2 px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-all shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Создать первый шаблон
                </button>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($templates as $template)
                    <div class="group bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-lg transition-all duration-200 border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <!-- Priority Bar -->
                        <div class="h-1.5 {{ $template->priority === 'high' ? 'bg-red-500' : ($template->priority === 'medium' ? 'bg-yellow-500' : 'bg-green-500') }}"></div>
                        
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-grow">
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-2">{{ $template->name }}</h3>
                                    @if($template->title)
                                        <p class="text-sm text-gray-600 dark:text-gray-300 mb-1"><span class="font-semibold">Заголовок:</span> {{ $template->title }}</p>
                                    @endif
                                </div>
                            </div>

                            @if($template->description)
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4 line-clamp-2">{{ $template->description }}</p>
                            @endif

                            <!-- Meta Info -->
                            <div class="flex flex-wrap gap-2 text-xs mb-4">
                                @if($template->priority)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg font-semibold
                                        {{ $template->priority === 'high' ? 'bg-red-50 text-red-700 border border-red-200 dark:bg-red-900/30 dark:text-red-300' : '' }}
                                        {{ $template->priority === 'medium' ? 'bg-yellow-50 text-yellow-700 border border-yellow-200 dark:bg-yellow-900/30 dark:text-yellow-300' : '' }}
                                        {{ $template->priority === 'low' ? 'bg-green-50 text-green-700 border border-green-200 dark:bg-green-900/30 dark:text-green-300' : '' }}
                                    ">
                                        Приоритет: {{ ucfirst($template->priority) }}
                                    </span>
                                @endif

                                @if($template->default_due_days)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg font-semibold bg-blue-50 text-blue-700 border border-blue-200 dark:bg-blue-900/30 dark:text-blue-300">
                                        Срок: {{ $template->default_due_days }} дн.
                                    </span>
                                @endif

                                @if($template->reminders_enabled)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200 dark:bg-indigo-900/30 dark:text-indigo-300">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                                        </svg>
                                        Напоминания
                                    </span>
                                @endif
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-2">
                                <button 
                                    onclick="applyTemplate({{ $template->id }})"
                                    class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 bg-purple-50 text-purple-700 rounded-lg hover:bg-purple-100 transition-all text-sm font-medium dark:bg-purple-900/30 dark:text-purple-300 dark:hover:bg-purple-900/50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Применить
                                </button>
                                <button 
                                    onclick="editTemplate({{ $template->id }})"
                                    class="px-4 py-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-all dark:hover:bg-blue-900/30"
                                    title="Редактировать">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button 
                                    onclick="deleteTemplate({{ $template->id }}, '{{ addslashes($template->name) }}')"
                                    class="px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg transition-all dark:hover:bg-red-900/30"
                                    title="Удалить">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<!-- Create Template Modal -->
<div id="createTemplateModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true" onclick="closeCreateTemplateModal()">
            <div class="absolute inset-0 bg-gray-900 dark:bg-black opacity-75"></div>
        </div>

        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            <form id="createTemplateForm" onsubmit="return handleCreateTemplate(event)">
                @csrf
                <div class="bg-gradient-to-r from-purple-500 to-indigo-600 px-6 py-5">
                    <h3 class="text-2xl font-bold text-white">Создать шаблон</h3>
                </div>
                <div class="px-6 py-6 space-y-5">
                    <div>
                        <label for="create_template_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Имя шаблона *</label>
                        <input type="text" id="create_template_name" name="name" required
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-400 transition text-base shadow-sm dark:bg-gray-700 dark:text-gray-100"
                               placeholder="Например: Еженедельный обзор">
                    </div>
                    <div>
                        <label for="create_template_title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Заголовок задачи</label>
                        <input type="text" id="create_template_title" name="title"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-400 transition text-base shadow-sm dark:bg-gray-700 dark:text-gray-100"
                               placeholder="Заголовок по умолчанию">
                    </div>
                    <div>
                        <label for="create_template_description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Описание</label>
                        <textarea id="create_template_description" name="description" rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-400 transition text-base shadow-sm resize-none dark:bg-gray-700 dark:text-gray-100"
                                  placeholder="Описание по умолчанию..."></textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="create_template_priority" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Приоритет</label>
                            <select id="create_template_priority" name="priority"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-400 transition text-base shadow-sm dark:bg-gray-700 dark:text-gray-100">
                                <option value="">Не указан</option>
                                <option value="low">Низкий</option>
                                <option value="medium" selected>Средний</option>
                                <option value="high">Высокий</option>
                            </select>
                        </div>
                        <div>
                            <label for="create_template_due_days" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Срок (дней)</label>
                            <input type="number" id="create_template_due_days" name="default_due_days" min="0" max="365"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-400 transition text-base shadow-sm dark:bg-gray-700 dark:text-gray-100"
                                   placeholder="Например: 7">
                        </div>
                    </div>
                    <div>
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" id="create_template_reminders" name="reminders_enabled" value="1"
                                   class="h-5 w-5 text-purple-600 rounded focus:ring-purple-500">
                            <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">Включить напоминания по умолчанию</span>
                        </label>
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 flex justify-end gap-3">
                    <button type="button" onclick="closeCreateTemplateModal()"
                            class="px-6 py-2.5 text-base font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        Отмена
                    </button>
                    <button type="submit"
                            class="px-6 py-2.5 text-base font-medium text-white bg-purple-600 border border-transparent rounded-lg hover:bg-purple-700 transition shadow-md hover:shadow-lg">
                        Создать
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Template Modal -->
<div id="editTemplateModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true" onclick="closeEditTemplateModal()">
            <div class="absolute inset-0 bg-gray-900 dark:bg-black opacity-75"></div>
        </div>

        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            <form id="editTemplateForm" onsubmit="return handleEditTemplate(event)">
                @csrf
                @method('PATCH')
                <input type="hidden" id="edit_template_id">
                <div class="bg-gradient-to-r from-purple-500 to-indigo-600 px-6 py-5">
                    <h3 class="text-2xl font-bold text-white">Редактировать шаблон</h3>
                </div>
                <div class="px-6 py-6 space-y-5">
                    <div>
                        <label for="edit_template_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Имя шаблона *</label>
                        <input type="text" id="edit_template_name" name="name" required
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-400 transition text-base shadow-sm dark:bg-gray-700 dark:text-gray-100">
                    </div>
                    <div>
                        <label for="edit_template_title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Заголовок задачи</label>
                        <input type="text" id="edit_template_title" name="title"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-400 transition text-base shadow-sm dark:bg-gray-700 dark:text-gray-100">
                    </div>
                    <div>
                        <label for="edit_template_description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Описание</label>
                        <textarea id="edit_template_description" name="description" rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-400 transition text-base shadow-sm resize-none dark:bg-gray-700 dark:text-gray-100"></textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="edit_template_priority" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Приоритет</label>
                            <select id="edit_template_priority" name="priority"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-400 transition text-base shadow-sm dark:bg-gray-700 dark:text-gray-100">
                                <option value="">Не указан</option>
                                <option value="low">Низкий</option>
                                <option value="medium">Средний</option>
                                <option value="high">Высокий</option>
                            </select>
                        </div>
                        <div>
                            <label for="edit_template_due_days" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Срок (дней)</label>
                            <input type="number" id="edit_template_due_days" name="default_due_days" min="0" max="365"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-400 transition text-base shadow-sm dark:bg-gray-700 dark:text-gray-100">
                        </div>
                    </div>
                    <div>
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" id="edit_template_reminders" name="reminders_enabled" value="1"
                                   class="h-5 w-5 text-purple-600 rounded focus:ring-purple-500">
                            <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">Включить напоминания по умолчанию</span>
                        </label>
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 flex justify-end gap-3">
                    <button type="button" onclick="closeEditTemplateModal()"
                            class="px-6 py-2.5 text-base font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        Отмена
                    </button>
                    <button type="submit"
                            class="px-6 py-2.5 text-base font-medium text-white bg-purple-600 border border-transparent rounded-lg hover:bg-purple-700 transition shadow-md hover:shadow-lg">
                        Сохранить
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
function openCreateTemplateModal() {
    document.getElementById('createTemplateModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeCreateTemplateModal() {
    document.getElementById('createTemplateModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    document.getElementById('createTemplateForm').reset();
}

function openEditTemplateModal() {
    document.getElementById('editTemplateModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeEditTemplateModal() {
    document.getElementById('editTemplateModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    document.getElementById('editTemplateForm').reset();
}

async function handleCreateTemplate(e) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());
    data.reminders_enabled = formData.get('reminders_enabled') ? 1 : 0;

    try {
        const res = await fetch('/templates', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify(data),
        });
        const result = await res.json();
        if (result.success) {
            window.location.reload();
        } else {
            alert(result.message || 'Ошибка при создании шаблона');
        }
    } catch (error) {
        console.error('Create template error:', error);
        alert('Ошибка при создании шаблона');
    }
    return false;
}

async function editTemplate(id) {
    try {
        const res = await fetch(`/templates/${id}`, {
            headers: { 'Accept': 'application/json' }
        });
        const data = await res.json();
        if (!data.success) {
            alert('Ошибка загрузки шаблона');
            return;
        }
        const t = data.template;
        document.getElementById('edit_template_id').value = t.id;
        document.getElementById('edit_template_name').value = t.name || '';
        document.getElementById('edit_template_title').value = t.title || '';
        document.getElementById('edit_template_description').value = t.description || '';
        document.getElementById('edit_template_priority').value = t.priority || '';
        document.getElementById('edit_template_due_days').value = t.default_due_days || '';
        document.getElementById('edit_template_reminders').checked = !!t.reminders_enabled;
        openEditTemplateModal();
    } catch (e) {
        console.error('Load template error:', e);
        alert('Ошибка загрузки шаблона');
    }
}

async function handleEditTemplate(e) {
    e.preventDefault();
    const id = document.getElementById('edit_template_id').value;
    const form = e.target;
    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());
    data.reminders_enabled = formData.get('reminders_enabled') ? 1 : 0;

    try {
        const res = await fetch(`/templates/${id}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify(data),
        });
        const result = await res.json();
        if (result.success) {
            window.location.reload();
        } else {
            alert(result.message || 'Ошибка при обновлении шаблона');
        }
    } catch (error) {
        console.error('Update template error:', error);
        alert('Ошибка при обновлении шаблона');
    }
    return false;
}

async function deleteTemplate(id, name) {
    if (!confirm(`Удалить шаблон "${name}"?`)) return;

    try {
        const res = await fetch(`/templates/${id}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
        });
        const data = await res.json();
        if (data.success) {
            window.location.reload();
        } else {
            alert(data.message || 'Ошибка при удалении шаблона');
        }
    } catch (error) {
        console.error('Delete template error:', error);
        alert('Ошибка при удалении шаблона');
    }
}

async function applyTemplate(id) {
    // Redirect to tasks page with template applied
    window.location.href = `/tasks?apply_template=${id}`;
}

// Close modals on Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeCreateTemplateModal();
        closeEditTemplateModal();
    }
});
</script>
@endsection
@endsection
