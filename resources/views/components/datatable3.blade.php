@props([
    'id' => 'datatable3',
    'title' => null,
    'subtitle' => null,
    'headers' => [],
    'searchable' => true,
    'exportable' => true,
])

<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    @if($title || $slot->isNotEmpty())
    <div class="px-5 py-4 sm:px-6 sm:py-5">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                @if($title)
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">{{ $title }}</h3>
                @endif
                @if($subtitle)
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $subtitle }}</p>
                @endif
            </div>
            @if($exportable)
            <div class="flex items-center gap-2">
                {{ $actions ?? '' }}
            </div>
            @endif
        </div>
    </div>
    @endif

    <div class="p-5 border-t border-gray-100 dark:border-gray-800 sm:p-6">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto" id="{{ $id }}">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800/50 text-left">
                        @foreach($headers as $header)
                        <th class="px-4 py-3 font-medium text-gray-900 dark:text-white text-sm">
                            {{ $header }}
                        </th>
                        @endforeach
                    </tr>
                    <tr class="bg-gray-100 dark:bg-gray-900/50">
                        @foreach($headers as $index => $header)
                        <th class="px-2 py-2">
                            @if($header !== 'Ações')
                            <input type="text" class="column-filter form-control form-control-sm w-full px-2 py-1 text-xs border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-800 dark:text-white" placeholder="Filtrar {{ strtolower($header) }}" data-column="{{ $index }}">
                            @endif
                        </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    {{ $body }}
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    var table = $('#{{ $id }}').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json'
        },
        responsive: true,
        pageLength: 20,
        lengthMenu: [[10, 20, 50, 100, -1], [10, 20, 50, 100, "Todos"]],
        lengthChange: true,
        order: [[0, 'desc']],
        dom: 'Blfrtip',
        buttons: [
            @if($exportable)
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
            @endif
        ],
        initComplete: function() {
            var api = this.api();

            // Aplica filtros em cada coluna
            $('#{{ $id }} thead tr:eq(1) input.column-filter').each(function() {
                var columnIndex = $(this).data('column');
                var input = this;

                $(input).on('keyup change clear', function() {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());
                    api.column(columnIndex).search(val ? val : '', true, false).draw();
                });
            });
        }
    });
});
</script>
@endpush
