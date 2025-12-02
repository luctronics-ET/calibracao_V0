<!-- Sidebar -->
<aside
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="absolute left-0 top-0 z-50 flex h-screen w-72 flex-col overflow-y-hidden bg-gray-900 dark:bg-gray-950 duration-300 ease-linear lg:static lg:translate-x-0"
    @click.outside="sidebarOpen = false"
>
    <!-- Logo -->
    <div class="flex items-center justify-between gap-2 px-6 py-5.5 lg:py-6.5">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <i class="fas fa-cubes text-blue-500 text-2xl"></i>
            <span class="text-xl font-bold text-white">CalibSys</span>
        </a>

        <button
            class="block lg:hidden text-white"
            @click="sidebarOpen = false"
        >
            <i class="fas fa-times text-xl"></i>
        </button>
    </div>

    <!-- Menu -->
    <div class="flex flex-col overflow-y-auto duration-300 ease-linear">
        <nav class="px-4 py-4 lg:px-6">

            <div class="mb-4">
                <h3 class="mb-2 px-4 text-xs font-semibold uppercase text-gray-400">Menu</h3>
                <ul class="space-y-1.5">
                    <!-- Dashboard -->
                    <li>
                        <a href="{{ route('dashboard') }}"
                           class="group relative flex items-center gap-3 rounded-lg px-4 py-2.5 font-medium text-gray-300 hover:bg-gray-800 hover:text-white {{ request()->routeIs('dashboard') ? 'bg-gray-800 text-white' : '' }}">
                            <i class="fas fa-home text-lg"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <!-- Equipamentos -->
                    <li>
                        <a href="{{ route('equipamentos.index') }}"
                           class="group relative flex items-center gap-3 rounded-lg px-4 py-2.5 font-medium text-gray-300 hover:bg-gray-800 hover:text-white {{ request()->routeIs('equipamentos.*') ? 'bg-gray-800 text-white' : '' }}">
                            <i class="fas fa-cube text-lg"></i>
                            <span>Equipamentos</span>
                            @if(isset($equipamentosVencidos) && $equipamentosVencidos > 0)
                                <span class="ml-auto inline-flex items-center justify-center rounded-full bg-red-600 px-2 py-0.5 text-xs font-medium text-white">
                                    {{ $equipamentosVencidos }}
                                </span>
                            @endif
                        </a>
                    </li>

                    <!-- Calibrações -->
                    <li>
                        <a href="{{ route('calibracoes.index') }}"
                           class="group relative flex items-center gap-3 rounded-lg px-4 py-2.5 font-medium text-gray-300 hover:bg-gray-800 hover:text-white {{ request()->routeIs('calibracoes.*') ? 'bg-gray-800 text-white' : '' }}">
                            <i class="fas fa-clipboard-check text-lg"></i>
                            <span>Calibrações</span>
                        </a>
                    </li>

                    <!-- Lotes -->
                    <li>
                        <a href="{{ route('lotes.index') }}"
                           class="group relative flex items-center gap-3 rounded-lg px-4 py-2.5 font-medium text-gray-300 hover:bg-gray-800 hover:text-white {{ request()->routeIs('lotes.*') ? 'bg-gray-800 text-white' : '' }}">
                            <i class="fas fa-boxes text-lg"></i>
                            <span>Lotes</span>
                        </a>
                    </li>

                    <!-- Laboratórios -->
                    <li>
                        <a href="{{ route('laboratorios.index') }}"
                           class="group relative flex items-center gap-3 rounded-lg px-4 py-2.5 font-medium text-gray-300 hover:bg-gray-800 hover:text-white {{ request()->routeIs('laboratorios.*') ? 'bg-gray-800 text-white' : '' }}">
                            <i class="fas fa-flask text-lg"></i>
                            <span>Laboratórios</span>
                        </a>
                    </li>

                    <!-- Contratos -->
                    <li>
                        <a href="{{ route('contratos.index') }}"
                           class="group relative flex items-center gap-3 rounded-lg px-4 py-2.5 font-medium text-gray-300 hover:bg-gray-800 hover:text-white {{ request()->routeIs('contratos.*') ? 'bg-gray-800 text-white' : '' }}">
                            <i class="fas fa-file-contract text-lg"></i>
                            <span>Contratos</span>
                        </a>
                    </li>

                    <!-- Solicitações -->
                    <li>
                        <a href="{{ route('solicitacoes.index') }}"
                           class="group relative flex items-center gap-3 rounded-lg px-4 py-2.5 font-medium text-gray-300 hover:bg-gray-800 hover:text-white {{ request()->routeIs('solicitacoes.*') ? 'bg-gray-800 text-white' : '' }}">
                            <i class="fas fa-clipboard-list text-lg"></i>
                            <span>Solicitações</span>
                        </a>
                    </li>

                    <!-- Transportes -->
                    <li>
                        <a href="{{ route('transportes.index') }}"
                           class="group relative flex items-center gap-3 rounded-lg px-4 py-2.5 font-medium text-gray-300 hover:bg-gray-800 hover:text-white {{ request()->routeIs('transportes.*') ? 'bg-gray-800 text-white' : '' }}">
                            <i class="fas fa-truck text-lg"></i>
                            <span>Transportes</span>
                        </a>
                    </li>

                    <!-- Padrões RBC -->
                    <li>
                        <a href="{{ route('padroes.index') }}"
                           class="group relative flex items-center gap-3 rounded-lg px-4 py-2.5 font-medium text-gray-300 hover:bg-gray-800 hover:text-white {{ request()->routeIs('padroes.*') ? 'bg-gray-800 text-white' : '' }}">
                            <i class="fas fa-award text-lg"></i>
                            <span>Padrões RBC</span>
                        </a>
                    </li>

                    <!-- Locais -->
                    <li>
                        <a href="{{ route('locais.index') }}"
                           class="group relative flex items-center gap-3 rounded-lg px-4 py-2.5 font-medium text-gray-300 hover:bg-gray-800 hover:text-white {{ request()->routeIs('locais.*') ? 'bg-gray-800 text-white' : '' }}">
                            <i class="fas fa-map-marker-alt text-lg"></i>
                            <span>Locais</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="mb-4">
                <h3 class="mb-2 px-4 text-xs font-semibold uppercase text-gray-400">Relatórios</h3>
                <ul class="space-y-1.5">
                    <!-- Certificados -->
                    <li>
                        <a href="{{ route('reports.certificados') }}"
                           class="group relative flex items-center gap-3 rounded-lg px-4 py-2.5 font-medium text-gray-300 hover:bg-gray-800 hover:text-white {{ request()->routeIs('reports.certificados') ? 'bg-gray-800 text-white' : '' }}">
                            <i class="fas fa-certificate text-lg"></i>
                            <span>Certificados</span>
                        </a>
                    </li>

                    <!-- Relatórios -->
                    <li>
                        <a href="{{ route('reports.index') }}"
                           class="group relative flex items-center gap-3 rounded-lg px-4 py-2.5 font-medium text-gray-300 hover:bg-gray-800 hover:text-white {{ request()->routeIs('reports.index') ? 'bg-gray-800 text-white' : '' }}">
                            <i class="fas fa-chart-bar text-lg"></i>
                            <span>Relatórios</span>
                        </a>
                    </li>

                    <!-- Vencimentos -->
                    <li>
                        <a href="{{ route('reports.vencimentos') }}"
                           class="group relative flex items-center gap-3 rounded-lg px-4 py-2.5 font-medium text-gray-300 hover:bg-gray-800 hover:text-white {{ request()->routeIs('reports.vencimentos') ? 'bg-gray-800 text-white' : '' }}">
                            <i class="fas fa-exclamation-triangle text-lg"></i>
                            <span>Vencimentos</span>
                        </a>
                    </li>

                    <!-- Histórico -->
                    <li>
                        <a href="{{ route('reports.historico') }}"
                           class="group relative flex items-center gap-3 rounded-lg px-4 py-2.5 font-medium text-gray-300 hover:bg-gray-800 hover:text-white {{ request()->routeIs('reports.historico') ? 'bg-gray-800 text-white' : '' }}">
                            <i class="fas fa-history text-lg"></i>
                            <span>Histórico</span>
                        </a>
                    </li>

                    <!-- Custos -->
                    <li>
                        <a href="{{ route('reports.custos') }}"
                           class="group relative flex items-center gap-3 rounded-lg px-4 py-2.5 font-medium text-gray-300 hover:bg-gray-800 hover:text-white {{ request()->routeIs('reports.custos') ? 'bg-gray-800 text-white' : '' }}">
                            <i class="fas fa-dollar-sign text-lg"></i>
                            <span>Custos</span>
                        </a>
                    </li>

                    <!-- IGP -->
                    <li>
                        <a href="{{ route('reports.igp') }}"
                           class="group relative flex items-center gap-3 rounded-lg px-4 py-2.5 font-medium text-gray-300 hover:bg-gray-800 hover:text-white {{ request()->routeIs('reports.igp') ? 'bg-gray-800 text-white' : '' }}">
                            <i class="fas fa-chart-line text-lg"></i>
                            <span>IGP</span>
                        </a>
                    </li>
                </ul>
            </div>

        </nav>
    </div>
</aside>

<!-- Backdrop para mobile -->
<div
    x-show="sidebarOpen"
    @click="sidebarOpen = false"
    class="fixed inset-0 z-40 bg-black/50 lg:hidden"
    style="display: none;"
></div>
