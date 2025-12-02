<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'label' => '',
    'name' => '',
    'options' => [],
    'selected' => '',
    'required' => false,
    'disabled' => false,
    'error' => null,
    'help' => null,
    'placeholder' => 'Selecione...'
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'label' => '',
    'name' => '',
    'options' => [],
    'selected' => '',
    'required' => false,
    'disabled' => false,
    'error' => null,
    'help' => null,
    'placeholder' => 'Selecione...'
]); ?>
<?php foreach (array_filter(([
    'label' => '',
    'name' => '',
    'options' => [],
    'selected' => '',
    'required' => false,
    'disabled' => false,
    'error' => null,
    'help' => null,
    'placeholder' => 'Selecione...'
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

    <select
        name="<?php echo e($name); ?>"
        id="<?php echo e($name); ?>"
        <?php if($required): ?> required <?php endif; ?>
        <?php if($disabled): ?> disabled <?php endif; ?>
        <?php echo e($attributes->merge(['class' => 'w-full rounded-lg border px-4 py-2.5 text-gray-900 dark:text-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors ' . ($error ? 'border-red-500 dark:border-red-500' : 'border-gray-300 dark:border-gray-600')])); ?>

    >
        <?php if($placeholder): ?>
            <option value=""><?php echo e($placeholder); ?></option>
        <?php endif; ?>

        <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($value); ?>" <?php echo e(old($name, $selected) == $value ? 'selected' : ''); ?>>
                <?php echo e($label); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

    <?php if($error): ?>
        <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($error); ?></p>
    <?php endif; ?>

    <?php if($help): ?>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400"><?php echo e($help); ?></p>
    <?php endif; ?>
</div>
<?php /**PATH /home/luciano/Área de trabalho/dev/calibracao_V0/resources/views/components/select.blade.php ENDPATH**/ ?>