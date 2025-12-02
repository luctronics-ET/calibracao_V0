<?php $__env->startSection('title', 'Equipamentos - Sistema de Calibração'); ?>

<?php $__env->startSection('breadcrumb'); ?>
<nav class="flex mb-6" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
            <a href="<?php echo e(route('dashboard')); ?>" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                <i class="fas fa-home mr-2"></i>
                Dashboard
            </a>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Equipamentos</span>
            </div>
        </li>
    </ol>
</nav>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
        <i class="fas fa-cube text-blue-600 mr-2"></i>
        Gestão de Equipamentos
    </h2>

    <div class="flex gap-2">
        <a href="<?php echo e(route('equipamentos.create')); ?>" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
            <i class="fas fa-plus"></i>
            Novo Equipamento
        </a>

        <button type="button" onclick="window.location.reload()" class="inline-flex items-center gap-2 rounded-lg bg-gray-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
            <i class="fas fa-sync-alt"></i>
            Atualizar
        </button>
    </div>
</div>

<!-- Cards de Resumo -->
<div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4 mb-6">
    <!-- Total de Equipamentos -->
    <div class="rounded-lg bg-white dark:bg-gray-800 p-6 shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total de Equipamentos</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2"><?php echo e($equipamentos->count()); ?></p>
            </div>
            <div class="flex h-14 w-14 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900">
                <i class="fas fa-cube text-2xl text-blue-600 dark:text-blue-400"></i>
            </div>
        </div>
    </div>

    <!-- Equipamentos Ativos -->
    <div class="rounded-lg bg-white dark:bg-gray-800 p-6 shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Ativos</p>
                <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-2">
                    <?php echo e($equipamentos->where('equipamento_status', 'ativo')->count()); ?>

                </p>
            </div>
            <div class="flex h-14 w-14 items-center justify-center rounded-full bg-green-100 dark:bg-green-900">
                <i class="fas fa-check-circle text-2xl text-green-600 dark:text-green-400"></i>
            </div>
        </div>
    </div>

    <!-- Calibrações Vencidas -->
    <div class="rounded-lg bg-white dark:bg-gray-800 p-6 shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Calibrações Vencidas</p>
                <p class="text-3xl font-bold text-red-600 dark:text-red-400 mt-2">
                    <?php echo e($equipamentos->filter(function($e) {
                        return $e->equipamento_data_proxima_calibracao &&
                               \Carbon\Carbon::parse($e->equipamento_data_proxima_calibracao)->isPast();
                    })->count()); ?>

                </p>
            </div>
            <div class="flex h-14 w-14 items-center justify-center rounded-full bg-red-100 dark:bg-red-900">
                <i class="fas fa-exclamation-triangle text-2xl text-red-600 dark:text-red-400"></i>
            </div>
        </div>
    </div>

    <!-- A Vencer (30 dias) -->
    <div class="rounded-lg bg-white dark:bg-gray-800 p-6 shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">A Vencer (30 dias)</p>
                <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400 mt-2">
                    <?php echo e($equipamentos->filter(function($e) {
                        return $e->equipamento_data_proxima_calibracao &&
                               \Carbon\Carbon::parse($e->equipamento_data_proxima_calibracao)->isBetween(now(), now()->addDays(30));
                    })->count()); ?>

                </p>
            </div>
            <div class="flex h-14 w-14 items-center justify-center rounded-full bg-yellow-100 dark:bg-yellow-900">
                <i class="fas fa-clock text-2xl text-yellow-600 dark:text-yellow-400"></i>
            </div>
        </div>
    </div>
</div>

