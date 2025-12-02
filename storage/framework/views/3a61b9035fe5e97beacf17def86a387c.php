<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'type' => 'text',
    'label' => '',
    'name' => '',
    'value' => '',
    'placeholder' => '',
    'required' => false,
    'disabled' => false,
    'error' => null,
    'help' => null
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'type' => 'text',
    'label' => '',
    'name' => '',
    'value' => '',
    'placeholder' => '',
    'required' => false,
    'disabled' => false,
    'error' => null,
    'help' => null
]); ?>
<?php foreach (array_filter(([
    'type' => 'text',
    'label' => '',
    'name' => '',
    'value' => '',
    'placeholder' => '',
    'required' => false,
    'disabled' => false,
    'error' => null,
    'help' => null
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div class="mb-4">
    <?php if($label): ?>
        <label for="<?php echo e($name); ?>" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            <?php echo e($label); ?>

            <?php if($required): ?>
                <span class="text-red-600">*</span>
            <?php endif; ?>
        </label>
    <?php endif; ?>

    <input
        type="<?php echo e($type); ?>"
        name="<?php echo e($name); ?>"
        id="<?php echo e($name); ?>"
        value="<?php echo e(old($name, $value)); ?>"
        placeholder="<?php echo e($placeholder); ?>"
        <?php if($required): ?> required <?php endif; ?>
        <?php if($disabled): ?> disabled <?php endif; ?>
        <?php echo e($attributes->merge(['class' => 'w-full rounded-lg border px-4 py-2.5 text-gray-900 dark:text-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors ' . ($error ? 'border-red-500 dark:border-red-500' : 'border-gray-300 dark:border-gray-600')])); ?>

    >

    <?php if($error): ?>
        <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($error); ?></p>
    <?php endif; ?>

    <?php if($help): ?>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400"><?php echo e($help); ?></p>
    <?php endif; ?>
</div>
<?php /**PATH /home/luciano/Área de trabalho/dev/calibracao_V0/resources/views/components/input.blade.php ENDPATH**/ ?>