@props([
    'id' => 'datatable1',
    'title' => null,
    'headers' => [],
    'data' => [],
    'actions' => true,
])

<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 pb-3 pt-4 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6">
    @if($title)
    <div class="flex flex-col gap-2 mb-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">{{ $title }}</h3>
        </div>
        {{ $slot ?? '' }}
    </div>
    @endif

    <div class="w-full overflow-x-auto">
        <table class="min-w-full" id="{{ $id }}">
            <thead>
                <tr class="border-gray-100 border-y dark:border-gray-800">
                    @foreach($headers as $header)
                    <th class="py-3 text-left">
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
                {{ $body }}
            </tbody>
        </table>
    </div>
</div>
