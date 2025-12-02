@props([
    'task' => null
])

@php
$priorityColors = [
    'alta' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
    'media' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
    'baixa' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
];

$statusColors = [
    'pendente' => 'border-gray-300 dark:border-gray-700',
    'em_andamento' => 'border-blue-300 dark:border-blue-700 bg-blue-50/50 dark:bg-blue-900/10',
    'concluida' => 'border-green-300 dark:border-green-700 bg-green-50/50 dark:bg-green-900/10',
];
@endphp

<div
    data-priority="{{ $task['priority'] ?? 'media' }}"
    data-status="{{ $task['status'] ?? 'pendente' }}"
    class="group flex items-start gap-3 rounded-lg border p-4 transition-all hover:shadow-md {{ $statusColors[$task['status'] ?? 'pendente'] }}"
>
    <!-- Checkbox -->
    <div class="flex pt-0.5">
        <input
            type="checkbox"
            {{ ($task['status'] ?? 'pendente') === 'concluida' ? 'checked' : '' }}
            class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-900"
            onchange="toggleTaskStatus(this)"
        />
    </div>

    <!-- Conteúdo da Tarefa -->
    <div class="flex-1 min-w-0">
        <div class="flex items-start justify-between gap-3">
            <div class="flex-1">
                <h4 class="font-medium text-gray-900 dark:text-white {{ ($task['status'] ?? 'pendente') === 'concluida' ? 'line-through opacity-60' : '' }}">
                    {{ $task['title'] ?? 'Sem título' }}
                </h4>
                @if(!empty($task['description']))
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ $task['description'] }}
                </p>
                @endif
            </div>

            <!-- Prioridade Badge -->
            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $priorityColors[$task['priority'] ?? 'media'] }}">
                {{ ucfirst($task['priority'] ?? 'média') }}
            </span>
        </div>

        <!-- Informações Adicionais -->
        <div class="mt-3 flex flex-wrap items-center gap-4 text-xs text-gray-500 dark:text-gray-400">
            @if(!empty($task['due_date']))
            <div class="flex items-center gap-1">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span>{{ \Carbon\Carbon::parse($task['due_date'])->format('d/m/Y') }}</span>
            </div>
            @endif

            @if(!empty($task['assignee']))
            <div class="flex items-center gap-1">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span>{{ $task['assignee'] }}</span>
            </div>
            @endif

            @if(!empty($task['tags']))
            <div class="flex items-center gap-1">
                @foreach(explode(',', $task['tags']) as $tag)
                <span class="inline-flex items-center rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                    {{ trim($tag) }}
                </span>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    <!-- Ações -->
    <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
        <button
            onclick="editTask({{ json_encode($task) }})"
            class="rounded p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-gray-800 dark:hover:text-gray-300"
            title="Editar"
        >
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
        </button>
        <button
            onclick="deleteTask({{ $task['id'] ?? 0 }})"
            class="rounded p-1.5 text-gray-400 hover:bg-red-100 hover:text-red-600 dark:hover:bg-red-900/30 dark:hover:text-red-400"
            title="Excluir"
        >
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </button>
    </div>
</div>
