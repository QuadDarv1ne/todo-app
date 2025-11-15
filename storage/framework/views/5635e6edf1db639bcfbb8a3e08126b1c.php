<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['percentage', 'label' => null, 'size' => 'md']));

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

foreach (array_filter((['percentage', 'label' => null, 'size' => 'md']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="progress-bar">
    <?php if($label): ?>
        <div class="flex justify-between items-center mb-3">
            <span class="text-base font-semibold text-gray-700"><?php echo e($label); ?></span>
            <span class="text-xl font-bold text-indigo-600"><?php echo e(round($percentage)); ?>%</span>
        </div>
    <?php endif; ?>
    
    <?php
        $height = match($size) {
            'sm' => 'h-2.5',
            'lg' => 'h-5',
            default => 'h-4',
        };
    ?>
    
    <div class="w-full bg-gray-200 rounded-full overflow-hidden <?php echo e($height); ?>">
        <div 
            class="h-full bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full transition-all duration-1000 ease-out shadow-sm"
            style="width: <?php echo e($percentage); ?>%"
        ></div>
    </div>
    
    <?php if($label && trim($slot)): ?>
        <div class="mt-3 text-sm text-gray-600">
            <?php echo e($slot); ?>

        </div>
    <?php endif; ?>
</div><?php /**PATH C:\Users\maksi\OneDrive\Documents\GitHub\todo-app\resources\views/components/progress-bar.blade.php ENDPATH**/ ?>