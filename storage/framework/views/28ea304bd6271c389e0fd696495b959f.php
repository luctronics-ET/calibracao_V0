<!DOCTYPE html>
<html lang="pt-BR"
      x-data="{ darkMode: false, sidebarOpen: false }"
      x-init="darkMode = JSON.parse(localStorage.getItem('darkMode') || 'false');
              $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
      :class="{'dark': darkMode}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'CalibSys - Sistema de Calibração'); ?></title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

    <!-- Custom Styles -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        * {
            font-family: 'Inter', sans-serif;
        }

        /* Scrollbar personalizado */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .dark ::-webkit-scrollbar-track {
            background: #1e293b;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .dark ::-webkit-scrollbar-thumb {
            background: #475569;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* DataTables customização */
        .dataTables_wrapper {
            padding: 0;
        }

        table.dataTable thead th {
            font-weight: 600;
            border-bottom: 2px solid #e2e8f0;
        }

        .dark table.dataTable thead th {
            border-bottom-color: #374151;
        }

        table.dataTable tbody tr:hover {
            background-color: #f8fafc !important;
        }

        .dark table.dataTable tbody tr:hover {
            background-color: #1f2937 !important;
        }

        /* Animações suaves */
        .transition-all {
            transition: all 0.3s ease;
        }

        /* Estilo dos botões do DataTables */
        .dt-buttons {
            margin-bottom: 1rem;
        }

        .dt-button {
            margin-right: 0.5rem !important;
        }
    </style>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">

    <!-- Page Wrapper -->
    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <?php echo $__env->make('layouts.partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- Content Area -->
        <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">

            <!-- Header -->
            <?php echo $__env->make('layouts.partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <!-- Main Content -->
            <main class="flex-1">
                <div class="mx-auto max-w-(--breakpoint-2xl) p-4 md:p-6">

                    <!-- Breadcrumb -->
                    <?php echo $__env->yieldContent('breadcrumb'); ?>

                    <!-- Flash Messages -->
                    <?php if(session('success')): ?>
                        <div class="mb-4 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 p-4" role="alert">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-600 dark:text-green-400 mr-3"></i>
                                <span class="text-sm font-medium text-green-800 dark:text-green-200"><?php echo e(session('success')); ?></span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if(session('error')): ?>
                        <div class="mb-4 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 p-4" role="alert">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-circle text-red-600 dark:text-red-400 mr-3"></i>
                                <span class="text-sm font-medium text-red-800 dark:text-red-200"><?php echo e(session('error')); ?></span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if($errors->any()): ?>
                        <div class="mb-4 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 p-4" role="alert">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-exclamation-triangle text-red-600 dark:text-red-400 mr-3"></i>
                                <span class="text-sm font-semibold text-red-800 dark:text-red-200">Erros encontrados:</span>
                            </div>
                            <ul class="list-disc list-inside text-sm text-red-700 dark:text-red-300 ml-6">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <!-- Page Content -->
                    <?php echo $__env->yieldContent('content'); ?>

                </div>
            </main>

            <!-- Footer -->
            <?php echo $__env->make('layouts.partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <!-- DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <!-- Default DataTable Configuration -->
    <script>
        // Configuração global do DataTables em português
        window.dataTablesPtBr = {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json'
        };

        $(document).ready(function() {
            // Configuração padrão para tabelas com classe .data-table
            $('.data-table').DataTable({
                responsive: true,
                language: window.dataTablesPtBr,
                pageLength: 25,
                order: [[0, 'desc']]
            });
        });
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>

</body>
</html>
<?php /**PATH /home/luciano/Área de trabalho/dev/calibracao_V0/resources/views/layouts/app.blade.php ENDPATH**/ ?>