<?php if (isset($component)) { $__componentOriginald23bc4ec89b5fd959bca40bc550a62af = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald23bc4ec89b5fd959bca40bc550a62af = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.datatable3','data' => ['id' => 'equipamentosTable','title' => '','headers' => ['ID', 'Código', 'Tipo', 'Fabricante', 'Modelo', 'Serial', 'Setor', 'Localização', 'Status Equipamento', 'Status Calibração', 'Última Calibração', 'Próx. Calibração', 'IGP', 'Ações'],'searchable' => true,'exportable' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('datatable3'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'equipamentosTable','title' => '','headers' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['ID', 'Código', 'Tipo', 'Fabricante', 'Modelo', 'Serial', 'Setor', 'Localização', 'Status Equipamento', 'Status Calibração', 'Última Calibração', 'Próx. Calibração', 'IGP', 'Ações']),'searchable' => true,'exportable' => true]); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <button onclick="$('#equipamentosTable').DataTable().button('.buttons-excel').trigger()" class="inline-flex items-center gap-1.5 rounded-lg bg-green-600 px-3 py-2 text-sm font-medium text-white hover:bg-green-700 transition-colors">
            <i class="fas fa-file-excel"></i>
            Excel
        </button>
        <button onclick="$('#equipamentosTable').DataTable().button('.buttons-pdf').trigger()" class="inline-flex items-center gap-1.5 rounded-lg bg-red-600 px-3 py-2 text-sm font-medium text-white hover:bg-red-700 transition-colors">
            <i class="fas fa-file-pdf"></i>
            PDF
        </button>
     <?php $__env->endSlot(); ?>

     <?php $__env->slot('body', null, []); ?> 
                    <?php $__empty_1 = true; $__currentLoopData = $equipamentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $equipamento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                #<?php echo e($equipamento->id); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                <?php echo e($equipamento->equipamento_codigo_interno ?? '-'); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                <?php echo e($equipamento->equipamento_tipo ?? '-'); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                <?php echo e($equipamento->equipamento_fabricante ?? '-'); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                <?php echo e($equipamento->equipamento_modelo ?? '-'); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                <?php echo e($equipamento->equipamento_serial ?? '-'); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                <?php echo e($equipamento->equipamento_setor ?? '-'); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                <?php echo e($equipamento->equipamento_localizacao ?? '-'); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if($equipamento->equipamento_status === 'ativo'): ?>
                                    <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-300">
                                        <i class="fas fa-check-circle mr-1"></i> Ativo
                                    </span>
                                <?php elseif($equipamento->equipamento_status === 'inativo'): ?>
                                    <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                        <i class="fas fa-pause-circle mr-1"></i> Inativo
                                    </span>
                                <?php elseif($equipamento->equipamento_status === 'manutencao'): ?>
                                    <span class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                                        <i class="fas fa-tools mr-1"></i> Manutenção
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800 dark:bg-red-900 dark:text-red-300">
                                        <i class="fas fa-ban mr-1"></i> Descartado
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if($equipamento->equipamento_certificado_status === 'CALIBRADO'): ?>
                                    <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-300">
                                        <i class="fas fa-check-circle mr-1"></i> Calibrado
                                    </span>
                                <?php elseif($equipamento->equipamento_certificado_status === 'DESCALIBRADO'): ?>
                                    <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800 dark:bg-red-900 dark:text-red-300">
                                        <i class="fas fa-times-circle mr-1"></i> Descalibrado
                                    </span>
                                <?php else: ?>
                                    <span class="text-gray-400 dark:text-gray-500">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                <?php if($equipamento->equipamento_data_ultima_calibracao): ?>
                                    <?php echo e(\Carbon\Carbon::parse($equipamento->equipamento_data_ultima_calibracao)->format('d/m/Y')); ?>

                                <?php else: ?>
                                    <span class="text-gray-400 dark:text-gray-500">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <?php if($equipamento->proxima_calibracao_prevista): ?>
                                    <?php
                                        $proximaData = \Carbon\Carbon::parse($equipamento->proxima_calibracao_prevista);
                                        $hoje = now();
                                        $vencida = $proximaData->isPast();
                                        $aVencer = $proximaData->isBetween($hoje, $hoje->copy()->addDays(30));
                                    ?>

                                    <?php if($vencida): ?>
                                        <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800 dark:bg-red-900 dark:text-red-300">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>
                                            <?php echo e($proximaData->format('d/m/Y')); ?>

                                        </span>
                                    <?php elseif($aVencer): ?>
                                        <span class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                                            <i class="fas fa-clock mr-1"></i>
                                            <?php echo e($proximaData->format('d/m/Y')); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="text-gray-700 dark:text-gray-300">
                                            <?php echo e($proximaData->format('d/m/Y')); ?>

                                        </span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="text-gray-400 dark:text-gray-500">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if($equipamento->equipamento_igp): ?>
                                    <?php
                                        $igp = $equipamento->equipamento_igp;
                                        if($igp >= 12) {
                                            $color = 'red';
                                        } elseif($igp >= 7) {
                                            $color = 'yellow';
                                        } else {
                                            $color = 'green';
                                        }
                                    ?>
                                    <span class="inline-flex items-center rounded-full bg-<?php echo e($color); ?>-100 px-2.5 py-0.5 text-xs font-medium text-<?php echo e($color); ?>-800 dark:bg-<?php echo e($color); ?>-900 dark:text-<?php echo e($color); ?>-300">
                                        <?php echo e($igp); ?> - <?php echo e(ucfirst($equipamento->equipamento_classificacao ?? 'N/A')); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="text-gray-400 dark:text-gray-500">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="<?php echo e(route('equipamentos.show', $equipamento->id)); ?>"
                                       class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300"
                                       title="Visualizar">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('equipamentos.edit', $equipamento->id)); ?>"
                                       class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300"
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?php echo e(route('equipamentos.destroy', $equipamento->id)); ?>"
                                          method="POST"
                                          class="inline-block"
                                          onsubmit="return confirm('Tem certeza que deseja excluir este equipamento?');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit"
                                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                                title="Excluir">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="11" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                <i class="fas fa-inbox text-4xl mb-2 text-gray-400"></i>
                                <p>Nenhum equipamento cadastrado.</p>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/luciano/Área de trabalho/dev/calibracao_V0/resources/views/equipamentos/index.blade.php ENDPATH**/ ?>