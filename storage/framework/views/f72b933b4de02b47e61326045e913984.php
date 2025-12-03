<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'id' => 'datatable3',
    'title' => null,
    'subtitle' => null,
    'headers' => [],
    'searchable' => true,
    'exportable' => true,
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'id' => 'datatable3',
    'title' => null,
    'subtitle' => null,
    'headers' => [],
    'searchable' => true,
    'exportable' => true,
]); ?>
<?php foreach (array_filter(([
    'id' => 'datatable3',
    'title' => null,
    'subtitle' => null,
    'headers' => [],
    'searchable' => true,
    'exportable' => true,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <?php if($title || $slot->isNotEmpty()): ?>
    <div class="px-5 py-4 sm:px-6 sm:py-5">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <?php if($title): ?>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90"><?php echo e($title); ?></h3>
                <?php endif; ?>
                <?php if($subtitle): ?>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400"><?php echo e($subtitle); ?></p>
                <?php endif; ?>
            </div>
            <?php if($exportable): ?>
            <div class="flex items-center gap-2">
                <?php echo e($actions ?? ''); ?>

            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <div class="p-5 border-t border-gray-100 dark:border-gray-800 sm:p-6">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto" id="<?php echo e($id); ?>">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800/50 text-left">
                        <?php $__currentLoopData = $headers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $header): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <th class="px-4 py-3 font-medium text-gray-900 dark:text-white text-sm">
                            <?php echo e($header); ?>

                        </th>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tr>
                    <tr class="bg-gray-100 dark:bg-gray-900/50">
                        <?php $__currentLoopData = $headers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $header): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <th class="px-2 py-2">
                            <?php if($header !== 'Ações'): ?>
                            <input type="text" class="column-filter form-control form-control-sm w-full px-2 py-1 text-xs border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-800 dark:text-white" placeholder="Filtrar <?php echo e(strtolower($header)); ?>" data-column="<?php echo e($index); ?>">
                            <?php endif; ?>
                        </th>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    <?php echo e($body); ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
$(document).ready(function() {
    try {
        var table = $('#<?php echo e($id); ?>').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json'
            },
            responsive: true,
            pageLength: 20,
            lengthMenu: [[10, 20, 50, 100, -1], [10, 20, 50, 100, "Todos"]],
            lengthChange: true,
            order: [[0, 'desc']],
            dom: 'Blfrtip',
            deferRender: true,
            processing: false,
            buttons: [
            <?php if($exportable): ?>
            {
                extend: 'excel',
                className: 'btn btn-sm btn-success',
                text: '<i class="fas fa-file-excel mr-1"></i> Excel',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
            {
                extend: 'pdf',
                className: 'btn btn-sm btn-danger',
                text: '<i class="fas fa-file-pdf mr-1"></i> PDF',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
            {
                extend: 'print',
                className: 'btn btn-sm btn-info',
                text: '<i class="fas fa-print mr-1"></i> Imprimir',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            }
            <?php endif; ?>
        ],
        initComplete: function() {
            var api = this.api();

            // Aplica filtros em cada coluna
            $('#<?php echo e($id); ?> thead tr:eq(1) input.column-filter').each(function() {
                var columnIndex = $(this).data('column');
                var input = this;

                $(input).on('keyup change clear', function() {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());
                    api.column(columnIndex).search(val ? val : '', true, false).draw();
                });
            });
        }
    });
    } catch(e) {
        console.error('Erro ao inicializar DataTable:', e);
        alert('Erro ao carregar tabela: ' + e.message);
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/luciano/Área de trabalho/dev/calibracao_V0/resources/views/components/datatable3.blade.php ENDPATH**/ ?>