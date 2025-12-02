<?php $__env->startSection('title', 'Novo Equipamento - Sistema de Calibração'); ?>

<?php $__env->startSection('breadcrumb'); ?>
<nav class="flex mb-6" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
            <a href="<?php echo e(route('dashboard')); ?>" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                <i class="fas fa-home mr-2"></i>
                Dashboard
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                <a href="<?php echo e(route('equipamentos.index')); ?>" class="text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">Equipamentos</a>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Novo</span>
            </div>
        </li>
    </ol>
</nav>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
        <i class="fas fa-plus-circle text-blue-600 mr-2"></i>
        Cadastrar Novo Equipamento
    </h2>
</div>

<form action="<?php echo e(route('equipamentos.store')); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
    <?php echo csrf_field(); ?>

    <!-- Informações Básicas -->
    <div class="rounded-lg bg-white dark:bg-gray-800 shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
            <i class="fas fa-info-circle text-blue-600 mr-2"></i>
            Informações Básicas
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php if (isset($component)) { $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input','data' => ['label' => 'Classe do Equipamento','name' => 'equipamento_classe','placeholder' => 'Ex: Instrumento de Medição','value' => old('equipamento_classe'),'error' => $errors->first('equipamento_classe')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Classe do Equipamento','name' => 'equipamento_classe','placeholder' => 'Ex: Instrumento de Medição','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('equipamento_classe')),'error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('equipamento_classe'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $attributes = $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $component = $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input','data' => ['label' => 'Tipo','name' => 'equipamento_tipo','placeholder' => 'Ex: Paquímetro Digital','value' => old('equipamento_tipo'),'error' => $errors->first('equipamento_tipo'),'required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Tipo','name' => 'equipamento_tipo','placeholder' => 'Ex: Paquímetro Digital','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('equipamento_tipo')),'error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('equipamento_tipo')),'required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $attributes = $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $component = $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input','data' => ['label' => 'Código Interno','name' => 'equipamento_codigo_interno','placeholder' => 'Ex: EQ-001','value' => old('equipamento_codigo_interno'),'error' => $errors->first('equipamento_codigo_interno')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Código Interno','name' => 'equipamento_codigo_interno','placeholder' => 'Ex: EQ-001','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('equipamento_codigo_interno')),'error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('equipamento_codigo_interno'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $attributes = $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $component = $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input','data' => ['label' => 'Fabricante','name' => 'equipamento_fabricante','placeholder' => 'Ex: Mitutoyo','value' => old('equipamento_fabricante'),'error' => $errors->first('equipamento_fabricante'),'required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Fabricante','name' => 'equipamento_fabricante','placeholder' => 'Ex: Mitutoyo','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('equipamento_fabricante')),'error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('equipamento_fabricante')),'required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $attributes = $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $component = $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input','data' => ['label' => 'Modelo','name' => 'equipamento_modelo','placeholder' => 'Ex: CD-6 CSX','value' => old('equipamento_modelo'),'error' => $errors->first('equipamento_modelo'),'required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Modelo','name' => 'equipamento_modelo','placeholder' => 'Ex: CD-6 CSX','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('equipamento_modelo')),'error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('equipamento_modelo')),'required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $attributes = $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $component = $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input','data' => ['label' => 'Número de Série','name' => 'equipamento_serial','placeholder' => 'Ex: 123456789','value' => old('equipamento_serial'),'error' => $errors->first('equipamento_serial')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Número de Série','name' => 'equipamento_serial','placeholder' => 'Ex: 123456789','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('equipamento_serial')),'error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('equipamento_serial'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $attributes = $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $component = $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
        </div>
    </div>

    <!-- Características Técnicas -->
    <div class="rounded-lg bg-white dark:bg-gray-800 shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
            <i class="fas fa-cogs text-blue-600 mr-2"></i>
            Características Técnicas
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php if (isset($component)) { $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input','data' => ['label' => 'Resolução','name' => 'equipamento_resolucao','placeholder' => 'Ex: 0.01 mm','value' => old('equipamento_resolucao'),'error' => $errors->first('equipamento_resolucao')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Resolução','name' => 'equipamento_resolucao','placeholder' => 'Ex: 0.01 mm','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('equipamento_resolucao')),'error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('equipamento_resolucao'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $attributes = $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $component = $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input','data' => ['label' => 'Faixa de Medição','name' => 'equipamento_faixa_medicao','placeholder' => 'Ex: 0-150 mm','value' => old('equipamento_faixa_medicao'),'error' => $errors->first('equipamento_faixa_medicao')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Faixa de Medição','name' => 'equipamento_faixa_medicao','placeholder' => 'Ex: 0-150 mm','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('equipamento_faixa_medicao')),'error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('equipamento_faixa_medicao'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $attributes = $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $component = $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input','data' => ['label' => 'Incerteza Nominal','name' => 'equipamento_incerteza_nominal','placeholder' => 'Ex: ± 0.02 mm','value' => old('equipamento_incerteza_nominal'),'error' => $errors->first('equipamento_incerteza_nominal')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Incerteza Nominal','name' => 'equipamento_incerteza_nominal','placeholder' => 'Ex: ± 0.02 mm','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('equipamento_incerteza_nominal')),'error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('equipamento_incerteza_nominal'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $attributes = $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $component = $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
        </div>
    </div>

    <!-- Dimensões Físicas -->
    <div class="rounded-lg bg-white dark:bg-gray-800 shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
            <i class="fas fa-ruler-combined text-blue-600 mr-2"></i>
            Dimensões Físicas e Elétricas
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <?php if (isset($component)) { $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input','data' => ['type' => 'number','label' => 'Altura (mm)','name' => 'equipamento_altura_mm','placeholder' => 'Ex: 200','value' => old('equipamento_altura_mm'),'error' => $errors->first('equipamento_altura_mm')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'number','label' => 'Altura (mm)','name' => 'equipamento_altura_mm','placeholder' => 'Ex: 200','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('equipamento_altura_mm')),'error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('equipamento_altura_mm'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $attributes = $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $component = $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input','data' => ['type' => 'number','label' => 'Largura (mm)','name' => 'equipamento_largura_mm','placeholder' => 'Ex: 100','value' => old('equipamento_largura_mm'),'error' => $errors->first('equipamento_largura_mm')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'number','label' => 'Largura (mm)','name' => 'equipamento_largura_mm','placeholder' => 'Ex: 100','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('equipamento_largura_mm')),'error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('equipamento_largura_mm'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $attributes = $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $component = $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input','data' => ['type' => 'number','label' => 'Comprimento (mm)','name' => 'equipamento_comprimento_mm','placeholder' => 'Ex: 300','value' => old('equipamento_comprimento_mm'),'error' => $errors->first('equipamento_comprimento_mm')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'number','label' => 'Comprimento (mm)','name' => 'equipamento_comprimento_mm','placeholder' => 'Ex: 300','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('equipamento_comprimento_mm')),'error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('equipamento_comprimento_mm'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $attributes = $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $component = $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input','data' => ['type' => 'number','label' => 'Tensão (V)','name' => 'equipamento_tensao_v','placeholder' => 'Ex: 110','value' => old('equipamento_tensao_v'),'error' => $errors->first('equipamento_tensao_v')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'number','label' => 'Tensão (V)','name' => 'equipamento_tensao_v','placeholder' => 'Ex: 110','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('equipamento_tensao_v')),'error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('equipamento_tensao_v'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $attributes = $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $component = $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input','data' => ['type' => 'number','label' => 'Potência (W)','name' => 'equipamento_potencia_w','placeholder' => 'Ex: 60','value' => old('equipamento_potencia_w'),'error' => $errors->first('equipamento_potencia_w')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'number','label' => 'Potência (W)','name' => 'equipamento_potencia_w','placeholder' => 'Ex: 60','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('equipamento_potencia_w')),'error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('equipamento_potencia_w'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $attributes = $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $component = $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
        </div>
    </div>

    <!-- Dados de Calibração -->
    <div class="rounded-lg bg-white dark:bg-gray-800 shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
            <i class="fas fa-calendar-check text-blue-600 mr-2"></i>
            Dados de Calibração
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <?php if (isset($component)) { $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input','data' => ['type' => 'date','label' => 'Última Calibração','name' => 'equipamento_data_ultima_calibracao','value' => old('equipamento_data_ultima_calibracao'),'error' => $errors->first('equipamento_data_ultima_calibracao')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'date','label' => 'Última Calibração','name' => 'equipamento_data_ultima_calibracao','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('equipamento_data_ultima_calibracao')),'error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('equipamento_data_ultima_calibracao'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $attributes = $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $component = $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input','data' => ['type' => 'date','label' => 'Próxima Calibração','name' => 'equipamento_data_proxima_calibracao','value' => old('equipamento_data_proxima_calibracao'),'error' => $errors->first('equipamento_data_proxima_calibracao')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'date','label' => 'Próxima Calibração','name' => 'equipamento_data_proxima_calibracao','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('equipamento_data_proxima_calibracao')),'error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('equipamento_data_proxima_calibracao'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $attributes = $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $component = $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input','data' => ['type' => 'number','label' => 'Periodicidade (meses)','name' => 'equipamento_periodicidade_meses','placeholder' => 'Ex: 12','value' => old('equipamento_periodicidade_meses'),'error' => $errors->first('equipamento_periodicidade_meses')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'number','label' => 'Periodicidade (meses)','name' => 'equipamento_periodicidade_meses','placeholder' => 'Ex: 12','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('equipamento_periodicidade_meses')),'error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('equipamento_periodicidade_meses'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $attributes = $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $component = $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input','data' => ['label' => 'Local de Calibração','name' => 'equipamento_local_calibracao','placeholder' => 'Ex: Lab. Interno','value' => old('equipamento_local_calibracao'),'error' => $errors->first('equipamento_local_calibracao')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Local de Calibração','name' => 'equipamento_local_calibracao','placeholder' => 'Ex: Lab. Interno','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('equipamento_local_calibracao')),'error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('equipamento_local_calibracao'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $attributes = $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $component = $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
        </div>
    </div>

    <!-- Status e Localização -->
    <div class="rounded-lg bg-white dark:bg-gray-800 shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
            <i class="fas fa-map-marker-alt text-blue-600 mr-2"></i>
            Status e Localização
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <?php if (isset($component)) { $__componentOriginaled2cde6083938c436304f332ba96bb7c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaled2cde6083938c436304f332ba96bb7c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.select','data' => ['label' => 'Status','name' => 'equipamento_status','options' => [
                    'ativo' => 'Ativo',
                    'inativo' => 'Inativo',
                    'manutencao' => 'Em Manutenção',
                    'descartado' => 'Descartado'
                ],'selected' => old('equipamento_status', 'ativo'),'error' => $errors->first('equipamento_status'),'required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Status','name' => 'equipamento_status','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                    'ativo' => 'Ativo',
                    'inativo' => 'Inativo',
                    'manutencao' => 'Em Manutenção',
                    'descartado' => 'Descartado'
                ]),'selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('equipamento_status', 'ativo')),'error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('equipamento_status')),'required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaled2cde6083938c436304f332ba96bb7c)): ?>
<?php $attributes = $__attributesOriginaled2cde6083938c436304f332ba96bb7c; ?>
<?php unset($__attributesOriginaled2cde6083938c436304f332ba96bb7c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaled2cde6083938c436304f332ba96bb7c)): ?>
<?php $component = $__componentOriginaled2cde6083938c436304f332ba96bb7c; ?>
<?php unset($__componentOriginaled2cde6083938c436304f332ba96bb7c); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input','data' => ['label' => 'Localização','name' => 'equipamento_localizacao','placeholder' => 'Ex: Sala 102','value' => old('equipamento_localizacao'),'error' => $errors->first('equipamento_localizacao')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Localização','name' => 'equipamento_localizacao','placeholder' => 'Ex: Sala 102','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('equipamento_localizacao')),'error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('equipamento_localizacao'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $attributes = $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $component = $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input','data' => ['label' => 'Setor','name' => 'equipamento_setor','placeholder' => 'Ex: Metrologia','value' => old('equipamento_setor'),'error' => $errors->first('equipamento_setor')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Setor','name' => 'equipamento_setor','placeholder' => 'Ex: Metrologia','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('equipamento_setor')),'error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('equipamento_setor'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $attributes = $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $component = $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
        </div>
    </div>

    <!-- Matriz IGP (Índice de Grau de Prioridade) -->
    <div class="rounded-lg bg-white dark:bg-gray-800 shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
            <i class="fas fa-chart-line text-blue-600 mr-2"></i>
            Matriz IGP - Índice de Grau de Prioridade
        </h3>

        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
            Avalie cada fator de 1 a 3. O IGP será calculado automaticamente (soma 5-15). Classificação: Baixa (&lt;7), Média (7-11), Alta (≥12).
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php if (isset($component)) { $__componentOriginaled2cde6083938c436304f332ba96bb7c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaled2cde6083938c436304f332ba96bb7c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.select','data' => ['label' => 'Frequência de Uso','name' => 'equipamento_frequencia_uso','options' => [
                    1 => '1 - Pouco usado',
                    2 => '2 - Uso moderado',
                    3 => '3 - Uso frequente'
                ],'selected' => old('equipamento_frequencia_uso'),'error' => $errors->first('equipamento_frequencia_uso'),'help' => 'Com que frequência o equipamento é utilizado?']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Frequência de Uso','name' => 'equipamento_frequencia_uso','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                    1 => '1 - Pouco usado',
                    2 => '2 - Uso moderado',
                    3 => '3 - Uso frequente'
                ]),'selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('equipamento_frequencia_uso')),'error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('equipamento_frequencia_uso')),'help' => 'Com que frequência o equipamento é utilizado?']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaled2cde6083938c436304f332ba96bb7c)): ?>
