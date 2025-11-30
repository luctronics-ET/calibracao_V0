<aside :class="sidebarToggle ? 'translate-x-0' : '-translate-x-full'"
    class="fixed left-0 top-0 z-9999 flex h-screen w-72 flex-col overflow-y-hidden border-r border-gray-200 bg-white transition-transform duration-300 ease-in-out lg:static lg:translate-x-0 dark:border-gray-700 dark:bg-gray-800">
    <!-- Sidebar Header -->
    <div class="flex items-center justify-between gap-2 px-6 py-5.5 lg:py-6.5">
        <a href="<?php echo e(route('dashboard')); ?>" class="flex items-center gap-3">
            <div
                class="flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br from-indigo-600 to-purple-600">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <span class="text-xl font-bold text-gray-800 dark:text-white">Calibração</span>
        </a>

        <button @click="sidebarToggle = false"
            class="flex h-8 w-8 items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 lg:hidden dark:text-gray-400 dark:hover:bg-gray-700">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Sidebar Menu -->
    <div class="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar">
        <nav class="px-4 py-4 lg:px-6">

            <div>
                <h3 class="mb-4 ml-4 text-xs font-semibold text-gray-400 uppercase">MENU</h3>

                <ul class="mb-6 flex flex-col gap-1.5">

                    <!-- Dashboard -->
                    <li>
                        <a href="<?php echo e(route('dashboard')); ?>"
                            class="group relative flex items-center gap-2.5 rounded-lg px-4 py-2.5 font-medium text-gray-700 duration-300 ease-in-out hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700 <?php echo e(request()->routeIs('dashboard') ? 'bg-gray-100 dark:bg-gray-700' : ''); ?>">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Dashboard
                        </a>
                    </li>

                    <!-- Equipamentos -->
                    <li>
                        <a href="<?php echo e(route('equipamentos.index')); ?>"
                            class="group relative flex items-center gap-2.5 rounded-lg px-4 py-2.5 font-medium text-gray-700 duration-300 ease-in-out hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700 <?php echo e(request()->routeIs('equipamentos.*') ? 'bg-gray-100 dark:bg-gray-700' : ''); ?>">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                            </svg>
                            Equipamentos
                        </a>
                    </li>

                    <!-- Calibrações -->
                    <li>
                        <a href="<?php echo e(route('calibracoes.index')); ?>"
                            class="group relative flex items-center gap-2.5 rounded-lg px-4 py-2.5 font-medium text-gray-700 duration-300 ease-in-out hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700 <?php echo e(request()->routeIs('calibracoes.*') ? 'bg-gray-100 dark:bg-gray-700' : ''); ?>">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                            Calibrações
                        </a>
                    </li>

                    <!-- Lotes de Envio -->
                    <li>
                        <a href="<?php echo e(route('lotes.index')); ?>"
                            class="group relative flex items-center gap-2.5 rounded-lg px-4 py-2.5 font-medium text-gray-700 duration-300 ease-in-out hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700 <?php echo e(request()->routeIs('lotes.*') ? 'bg-gray-100 dark:bg-gray-700' : ''); ?>">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            Lotes de Envio
                        </a>
                    </li>

                    <!-- Laboratórios -->
                    <li>
                        <a href="<?php echo e(route('laboratorios.index')); ?>"
                            class="group relative flex items-center gap-2.5 rounded-lg px-4 py-2.5 font-medium text-gray-700 duration-300 ease-in-out hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700 <?php echo e(request()->routeIs('laboratorios.*') ? 'bg-gray-100 dark:bg-gray-700' : ''); ?>">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Laboratórios
                        </a>
                    </li>

                    <!-- Logs -->
                    <li>
                        <a href="<?php echo e(route('logs.index')); ?>"
                            class="group relative flex items-center gap-2.5 rounded-lg px-4 py-2.5 font-medium text-gray-700 duration-300 ease-in-out hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700 <?php echo e(request()->routeIs('logs.*') ? 'bg-gray-100 dark:bg-gray-700' : ''); ?>">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Logs
                        </a>
                    </li>

                </ul>
            </div>

        </nav>
    </div>

</aside><?php /**PATH /var/www/resources/views/partials/sidebar.blade.php ENDPATH**/ ?>