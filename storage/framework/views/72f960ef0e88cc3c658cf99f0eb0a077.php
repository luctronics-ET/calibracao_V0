<?php $__env->startSection('title', 'Locais - CalibSys'); ?>
<?php $__env->startSection('content'); ?>
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold"><i class="fas fa-map-marker-alt text-blue-600 mr-2"></i>Locais e Localizações</h2>
    <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['variant' => 'primary','icon' => 'fas fa-plus','href' => route('locais.create')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'primary','icon' => 'fas fa-plus','href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('locais.create'))]); ?>Novo Local <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
</div>

<?php if (isset($component)) { $__componentOriginald23bc4ec89b5fd959bca40bc550a62af = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald23bc4ec89b5fd959bca40bc550a62af = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.datatable3','data' => ['id' => 'locaisTable','title' => '','headers' => ['ID', 'Nome', 'Tipo', 'Referência', 'Contato', 'Ações'],'searchable' => true,'exportable' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('datatable3'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'locaisTable','title' => '','headers' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['ID', 'Nome', 'Tipo', 'Referência', 'Contato', 'Ações']),'searchable' => true,'exportable' => true]); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <button onclick="$('#locaisTable').DataTable().button('.buttons-excel').trigger()" class="inline-flex items-center gap-1.5 rounded-lg bg-green-600 px-3 py-2 text-sm font-medium text-white hover:bg-green-700 transition-colors">
            <i class="fas fa-file-excel"></i>
            Excel
        </button>
        <button onclick="$('#locaisTable').DataTable().button('.buttons-pdf').trigger()" class="inline-flex items-center gap-1.5 rounded-lg bg-red-600 px-3 py-2 text-sm font-medium text-white hover:bg-red-700 transition-colors">
            <i class="fas fa-file-pdf"></i>
            PDF
        </button>
     <?php $__env->endSlot(); ?>

     <?php $__env->slot('body', null, []); ?> 
        <?php $__currentLoopData = $locais; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
            <td class="px-6 py-4"><?php echo e($l->id); ?></td>
            <td class="px-6 py-4 font-semibold"><?php echo e($l->nome); ?></td>
            <td class="px-6 py-4"><?php if (isset($component)) { $__componentOriginal2ddbc40e602c342e508ac696e52f8719 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2ddbc40e602c342e508ac696e52f8719 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.badge','data' => ['variant' => 'primary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'primary']); ?><?php echo e($l->tipo ?? '-'); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2ddbc40e602c342e508ac696e52f8719)): ?>
<?php $attributes = $__attributesOriginal2ddbc40e602c342e508ac696e52f8719; ?>
<?php unset($__attributesOriginal2ddbc40e602c342e508ac696e52f8719); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2ddbc40e602c342e508ac696e52f8719)): ?>
<?php $component = $__componentOriginal2ddbc40e602c342e508ac696e52f8719; ?>
<?php unset($__componentOriginal2ddbc40e602c342e508ac696e52f8719); ?>
<?php endif; ?></td>
            <td class="px-6 py-4"><?php echo e($l->referencia ?? '-'); ?></td>
            <td class="px-6 py-4"><?php echo e($l->contato ?? '-'); ?></td>
            <td class="px-6 py-4">
                <div class="flex gap-2">
                    <a href="<?php echo e(route('locais.show', $l)); ?>" class="text-blue-600 hover:text-blue-900"><i class="fas fa-eye"></i></a>
                    <a href="<?php echo e(route('locais.edit', $l)); ?>" class="text-yellow-600 hover:text-yellow-900"><i class="fas fa-edit"></i></a>
                </div>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
     <?php $__env->endSlot(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald23bc4ec89b5fd959bca40bc550a62af)): ?>
<?php $attributes = $__attributesOriginald23bc4ec89b5fd959bca40bc550a62af; ?>
<?php unset($__attributesOriginald23bc4ec89b5fd959bca40bc550a62af); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald23bc4ec89b5fd959bca40bc550a62af)): ?>
<?php $component = $__componentOriginald23bc4ec89b5fd959bca40bc550a62af; ?>
<?php unset($__componentOriginald23bc4ec89b5fd959bca40bc550a62af); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/luciano/Área de trabalho/dev/calibracao_V0/resources/views/locais/index.blade.php ENDPATH**/ ?>