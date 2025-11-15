<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['task']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['task']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div id="editTaskModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <!-- Modal container -->
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="editTaskForm">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>
                <div class="px-6 py-5 border-b border-gray-200">
                    <h3 class="text-2xl font-bold text-gray-900">Редактировать задачу</h3>
                </div>
                <div class="px-6 py-5 space-y-5">
                    <div>
                        <label for="edit-title" class="block text-sm font-medium text-gray-700 mb-2">Название</label>
                        <input type="text" id="edit-title" name="title" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition text-base shadow-sm">
                    </div>
                    <div>
                        <label for="edit-description" class="block text-sm font-medium text-gray-700 mb-2">Описание</label>
                        <textarea id="edit-description" name="description" rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition text-base shadow-sm resize-none"></textarea>
                    </div>
                    <div>
                        <label for="edit-due_date" class="block text-sm font-medium text-gray-700 mb-2">Дата выполнения (необязательно)</label>
                        <input type="date" id="edit-due_date" name="due_date"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition text-base shadow-sm">
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" id="edit-completed" name="completed" value="1"
                               class="h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500">
                        <label for="edit-completed" class="ml-2 block text-sm text-gray-700">Завершено</label>
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-50 flex justify-end gap-3">
                    <button type="button" id="cancelEdit"
                            class="px-5 py-2.5 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                        Отмена
                    </button>
                    <button type="submit"
                            class="px-5 py-2.5 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition shadow-md hover:shadow-lg">
                        Сохранить
                    </button>
                </div>
            </form>
        </div>
    </div>
</div><?php /**PATH C:\Users\maksi\OneDrive\Documents\GitHub\todo-app\resources\views/components/edit-task-modal.blade.php ENDPATH**/ ?>