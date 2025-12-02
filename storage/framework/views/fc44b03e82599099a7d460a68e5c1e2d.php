<?php $__env->startSection('title', 'Transportes - CalibSys'); ?>
<?php $__env->startSection('content'); ?>
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold"><i class="fas fa-truck text-blue-600 mr-2"></i>Transportadoras</h2>
    <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['variant' => 'primary','icon' => 'fas fa-plus','href' => route('transportes.create')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'primary','icon' => 'fas fa-plus','href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('transportes.create'))]); ?>Nova Transportadora <?php echo $__env->renderComponent(); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.datatable3','data' => ['id' => 'transportesTable','title' => '','headers' => ['ID', 'Transportadora', 'Motorista', 'Veículo', 'Documento', 'Contato', 'Ações'],'searchable' => true,'exportable' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('datatable3'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'transportesTable','title' => '','headers' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['ID', 'Transportadora', 'Motorista', 'Veículo', 'Documento', 'Contato', 'Ações']),'searchable' => true,'exportable' => true]); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <button onclick="$('#transportesTable').DataTable().button('.buttons-excel').trigger()" class="inline-flex items-center gap-1.5 rounded-lg bg-green-600 px-3 py-2 text-sm font-medium text-white hover:bg-green-700 transition-colors">
            <i class="fas fa-file-excel"></i>
            Excel
        </button>
        <button onclick="$('#transportesTable').DataTable().button('.buttons-pdf').trigger()" class="inline-flex items-center gap-1.5 rounded-lg bg-red-600 px-3 py-2 text-sm font-medium text-white hover:bg-red-700 transition-colors">
            <i class="fas fa-file-pdf"></i>
            PDF
        </button>
     <?php $__env->endSlot(); ?>

     <?php $__env->slot('body', null, []); ?> 
        <?php $__currentLoopData = $transportes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
            <td class="px-6 py-4"><?php echo e($t->id); ?></td>
            <td class="px-6 py-4 font-semibold"><?php echo e($t->transportadora); ?></td>
            <td class="px-6 py-4"><?php echo e($t->motorista ?? '-'); ?></td>
            <td class="px-6 py-4"><?php echo e($t->veiculo ?? '-'); ?></td>
            <td class="px-6 py-4"><?php echo e($t->documento_transporte ?? '-'); ?></td>
            <td class="px-6 py-4"><?php echo e($t->contato ?? '-'); ?></td>
            <td class="px-6 py-4">
                <div class="flex gap-2">
                    <a href="<?php echo e(route('transportes.show', $t)); ?>" class="text-blue-600 hover:text-blue-900"><i class="fas fa-eye"></i></a>
                    <a href="<?php echo e(route('transportes.edit', $t)); ?>" class="text-yellow-600 hover:text-yellow-900"><i class="fas fa-edit"></i></a>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/luciano/Área de trabalho/dev/calibracao_V0/resources/views/transportes/index.blade.php ENDPATH**/ ?>