<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistema de Calibração')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('styles')
</head>

<body x-data="{ 
    sidebarToggle: false, 
    darkMode: false,
    page: '{{ $page ?? 'dashboard' }}'
}" x-init="darkMode = JSON.parse(localStorage.getItem('darkMode') || 'false'); 
        $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
    :class="{'dark bg-gray-900': darkMode === true}" class="antialiased">

    <!-- Page Wrapper -->
    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        @include('partials.sidebar')

        <!-- Content Area -->
        <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">

            <!-- Mobile Overlay -->
            <div x-show="sidebarToggle" @click="sidebarToggle = false"
                x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-9998 bg-gray-900/50 lg:hidden" style="display: none;"></div>

            <!-- Header -->
            @include('partials.header')

            <!-- Main Content -->
            <main>
                <div class="p-4 mx-auto max-w-screen-2xl md:p-6 2xl:p-10">
                    @yield('content')
                </div>
            </main>

        </div>

    </div>

    @stack('scripts')
</body>

</html>