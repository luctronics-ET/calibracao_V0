<?php $__env->startSection('title', 'Equipamentos - Sistema de Calibração'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-header">
            <h2>📋 Equipamentos</h2>
            <div>
                <a href="<?php echo e(route('equipamentos.export', request()->all())); ?>" class="btn btn-success">📊 Exportar Excel</a>
                <a href="<?php echo e(route('equipamentos.create')); ?>" class="btn btn-primary">+ Novo Equipamento</a>
            </div>
        </div>

        <form method="GET" action="<?php echo e(route('equipamentos.index')); ?>" class="filter-form">
            <div class="form-row">
                <input type="text" name="q" value="<?php echo e(request('q')); ?>"
                    placeholder="Buscar (código, tipo, fabricante, modelo)" />
                <select name="criticidade">
                    <option value="">Criticidade (todas)</option>
                    <?php $__currentLoopData = ['baixa', 'media', 'alta', 'critica']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($c); ?>" <?php echo e(request('criticidade') === $c ? 'selected' : ''); ?>><?php echo e(ucfirst($c)); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <button type="submit" class="btn">Filtrar</button>
                <?php if(request()->hasAny(['q', 'criticidade'])): ?>
                    <a href="<?php echo e(route('equipamentos.index')); ?>" class="btn btn-secondary">Limpar</a>
                <?php endif; ?>
            </div>
        </form>

        <?php if(session('success')): ?>
            <div class="alert alert-success">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Tipo</th>
                    <th>Fabricante</th>
                    <th>Modelo</th>
                    <th>Criticidade</th>
                    <th>Próxima Calibração</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $equipamentos ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $equipamento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><strong><?php echo e($equipamento->codigo_interno); ?></strong></td>
                        <td><?php echo e($equipamento->tipo); ?></td>
                        <td><?php echo e($equipamento->fabricante ?? '-'); ?></td>
                        <td><?php echo e($equipamento->modelo ?? '-'); ?></td>
                        <td>
                            <?php if($equipamento->criticidade === 'critica'): ?>
                                <span class="badge badge-danger">Crítica</span>
                            <?php elseif($equipamento->criticidade === 'alta'): ?>
                                <span class="badge badge-warning">Alta</span>
                            <?php elseif($equipamento->criticidade === 'media'): ?>
                                <span class="badge badge-info">Média</span>
                            <?php else: ?>
                                <span class="badge badge-secondary">Baixa</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($equipamento->data_proxima_calibracao): ?>
                                <?php echo e(\Carbon\Carbon::parse($equipamento->data_proxima_calibracao)->format('d/m/Y')); ?>

                            <?php else: ?>
                                <span style="color: #999;">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($equipamento->status_calibracao === 'vencida'): ?>
                                <span class="badge badge-danger">Vencida</span>
                            <?php elseif($equipamento->status_calibracao === 'critica'): ?>
                                <span class="badge badge-danger">Crítica (≤7d)</span>
                            <?php elseif($equipamento->status_calibracao === 'proxima'): ?>
                                <span class="badge badge-warning">Próxima (≤30d)</span>
                            <?php elseif($equipamento->status_calibracao === 'em_dia'): ?>
                                <span class="badge badge-success">Em dia</span>
                            <?php else: ?>
                                <span class="badge badge-secondary">Sem calibração</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?php echo e(route('equipamentos.show', $equipamento)); ?>" class="btn btn-sm btn-primary">Ver</a>
                            <a href="<?php echo e(route('equipamentos.edit', $equipamento)); ?>" class="btn btn-sm btn-success">Editar</a>
                            <form action="<?php echo e(route('equipamentos.destroy', $equipamento)); ?>" method="POST"
                                style="display: inline;"
                                onsubmit="return confirm('Tem certeza que deseja excluir este equipamento?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                            </form>
                        </td>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 2rem; color: #6b7280;">
                            Nenhum equipamento cadastrado. <a href="/equipamentos/create">Cadastre o primeiro</a>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="pagination-wrapper">
            <?php echo e($equipamentos->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/equipamentos/index.blade.php ENDPATH**/ ?>