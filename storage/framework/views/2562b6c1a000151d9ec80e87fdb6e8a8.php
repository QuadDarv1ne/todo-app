<div class="task-form bg-white rounded-lg shadow-sm border border-gray-200 p-5">
    <form id="task-form" class="space-y-4">
        <?php echo csrf_field(); ?>
        <div class="flex gap-2">
            <input
                type="text"
                id="title"
                placeholder="Введите название задачи..."
                class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition text-sm"
                required
            >
            <button type="submit" class="px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition shadow-sm">
                Добавить
            </button>
        </div>
        <textarea 
            id="description"
            placeholder="Описание задачи (необязательно)..."
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition text-sm resize-none"
            rows="2"
        ></textarea>
    </form>
</div><?php /**PATH C:\Users\maksi\OneDrive\Documents\GitHub\todo-app\resources\views/components/task-form.blade.php ENDPATH**/ ?>