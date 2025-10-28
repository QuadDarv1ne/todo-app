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

<div class="text-center py-12">
    <?php if($icon): ?>
        <div class="mx-auto h-12 w-12 text-gray-400">
            <?php echo $icon; ?>

        </div>
    <?php endif; ?>
    
    <h3 class="mt-2 text-sm font-medium text-gray-900"><?php echo e($title); ?></h3>
    <p class="mt-1 text-sm text-gray-500">
        <?php echo e($description); ?>

    </p>
    
    <?php if($actionText && $actionUrl): ?>
        <div class="mt-6">
            <a href="<?php echo e($actionUrl); ?>" 
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <?php echo e($actionText); ?>

            </a>
        </div>
    <?php endif; ?>
</div><?php /**PATH C:\Users\maksi\OneDrive\Documents\GitHub\todo-app\resources\views/components/empty-state.blade.php ENDPATH**/ ?>