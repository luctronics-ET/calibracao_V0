@props([
    'title' => '',
    'icon' => null,
    'padding' => true
])

<div {{ $attributes->merge(['class' => 'rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-white/[0.03] shadow-sm']) }}>
    @if($title || $icon)
        <div class="border-b border-gray-200 dark:border-gray-800 px-6 py-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                @if($icon)
                    <i class="{{ $icon }} text-blue-600 dark:text-blue-400"></i>
                @endif
                {{ $title }}
            </h3>
        </div>
    @endif

    <div class="{{ $padding ? 'px-6 py-4' : '' }}">
        {{ $slot }}
    </div>
</div>