<?php $attributes = $__attributesOriginaled2cde6083938c436304f332ba96bb7c; ?>
<?php unset($__attributesOriginaled2cde6083938c436304f332ba96bb7c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaled2cde6083938c436304f332ba96bb7c)): ?>
<?php $component = $__componentOriginaled2cde6083938c436304f332ba96bb7c; ?>
<?php unset($__componentOriginaled2cde6083938c436304f332ba96bb7c); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginaled2cde6083938c436304f332ba96bb7c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaled2cde6083938c436304f332ba96bb7c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.select','data' => ['label' => 'Necessidade Crítica','name' => 'equipamento_necessidade_critica','options' => [
                    1 => '1 - Não crítico',
                    2 => '2 - Moderadamente crítico',
                    3 => '3 - Crítico'
                ],'selected' => old('equipamento_necessidade_critica'),'error' => $errors->first('equipamento_necessidade_critica'),'help' => 'Qual o impacto se o equipamento estiver indisponível?']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Necessidade Crítica','name' => 'equipamento_necessidade_critica','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                    1 => '1 - Não crítico',
                    2 => '2 - Moderadamente crítico',
                    3 => '3 - Crítico'
                ]),'selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('equipamento_necessidade_critica')),'error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('equipamento_necessidade_critica')),'help' => 'Qual o impacto se o equipamento estiver indisponível?']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaled2cde6083938c436304f332ba96bb7c)): ?>
