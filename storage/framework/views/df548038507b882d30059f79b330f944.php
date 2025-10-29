<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['title', 'description', 'icon', 'actionText' => null, 'actionUrl' => null]));

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

foreach (array_filter((['title', 'description', 'icon', 'actionText' => null, 'actionUrl' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="empty-state text-center py-16">
    <?php if($icon): ?>
        <div class="mx-auto h-16 w-16 text-gray-400 mb-6">
            <?php echo $icon; ?>

        </div>
    <?php endif; ?>
    
    <h3 class="text-xl font-semibold text-gray-900 mb-2"><?php echo e($title); ?></h3>
    <p class="text-gray-600 max-w-md mx-auto">
        <?php echo e($description); ?>

    </p>
    
    <?php if($actionText && $actionUrl): ?>
        <div class="mt-8">
            <a href="<?php echo e($actionUrl); ?>" 
               class="inline-flex items-center px-5 py-3 bg-indigo-600 border border-transparent rounded-lg font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                <?php echo e($actionText); ?>

            </a>
        </div>
    <?php endif; ?>
</div><?php /**PATH C:\Users\maksi\OneDrive\Documents\GitHub\todo-app\resources\views/components/empty-state.blade.php ENDPATH**/ ?>