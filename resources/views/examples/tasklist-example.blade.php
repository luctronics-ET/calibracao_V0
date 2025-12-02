<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tarefas - Sistema de Calibração</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 dark:bg-gray-900">
    <div class="min-h-screen p-4 sm:p-6 lg:p-8">
        <div class="mx-auto max-w-7xl">
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
                            <span class="ml-1 text-gray-500 dark:text-gray-400">Tarefas</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Título da Página -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Tarefas de Calibração</h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Gerencie todas as atividades relacionadas ao processo de calibração
                </p>
            </div>

            <!-- Componente Task List -->
            <x-tasklist
                title="Atividades Pendentes"
                :tasks="[
                    [
                        'id' => 1,
                        'title' => 'Realizar calibração da balança analítica BP-210D',
                        'description' => 'Calibração anual conforme cronograma. Usar padrões RBC 001 e 002.',
                        'priority' => 'alta',
                        'status' => 'em_andamento',
                        'due_date' => '2025-12-10',
                        'assignee' => 'João Silva',
                        'tags' => 'balança,urgente'
                    ],
                    [
                        'id' => 2,
                        'title' => 'Emitir certificado de calibração',
                        'description' => 'Emitir certificado para o paquímetro digital calibrado em 05/12',
                        'priority' => 'media',
                        'status' => 'pendente',
                        'due_date' => '2025-12-08',
                        'assignee' => 'Maria Santos',
                        'tags' => 'certificado,documentação'
                    ],
                    [
                        'id' => 3,
                        'title' => 'Verificar temperatura do laboratório',
                        'description' => 'Realizar verificação diária da temperatura ambiente',
                        'priority' => 'baixa',
                        'status' => 'concluida',
                        'due_date' => '2025-12-05',
                        'assignee' => 'Pedro Costa'
                    ],
                    [
                        'id' => 4,
                        'title' => 'Solicitar manutenção preventiva',
                        'description' => 'Solicitar manutenção do sistema de climatização',
                        'priority' => 'media',
                        'status' => 'pendente',
                        'due_date' => '2025-12-12',
                        'assignee' => 'Ana Paula',
                        'tags' => 'manutenção,laboratório'
                    ],
                    [
                        'id' => 5,
                        'title' => 'Atualizar planilha de controle IGP-10',
                        'description' => 'Inserir dados da última calibração no sistema de gestão',
                        'priority' => 'alta',
                        'status' => 'em_andamento',
                        'due_date' => '2025-12-07',
                        'assignee' => 'Carlos Eduardo',
                        'tags' => 'documentação,igp-10'
                    ],
                ]"
            />

            <!-- Estatísticas -->
            <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Total</p>
                            <p class="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">5</p>
                        </div>
                        <div class="rounded-full bg-blue-100 p-3 dark:bg-blue-900/30">
                            <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Pendentes</p>
                            <p class="mt-1 text-2xl font-semibold text-amber-600 dark:text-amber-400">2</p>
                        </div>
                        <div class="rounded-full bg-amber-100 p-3 dark:bg-amber-900/30">
                            <svg class="h-6 w-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Em Andamento</p>
                            <p class="mt-1 text-2xl font-semibold text-blue-600 dark:text-blue-400">2</p>
                        </div>
                        <div class="rounded-full bg-blue-100 p-3 dark:bg-blue-900/30">
                            <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Concluídas</p>
                            <p class="mt-1 text-2xl font-semibold text-green-600 dark:text-green-400">1</p>
                        </div>
                        <div class="rounded-full bg-green-100 p-3 dark:bg-green-900/30">
                            <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @stack('scripts')

    <script>
    function toggleTaskStatus(checkbox) {
        const card = checkbox.closest('div[data-status]');
        if (checkbox.checked) {
            card.dataset.status = 'concluida';
            card.classList.add('bg-green-50/50', 'dark:bg-green-900/10', 'border-green-300', 'dark:border-green-700');
        } else {
            card.dataset.status = 'pendente';
            card.classList.remove('bg-green-50/50', 'dark:bg-green-900/10', 'border-green-300', 'dark:border-green-700');
        }
    }

    function editTask(task) {
        console.log('Editar tarefa:', task);
        alert('Funcionalidade de edição: ' + task.title);
    }

    function deleteTask(id) {
        if (confirm('Deseja realmente excluir esta tarefa?')) {
            console.log('Excluir tarefa ID:', id);
            alert('Tarefa excluída!');
        }
    }
    </script>
</body>
</html>