<?php $attributes = $__attributesOriginaled2cde6083938c436304f332ba96bb7c; ?>
<?php unset($__attributesOriginaled2cde6083938c436304f332ba96bb7c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaled2cde6083938c436304f332ba96bb7c)): ?>
<?php $component = $__componentOriginaled2cde6083938c436304f332ba96bb7c; ?>
<?php unset($__componentOriginaled2cde6083938c436304f332ba96bb7c); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginaled2cde6083938c436304f332ba96bb7c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaled2cde6083938c436304f332ba96bb7c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.select','data' => ['label' => 'Abundância','name' => 'equipamento_abundancia','options' => [
                    1 => '1 - Abundante (facilmente substituível)',
                    2 => '2 - Disponibilidade média',
                    3 => '3 - Escasso (único/raro)'
                ],'selected' => old('equipamento_abundancia'),'error' => $errors->first('equipamento_abundancia'),'help' => 'Existem equipamentos similares disponíveis?']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Abundância','name' => 'equipamento_abundancia','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                    1 => '1 - Abundante (facilmente substituível)',
                    2 => '2 - Disponibilidade média',
                    3 => '3 - Escasso (único/raro)'
                ]),'selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('equipamento_abundancia')),'error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('equipamento_abundancia')),'help' => 'Existem equipamentos similares disponíveis?']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaled2cde6083938c436304f332ba96bb7c)): ?>
