<?php $__env->startSection('title', 'Logs de Auditoria'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-header">
            <h2>📋 Logs de Auditoria</h2>
        </div>

        <form method="GET" action="<?php echo e(route('logs.index')); ?>" class="filter-form">
            <div class="form-row">
                <select name="tabela">
                    <option value="">Tabela (todas)</option>
                    <option value="equipamentos" <?php echo e(request('tabela') === 'equipamentos' ? 'selected' : ''); ?>>Equipamentos
                    </option>
                    <option value="calibracoes" <?php echo e(request('tabela') === 'calibracoes' ? 'selected' : ''); ?>>Calibrações
                    </option>
                    <option value="lotes_envio" <?php echo e(request('tabela') === 'lotes_envio' ? 'selected' : ''); ?>>Lotes</option>
                    <option value="laboratorios" <?php echo e(request('tabela') === 'laboratorios' ? 'selected' : ''); ?>>Laboratórios
                    </option>
                </select>
                <select name="acao">
                    <option value="">Ação (todas)</option>
                    <option value="create" <?php echo e(request('acao') === 'create' ? 'selected' : ''); ?>>Criar</option>
                    <option value="update" <?php echo e(request('acao') === 'update' ? 'selected' : ''); ?>>Atualizar</option>
                    <option value="delete" <?php echo e(request('acao') === 'delete' ? 'selected' : ''); ?>>Excluir</option>
                </select>
                <input type="date" name="from" value="<?php echo e(request('from')); ?>" placeholder="Data início" />
                <input type="date" name="to" value="<?php echo e(request('to')); ?>" placeholder="Data fim" />
                <button type="submit" class="btn">Filtrar</button>
                <?php if(request()->hasAny(['tabela', 'acao', 'from', 'to'])): ?>
                    <a href="<?php echo e(route('logs.index')); ?>" class="btn btn-secondary">Limpar</a>
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
                    <th style="width: 5%;">ID</th>
                    <th style="width: 12%;">Data/Hora</th>
                    <th style="width: 12%;">Tabela</th>
                    <th style="width: 8%;">Ação</th>
                    <th style="width: 10%;">Registro</th>
                    <th style="width: 15%;">Usuário</th>
                    <th style="width: 12%;">IP</th>
                    <th style="width: 8%;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $logs ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($log->id); ?></td>
                        <td><?php echo e($log->created_at->format('d/m/Y H:i:s')); ?></td>
                        <td>
                            <?php if($log->tabela === 'equipamentos'): ?>
                                <span class="badge badge-info">Equipamentos</span>
                            <?php elseif($log->tabela === 'calibracoes'): ?>
                                <span class="badge badge-warning">Calibrações</span>
                            <?php elseif($log->tabela === 'lotes_envio'): ?>
                                <span class="badge badge-primary">Lotes</span>
                            <?php else: ?>
                                <span class="badge badge-secondary"><?php echo e(ucfirst($log->tabela)); ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($log->acao === 'create'): ?>
                                <span class="badge badge-success">Criar</span>
                            <?php elseif($log->acao === 'update'): ?>
                                <span class="badge badge-warning">Atualizar</span>
                            <?php elseif($log->acao === 'delete'): ?>
                                <span class="badge badge-danger">Excluir</span>
                            <?php else: ?>
                                <?php echo e(ucfirst($log->acao)); ?>

                            <?php endif; ?>
                        </td>
                        <td>#<?php echo e($log->registro_id); ?></td>
                        <td><?php echo e($log->usuario->name ?? 'Sistema'); ?></td>
                        <td><code style="font-size: 11px;"><?php echo e($log->ip); ?></code></td>
                        <td>
                            <a href="<?php echo e(route('logs.show', $log)); ?>" class="btn btn-sm btn-primary">Detalhes</a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 2rem; color: #6b7280;">
                            Nenhum log de auditoria registrado.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="pagination-wrapper">
            <?php echo e($logs->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/logs/index.blade.php ENDPATH**/ ?>