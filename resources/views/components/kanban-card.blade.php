@props([
    'task' => null
])

@php
$priorityColors = [
    'alta' => 'border-l-red-500',
    'media' => 'border-l-amber-500',
    'baixa' => 'border-l-green-500',
];
@endphp

<div
    id="card-{{ $task['id'] ?? uniqid() }}"
    draggable="true"
    ondragstart="drag(event)"
    class="kanban-card group rounded-lg border-l-4 {{ $priorityColors[$task['priority'] ?? 'media'] }} bg-white p-4 shadow-sm hover:shadow-md transition-shadow cursor-move dark:bg-gray-800 dark:border-gray-700"
>
    <!-- Cabeçalho do Card -->
    <div class="flex items-start justify-between gap-2">
        <h5 class="flex-1 font-medium text-gray-900 dark:text-white text-sm">
            {{ $task['title'] ?? 'Sem título' }}
        </h5>

        <!-- Ações -->
        <div class="flex items-center gap-0.5 opacity-0 group-hover:opacity-100 transition-opacity">
            <button
                onclick="editKanbanCard({{ json_encode($task) }})"
                class="rounded p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-gray-700 dark:hover:text-gray-300"
                title="Editar"
            >
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </button>
            <button
                onclick="deleteKanbanCard({{ $task['id'] ?? 0 }})"
                class="rounded p-1 text-gray-400 hover:bg-red-100 hover:text-red-600 dark:hover:bg-red-900/30 dark:hover:text-red-400"
                title="Excluir"
            >
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Descrição -->
    @if(!empty($task['description']))
    <p class="mt-2 text-xs text-gray-600 dark:text-gray-400 line-clamp-2">
        {{ $task['description'] }}
    </p>
    @endif

    <!-- Tags -->
    @if(!empty($task['tags']))
    <div class="mt-3 flex flex-wrap gap-1">
        @foreach(explode(',', $task['tags']) as $tag)
        <span class="inline-flex items-center rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-700 dark:bg-gray-700 dark:text-gray-300">
            {{ trim($tag) }}
        </span>
        @endforeach
    </div>
    @endif

    <!-- Footer -->
    <div class="mt-3 flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
        <!-- Data de Entrega -->
        <div class="flex items-center gap-1">
            @if(!empty($task['due_date']))
            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span>{{ \Carbon\Carbon::parse($task['due_date'])->format('d/m') }}</span>
            @endif
        </div>

        <!-- Responsável -->
        @if(!empty($task['assignee']))
        <div class="flex items-center gap-1">
            <div class="flex h-6 w-6 items-center justify-center rounded-full bg-blue-100 text-xs font-medium text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                {{ substr($task['assignee'], 0, 1) }}
            </div>
        </div>
        @endif
    </div>

    <!-- Indicador de Prioridade -->
    <div class="mt-2 flex items-center gap-1.5 text-xs">
        <div class="flex items-center gap-1">
            <div class="h-2 w-2 rounded-full {{ $task['priority'] === 'alta' ? 'bg-red-500' : ($task['priority'] === 'baixa' ? 'bg-green-500' : 'bg-amber-500') }}"></div>
            <span class="text-gray-600 dark:text-gray-400">{{ ucfirst($task['priority'] ?? 'média') }}</span>
        </div>

        <!-- Checklist Progress (se houver) -->
        @if(!empty($task['checklist_total']))
        <div class="ml-auto flex items-center gap-1">
            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
            <span>{{ $task['checklist_done'] ?? 0 }}/{{ $task['checklist_total'] }}</span>
        </div>
        @endif
    </div>
</div>
