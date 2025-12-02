@props([
    'id' => 'datatable2',
    'title' => null,
    'headers' => [],
])

<div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    @if($title)
    <div class="px-5 py-4 sm:px-6 sm:py-5 border-b border-gray-100 dark:border-gray-800">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">{{ $title }}</h3>
    </div>
    @endif

    <div class="max-w-full overflow-x-auto">
        <table class="min-w-full" id="{{ $id }}">
            <thead>
                <tr class="border-b border-gray-100 dark:border-gray-800">
                    @foreach($headers as $header)
                    <th class="px-5 py-3 sm:px-6 text-left">
                        <div class="flex items-center">
                            <p class="font-medium text-gray-500 text-xs uppercase dark:text-gray-400">
                                {{ $header }}
                            </p>
                        </div>
                    </th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                {{ $slot }}
            </tbody>
        </table>
    </div>
</div>
