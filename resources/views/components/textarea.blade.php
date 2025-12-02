@props([
    'label' => '',
    'name' => '',
    'value' => '',
    'rows' => 4,
    'placeholder' => '',
    'required' => false,
    'disabled' => false,
    'error' => null,
    'help' => null
])

<div class="mb-4">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            {{ $label }}
            @if($required)
                <span class="text-red-600">*</span>
            @endif
        </label>
    @endif

    <textarea
        name="{{ $name }}"
        id="{{ $name }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        @if($required) required @endif
        @if($disabled) disabled @endif
        {{ $attributes->merge(['class' => 'w-full rounded-lg border px-4 py-2.5 text-gray-900 dark:text-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors ' . ($error ? 'border-red-500 dark:border-red-500' : 'border-gray-300 dark:border-gray-600')]) }}
    >{{ old($name, $value) }}</textarea>

    @if($error)
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $error }}</p>
    @endif

    @if($help)
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $help }}</p>
    @endif
</div>
