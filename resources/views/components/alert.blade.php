@props([
    'variant' => 'info',
    'dismissible' => true
])

@php
    $variants = [
        'success' => 'bg-green-50 dark:bg-green-900/20 border-green-200 dark:border-green-800 text-green-800 dark:text-green-200',
        'error' => 'bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-800 text-red-800 dark:text-red-200',
        'warning' => 'bg-yellow-50 dark:bg-yellow-900/20 border-yellow-200 dark:border-yellow-800 text-yellow-800 dark:text-yellow-200',
        'info' => 'bg-blue-50 dark:bg-blue-900/20 border-blue-200 dark:border-blue-800 text-blue-800 dark:text-blue-200',
    ];

    $icons = [
        'success' => 'fa-check-circle text-green-600 dark:text-green-400',
        'error' => 'fa-exclamation-circle text-red-600 dark:text-red-400',
        'warning' => 'fa-exclamation-triangle text-yellow-600 dark:text-yellow-400',
        'info' => 'fa-info-circle text-blue-600 dark:text-blue-400',
    ];
@endphp

<div
    x-data="{ show: true }"
    x-show="show"
    x-transition
    {{ $attributes->merge(['class' => 'rounded-lg border p-4 ' . $variants[$variant]]) }}
    role="alert"
>
    <div class="flex items-start">
        <i class="fas {{ $icons[$variant] }} mr-3 mt-0.5"></i>
        <div class="flex-1">
            {{ $slot }}
        </div>
        @if($dismissible)
            <button
                @click="show = false"
                class="ml-3 -mr-1 -mt-1 p-1 hover:opacity-75 transition-opacity"
            >
                <i class="fas fa-times"></i>
            </button>
        @endif
    </div>
</div>
