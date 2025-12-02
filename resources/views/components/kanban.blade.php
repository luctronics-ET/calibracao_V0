@props([
    'id' => 'kanban-' . uniqid(),
    'title' => 'Quadro Kanban',
    'columns' => [
        'backlog' => 'Backlog',
        'todo' => 'A Fazer',
        'in_progress' => 'Em Andamento',
        'review' => 'Em Revisão',
        'done' => 'Concluído'
    ],
    'tasks' => [],
])

<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Cabeçalho -->
    <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-800 sm:px-6">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">{{ $title }}</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Organize suas tarefas visualmente
                </p>
            </div>
            <div class="flex items-center gap-2">
                <button
                    onclick="openKanbanTaskModal()"
                    class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Novo Card
                </button>
            </div>
        </div>
    </div>

    <!-- Quadro Kanban -->
    <div class="p-5 sm:p-6">
        <div class="kanban-board flex gap-4 overflow-x-auto pb-4" id="{{ $id }}">
            @foreach($columns as $columnId => $columnTitle)
            <div class="kanban-column flex-shrink-0 w-80">
                <!-- Cabeçalho da Coluna -->
                <div class="mb-3 flex items-center justify-between rounded-lg bg-gray-50 px-4 py-3 dark:bg-gray-800/50">
                    <h4 class="font-semibold text-gray-900 dark:text-white">
                        {{ $columnTitle }}
                    </h4>
                    <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-gray-200 text-xs font-medium text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                        {{ count(array_filter($tasks, fn($t) => ($t['column'] ?? 'backlog') === $columnId)) }}
                    </span>
                </div>

                <!-- Cards da Coluna -->
                <div
                    class="kanban-cards space-y-3 min-h-[200px] rounded-lg border-2 border-dashed border-gray-200 p-3 dark:border-gray-700"
                    data-column="{{ $columnId }}"
                    ondrop="drop(event)"
                    ondragover="allowDrop(event)"
                >
                    @foreach($tasks as $task)
                        @if(($task['column'] ?? 'backlog') === $columnId)
                            <x-kanban-card :task="$task" />
                        @endif
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Modal Criar/Editar Card -->
<div id="kanban-task-modal-{{ $id }}" class="fixed inset-0 z-99999 hidden">
    <div class="flex min-h-screen items-center justify-center p-4">
        <div onclick="closeKanbanTaskModal()" class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm"></div>

        <div class="relative w-full max-w-lg rounded-2xl bg-white p-6 dark:bg-gray-900">
            <button
                onclick="closeKanbanTaskModal()"
                class="absolute right-5 top-5 flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 text-gray-400 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <h5 class="mb-6 text-xl font-semibold text-gray-800 dark:text-white/90">
                Novo Card
            </h5>

            <form id="kanban-task-form-{{ $id }}" class="space-y-4">
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Título
                    </label>
                    <input
                        type="text"
                        name="title"
                        required
                        class="h-11 w-full rounded-lg border border-gray-300 px-4 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                        placeholder="Digite o título do card"
                    />
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Descrição
                    </label>
                    <textarea
                        name="description"
                        rows="3"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                        placeholder="Descreva o card"
                    ></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Coluna
                        </label>
                        <select name="column" class="h-11 w-full rounded-lg border border-gray-300 px-4 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            @foreach($columns as $columnId => $columnTitle)
                            <option value="{{ $columnId }}">{{ $columnTitle }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Prioridade
                        </label>
                        <select name="priority" class="h-11 w-full rounded-lg border border-gray-300 px-4 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            <option value="baixa">Baixa</option>
                            <option value="media" selected>Média</option>
                            <option value="alta">Alta</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Responsável
                    </label>
                    <input
                        type="text"
                        name="assignee"
                        class="h-11 w-full rounded-lg border border-gray-300 px-4 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                        placeholder="Nome do responsável"
                    />
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Data de Entrega
                    </label>
                    <input
                        type="date"
                        name="due_date"
                        class="h-11 w-full rounded-lg border border-gray-300 px-4 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                    />
                </div>

                <div class="flex gap-3 pt-4">
                    <button
                        type="submit"
                        class="flex-1 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-blue-700"
                    >
                        Criar Card
                    </button>
                    <button
                        type="button"
                        onclick="closeKanbanTaskModal()"
                        class="flex-1 rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800"
                    >
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function openKanbanTaskModal() {
    document.getElementById('kanban-task-modal-{{ $id }}').classList.remove('hidden');
}

function closeKanbanTaskModal() {
    document.getElementById('kanban-task-modal-{{ $id }}').classList.add('hidden');
}

// Drag and Drop
function allowDrop(ev) {
    ev.preventDefault();
    ev.currentTarget.classList.add('bg-blue-50', 'dark:bg-blue-900/10', 'border-blue-300', 'dark:border-blue-700');
}

function drag(ev) {
    ev.dataTransfer.setData("cardId", ev.target.id);
    ev.target.classList.add('opacity-50');
}

function drop(ev) {
    ev.preventDefault();
    const cardId = ev.dataTransfer.getData("cardId");
    const card = document.getElementById(cardId);
    const column = ev.currentTarget;

    if (card && column.classList.contains('kanban-cards')) {
        column.appendChild(card);
        card.classList.remove('opacity-50');

        // Atualizar contador da coluna
        updateColumnCount(column);

        // Remover destaque
        column.classList.remove('bg-blue-50', 'dark:bg-blue-900/10', 'border-blue-300', 'dark:border-blue-700');
    }
}

function updateColumnCount(column) {
    const count = column.querySelectorAll('.kanban-card').length;
    const header = column.parentElement.querySelector('span');
    if (header) {
        header.textContent = count;
    }
}

// Remover destaque ao sair
document.querySelectorAll('.kanban-cards').forEach(col => {
    col.addEventListener('dragleave', function(e) {
        if (e.target === this) {
            this.classList.remove('bg-blue-50', 'dark:bg-blue-900/10', 'border-blue-300', 'dark:border-blue-700');
        }
    });
});
</script>
@endpush