<?php $attributes = $__attributesOriginaled2cde6083938c436304f332ba96bb7c; ?>
<?php unset($__attributesOriginaled2cde6083938c436304f332ba96bb7c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaled2cde6083938c436304f332ba96bb7c)): ?>
<?php $component = $__componentOriginaled2cde6083938c436304f332ba96bb7c; ?>
<?php unset($__componentOriginaled2cde6083938c436304f332ba96bb7c); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginaled2cde6083938c436304f332ba96bb7c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaled2cde6083938c436304f332ba96bb7c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.select','data' => ['label' => 'Custo de Indisponibilidade','name' => 'equipamento_custo_indisponibilidade','options' => [
                    1 => '1 - Baixo custo',
                    2 => '2 - Custo médio',
                    3 => '3 - Alto custo'
                ],'selected' => old('equipamento_custo_indisponibilidade'),'error' => $errors->first('equipamento_custo_indisponibilidade'),'help' => 'Qual o custo se o equipamento parar?']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Custo de Indisponibilidade','name' => 'equipamento_custo_indisponibilidade','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                    1 => '1 - Baixo custo',
                    2 => '2 - Custo médio',
                    3 => '3 - Alto custo'
                ]),'selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('equipamento_custo_indisponibilidade')),'error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('equipamento_custo_indisponibilidade')),'help' => 'Qual o custo se o equipamento parar?']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaled2cde6083938c436304f332ba96bb7c)): ?>
