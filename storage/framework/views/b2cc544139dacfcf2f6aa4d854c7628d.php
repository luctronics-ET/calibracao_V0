<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'variant' => 'default',
    'size' => 'md'
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'variant' => 'default',
    'size' => 'md'
]); ?>
<?php foreach (array_filter(([
    'variant' => 'default',
    'size' => 'md'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
    $variants = [
        'default' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
        'primary' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
        'success' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
        'danger' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
        'warning' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
        'info' => 'bg-cyan-100 text-cyan-800 dark:bg-cyan-900 dark:text-cyan-300',
    ];

    $sizes = [
        'sm' => 'px-2 py-0.5 text-xs',
        'md' => 'px-2.5 py-0.5 text-sm',
        'lg' => 'px-3 py-1 text-base',
    ];
?>

<span <?php echo e($attributes->merge(['class' => 'inline-flex items-center gap-1 rounded-full font-medium ' . $variants[$variant] . ' ' . $sizes[$size]])); ?>>
    <?php echo e($slot); ?>

</span>
<?php /**PATH /home/luciano/Área de trabalho/dev/calibracao_V0/resources/views/components/badge.blade.php ENDPATH**/ ?>