<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'title' => '',
    'icon' => null,
    'padding' => true
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'title' => '',
    'icon' => null,
    'padding' => true
]); ?>
<?php foreach (array_filter(([
    'title' => '',
    'icon' => null,
    'padding' => true
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div <?php echo e($attributes->merge(['class' => 'rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-white/[0.03] shadow-sm'])); ?>>
    <?php if($title || $icon): ?>
        <div class="border-b border-gray-200 dark:border-gray-800 px-6 py-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <?php if($icon): ?>
                    <i class="<?php echo e($icon); ?> text-blue-600 dark:text-blue-400"></i>
                <?php endif; ?>
                <?php echo e($title); ?>

            </h3>
        </div>
    <?php endif; ?>

    <div class="<?php echo e($padding ? 'px-6 py-4' : ''); ?>">
        <?php echo e($slot); ?>

    </div>
</div>
<?php /**PATH /home/luciano/Área de trabalho/dev/calibracao_V0/resources/views/components/card.blade.php ENDPATH**/ ?>