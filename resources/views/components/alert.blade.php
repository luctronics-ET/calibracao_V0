{{-- Alert Component --}}
@props([
    'type' => 'info',
    'dismissible' => false,
    'icon' => true,
])

@php
$types = [
    'info' => [
        'bg' => 'bg-blue-50 dark:bg-gray-800',
        'border' => 'border-blue-300 dark:border-blue-800',
        'text' => 'text-blue-800 dark:text-blue-400',
        'icon' => '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>',
    ],
    'success' => [
        'bg' => 'bg-green-50 dark:bg-gray-800',
        'border' => 'border-green-300 dark:border-green-800',
        'text' => 'text-green-800 dark:text-green-400',
        'icon' => '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>',
    ],
    'warning' => [
        'bg' => 'bg-yellow-50 dark:bg-gray-800',
        'border' => 'border-yellow-300 dark:border-yellow-800',
        'text' => 'text-yellow-800 dark:text-yellow-400',
        'icon' => '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>',
    ],
    'danger' => [
        'bg' => 'bg-red-50 dark:bg-gray-800',
        'border' => 'border-red-300 dark:border-red-800',
        'text' => 'text-red-800 dark:text-red-400',
        'icon' => '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>',
    ],
];

$config = $types[$type];
@endphp

<div 
    {{ $attributes->merge(['class' => "border {$config['bg']} {$config['border']} {$config['text']} rounded-lg p-4"]) }}
    @if($dismissible) x-data="{ show: true }" x-show="show" @endif
>
    <div class="flex items-start">
        @if($icon)
            <div class="flex-shrink-0">
                {!! $config['icon'] !!}
            </div>
        @endif
        <div class="{{ $icon ? 'ml-3' : '' }} flex-1 text-sm font-medium">
            {{ $slot }}
        </div>
        @if($dismissible)
            <button @click="show = false" type="button" class="{{ $config['text'] }} ml-auto -mx-1.5 -my-1.5 rounded-lg focus:ring-2 p-1.5 inline-flex h-8 w-8 items-center justify-center hover:bg-opacity-20">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        @endif
    </div>
</div>
