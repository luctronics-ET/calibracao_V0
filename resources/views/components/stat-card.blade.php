{{-- Stat Card Component --}}
@props([
    'title' => '',
    'value' => '',
    'icon' => null,
    'trend' => null, // 'up', 'down', null
    'trendValue' => null,
    'iconBg' => 'bg-indigo-100',
    'iconColor' => 'text-indigo-600',
])

<div {{ $attributes->merge(['class' => 'bg-white rounded-xl shadow-lg p-6 border border-gray-100 dark:bg-gray-800 dark:border-gray-700']) }}>
    <div class="flex items-center justify-between">
        <div class="flex-1">
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ $title }}</p>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-2">{{ $value }}</h3>
            
            @if($trend && $trendValue)
                <div class="flex items-center mt-2 text-sm">
                    @if($trend === 'up')
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                        <span class="text-green-500 ml-1">{{ $trendValue }}</span>
                    @else
                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                        </svg>
                        <span class="text-red-500 ml-1">{{ $trendValue }}</span>
                    @endif
                    <span class="text-gray-500 ml-1">vs mês anterior</span>
                </div>
            @endif
        </div>
        
        @if($icon)
            <div class="{{ $iconBg }} p-3 rounded-lg">
                {!! $icon !!}
            </div>
        @endif
    </div>
</div>
