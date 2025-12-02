<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendário - Sistema de Calibração</title>
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
                            <span class="ml-1 text-gray-500 dark:text-gray-400">Calendário</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Título da Página -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Calendário de Calibrações</h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Visualize e gerencie todas as datas de calibração programadas
                </p>
            </div>

            <!-- Componente Calendar -->
            <x-calendar
                title="Agenda de Calibrações"
                :events="[
                    [
                        'title' => 'Calibração Balança Analítica',
                        'start' => '2025-12-10',
                        'backgroundColor' => '#3B82F6',
                        'borderColor' => '#3B82F6'
                    ],
                    [
                        'title' => 'Calibração Paquímetro Digital',
                        'start' => '2025-12-15T10:00:00',
                        'end' => '2025-12-15T12:00:00',
                        'backgroundColor' => '#10B981',
                        'borderColor' => '#10B981'
                    ],
                    [
                        'title' => 'Calibração Termômetro',
                        'start' => '2025-12-20',
                        'backgroundColor' => '#F59E0B',
                        'borderColor' => '#F59E0B'
                    ],
                ]"
            />

            <!-- Legenda -->
            <div class="mt-6 rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                <h4 class="mb-3 text-sm font-semibold text-gray-800 dark:text-white">Legenda</h4>
                <div class="flex flex-wrap gap-4">
                    <div class="flex items-center gap-2">
                        <div class="h-3 w-3 rounded-full bg-blue-500"></div>
                        <span class="text-sm text-gray-600 dark:text-gray-400">Balança</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="h-3 w-3 rounded-full bg-green-500"></div>
                        <span class="text-sm text-gray-600 dark:text-gray-400">Paquímetro</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="h-3 w-3 rounded-full bg-amber-500"></div>
                        <span class="text-sm text-gray-600 dark:text-gray-400">Termômetro</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="h-3 w-3 rounded-full bg-red-500"></div>
                        <span class="text-sm text-gray-600 dark:text-gray-400">Urgente</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="h-3 w-3 rounded-full bg-purple-500"></div>
                        <span class="text-sm text-gray-600 dark:text-gray-400">Revisão</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
