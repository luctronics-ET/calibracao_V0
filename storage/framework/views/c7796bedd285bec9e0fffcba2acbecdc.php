<?php $__env->startSection('title', 'Calibrações - Sistema de Calibração'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-header">
            <h2>🔬 Calibrações</h2>
            <div>
                <a href="<?php echo e(route('calibracoes.export', request()->all())); ?>" class="btn btn-success">📊 Exportar Excel</a>
                <a href="/calibracoes/create" class="btn btn-primary">+ Nova Calibração</a>
            </div>
        </div>
        <form method="GET" action="<?php echo e(route('calibracoes.index')); ?>" class="filter-form">
            <div class="form-row">
                <select name="resultado">
                    <option value="">Resultado (todos)</option>
                    <?php $__currentLoopData = ['aprovado', 'reprovado', 'condicional']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($r); ?>" <?php echo e(request('resultado') === $r ? 'selected' : ''); ?>><?php echo e(ucfirst($r)); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <input type="date" name="from" value="<?php echo e(request('from')); ?>" />
                <input type="date" name="to" value="<?php echo e(request('to')); ?>" />
                <button type="submit" class="btn">Filtrar</button>
                <?php if(request()->hasAny(['resultado', 'from', 'to'])): ?>
                    <a href="<?php echo e(route('calibracoes.index')); ?>" class="btn btn-secondary">Limpar</a>
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
                    <th>ID</th>
                    <th>Equipamento</th>
                    <th>Laboratório</th>
                    <th>Data Envio</th>
                    <th>Data Retorno</th>
                    <th>Status</th>
                    <th>Resultado</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $calibracoes ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $calibracao): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($calibracao->id); ?></td>
                        <td><?php echo e($calibracao->equipamento->patrimonio ?? 'N/A'); ?></td>
                        <td><?php echo e($calibracao->laboratorio->nome ?? 'N/A'); ?></td>
                        <td><?php echo e($calibracao->data_envio ? \Carbon\Carbon::parse($calibracao->data_envio)->format('d/m/Y') : '-'); ?>

                        </td>
                        <td><?php echo e($calibracao->data_retorno ? \Carbon\Carbon::parse($calibracao->data_retorno)->format('d/m/Y') : '-'); ?>

                        </td>
                        <td>
                            <?php if($calibracao->status === 'concluida'): ?>
                                <span class="badge badge-success">Concluída</span>
                            <?php elseif($calibracao->status === 'em_processo'): ?>
                                <span class="badge badge-info">Em Processo</span>
                            <?php else: ?>
                                <span class="badge badge-warning">Pendente</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($calibracao->resultado === 'aprovado'): ?>
                                <span class="badge badge-success">✓ Aprovado</span>
                            <?php elseif($calibracao->resultado === 'reprovado'): ?>
                                <span class="badge badge-danger">✗ Reprovado</span>
                            <?php else: ?>
                                <span class="badge badge-warning">Pendente</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="/calibracoes/<?php echo e($calibracao->id); ?>" class="btn btn-sm btn-primary">Ver</a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 2rem; color: #6b7280;">
                            Nenhuma calibração registrada. <a href="/calibracoes/create">Registre a primeira</a>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="pagination-wrapper">
            <?php echo e($calibracoes->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/calibracoes/index.blade.php ENDPATH**/ ?>