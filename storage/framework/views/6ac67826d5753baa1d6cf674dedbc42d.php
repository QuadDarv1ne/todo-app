<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['title', 'value', 'description', 'color' => 'blue']));

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

foreach (array_filter((['title', 'value', 'description', 'color' => 'blue']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="stats-card bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-all duration-300 overflow-hidden">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-600"><?php echo e($title); ?></p>
            <p class="text-3xl font-bold text-gray-900 mt-1"><?php echo e($value); ?></p>
            <?php if($description): ?>
                <p class="text-xs text-gray-500 mt-2"><?php echo e($description); ?></p>
            <?php endif; ?>
        </div>
        
        <?php if(trim($slot)): ?>
            <div class="p-3 rounded-lg bg-<?php echo e($color); ?>-100 text-<?php echo e($color); ?>-600">
                <div class="h-8 w-8">
                    <?php echo $slot; ?>

                </div>
            </div>
        <?php endif; ?>
    </div>
</div><?php /**PATH C:\Users\maksi\OneDrive\Documents\GitHub\todo-app\resources\views/components/stats-card.blade.php ENDPATH**/ ?>