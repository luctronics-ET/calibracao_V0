<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quadro Kanban - Sistema de Calibração</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900">
    <div class="min-h-screen p-4 sm:p-6 lg:p-8">
        <div class="mx-auto max-w-[1600px]">
            <!-- Breadcrumb -->
            <nav class="mb-6 flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="/" class="text-gray-700 hover:text-blue-600 dark:text-gray-400">Dashboard</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="mx-1 h-3 w-3 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-gray-500 dark:text-gray-400">Kanban</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Título da Página -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Quadro Kanban de Calibrações</h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Visualize o fluxo de trabalho das calibrações de forma organizada
                </p>
            </div>

            <!-- Componente Kanban -->
            <x-kanban
                title="Fluxo de Calibração"
                :columns="[
                    'backlog' => 'Backlog',
                    'todo' => 'A Fazer',
                    'in_progress' => 'Em Andamento',
                    'review' => 'Em Revisão',
                    'done' => 'Concluído'
                ]"
                :tasks="[
                    [
                        'id' => 1,
                        'title' => 'Balança Analítica BP-210D',
                        'description' => 'Calibração anual conforme cronograma. Utilizar padrões RBC 001 e 002.',
                        'column' => 'in_progress',
                        'priority' => 'alta',
                        'due_date' => '2025-12-10',
                        'assignee' => 'João Silva',
                        'tags' => 'balança,urgente',
                        'checklist_done' => 3,
                        'checklist_total' => 5
                    ],
                    [
                        'id' => 2,
                        'title' => 'Paquímetro Digital 150mm',
                        'description' => 'Certificado vencido. Realizar calibração completa.',
                        'column' => 'todo',
                        'priority' => 'alta',
                        'due_date' => '2025-12-08',
                        'assignee' => 'Maria Santos',
                        'tags' => 'paquímetro,dimensional'
                    ],
                    [
                        'id' => 3,
                        'title' => 'Termômetro Digital PT-100',
                        'description' => 'Verificação semestral de acordo com procedimento OP-CAL-003',
                        'column' => 'review',
                        'priority' => 'media',
                        'due_date' => '2025-12-12',
                        'assignee' => 'Pedro Costa',
                        'tags' => 'temperatura,termo'
                    ],
                    [
                        'id' => 4,
                        'title' => 'Manômetro 0-10 Bar',
                        'description' => 'Calibração anual. Usar padrão RBC-P-005',
                        'column' => 'todo',
                        'priority' => 'media',
                        'due_date' => '2025-12-15',
                        'assignee' => 'Ana Paula',
                        'tags' => 'pressão,manômetro'
                    ],
                    [
                        'id' => 5,
                        'title' => 'Micrômetro Externo 25mm',
                        'description' => 'Calibração realizada. Aguardando emissão do certificado.',
                        'column' => 'done',
                        'priority' => 'baixa',
                        'due_date' => '2025-12-05',
                        'assignee' => 'Carlos Eduardo',
                        'tags' => 'dimensional,micrômetro',
                        'checklist_done' => 4,
                        'checklist_total' => 4
                    ],
                    [
                        'id' => 6,
                        'title' => 'Balança de Precisão 6200g',
                        'description' => 'Aguardando disponibilidade do laboratório',
                        'column' => 'backlog',
                        'priority' => 'baixa',
                        'due_date' => '2025-12-20',
                        'assignee' => 'João Silva',
                        'tags' => 'balança,massa'
                    ],
                    [
                        'id' => 7,
                        'title' => 'Termohigrômetro Digital',
                        'description' => 'Calibração de temperatura e umidade. Procedimento OP-CAL-008',
                        'column' => 'in_progress',
                        'priority' => 'alta',
                        'due_date' => '2025-12-09',
                        'assignee' => 'Maria Santos',
                        'tags' => 'temperatura,umidade',
                        'checklist_done' => 2,
                        'checklist_total' => 6
                    ],
                    [
                        'id' => 8,
                        'title' => 'Paquímetro Analógico 300mm',
                        'description' => 'Revisão do certificado anterior identificou não conformidade',
                        'column' => 'review',
                        'priority' => 'alta',
                        'due_date' => '2025-12-07',
                        'assignee' => 'Pedro Costa',
                        'tags' => 'dimensional,revisão'
                    ],
                    [
                        'id' => 9,
                        'title' => 'Cronômetro Digital',
                        'description' => 'Calibração semestral conforme programação',
                        'column' => 'backlog',
                        'priority' => 'media',
                        'due_date' => '2025-12-18',
                        'tags' => 'tempo,cronômetro'
                    ],
                ]"
            />

            <!-- Métricas do Quadro -->
            <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
                <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="text-center">
                        <p class="text-sm text-gray-600 dark:text-gray-400">Backlog</p>
                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">2</p>
                        <div class="mt-2 h-2 w-full rounded-full bg-gray-200 dark:bg-gray-700">
                            <div class="h-2 rounded-full bg-gray-400" style="width: 22%"></div>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="text-center">
                        <p class="text-sm text-gray-600 dark:text-gray-400">A Fazer</p>
                        <p class="mt-2 text-3xl font-bold text-amber-600 dark:text-amber-400">2</p>
                        <div class="mt-2 h-2 w-full rounded-full bg-gray-200 dark:bg-gray-700">
                            <div class="h-2 rounded-full bg-amber-400" style="width: 22%"></div>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="text-center">
                        <p class="text-sm text-gray-600 dark:text-gray-400">Em Andamento</p>
                        <p class="mt-2 text-3xl font-bold text-blue-600 dark:text-blue-400">2</p>
                        <div class="mt-2 h-2 w-full rounded-full bg-gray-200 dark:bg-gray-700">
                            <div class="h-2 rounded-full bg-blue-500" style="width: 22%"></div>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="text-center">
                        <p class="text-sm text-gray-600 dark:text-gray-400">Em Revisão</p>
                        <p class="mt-2 text-3xl font-bold text-purple-600 dark:text-purple-400">2</p>
                        <div class="mt-2 h-2 w-full rounded-full bg-gray-200 dark:bg-gray-700">
                            <div class="h-2 rounded-full bg-purple-500" style="width: 22%"></div>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="text-center">
                        <p class="text-sm text-gray-600 dark:text-gray-400">Concluído</p>
                        <p class="mt-2 text-3xl font-bold text-green-600 dark:text-green-400">1</p>
                        <div class="mt-2 h-2 w-full rounded-full bg-gray-200 dark:bg-gray-700">
                            <div class="h-2 rounded-full bg-green-500" style="width: 11%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @stack('scripts')

    <script>
    function editKanbanCard(task) {
        console.log('Editar card:', task);
        alert('Editar: ' + task.title);
    }

    function deleteKanbanCard(id) {
        if (confirm('Deseja realmente excluir este card?')) {
            console.log('Excluir card ID:', id);
            const card = document.getElementById('card-' + id);
            if (card) {
                card.remove();
                alert('Card excluído!');
            }
        }
    }
    </script>
</body>
</html>
