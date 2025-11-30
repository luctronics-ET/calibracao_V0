<?php $__env->startSection('content'); ?>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Detalhes do Laboratório</h1>
                <div class="flex gap-2">
                    <a href="<?php echo e(route('laboratorios.edit', $laboratorio)); ?>"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                        Editar
                    </a>
                    <a href="<?php echo e(route('laboratorios.index')); ?>"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                        Voltar
                    </a>
                </div>
            </div>

            <!-- Informações do Laboratório -->
            <div class="bg-white shadow-md rounded px-8 py-6 mb-6">
                <h2 class="text-2xl font-semibold text-gray-700 mb-4 border-b pb-2">Informações do Laboratório</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <p class="text-sm text-gray-600 font-semibold">Nome</p>
                        <p class="text-lg"><?php echo e($laboratorio->nome); ?></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">CNPJ</p>
                        <p class="text-lg"><?php echo e($laboratorio->cnpj ?? '-'); ?></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Contato</p>
                        <p class="text-lg"><?php echo e($laboratorio->contato ?? '-'); ?></p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-sm text-gray-600 font-semibold">Endereço</p>
                        <p class="text-lg"><?php echo e($laboratorio->endereco ?? '-'); ?></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Acreditação</p>
                        <p class="text-lg">
                            <?php if($laboratorio->acreditado): ?>
                                <span class="inline-block bg-green-500 text-white px-3 py-1 rounded">Acreditado</span>
                            <?php else: ?>
                                <span class="inline-block bg-gray-500 text-white px-3 py-1 rounded">Não Acreditado</span>
                            <?php endif; ?>
                        </p>
                    </div>
                    <?php if($laboratorio->escopo): ?>
                        <div class="col-span-2">
                            <p class="text-sm text-gray-600 font-semibold">Escopo de Acreditação</p>
                            <p class="text-lg whitespace-pre-line"><?php echo e($laboratorio->escopo); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Contratos -->
            <?php if($laboratorio->contratos && $laboratorio->contratos->count() > 0): ?>
                <div class="bg-white shadow-md rounded px-8 py-6 mb-6">
                    <h2 class="text-2xl font-semibold text-gray-700 mb-4 border-b pb-2">Contratos</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left">Edital</th>
                                    <th class="px-4 py-2 text-left">Vigência Início</th>
                                    <th class="px-4 py-2 text-left">Vigência Fim</th>
                                    <th class="px-4 py-2 text-left">Preço Unitário</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $laboratorio->contratos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contrato): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="border-b">
                                        <td class="px-4 py-2"><?php echo e($contrato->edital_num ?? '-'); ?></td>
                                        <td class="px-4 py-2">
                                            <?php echo e($contrato->vigencia_ini ? \Carbon\Carbon::parse($contrato->vigencia_ini)->format('d/m/Y') : '-'); ?>

                                        </td>
                                        <td class="px-4 py-2">
                                            <?php echo e($contrato->vigencia_fim ? \Carbon\Carbon::parse($contrato->vigencia_fim)->format('d/m/Y') : '-'); ?>

                                        </td>
                                        <td class="px-4 py-2">R$ <?php echo e(number_format($contrato->preco_unitario ?? 0, 2, ',', '.')); ?>

                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/laboratorios/show.blade.php ENDPATH**/ ?>