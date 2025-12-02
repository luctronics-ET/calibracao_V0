@props([
    'id' => 'modal',
    'title' => '',
    'size' => 'md'
])

@php
    $sizes = [
        'sm' => 'max-w-md',
        'md' => 'max-w-lg',
        'lg' => 'max-w-2xl',
        'xl' => 'max-w-4xl',
        'full' => 'max-w-7xl',
    ];
@endphp

<div
    x-data="{ open: false }"
    x-show="open"
    x-on:open-modal-{{ $id }}.window="open = true"
    x-on:close-modal-{{ $id }}.window="open = false"
    x-on:keydown.escape.window="open = false"
    class="fixed inset-0 z-50 overflow-y-auto"
    style="display: none;"
>
    <!-- Backdrop -->
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black bg-opacity-50"
        @click="open = false"
    ></div>

    <!-- Modal -->
    <div class="flex items-center justify-center min-h-screen p-4">
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95"
            class="relative w-full {{ $sizes[$size] }} bg-white dark:bg-gray-800 rounded-lg shadow-xl"
        >
            <!-- Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    {{ $title }}
                </h3>
                <button
                    @click="open = false"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors"
                >
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Body -->
            <div class="p-6">
                {{ $slot }}
            </div>

            <!-- Footer (if provided) -->
            @isset($footer)
                <div class="flex items-center justify-end gap-3 p-6 border-t border-gray-200 dark:border-gray-700">
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </div>
</div>
