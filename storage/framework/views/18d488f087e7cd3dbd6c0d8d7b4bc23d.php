<?php $__env->startSection('title', 'Lotes de Envio - Sistema de Calibração'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-header">
            <h2>📦 Lotes de Envio</h2>
            <div>
                <a href="<?php echo e(route('lotes.export', request()->all())); ?>" class="btn btn-success">📊 Exportar Excel</a>
                <a href="/lotes/create" class="btn btn-primary">+ Novo Lote</a>
            </div>
        </div>
        <form method="GET" action="<?php echo e(route('lotes.index')); ?>" class="filter-form">
            <div class="form-row">
                <select name="status">
                    <option value="">Status (todos)</option>
                    <?php $__currentLoopData = ['preparacao', 'enviado', 'em_calibracao', 'concluido', 'cancelado']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($s); ?>" <?php echo e(request('status') === $s ? 'selected' : ''); ?>>
                            <?php echo e(str_replace('_', ' ', ucfirst($s))); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <select name="laboratorio_id">
                    <option value="">Laboratório (todos)</option>
                    <?php $__currentLoopData = ($laboratorios ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($lab->id); ?>" <?php echo e((string) request('laboratorio_id') === (string) $lab->id ? 'selected' : ''); ?>><?php echo e($lab->nome); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <input type="date" name="from" value="<?php echo e(request('from')); ?>" />
                <input type="date" name="to" value="<?php echo e(request('to')); ?>" />
                <button type="submit" class="btn">Filtrar</button>
                <?php if(request()->hasAny(['status', 'laboratorio_id', 'from', 'to'])): ?>
                    <a href="<?php echo e(route('lotes.index')); ?>" class="btn btn-secondary">Limpar</a>
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
                    <th>Número do Lote</th>
                    <th>Laboratório</th>
                    <th>Data Envio</th>
                    <th>Previsão Retorno</th>
                    <th>Qtd Equipamentos</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $lotes ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lote): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($lote->id); ?></td>
                        <td><strong><?php echo e($lote->numero_lote); ?></strong></td>
                        <td><?php echo e($lote->laboratorio->nome ?? 'N/A'); ?></td>
                        <td><?php echo e($lote->data_envio ? \Carbon\Carbon::parse($lote->data_envio)->format('d/m/Y') : '-'); ?></td>
                        <td><?php echo e($lote->previsao_retorno ? \Carbon\Carbon::parse($lote->previsao_retorno)->format('d/m/Y') : '-'); ?>

                        </td>
                        <td><?php echo e($lote->itens->count() ?? 0); ?></td>
                        <td>
                            <?php if($lote->status === 'enviado'): ?>
                                <span class="badge badge-info">Enviado</span>
                            <?php elseif($lote->status === 'retornado'): ?>
                                <span class="badge badge-success">Retornado</span>
                            <?php else: ?>
                                <span class="badge badge-warning">Pendente</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="/lotes/<?php echo e($lote->id); ?>" class="btn btn-sm btn-primary">Ver</a>
                            <a href="/lotes/<?php echo e($lote->id); ?>/edit" class="btn btn-sm btn-success">Editar</a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 2rem; color: #6b7280;">
                            Nenhum lote criado. <a href="/lotes/create">Crie o primeiro lote</a>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="pagination-wrapper">
            <?php echo e($lotes->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/lotes/index.blade.php ENDPATH**/ ?>