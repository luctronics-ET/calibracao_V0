<?php $__env->startSection('title', 'Laboratórios - Sistema de Calibração'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-header">
            <h2>🏢 Laboratórios</h2>
            <a href="/laboratorios/create" class="btn btn-primary">+ Novo Laboratório</a>
        </div>

        <form method="GET" action="<?php echo e(route('laboratorios.index')); ?>" class="filter-form">
            <div class="form-row">
                <input type="text" name="q" value="<?php echo e(request('q')); ?>" placeholder="Buscar por nome ou CNPJ" />
                <button type="submit" class="btn">Filtrar</button>
                <?php if(request()->has('q')): ?>
                    <a href="<?php echo e(route('laboratorios.index')); ?>" class="btn btn-secondary">Limpar</a>
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
                    <th>Nome</th>
                    <th>CNPJ</th>
                    <th>Telefone</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $laboratorios ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $laboratorio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($laboratorio->id); ?></td>
                        <td><strong><?php echo e($laboratorio->nome); ?></strong></td>
                        <td><?php echo e($laboratorio->cnpj); ?></td>
                        <td><?php echo e($laboratorio->telefone); ?></td>
                        <td><?php echo e($laboratorio->email); ?></td>
                        <td>
                            <?php if($laboratorio->ativo): ?>
                                <span class="badge badge-success">Ativo</span>
                            <?php else: ?>
                                <span class="badge badge-danger">Inativo</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="/laboratorios/<?php echo e($laboratorio->id); ?>" class="btn btn-sm btn-primary">Ver</a>
                            <a href="/laboratorios/<?php echo e($laboratorio->id); ?>/edit" class="btn btn-sm btn-success">Editar</a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 2rem; color: #6b7280;">
                            Nenhum laboratório cadastrado. <a href="/laboratorios/create">Cadastre o primeiro</a>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="pagination-wrapper">
            <?php echo e($laboratorios->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/laboratorios/index.blade.php ENDPATH**/ ?>