<?php $attributes = $__attributesOriginaled2cde6083938c436304f332ba96bb7c; ?>
<?php unset($__attributesOriginaled2cde6083938c436304f332ba96bb7c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaled2cde6083938c436304f332ba96bb7c)): ?>
<?php $component = $__componentOriginaled2cde6083938c436304f332ba96bb7c; ?>
<?php unset($__componentOriginaled2cde6083938c436304f332ba96bb7c); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginaled2cde6083938c436304f332ba96bb7c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaled2cde6083938c436304f332ba96bb7c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.select','data' => ['label' => 'Criticidade Metrológica','name' => 'equipamento_criticidade_metrologica','options' => [
                    1 => '1 - Baixa criticidade',
                    2 => '2 - Média criticidade',
                    3 => '3 - Alta criticidade'
                ],'selected' => old('equipamento_criticidade_metrologica'),'error' => $errors->first('equipamento_criticidade_metrologica'),'help' => 'Qual a importância metrológica do equipamento?']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Criticidade Metrológica','name' => 'equipamento_criticidade_metrologica','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                    1 => '1 - Baixa criticidade',
                    2 => '2 - Média criticidade',
                    3 => '3 - Alta criticidade'
                ]),'selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('equipamento_criticidade_metrologica')),'error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('equipamento_criticidade_metrologica')),'help' => 'Qual a importância metrológica do equipamento?']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaled2cde6083938c436304f332ba96bb7c)): ?>
