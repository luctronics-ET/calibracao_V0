{{-- Card Component --}}
@props([
    'title' => null,
    'icon' => null,
    'iconBg' => 'bg-indigo-100',
    'iconColor' => 'text-indigo-600',
    'padding' => 'p-5',
    'shadow' => 'shadow-lg',
])

<div {{ $attributes->merge(['class' => "bg-white {$shadow} rounded-xl {$padding} border border-gray-100 hover:shadow-xl transition dark:bg-gray-800 dark:border-gray-700"]) }}>
    @if($title || $icon)
        <div class="flex items-center gap-2 mb-4">
            @if($icon)
                <div class="{{ $iconBg }} p-2 rounded-lg">
                    {!! $icon !!}
                </div>
            @endif
            @if($title)
                <h3 class="font-bold text-gray-800 dark:text-white">{{ $title }}</h3>
            @endif
        </div>
    @endif
    
    <div>
        {{ $slot }}
    </div>
</div>
