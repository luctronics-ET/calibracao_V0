<?php $__env->startSection('title', 'Contratos - CalibSys'); ?>

<?php $__env->startSection('page-title', 'Contratos de Serviço'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
        <i class="fas fa-file-contract text-blue-600 mr-2"></i>
        Gestão de Contratos
    </h2>

    <div class="flex gap-2">
        <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['variant' => 'primary','icon' => 'fas fa-plus','href' => route('contratos.create')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'primary','icon' => 'fas fa-plus','href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('contratos.create'))]); ?>
            Novo Contrato
         <?php echo $__env->renderComponent(); ?>
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
</div>

<!-- Cards de Resumo -->
<div class="grid grid-cols-1 gap-4 md:grid-cols-3 mb-6">
    <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-white/[0.03] p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total de Contratos</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2"><?php echo e($contratos->total()); ?></p>
            </div>
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/30">
                <i class="fas fa-file-contract text-2xl text-blue-600 dark:text-blue-400"></i>
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-white/[0.03] p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Ativos</p>
                <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-2">
                    <?php echo e($contratos->filter(fn($c) => $c->data_fim && $c->data_fim >= now())->count()); ?>

                </p>
            </div>
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-green-100 dark:bg-green-900/30">
                <i class="fas fa-check-circle text-2xl text-green-600 dark:text-green-400"></i>
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-white/[0.03] p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Vencidos</p>
                <p class="text-3xl font-bold text-red-600 dark:text-red-400 mt-2">
                    <?php echo e($contratos->filter(fn($c) => $c->data_fim && $c->data_fim < now())->count()); ?>

                </p>
            </div>
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/30">
                <i class="fas fa-exclamation-triangle text-2xl text-red-600 dark:text-red-400"></i>
            </div>
        </div>
    </div>
</div>

<!-- Tabela -->
<?php if (isset($component)) { $__componentOriginald23bc4ec89b5fd959bca40bc550a62af = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald23bc4ec89b5fd959bca40bc550a62af = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.datatable3','data' => ['id' => 'contratosTable','title' => 'Lista de Contratos','subtitle' => 'Gerencie todos os contratos de serviço','headers' => ['Número', 'Laboratório', 'Início', 'Fim', 'Valor', 'Status', 'Ações'],'exportable' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('datatable3'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'contratosTable','title' => 'Lista de Contratos','subtitle' => 'Gerencie todos os contratos de serviço','headers' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['Número', 'Laboratório', 'Início', 'Fim', 'Valor', 'Status', 'Ações']),'exportable' => true]); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['variant' => 'outline','icon' => 'fas fa-file-excel','onclick' => '$(\'#contratosTable\').DataTable().button(\'.buttons-excel\').trigger();']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'outline','icon' => 'fas fa-file-excel','onclick' => '$(\'#contratosTable\').DataTable().button(\'.buttons-excel\').trigger();']); ?>
            Excel
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['variant' => 'outline','icon' => 'fas fa-file-pdf','onclick' => '$(\'#contratosTable\').DataTable().button(\'.buttons-pdf\').trigger();']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'outline','icon' => 'fas fa-file-pdf','onclick' => '$(\'#contratosTable\').DataTable().button(\'.buttons-pdf\').trigger();']); ?>
            PDF
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
     <?php $__env->endSlot(); ?>

     <?php $__env->slot('body', null, []); ?> 
        <?php $__empty_1 = true; $__currentLoopData = $contratos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contrato): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
            <td class="px-4 py-3">
                <span class="font-semibold text-gray-900 dark:text-white"><?php echo e($contrato->numero_contrato); ?></span>
            </td>
            <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                <?php echo e($contrato->laboratorio->nome ?? '-'); ?>

            </td>
            <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                <?php echo e($contrato->data_inicio ? $contrato->data_inicio->format('d/m/Y') : '-'); ?>

            </td>
            <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                <?php echo e($contrato->data_fim ? $contrato->data_fim->format('d/m/Y') : '-'); ?>

            </td>
            <td class="px-4 py-3">
                <?php if($contrato->valor_contrato): ?>
                    <span class="font-medium text-gray-900 dark:text-white">
                        R$ <?php echo e(number_format($contrato->valor_contrato, 2, ',', '.')); ?>

                    </span>
                <?php else: ?>
                    <span class="text-gray-400">-</span>
                <?php endif; ?>
            </td>
            <td class="px-4 py-3">
                <?php if($contrato->data_fim && $contrato->data_fim >= now()): ?>
                    <span class="inline-flex items-center rounded-full bg-success-50 px-2 py-0.5 text-xs font-medium text-success-700 dark:bg-success-500/15 dark:text-success-500">
                        Ativo
                    </span>
                <?php elseif($contrato->data_fim): ?>
                    <span class="inline-flex items-center rounded-full bg-red-50 px-2 py-0.5 text-xs font-medium text-red-700 dark:bg-red-500/15 dark:text-red-500">
                        Vencido
                    </span>
                <?php else: ?>
                    <span class="inline-flex items-center rounded-full bg-gray-50 px-2 py-0.5 text-xs font-medium text-gray-700 dark:bg-gray-500/15 dark:text-gray-400">
                        Indefinido
                    </span>
                <?php endif; ?>
            </td>
            <td class="px-4 py-3">
                <div class="flex items-center gap-2">
                    <a href="<?php echo e(route('contratos.show', $contrato)); ?>"
                       class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-500/10"
                       title="Visualizar">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="<?php echo e(route('contratos.edit', $contrato)); ?>"
                       class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-yellow-600 hover:bg-yellow-50 dark:hover:bg-yellow-500/10"
                       title="Editar">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="<?php echo e(route('contratos.destroy', $contrato)); ?>" method="POST" class="inline">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit"
                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-red-600 hover:bg-red-50 dark:hover:bg-red-500/10"
                                onclick="return confirm('Tem certeza que deseja excluir este contrato?')"
                                title="Excluir">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
            <td colspan="7" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                <i class="fas fa-inbox text-4xl mb-2 text-gray-300 dark:text-gray-600"></i>
                <p>Nenhum contrato cadastrado</p>
            </td>
        </tr>
        <?php endif; ?>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/luciano/Área de trabalho/dev/calibracao_V0/resources/views/contratos/index.blade.php ENDPATH**/ ?>