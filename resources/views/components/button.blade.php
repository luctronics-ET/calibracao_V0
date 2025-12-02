@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'icon' => null,
    'href' => null
])

@php
    $variants = [
        'primary' => 'bg-blue-600 hover:bg-blue-700 text-white border-transparent focus:ring-blue-500',
        'secondary' => 'bg-gray-600 hover:bg-gray-700 text-white border-transparent focus:ring-gray-500',
        'success' => 'bg-green-600 hover:bg-green-700 text-white border-transparent focus:ring-green-500',
        'danger' => 'bg-red-600 hover:bg-red-700 text-white border-transparent focus:ring-red-500',
        'warning' => 'bg-yellow-500 hover:bg-yellow-600 text-white border-transparent focus:ring-yellow-500',
        'info' => 'bg-cyan-600 hover:bg-cyan-700 text-white border-transparent focus:ring-cyan-500',
        'outline' => 'bg-white hover:bg-gray-50 text-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 border-gray-300 dark:border-gray-600 focus:ring-gray-500',
    ];

    $sizes = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2.5 text-sm',
        'lg' => 'px-6 py-3 text-base',
    ];

    $classes = 'inline-flex items-center justify-center gap-2 rounded-lg border font-medium transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed ' . $variants[$variant] . ' ' . $sizes[$size];
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <i class="{{ $icon }}"></i>
        @endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <i class="{{ $icon }}"></i>
        @endif
        {{ $slot }}
    </button>
@endif