<?php $attributes = $__attributesOriginaled2cde6083938c436304f332ba96bb7c; ?>
<?php unset($__attributesOriginaled2cde6083938c436304f332ba96bb7c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaled2cde6083938c436304f332ba96bb7c)): ?>
<?php $component = $__componentOriginaled2cde6083938c436304f332ba96bb7c; ?>
<?php unset($__componentOriginaled2cde6083938c436304f332ba96bb7c); ?>
<?php endif; ?>
        </div>
    </div>

    <!-- Dados Financeiros -->
    <div class="rounded-lg bg-white dark:bg-gray-800 shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
            <i class="fas fa-dollar-sign text-blue-600 mr-2"></i>
            Dados Financeiros
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <?php if (isset($component)) { $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input','data' => ['type' => 'number','step' => '0.01','label' => 'Valor de Aquisição (R$)','name' => 'valor_aquisicao','placeholder' => 'Ex: 1500.00','value' => old('valor_aquisicao'),'error' => $errors->first('valor_aquisicao')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'number','step' => '0.01','label' => 'Valor de Aquisição (R$)','name' => 'valor_aquisicao','placeholder' => 'Ex: 1500.00','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('valor_aquisicao')),'error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('valor_aquisicao'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $attributes = $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $component = $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input','data' => ['type' => 'number','step' => '0.01','label' => 'Custo Estimado de Calibração (R$)','name' => 'equipamento_custo_estimado','placeholder' => 'Ex: 250.00','value' => old('equipamento_custo_estimado'),'error' => $errors->first('equipamento_custo_estimado')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'number','step' => '0.01','label' => 'Custo Estimado de Calibração (R$)','name' => 'equipamento_custo_estimado','placeholder' => 'Ex: 250.00','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('equipamento_custo_estimado')),'error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('equipamento_custo_estimado'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $attributes = $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $component = $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input','data' => ['type' => 'date','label' => 'Data de Aquisição','name' => 'data_aquisicao','value' => old('data_aquisicao'),'error' => $errors->first('data_aquisicao')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'date','label' => 'Data de Aquisição','name' => 'data_aquisicao','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('data_aquisicao')),'error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('data_aquisicao'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $attributes = $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $component = $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
        </div>
    </div>

    <!-- Documentação -->
    <div class="rounded-lg bg-white dark:bg-gray-800 shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
            <i class="fas fa-file-alt text-blue-600 mr-2"></i>
            Documentação e Instruções
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <?php if (isset($component)) { $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input','data' => ['label' => 'Link do Fabricante','name' => 'equipamento_link_fabricante','type' => 'url','placeholder' => 'https://...','value' => old('equipamento_link_fabricante'),'error' => $errors->first('equipamento_link_fabricante')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Link do Fabricante','name' => 'equipamento_link_fabricante','type' => 'url','placeholder' => 'https://...','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('equipamento_link_fabricante')),'error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('equipamento_link_fabricante'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $attributes = $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $component = $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Manual PDF
                </label>
                <input
                    type="file"
                    name="equipamento_manual_pdf"
                    accept=".pdf"
                    class="w-full rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 px-4 py-2.5 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                <?php if($errors->has('equipamento_manual_pdf')): ?>
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($errors->first('equipamento_manual_pdf')); ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4">
            <?php if (isset($component)) { $__componentOriginal4727f9fd7c3055c2cf9c658d89b16886 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4727f9fd7c3055c2cf9c658d89b16886 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.textarea','data' => ['label' => 'Instruções de Uso','name' => 'equipamento_instrucao_uso','rows' => '3','placeholder' => 'Descreva as instruções de uso do equipamento...','value' => old('equipamento_instrucao_uso'),'error' => $errors->first('equipamento_instrucao_uso')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Instruções de Uso','name' => 'equipamento_instrucao_uso','rows' => '3','placeholder' => 'Descreva as instruções de uso do equipamento...','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('equipamento_instrucao_uso')),'error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('equipamento_instrucao_uso'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4727f9fd7c3055c2cf9c658d89b16886)): ?>
<?php $attributes = $__attributesOriginal4727f9fd7c3055c2cf9c658d89b16886; ?>
<?php unset($__attributesOriginal4727f9fd7c3055c2cf9c658d89b16886); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4727f9fd7c3055c2cf9c658d89b16886)): ?>
<?php $component = $__componentOriginal4727f9fd7c3055c2cf9c658d89b16886; ?>
<?php unset($__componentOriginal4727f9fd7c3055c2cf9c658d89b16886); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginal4727f9fd7c3055c2cf9c658d89b16886 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4727f9fd7c3055c2cf9c658d89b16886 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.textarea','data' => ['label' => 'Instruções de Operação','name' => 'equipamento_instrucao_operacao','rows' => '3','placeholder' => 'Descreva as instruções de operação...','value' => old('equipamento_instrucao_operacao'),'error' => $errors->first('equipamento_instrucao_operacao')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Instruções de Operação','name' => 'equipamento_instrucao_operacao','rows' => '3','placeholder' => 'Descreva as instruções de operação...','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('equipamento_instrucao_operacao')),'error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('equipamento_instrucao_operacao'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4727f9fd7c3055c2cf9c658d89b16886)): ?>
<?php $attributes = $__attributesOriginal4727f9fd7c3055c2cf9c658d89b16886; ?>
<?php unset($__attributesOriginal4727f9fd7c3055c2cf9c658d89b16886); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4727f9fd7c3055c2cf9c658d89b16886)): ?>
<?php $component = $__componentOriginal4727f9fd7c3055c2cf9c658d89b16886; ?>
<?php unset($__componentOriginal4727f9fd7c3055c2cf9c658d89b16886); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginal4727f9fd7c3055c2cf9c658d89b16886 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4727f9fd7c3055c2cf9c658d89b16886 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.textarea','data' => ['label' => 'Instruções de Segurança','name' => 'equipamento_instrucao_seguranca','rows' => '3','placeholder' => 'Descreva as instruções de segurança...','value' => old('equipamento_instrucao_seguranca'),'error' => $errors->first('equipamento_instrucao_seguranca')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Instruções de Segurança','name' => 'equipamento_instrucao_seguranca','rows' => '3','placeholder' => 'Descreva as instruções de segurança...','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('equipamento_instrucao_seguranca')),'error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('equipamento_instrucao_seguranca'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4727f9fd7c3055c2cf9c658d89b16886)): ?>
<?php $attributes = $__attributesOriginal4727f9fd7c3055c2cf9c658d89b16886; ?>
<?php unset($__attributesOriginal4727f9fd7c3055c2cf9c658d89b16886); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4727f9fd7c3055c2cf9c658d89b16886)): ?>
<?php $component = $__componentOriginal4727f9fd7c3055c2cf9c658d89b16886; ?>
<?php unset($__componentOriginal4727f9fd7c3055c2cf9c658d89b16886); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginal4727f9fd7c3055c2cf9c658d89b16886 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4727f9fd7c3055c2cf9c658d89b16886 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.textarea','data' => ['label' => 'Comentários Adicionais','name' => 'equipamento_comentarios','rows' => '3','placeholder' => 'Observações e comentários gerais...','value' => old('equipamento_comentarios'),'error' => $errors->first('equipamento_comentarios')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Comentários Adicionais','name' => 'equipamento_comentarios','rows' => '3','placeholder' => 'Observações e comentários gerais...','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('equipamento_comentarios')),'error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('equipamento_comentarios'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4727f9fd7c3055c2cf9c658d89b16886)): ?>
<?php $attributes = $__attributesOriginal4727f9fd7c3055c2cf9c658d89b16886; ?>
<?php unset($__attributesOriginal4727f9fd7c3055c2cf9c658d89b16886); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4727f9fd7c3055c2cf9c658d89b16886)): ?>
<?php $component = $__componentOriginal4727f9fd7c3055c2cf9c658d89b16886; ?>
<?php unset($__componentOriginal4727f9fd7c3055c2cf9c658d89b16886); ?>
<?php endif; ?>
        </div>
    </div>

    <!-- Foto do Equipamento -->
    <div class="rounded-lg bg-white dark:bg-gray-800 shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
            <i class="fas fa-camera text-blue-600 mr-2"></i>
            Foto do Equipamento
        </h3>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Foto
            </label>
            <input
                type="file"
                name="equipamento_foto"
                accept="image/*"
                class="w-full rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 px-4 py-2.5 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
            <?php if($errors->has('equipamento_foto')): ?>
                <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($errors->first('equipamento_foto')); ?></p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Botões de Ação -->
    <div class="flex items-center justify-end gap-3">
        <a href="<?php echo e(route('equipamentos.index')); ?>"
           class="inline-flex items-center gap-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-6 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
            <i class="fas fa-times"></i>
            Cancelar
        </a>

        <button type="submit"
                class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-6 py-2.5 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
            <i class="fas fa-save"></i>
            Salvar Equipamento
        </button>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Calcular IGP automaticamente quando os valores mudarem
document.addEventListener('DOMContentLoaded', function() {
    const igpInputs = [
        'equipamento_frequencia_uso',
        'equipamento_necessidade_critica',
        'equipamento_abundancia',
        'equipamento_custo_indisponibilidade',
        'equipamento_criticidade_metrologica'
    ];

    igpInputs.forEach(inputName => {
        const input = document.querySelector(`select[name="${inputName}"]`);
        if(input) {
            input.addEventListener('change', calculateIGP);
        }
    });

    function calculateIGP() {
        let sum = 0;
        let allFilled = true;

        igpInputs.forEach(inputName => {
            const input = document.querySelector(`select[name="${inputName}"]`);
            if(input && input.value) {
                sum += parseInt(input.value);
            } else {
                allFilled = false;
            }
        });

        if(allFilled) {
            let classification = 'baixa';
            if(sum >= 12) classification = 'alta';
            else if(sum >= 7) classification = 'media';

            console.log(`IGP calculado: ${sum} - Classificação: ${classification}`);
        }
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/luciano/Área de trabalho/dev/calibracao_V0/resources/views/equipamentos/create.blade.php ENDPATH**/ ?>