<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Editar Laboratório</h1>
            <a href="<?php echo e(route('laboratorios.index')); ?>" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                Voltar
            </a>
        </div>

        <?php if($errors->any()): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('laboratorios.update', $laboratorio)); ?>" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="col-span-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="nome">
                        Nome <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="nome" 
                        id="nome" 
                        value="<?php echo e(old('nome', $laboratorio->nome)); ?>"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline <?php $__errorArgs = ['nome'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        required
                    >
                    <?php $__errorArgs = ['nome'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-xs italic mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="cnpj">
                        CNPJ
                    </label>
                    <input 
                        type="text" 
                        name="cnpj" 
                        id="cnpj" 
                        value="<?php echo e(old('cnpj', $laboratorio->cnpj)); ?>"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        placeholder="00.000.000/0000-00"
                    >
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="contato">
                        Contato
                    </label>
                    <input 
                        type="text" 
                        name="contato" 
                        id="contato" 
                        value="<?php echo e(old('contato', $laboratorio->contato)); ?>"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        placeholder="Telefone/Email"
                    >
                </div>

                <div class="col-span-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="endereco">
                        Endereço
                    </label>
                    <input 
                        type="text" 
                        name="endereco" 
                        id="endereco" 
                        value="<?php echo e(old('endereco', $laboratorio->endereco)); ?>"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    >
                </div>

                <div class="col-span-2">
                    <label class="flex items-center">
                        <input 
                            type="checkbox" 
                            name="acreditado" 
                            id="acreditado" 
                            value="1"
                            <?php echo e(old('acreditado', $laboratorio->acreditado) ? 'checked' : ''); ?>

                            class="mr-2 leading-tight"
                        >
                        <span class="text-sm font-bold text-gray-700">
                            Laboratório Acreditado
                        </span>
                    </label>
                </div>

                <div class="col-span-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="escopo">
                        Escopo de Acreditação
                    </label>
                    <textarea 
                        name="escopo" 
                        id="escopo" 
                        rows="4"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        placeholder="Descreva os serviços e calibrações realizadas..."
                    ><?php echo e(old('escopo', $laboratorio->escopo)); ?></textarea>
                </div>
            </div>

            <div class="flex items-center justify-end mt-8 gap-4">
                <a href="<?php echo e(route('laboratorios.index')); ?>" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Cancelar
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Atualizar Laboratório
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/laboratorios/edit.blade.php ENDPATH**/ ?>