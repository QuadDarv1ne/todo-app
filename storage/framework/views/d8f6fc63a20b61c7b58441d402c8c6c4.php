<form id="reminders-form" class="space-y-4" aria-describedby="reminders-help">
    <p id="reminders-help" class="text-sm text-gray-600 dark:text-gray-400">
        Настройте напоминания о сроках задач и время их отправки.
    </p>

    <div class="flex items-center gap-3">
        <input id="reminder_enabled" name="reminder_enabled" type="checkbox" value="1" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" <?php echo e($user->reminder_enabled ? 'checked' : ''); ?>>
        <label for="reminder_enabled" class="text-sm text-gray-700 dark:text-gray-200">Включить напоминания</label>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="flex items-center gap-3">
            <input id="reminder_1_day" name="reminder_1_day" type="checkbox" value="1" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" <?php echo e($user->reminder_1_day ? 'checked' : ''); ?>>
            <label for="reminder_1_day" class="text-sm text-gray-700 dark:text-gray-200">За 1 день до срока</label>
        </div>
        <div class="flex items-center gap-3">
            <input id="reminder_3_days" name="reminder_3_days" type="checkbox" value="1" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" <?php echo e($user->reminder_3_days ? 'checked' : ''); ?>>
            <label for="reminder_3_days" class="text-sm text-gray-700 dark:text-gray-200">За 3 дня до срока</label>
        </div>
        <div class="flex items-center gap-3">
            <input id="reminder_1_week" name="reminder_1_week" type="checkbox" value="1" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" <?php echo e($user->reminder_1_week ? 'checked' : ''); ?>>
            <label for="reminder_1_week" class="text-sm text-gray-700 dark:text-gray-200">За 1 неделю до срока</label>
        </div>
        <div class="flex items-center gap-3">
            <input id="reminder_overdue" name="reminder_overdue" type="checkbox" value="1" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" <?php echo e($user->reminder_overdue ? 'checked' : ''); ?>>
            <label for="reminder_overdue" class="text-sm text-gray-700 dark:text-gray-200">О просроченных задачах</label>
        </div>
    </div>

    <div class="sm:max-w-xs">
        <label for="reminder_time" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Время отправки</label>
        <input id="reminder_time" name="reminder_time" type="time" value="<?php echo e($user->reminder_time ? $user->reminder_time->format('H:i') : '09:00'); ?>" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
    </div>

    <div class="flex items-center gap-3">
        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors duration-200">Сохранить</button>
        <span id="reminders-status" class="text-sm text-gray-600 dark:text-gray-400" role="status" aria-live="polite"></span>
    </div>
</form>
<?php /**PATH C:\Users\maksi\OneDrive\Documents\GitHub\todo-app\resources\views/profile/partials/reminder-settings-form.blade.php ENDPATH**/ ?>