@props(['status'])

@if ($status)
    <div
        {{ $attributes->merge(['class' => 'flex items-center py-3 px-5 mt-5 text-green-700 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400']) }}>

        <x-heroicon-o-check-circle class="w-7 h-7" />

        <span class="sr-only">status</span>

        <div class="ml-3 text font-medium">
            {{ $status }}
        </div>

        {{-- <button type="button"
            class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700">
            <span class="sr-only">Close</span>
            <x-heroicon-m-x-mark class="w-10 h-10" />
        </button> --}}
    </div>
@endif
