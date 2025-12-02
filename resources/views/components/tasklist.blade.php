@props([
    'id' => 'tasklist-' . uniqid(),
    'title' => 'Lista de Tarefas',
    'tasks' => [],
    'showSearch' => true,
    'showFilters' => true,
])

<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Cabeçalho -->
    <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-800 sm:px-6">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">{{ $title }}</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Gerencie suas tarefas e acompanhe o progresso
                </p>
            </div>
            <button
                onclick="openTaskModal()"
                class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nova Tarefa
            </button>
        </div>
    </div>

    <!-- Busca e Filtros -->
    @if($showSearch || $showFilters)
    <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-800 sm:px-6">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
            @if($showSearch)
            <div class="flex-1">
                <div class="relative">
                    <input
                        type="text"
                        id="task-search-{{ $id }}"
                        placeholder="Buscar tarefas..."
                        class="h-10 w-full rounded-lg border border-gray-300 bg-transparent pl-10 pr-4 text-sm text-gray-800 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                    />
                    <svg class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>
            @endif

            @if($showFilters)
            <div class="flex gap-2">
                <select
                    id="filter-priority-{{ $id }}"
                    class="h-10 rounded-lg border border-gray-300 bg-transparent px-3 text-sm text-gray-800 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                >
                    <option value="">Todas Prioridades</option>
                    <option value="alta">Alta</option>
                    <option value="media">Média</option>
                    <option value="baixa">Baixa</option>
                </select>

                <select
                    id="filter-status-{{ $id }}"
                    class="h-10 rounded-lg border border-gray-300 bg-transparent px-3 text-sm text-gray-800 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                >
                    <option value="">Todos Status</option>
                    <option value="pendente">Pendente</option>
                    <option value="em_andamento">Em Andamento</option>
                    <option value="concluida">Concluída</option>
                </select>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Lista de Tarefas -->
    <div class="p-5 sm:p-6">
        <div id="task-list-{{ $id }}" class="space-y-2">
            @forelse($tasks as $task)
                <x-task-item :task="$task" />
            @empty
            <div class="py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">Nenhuma tarefa encontrada</p>
                <button
                    onclick="openTaskModal()"
                    class="mt-4 inline-flex items-center gap-2 text-sm font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400"
                >
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Criar sua primeira tarefa
                </button>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Modal Criar/Editar Tarefa -->
<div id="task-modal-{{ $id }}" class="fixed inset-0 z-99999 hidden">
    <div class="flex min-h-screen items-center justify-center p-4">
        <div onclick="closeTaskModal()" class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm"></div>

        <div class="relative w-full max-w-lg rounded-2xl bg-white p-6 dark:bg-gray-900">
            <button
                onclick="closeTaskModal()"
                class="absolute right-5 top-5 flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 text-gray-400 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <h5 class="mb-6 text-xl font-semibold text-gray-800 dark:text-white/90">
                Nova Tarefa
            </h5>

            <form id="task-form-{{ $id }}" class="space-y-4">
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Título
                    </label>
                    <input
                        type="text"
                        name="title"
                        required
                        class="h-11 w-full rounded-lg border border-gray-300 px-4 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                        placeholder="Digite o título da tarefa"
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
                        placeholder="Descreva a tarefa"
                    ></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
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
                </div>

                <div class="flex gap-3 pt-4">
                    <button
                        type="submit"
                        class="flex-1 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-blue-700"
                    >
                        Criar Tarefa
                    </button>
                    <button
                        type="button"
                        onclick="closeTaskModal()"
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
function openTaskModal() {
    document.getElementById('task-modal-{{ $id }}').classList.remove('hidden');
}

function closeTaskModal() {
    document.getElementById('task-modal-{{ $id }}').classList.add('hidden');
}

// Busca de tarefas
document.getElementById('task-search-{{ $id }}')?.addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const tasks = document.querySelectorAll('#task-list-{{ $id }} > div');

    tasks.forEach(task => {
        const text = task.textContent.toLowerCase();
        task.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});

// Filtros
['filter-priority-{{ $id }}', 'filter-status-{{ $id }}'].forEach(id => {
    document.getElementById(id)?.addEventListener('change', filterTasks);
});

function filterTasks() {
    const priorityFilter = document.getElementById('filter-priority-{{ $id }}')?.value;
    const statusFilter = document.getElementById('filter-status-{{ $id }}')?.value;
    const tasks = document.querySelectorAll('#task-list-{{ $id }} > div');

    tasks.forEach(task => {
        const priority = task.dataset.priority;
        const status = task.dataset.status;

        const matchPriority = !priorityFilter || priority === priorityFilter;
        const matchStatus = !statusFilter || status === statusFilter;

        task.style.display = matchPriority && matchStatus ? '' : 'none';
    });
}
</script>
@endpush
