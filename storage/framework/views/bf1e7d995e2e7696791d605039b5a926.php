<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['currentFilter' => 'all', 'searchQuery' => '']));

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

foreach (array_filter((['currentFilter' => 'all', 'searchQuery' => '']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="task-filters bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5">
        <!-- Search -->
        <div class="flex-1 max-w-2xl">
            <form method="GET" action="<?php echo e(route('tasks.index')); ?>" class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input
                    type="text"
                    name="search"
                    value="<?php echo e($searchQuery); ?>"
                    placeholder="Поиск задач..."
                    class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition text-base shadow-sm"
                >
                <?php if($searchQuery): ?>
                    <a href="<?php echo e(route('tasks.index')); ?>" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </a>
                <?php endif; ?>
            </form>
        </div>
        
        <!-- Filters -->
        <div class="flex flex-wrap gap-2">
            <?php
                $filters = [
                    'all' => 'Все задачи',
                    'pending' => 'Активные',
                    'completed' => 'Завершённые'
                ];
            ?>
            
            <?php $__currentLoopData = $filters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('tasks.index', array_merge(request()->except('filter', 'page'), ['filter' => $key]))); ?>" 
                   class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 <?php echo e($currentFilter === $key ? 'bg-indigo-600 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'); ?>">
                    <?php echo e($label); ?>

                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div><?php /**PATH C:\Users\maksi\OneDrive\Documents\GitHub\todo-app\resources\views/components/task-filters.blade.php ENDPATH**/ ?>