<!-- Header -->
<header class="sticky top-0 z-30 flex w-full bg-white dark:bg-gray-800 shadow-sm">
    <div class="flex flex-grow items-center justify-between px-4 py-4 md:px-6 2xl:px-11">

        <!-- Left: Hamburger + Page Title -->
        <div class="flex items-center gap-3 sm:gap-4">
            <!-- Hamburger Toggle -->
            <button
                @click="sidebarOpen = !sidebarOpen"
                class="z-50 block rounded-sm border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-2 shadow-sm lg:hidden"
            >
                <span class="relative block h-5 w-5">
                    <span class="absolute right-0 h-full w-full">
                        <span class="relative left-0 top-0 my-1 block h-0.5 w-0 rounded-sm bg-gray-900 dark:bg-white delay-[0] duration-200 ease-in-out"
                              :class="!sidebarOpen && '!w-full delay-300'"></span>
                        <span class="relative left-0 top-0 my-1 block h-0.5 w-0 rounded-sm bg-gray-900 dark:bg-white delay-150 duration-200 ease-in-out"
                              :class="!sidebarOpen && '!w-full delay-400'"></span>
                        <span class="relative left-0 top-0 my-1 block h-0.5 w-0 rounded-sm bg-gray-900 dark:bg-white delay-200 duration-200 ease-in-out"
                              :class="!sidebarOpen && '!w-full delay-500'"></span>
                    </span>
                    <span class="absolute right-0 h-full w-full rotate-45">
                        <span class="absolute left-2.5 top-0 block h-full w-0.5 rounded-sm bg-gray-900 dark:bg-white delay-300 duration-200 ease-in-out"
                              :class="!sidebarOpen && '!h-0 !delay-[0]'"></span>
                        <span class="delay-400 absolute left-0 top-2.5 block h-0.5 w-full rounded-sm bg-gray-900 dark:bg-white duration-200 ease-in-out"
                              :class="!sidebarOpen && '!h-0 !delay-200'"></span>
                    </span>
                </span>
            </button>

            <!-- Page Title -->
            <h1 class="text-xl font-semibold text-gray-900 dark:text-white">
                <?php echo $__env->yieldContent('page-title', 'Dashboard'); ?>
            </h1>
        </div>

        <!-- Right: Dark Mode + Notifications + User -->
        <div class="flex items-center gap-3 2xl:gap-7">

            <!-- Dark Mode Toggle -->
            <button
                @click="darkMode = !darkMode"
                class="relative flex h-10 w-10 items-center justify-center rounded-full border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors"
            >
                <i class="fas fa-moon text-gray-600 dark:hidden"></i>
                <i class="fas fa-sun text-yellow-400 hidden dark:block"></i>
            </button>

            <!-- Notifications -->
            <div x-data="{ dropdownOpen: false }" class="relative">
                <button
                    @click="dropdownOpen = !dropdownOpen"
                    class="relative flex h-10 w-10 items-center justify-center rounded-full border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors"
                >
                    <i class="fas fa-bell text-gray-600 dark:text-gray-300"></i>
                    <span class="absolute -top-0.5 -right-0.5 z-1 h-4 w-4 rounded-full bg-red-600">
                        <span class="absolute -z-1 inline-flex h-full w-full animate-ping rounded-full bg-red-400 opacity-75"></span>
                        <span class="flex items-center justify-center text-xs font-semibold text-white">3</span>
                    </span>
                </button>

                <!-- Dropdown -->
                <div
                    x-show="dropdownOpen"
                    @click.outside="dropdownOpen = false"
                    class="absolute -right-16 sm:right-0 mt-2.5 w-80 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-lg"
                    style="display: none;"
                >
                    <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                        <h5 class="text-sm font-semibold text-gray-900 dark:text-white">Notificações</h5>
                    </div>

                    <ul class="divide-y divide-gray-200 dark:divide-gray-700 max-h-80 overflow-y-auto">
                        <li>
                            <a href="#" class="flex gap-3 px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <div class="flex-shrink-0">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-red-100 dark:bg-red-900">
                                        <i class="fas fa-exclamation-triangle text-red-600 dark:text-red-400"></i>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                        Calibrações vencidas
                                    </p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        5 equipamentos com calibração vencida
                                    </p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Há 2 horas</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex gap-3 px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <div class="flex-shrink-0">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-yellow-100 dark:bg-yellow-900">
                                        <i class="fas fa-clock text-yellow-600 dark:text-yellow-400"></i>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                        Calibrações próximas
                                    </p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        8 equipamentos vencem em 30 dias
                                    </p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Há 5 horas</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex gap-3 px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <div class="flex-shrink-0">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-green-100 dark:bg-green-900">
                                        <i class="fas fa-check-circle text-green-600 dark:text-green-400"></i>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                        Lote enviado
                                    </p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        Lote #12 enviado com sucesso
                                    </p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Ontem</p>
                                </div>
                            </a>
                        </li>
                    </ul>

                    <div class="border-t border-gray-200 dark:border-gray-700 px-4 py-3">
                        <a href="#" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">
                            Ver todas as notificações
                        </a>
                    </div>
                </div>
            </div>

            <!-- User Menu -->
            <div x-data="{ dropdownOpen: false }" class="relative">
                <button
                    @click="dropdownOpen = !dropdownOpen"
                    class="flex items-center gap-3"
                >
                    <span class="hidden lg:block text-right">
                        <span class="block text-sm font-medium text-gray-900 dark:text-white">Admin User</span>
                        <span class="block text-xs text-gray-500 dark:text-gray-400">Administrador</span>
                    </span>

                    <div class="h-10 w-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold">
                        AU
                    </div>

                    <i class="fas fa-chevron-down text-xs text-gray-400 hidden lg:block"></i>
                </button>

                <!-- Dropdown -->
                <div
                    x-show="dropdownOpen"
                    @click.outside="dropdownOpen = false"
                    class="absolute right-0 mt-4 w-56 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-lg"
                    style="display: none;"
                >
                    <ul class="py-2">
                        <li>
                            <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <i class="fas fa-user"></i>
                                Meu Perfil
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <i class="fas fa-cog"></i>
                                Configurações
                            </a>
                        </li>
                        <li class="border-t border-gray-200 dark:border-gray-700">
                            <a href="#" onclick="alert('Funcionalidade de logout será implementada')" class="flex w-full items-center gap-3 px-4 py-2.5 text-sm text-red-600 dark:text-red-400 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <i class="fas fa-sign-out-alt"></i>
                                Sair
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</header>
<?php /**PATH /home/luciano/Área de trabalho/dev/calibracao_V0/resources/views/layouts/partials/header.blade.php ENDPATH**/ ?>